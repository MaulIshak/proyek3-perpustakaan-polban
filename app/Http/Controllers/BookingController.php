<?php

namespace App\Http\Controllers;

use App\Models\BookingBuku;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\BrevoService;

class BookingController extends Controller
{
    protected $brevo;

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
        $query = BookingBuku::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'ilike', "%{$search}%")
                  ->orWhere('nim_nip', 'like', "%{$search}%")
                  ->orWhere('judul_buku', 'ilike', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(5)->withQueryString();

        return Inertia::render('admin/booking/Index', [
            'bookings' => $bookings,
            'filters'  => $request->only(['search']),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = BookingBuku::findOrFail($id);
        
        // [1] Tambahkan 'collected' ke validasi
        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled,pending,collected',
            'rejection_reason' => 'nullable|string',
            'deadline' => 'nullable|required_if:status,approved|date', 
        ]);

        $booking->status = $request->status;
        
        // --- LOGIKA PENYIMPANAN DATA TAMBAHAN ---
        if ($request->status === 'approved') {
            $booking->deadline = $request->deadline; 
            $booking->rejection_reason = null;
        } elseif ($request->status === 'rejected') {
            $booking->rejection_reason = $request->rejection_reason;
            $booking->deadline = null;
        } elseif ($request->status === 'collected') {
            // Jika diambil, hapus deadline & reason (bersih)
            $booking->deadline = null;
            $booking->rejection_reason = null;
        } else {
            // Status Cancelled / Pending
            $booking->rejection_reason = null;
            $booking->deadline = null;
        }

        $booking->save();

        // --- LOGIKA KIRIM EMAIL ---
        // [PERUBAHAN] Jangan kirim email jika status 'collected'
        if ($booking->status !== 'pending' && $booking->status !== 'collected') {
            
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