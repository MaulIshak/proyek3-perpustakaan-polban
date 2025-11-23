<?php

namespace App\Http\Controllers;

use App\Models\BookingBuku;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusMail;
use Carbon\Carbon;

class BookingController extends Controller
{
    // --- USER SIDE ---
    
    public function create()
    {
        return Inertia::render('user/BookingBuku', [
            'title' => 'Booking Buku'
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi sesuai nama input di Vue (camelCase)
        $request->validate([
            'namaLengkap' => 'required|string|max:255',
            'nimNip'      => 'required|string|max:50',
            'email'       => 'required|email',
            'whatsapp'    => 'required|string|max:20',
            'judulBuku'   => 'required|string|max:255',
            'pengarang'   => 'required|string|max:255',
        ]);

        // 2. Simpan ke Database (Mapping camelCase -> snake_case)
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

    public function indexAdmin()
    {
        // Ambil data booking, urutkan dari yang terbaru
        // Kita bisa tambahkan filter status nanti jika perlu
        $bookings = BookingBuku::latest()->get();

        return Inertia::render('admin/booking/Index', [
            'bookings' => $bookings
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = BookingBuku::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled,pending',
            'rejection_reason' => 'nullable|string'
        ]);

        // 1. Update Data di Database
        $booking->status = $request->status;
        
        if ($request->status === 'rejected') {
            $booking->rejection_reason = $request->rejection_reason;
        } else {
            $booking->rejection_reason = null;
        }

        $booking->save();

        // 2. LOGIKA EMAIL & DEADLINE
        if ($booking->status !== 'pending') {
            
            $deadlineString = '-';

            // Logika Hitung Deadline (Hanya jika Disetujui)
            if ($booking->status === 'approved') {
                // Set Locale ke Indonesia biar hari/bulannya bahasa Indo
                Carbon::setLocale('id');
                
                $deadline = Carbon::now()->addDay(); // Tambah 24 Jam

                // Cek Hari Libur (Sabtu & Minggu)
                if ($deadline->isSaturday()) {
                    $deadline->addDays(2); // Loncat ke Senin
                } elseif ($deadline->isSunday()) {
                    $deadline->addDay();   // Loncat ke Senin
                }

                // Format: "Senin, 25 November 2025 Pukul 14:30"
                $deadlineString = $deadline->translatedFormat('l, d F Y') . ' Pukul ' . $deadline->format('H:i');
            }

            // Data yang dikirim ke Email
            $emailData = [
                'name'       => $booking->nama_lengkap,
                'book_title' => $booking->judul_buku,
                'status'     => $booking->status,
                'reason'     => $booking->rejection_reason,
                'deadline'   => $deadlineString,
            ];

            // Kirim Email (Gunakan Try-Catch agar app tidak crash jika internet mati/SMTP error)
            try {
                Mail::to($booking->email)->send(new BookingStatusMail($emailData));
            } catch (\Exception $e) {
                dd($e->getMessage());
                // Opsional: Log error jika perlu
                // Log::error("Gagal kirim email ke " . $booking->email . ": " . $e->getMessage());
            }
        }
        
        return redirect()->back()->with('success', 'Status diperbarui & Notifikasi email dikirim.');
    }

    public function destroy($id)
    {
        BookingBuku::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data booking berhasil dihapus.');
    }
}