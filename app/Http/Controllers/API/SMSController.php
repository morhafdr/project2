<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function index()
    {
        $data = [
            'company' => "Al-Mohit for Transport",
            'description' => "A leading company in the field of transportation and logistics, specializing in providing integrated shipping solutions that efficiently and effectively meet customer needs.",
            'expansion' => "Has offices in all provinces of Syria, enabling it to provide its services efficiently throughout the country.",
            'commitment' => "Committed to the highest standards of quality and safety, with a continuous focus on improving services to meet and exceed customer expectations.",
            'facebook' => "Find us on Facebook."
        ];

        return response()->json(['data' => $data]);
    }

    public function sendSMS(Request $request)
    {
        $request->validate([
            'to' => 'required|string',
            'message' => 'required|string',
        ]);
        $to = $request->input('to');
        $message = $request->input('message');

        $result = $this->twilioService->sendSMS($to, $message);

        if (isset($result['error'])) {
            Log::error('Failed to send SMS', ['error' => $result['error']]);
            return response()->json(['error' => $result['error']], 400);
        }
        Log::info('SMS sent successfully');
        return response()->json(['message' => 'SMS sent successfully', 'response' => $result]);
    }

}
