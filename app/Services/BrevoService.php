<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;

class BrevoService
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));
        $this->apiInstance = new TransactionalEmailsApi(null, $config);
    }

    public function sendEmail($subject, $message)
    {
        $emailData = new SendSmtpEmail([
            'sender' => [
                'email' => env('BREVO_SENDER_EMAIL'),
                'name'  => env('BREVO_SENDER_NAME'),
            ],
            'to' => [
                [
                    'email' => 'maulana.ishak.tif24@polban.ac.id',
                    'name'  => 'Maulana Ishak'
                ]
            ],
            'subject' => $subject,
            'htmlContent' => $message,
        ]);

        return $this->apiInstance->sendTransacEmail($emailData);
    }
}
