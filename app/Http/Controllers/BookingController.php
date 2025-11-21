<?php

namespace App\Http\Controllers;

use App\Models\BookingBuku;
use Illuminate\Http\Request;
use Inertia\Inertia;


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

        // Update data
        $booking->status = $request->status;
        
        // Jika ditolak, simpan alasannya. Jika tidak, kosongkan.
        if ($request->status === 'rejected') {
            $booking->rejection_reason = $request->rejection_reason;
        } else {
            $booking->rejection_reason = null;
        }

        $booking->save();

        // TODO: DI SINI LOKASI KODE UNTUK KIRIM EMAIL (NANTI)
        
        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function destroy($id)
    {
        BookingBuku::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data booking berhasil dihapus.');
    }
}