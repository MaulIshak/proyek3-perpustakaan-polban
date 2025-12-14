<?php

namespace App\Http\Controllers;

use App\Models\BookingBuku;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log; // Untuk logging error
use App\Services\BrevoService;      // [1] Import Service Brevo

class BookingController extends Controller
{
    protected $brevo;

    /**
     * [UBAH] Inject Service Melalui Constructor
     * Ini memungkinkan Laravel menyuntikkan konfigurasi Brevo yang SPESIFIK
     * untuk 'Booking Buku' (Nama Pengirim: Layanan Sirkulasi).
     */
    public function __construct(BrevoService $brevo)
    {
        $this->brevo = $brevo;
    }

    // --- USER SIDE ---
    public function create()
    {
        return Inertia::render('user/BookingBuku', [
            'title' => 'Booking Buku'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'nimNip'      => 'required|string|max:50',
            'email'       => 'required|email:dns',
            'whatsapp'    => 'required|string|max:20',
            'judulBuku'   => 'required|string|max:255',
            'pengarang'   => 'required|string|max:255',
        ]);

        BookingBuku::create([
            'nama_lengkap' => $request->namaLengkap,
            'nim_nip'      => $request->nimNip,
            'email'        => $request->email,
            'whatsapp'     => $request->whatsapp,
            'judul_buku'   => $request->judulBuku,
            'pengarang'    => $request->pengarang,
            'status'       => 'pending'
        ]);

        return redirect()->back()->with('success', 'Permintaan booking berhasil dikirim!');
    }

    // --- ADMIN SIDE ---
    public function indexAdmin(Request $request)
    {
        // Query Dasar
        $query = BookingBuku::query();

        // 1. Logika Search (Jika ada input 'search')
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'ilike', "%{$search}%") // Gunakan 'ilike' utk PostgreSQL (case-insensitive)
                  ->orWhere('nim_nip', 'like', "%{$search}%")
                  ->orWhere('judul_buku', 'ilike', "%{$search}%");
            });
        }

        // 2. Pagination
        $bookings = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('admin/booking/Index', [
            'bookings' => $bookings,
            'filters'  => $request->only(['search']),
        ]);
    }

    // [UBAH] Hapus BrevoService dari parameter method, gunakan $this->brevo
    public function updateStatus(Request $request, $id)
    {
        $booking = BookingBuku::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled,pending',
            'rejection_reason' => 'nullable|string',
            'deadline' => 'nullable|required_if:status,approved|date', 
        ]);

        $booking->status = $request->status;
        
        // --- LOGIKA PENYIMPANAN DEADLINE ---
        if ($request->status === 'approved') {
            $booking->deadline = $request->deadline; 
            $booking->rejection_reason = null;
        } elseif ($request->status === 'rejected') {
            $booking->rejection_reason = $request->rejection_reason;
            $booking->deadline = null; // Hapus deadline
        } else {
            // Status Cancelled / Pending
            $booking->rejection_reason = null;
            $booking->deadline = null; // Reset deadline jika dibatalkan
        }

        $booking->save();

        // --- LOGIKA KIRIM EMAIL ---
        if ($booking->status !== 'pending') {
            
            $deadlineString = '-';

            if ($booking->status === 'approved' && $booking->deadline) {
                Carbon::setLocale('id');
                $deadlineString = Carbon::parse($booking->deadline)
                                    ->translatedFormat('l, d F Y, \P\u\k\u\l H:i'); 
            }

            $emailData = [
                'name'       => $booking->nama_lengkap,
                'book_title' => $booking->judul_buku,
                'status'     => $booking->status,
                'reason'     => $booking->rejection_reason,
                'deadline'   => $deadlineString, 
            ];

            try {
                $emailContent = view('emails.booking_status', ['data' => $emailData])->render();

                $subject = match($booking->status) {
                    'approved' => '✅ Booking Disetujui - Perpustakaan Polban',
                    'rejected' => '❌ Booking Ditolak - Perpustakaan Polban',
                    'cancelled' => '⚠️ Booking Dibatalkan',
                    default => 'Update Status Booking'
                };

                // [UBAH] Gunakan $this->brevo yang sudah diinject di constructor
                $this->brevo->sendEmail(
                    $booking->email,        
                    $booking->nama_lengkap, 
                    $subject,               
                    $emailContent           
                );

            } catch (\Exception $e) {
                Log::error("Gagal kirim email booking ID {$id}: " . $e->getMessage());
            }
        }
        
        return redirect()->back()->with('success', 'Status diperbarui.');
    }

    public function destroy($id)
    {
        $booking = BookingBuku::findOrFail($id);
        $booking->delete();
        return redirect()->back()->with('success', 'Data booking berhasil dihapus.');
    }
}