<?php

namespace App\Http\Controllers;

use App\Services\BrevoService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function send(Request $request, BrevoService $brevo)
    {
        $request->validate([
            'nama'       => 'required|string',
            'email'      => 'required|email',
            'pertanyaan' => 'required|string',
        ]);

        $brevo->sendEmail(
            'Pertanyaan Baru dari ' . $request->nama,
            "<p><strong>Nama:</strong> {$request->nama}</p>
             <p><strong>Email:</strong> {$request->email}</p>
             <p><strong>Pertanyaan:</strong><br>{$request->pertanyaan}</p>"
        );

        return response()->json(['success' => true]);
    }
}
