<?php

namespace App\Services;

use App\Mail\SendVerifyOtp;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationService
{

    public function __construct() {

    }
    public function sendOtp($request)
    {
        $email =  $request;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response([
                'error' => __('message this email not found')
            ], 400);
        }
            $code_ = rand(10000, 99999);
        $code = VerificationCode::where('user_id', $user->id)->first();
        if ($code) {
            $code->code = $code_;
            $code->end_time = Carbon::now()->addMinutes(15);
            $code->created_at = Carbon::now();
            $code->save();
        } else {
            $code = new VerificationCode();
            $code->user_id = $user->id;
            $code->code = $code_;
            $code->end_time = Carbon::now()->addMinutes(15);
            $code->save();
        }
        Mail::to($email)->send(new SendVerifyOtp($code->code));

        return response()->json([
            "status" => true,
            "message" => __('message send verification code successfuly'),
        ], 200);
    }
    public function ResendOTP($request)
    {

        $user = User::where('email', $request)->first();
        $lastOTP = VerificationCode::where('user_id',$user->id)->orderBy('id','DESC')->first();
        if ($lastOTP){
            if ((Carbon::parse($lastOTP->created_at))->addMinutes(2) < Carbon::now()) {
                return $this->sendOtp($request);
            } else {
                return response()->json([
                    'error' => ('Please wait more time before Resend the code ')
                ], 400);
            }
        } else {
            return $this->sendOtp($request);
        }
    }

    public function VerifyOTP($request)
    {
        $code = $request->code;
        $user = Auth::user();
        $code = VerificationCode::where('user_id', $user->id)->where('code',$code)->first();

        if(!$code){
            return response()->json([
                'error' => "This OTP is not valid",
            ], 400);
        }
        $now = (Carbon::now());

        if($code->end_time < $now){
            return response()->json([
                'error' => "This OTP is not valid",
            ], 400);
        }
        $user->is_verified = 1;
        $user->save();
        $code->delete();
        $token = $user->createToken('')->plainTextToken;
        return response()->json([
            'massage' => 'successful_verified',
//            'user' => $user,
//            'token' => $token,
        ], 200);
    }
}
