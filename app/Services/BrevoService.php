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
    protected $senderName;
    protected $senderEmail;

    // [PENTING] Terima konfigurasi lewat Constructor
    public function __construct($apiKey, $senderName, $senderEmail)
    {
        // Setup Konfigurasi API
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
        
        // Setup Guzzle Client
        $client = new Client(['verify' => false]); // Hapus 'verify' => false jika di production (SSL aman)
        
        $this->apiInstance = new TransactionalEmailsApi($client, $config);

        // Simpan info pengirim ke properti class
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
    }

    public function sendEmail($toEmail, $toName, $subject, $message, $replyToEmail = null)
    {
        $emailData = [
            'sender' => [
                'name'  => $this->senderName,  // Menggunakan nama yang disuntikkan
                'email' => $this->senderEmail, // Menggunakan email yang disuntikkan
            ],
            'to' => [
                [
                    'email' => $toEmail,
                    'name'  => $toName
                ]
            ],
            'subject' => $subject,
            'htmlContent' => $message,
        ];

        // Jika ada Reply-To (opsional)
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