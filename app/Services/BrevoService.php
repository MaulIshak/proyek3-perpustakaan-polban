<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client; // <--- JANGAN LUPA IMPORT INI

class BrevoService
{
    protected $apiInstance;

    public function __construct()
    {
        // Konfigurasi API Key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));

        // --- BAGIAN INI YANG DIUBAH ---
        // Kita buat Client Guzzle sendiri dengan opsi 'verify' => false
        // Ini akan mematikan pengecekan SSL (Aman untuk localhost, JANGAN DIPAKAI SAAT SUDAH ONLINE/HOSTING)
        $client = new Client(['verify' => false]);

        // Masukkan client tersebut ke dalam constructor API Brevo
        $this->apiInstance = new TransactionalEmailsApi($client, $config);
    }

    public function sendEmail($subject, $message)
    {
        // Pastikan ENV tidak kosong untuk menghindari error
        $senderEmail = env('BREVO_SENDER_EMAIL', 'no-reply@perpustakaan.com');
        $senderName  = env('BREVO_SENDER_NAME', 'Sistem Perpustakaan');

        $emailData = new SendSmtpEmail([
            'sender' => [
                'email' => $senderEmail,
                'name'  => $senderName,
            ],
            'to' => [
                [
                    'email' => 'irvan',
                    'name'  => 'Maulana Ishak'
                ]
            ],
            'subject' => $subject,
            'htmlContent' => $message,
        ]);

        try {
            return $this->apiInstance->sendTransacEmail($emailData);
        } catch (\Exception $e) {
            // Log error biar bisa dibaca di laravel.log
            \Illuminate\Support\Facades\Log::error('Brevo Error: ' . $e->getMessage());
            throw $e;
        }
    }
}