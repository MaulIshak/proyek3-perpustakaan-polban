<?php

namespace App\Http\Controllers;

use App\Services\BrevoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class QuestionController extends Controller
{
    public function send(Request $request, BrevoService $brevo)
    {
        // 1. Rate Limiting
        $key = 'tanya-pustakawan:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'errors' => ['message' => "Terlalu banyak permintaan. Coba lagi dalam {$seconds} detik."]
            ], 429);
        }

        // 2. Validasi Input Ketat
        $validated = $request->validate([
            'nama'       => ['required', 'string', 'max:100', 'min:3'],
            // [UBAH] Gunakan 'email' saja agar lebih aman di localhost/testing
            'email'      => ['required', 'email', 'max:255'], 
            'pertanyaan' => ['required', 'string', 'max:3000', 'min:10'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min'      => 'Nama terlalu pendek (min 3 huruf).', // Tambahan pesan
            'email.email'   => 'Format email tidak valid (gunakan @polban.ac.id atau gmail).',
            'pertanyaan.min'=> 'Pertanyaan terlalu pendek (min 10 karakter).',
            'pertanyaan.max'=> 'Pertanyaan terlalu panjang.',
        ]);

        // Hitung limit (Increment)
        RateLimiter::hit($key, 3600); // Reset dalam 3600 detik (1 jam)

        // 3. Sanitasi Input
        $safeNama = e($validated['nama']);
        $safeEmail = e($validated['email']); // Email Mahasiswa
        $safePertanyaan = nl2br(e($validated['pertanyaan']));

        // Render View ke HTML String
        $emailContent = view('emails.tanya-pustakawan', [
            'nama' => $safeNama,
            'email' => $safeEmail,
            'pertanyaan' => $safePertanyaan
        ])->render();

        // 4. Kirim Email Menggunakan Service
        // Format: sendEmail($toEmail, $toName, $subject, $message, $replyTo)
        
        $adminEmail = 'maulana.ishak.tif24@polban.ac.id'; // Email Admin Tujuan

        $brevo->sendEmail(
            $adminEmail,                            // Ke: Admin
            'Admin Perpustakaan',                   // Nama Penerima
            'TANYA PUSTAKAWAN : Dari ' . $safeNama, // Subject
            $emailContent,                          // Isi Pesan (HTML)
            $safeEmail                              // Reply-To: Langsung ke email mahasiswa jika admin klik 'Balas'
        );

        return response()->json(['success' => true, 'message' => 'Pertanyaan berhasil dikirim!']);
    }
}