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
        // [PERBAIKAN 1] Gunakan config(), JANGAN env() di dalam class
        // env() seringkali NULL di production karena config caching
        $apiKey = config('services.brevo.key');

        // Debugging jika API Key masih tidak terbaca
        if (empty($apiKey)) {
            Log::critical('BREVO ERROR: API Key kosong! Pastikan file config/services.php sudah dikonfigurasi.');
        }

        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);

        // Opsi verify => false (Untuk mengatasi error SSL cURL 60)
        // Jika di hosting nanti sudah aman, baris ini bisa dihapus agar lebih secure.
        $client = new Client(['verify' => false]);

        $this->apiInstance = new TransactionalEmailsApi($client, $config);
    }

    public function sendEmail($subject, $message)
    {
        // [PERBAIKAN 2] Ambil data sender dari config
        $senderEmail = config('services.brevo.sender_email', 'no-reply@polban.ac.id');
        $senderName  = config('services.brevo.sender_name', 'Sistem Perpustakaan');

        $emailData = new SendSmtpEmail([
            'sender' => [
                'email' => $senderEmail,
                'name'  => $senderName,
            ],
            'to' => [
                [
                    'email' => 'maulana.ishak.tif24@polban.ac.id', // Email Admin
                    'name'  => 'Maulana Ishak'
                ]
            ],
            'subject' => $subject,
            'htmlContent' => $message,
        ]);

        try {
            return $this->apiInstance->sendTransacEmail($emailData);
        } catch (Exception $e) {
            // Log error agar terekam di storage/logs/laravel.log
            Log::error('Brevo Error: ' . $e->getMessage());
            throw $e;
        }
    }
}