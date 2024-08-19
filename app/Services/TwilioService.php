<?php
namespace App\Services;

use Twilio\Rest\Client as TwilioClient; // Use the Twilio SDK's Client class
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        // Get the Twilio credentials from the environment variables
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $this->from = env('TWILIO_PHONE_NUMBER');

        // Instantiate the Twilio client
        $this->client = new TwilioClient($sid, $token);
    }

    public function sendSMS($to, $message)
    {
        try {
            // Create and send the SMS using the Twilio client
            $sms = $this->client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message
                ]
            );

            return [
                'message' => 'SMS sent successfully',
                'response' => $sms
            ];
        } catch (\Exception $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
            return [
                'message' => 'Failed to send SMS',
                'response' => $e->getMessage()
            ];
        }
    }
}
