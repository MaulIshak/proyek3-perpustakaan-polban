<?php

namespace App\Http\Controllers;

use App\Services\BrevoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class QuestionController extends Controller
{
    public function send(Request $request, BrevoService $brevo)
    {
        // 1. Rate Limiting (TETAP SAMA)
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
            'email'      => ['required', 'email:dns', 'max:255'],
            'pertanyaan' => ['required', 'string', 'max:3000', 'min:10'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.email'   => 'Format email tidak valid.',
            'pertanyaan.min'=> 'Pertanyaan terlalu pendek, mohon jelaskan lebih detail.',
            'pertanyaan.max'=> 'Pertanyaan terlalu panjang (maks 3000 karakter).',
        ]);

        // Hitung limit (Increment)
        RateLimiter::hit($key, 3600); // Reset dalam 3600 detik (1 jam)

        // 3. Sanitasi Input (Mencegah HTML Injection)
        // Gunakan e() atau htmlspecialchars() agar input user dianggap teks biasa
        $safeNama = e($validated['nama']);
        $safeEmail = e($validated['email']);
        
        // nl2br() agar enter/baris baru dari user tetap terbaca di email
        $safePertanyaan = nl2br(e($validated['pertanyaan']));

        $emailContent = view('emails.tanya-pustakawan', [
            'nama' => $safeNama,
            'email' => $safeEmail,
            'pertanyaan' => $safePertanyaan
        ])->render();

        // Kirim hasil render ke BrevoService
        $brevo->sendEmail(
            'TANYA PUSTAKAWAN : Pertanyaan Baru dari ' . $safeNama, // Subject
            $emailContent // Body HTML yang sudah cantik
        );

        return response()->json(['success' => true, 'message' => 'Pertanyaan berhasil dikirim!']);
    }
}