<?php

namespace App\Service;

use Twilio\Rest\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SmsAlertService
{
    private $twilioSid;
    private $twilioToken;
    private $twilioFromNumber;

    public function __construct(ParameterBagInterface $params)
    {
        $this->twilioSid = $params->get('twilio_sid');
        $this->twilioToken = $params->get('twilio_token');
        $this->twilioFromNumber = $params->get('twilio_from_number');
    }

    public function sendSms(string $to, string $message): void
    {
        $client = new Client($this->twilioSid, $this->twilioToken);

        try {
            $client->messages->create(
                $to,
                [
                    'from' => $this->twilioFromNumber,
                    'body' => $message,
                ]
            );
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            error_log('Error sending SMS: ' . $e->getMessage());
        }
    }
}