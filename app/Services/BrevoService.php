<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client; 
use Exception;
use Illuminate\Support\Facades\Log;

class BrevoService
{
    protected $apiInstance;

    public function __construct()
    {
        // Konfigurasi API (Tetap sama seperti sebelumnya)
        $apiKey = config('services.brevo.key'); // Pastikan sudah ada di .env dan config/services.php

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
        $client = new Client(['verify' => false]); // Hapus verify false jika sudah di production (SSL aman)
        $this->apiInstance = new TransactionalEmailsApi($client, $config);
    }

    /**
     * Fungsi Kirim Email Dinamis
     * * @param string $toEmail   Email Penerima
     * @param string $toName    Nama Penerima
     * @param string $subject   Judul Email
     * @param string $message   Isi HTML Email
     * @param string|null $replyToEmail (Opsional) Jika admin ingin membalas langsung ke mahasiswa
     */
    public function sendEmail($toEmail, $toName, $subject, $message, $replyToEmail = null)
    {
        // 1. Sender Tetap 1 Akun (Sistem Perpustakaan)
        // Ambil dari config atau hardcode email perpustakaan yang verified di Brevo
        $senderEmail = config('services.brevo.sender_email', 'admin@perpustakaan.mavl.my.id'); 
        $senderName  = config('services.brevo.sender_name', 'Perpustakaan Polban');

        $emailData = [
            'sender' => [
                'email' => $senderEmail,
                'name'  => $senderName,
            ],
            // 2. Penerima Dinamis (Sesuai Parameter)
            'to' => [
                [
                    'email' => $toEmail,
                    'name'  => $toName
                ]
            ],
            'subject' => $subject,
            'htmlContent' => $message,
        ];

        // Jika ada Reply-To (Berguna untuk fitur Tanya Pustakawan)
        if ($replyToEmail) {
            $emailData['replyTo'] = ['email' => $replyToEmail];
        }

        $sendSmtpEmail = new SendSmtpEmail($emailData);

        try {
            return $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception $e) {
            Log::error('Brevo Error: ' . $e->getMessage());
            throw $e;
        }
    }
}