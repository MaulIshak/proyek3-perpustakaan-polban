<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; // PENTING: Pakai Facade Mail
use App\Mail\BookingStatusMail;      // PENTING: Panggil Class Mailable
use App\Models\BookingBuku;

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
        $request->validate([
            'namaLengkap' => 'required|string|max:255',
            
            'nimNip' => [
                'required',
                'numeric',
                'digits_between:9,10', // UPDATE: Sesuai request (9 sampai 10 digit)
            ],
            
            'email' => 'required|email:dns',
            
            'whatsapp' => [
                'required',
                'numeric',
                'starts_with:08,62',
                'digits_between:10,15', // UPDATE: Sesuai request (10 sampai 15 digit)
            ],
            
            'judulBuku' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
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
    public function indexAdmin()
    {
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

        $booking->status = $request->status;
        
        if ($request->status === 'rejected') {
            $booking->rejection_reason = $request->rejection_reason;
        } else {
            $booking->rejection_reason = null;
        }

        $booking->save();

        // --- LOGIKA KIRIM EMAIL (METODE STANDARD) ---
        if ($booking->status !== 'pending') {
            
            $deadlineString = '-';

            if ($booking->status === 'approved') {
                Carbon::setLocale('id');
                $deadline = Carbon::now()->addDay();
                
                if ($deadline->isSaturday()) {
                    $deadline->addDays(2);
                } elseif ($deadline->isSunday()) {
                    $deadline->addDay();
                }
                
                $deadlineString = $deadline->translatedFormat('l, d F Y H:i');
            }

            $emailData = [
                'name'       => $booking->nama_lengkap,
                'book_title' => $booking->judul_buku,
                'status'     => $booking->status,
                'reason'     => $booking->rejection_reason,
                'deadline'   => $deadlineString,
            ];

            try {
                // Mengirim menggunakan konfigurasi di .env (saat ini Mailtrap)
                Mail::to($booking->email)->send(new BookingStatusMail($emailData));
            } catch (\Exception $e) {
                // Error handling silent agar app tidak crash
                // \Log::error($e->getMessage());
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
