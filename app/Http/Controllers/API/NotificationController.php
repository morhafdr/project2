<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendNotificationRequest;
use App\Services\NotificationService;
use App\Models\User;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function send(SendNotificationRequest $request)
    {
        $user = User::findOrFail($request->user_id); // Ensure the user exists
        $title = $request->title;
        $message = $request->message;
        $result = $this->notificationService->send($user, $title, $message);
        return response()->json([
            'success' => $result === 1,
            'message' => $result === 1 ? 'Notification sent successfully.' : 'Failed to send notification.'
        ]);
    }

    public function GetNotification(){

        $not = $this->notificationService->index();
        return response()->json([
            'data' => $not
        ]);
    }
}
