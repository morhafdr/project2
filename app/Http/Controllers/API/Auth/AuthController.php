<?php

namespace App\Http\Controllers\API\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\loginClientRequest;
use App\Http\Requests\Auth\RegisterClientRequest;
use App\Models\User;
use App\Models\ResetCodePassword;
use App\Services\VerificationService;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail ;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Mail\SendCodeResetPassword;


class AuthController extends Controller
{
    use ApiResponse;
    protected $verifyService;
    public function __construct(VerificationService $service)
    {
        $this->verifyService = $service;
    }
   public function register(RegisterClientRequest $request){

       $UserInfo = $request->validated();
       $UserInfo['password'] = Hash::make($request->validated()['password']);

       $checkUser = User::where('email', $request->email)->first();
       if ($checkUser && !$checkUser->is_verified) {
           $checkUser->Update($UserInfo);
           $checkUser->save();
           $this->verifyService->ResendOTP($checkUser);
           $token = $checkUser->createToken('')->plainTextToken;
           $data=[];
           $data['user']=$checkUser;
           $data['user']['role']='client';
           $data['token']=$token;
           return   $this->success($data,'user created successfully',200);

       } elseif ($checkUser && $checkUser->is_verified) {
           // If the phone number is already verified
           return response()->json([
               'message' => 'This phone number is already registered and verified.'
           ], 422);
       }
       $user = User::create($UserInfo);
       $clientRole=Role::query()->where('name','client')->first();
       $user->assignRole($clientRole);
       $this->verifyService->sendOtp($user->email);
       $token = $user->createToken('authToken')->plainTextToken;
       $data=[];
       $data['user']=$user;
       $data['user']['role']='client';
       $data['token']=$token;
       return   $this->success($data,'user created successfully',200);
   }

   public function login(loginClientRequest $request){
       if(!Auth::attempt($request->only(['email','password']))){
           $this->error('email and password does not math',400);
        }
       $user=User::query()->where('email',$request['email'])->first();
       if (!$user->is_verified) {
           $this->verifyService->sendOtp($user->phone);
       }
       $token = $user->createToken('authToken')->plainTextToken;
       // Update the fcm_token if provided
       if ($request->filled('fcm_token')) {
           $user->update(['fcm_token' => $request->fcm_token]);
       }
       $role = $user->getRoleNames()->first();
       unset($user->roles);
       $data=[];
       $data['user']=$user;
       $data['token']=$token;
       $data['user']['role']=$role;
       return $this->success($data,'user loged in successfuly',200);
   }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json(['success' => 'logged out successfully']);

    }

    public function ResendOTP(Request $request)
    {
        $otp = $this->verifyService->ResendOTP($request);
        return $otp ;
    }

    public function VerifyOTP(Request $request)
    {
        $otp = $this->verifyService->VerifyOTP($request);
        return $otp ;
    }

 ////////////////////////////////////    forget password     //////////////////////////////////
 public function ForgetPassword (Request $request) {

    $data = $request->validate(['email' => 'required|email']);

    if (!User::where('email', $data['email'])->exists()) {
        return response()->json(['message' => 'Email does not exist in our App'], 404);
    }

    // Delete all old code that user send before.
    ResetCodePassword::where('email', $request->email)->delete();

    //
    $data['code'] = mt_rand(1000, 9999);

    // Create a new code
    $codeData = ResetCodePassword::create($data);

    // Send email to user
    Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));

    return response(['message' => trans('we send code to your email')], 200);
}

    public function ValidateResetCode(Request $request) {
        $request->validate(['code' => 'required|string|exists:reset_code_passwords']);

        $passwordReset = ResetCodePassword::query()->firstWhere('code' ,$request['code']);

        //check if it is nor expired the time is one hour
        if ($passwordReset['created_at'] > now() ->addHour()){
            $passwordReset->delete();
            return response()->json(['message' => trans('passwords.code_is_expire')  ],422);
        }

        if ($passwordReset === null) {
            return response()->json(['message' => trans('passwords.code_is_expire')], 422);
        }

        return response()->json(['message' => 'Code is valid', 'email' => $passwordReset['email']], 200);
    }



    public function ResetPassword (Request $request) {
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords',
            'password' => 'required|min:8|confirmed',
        ]);

        $passwordReset = ResetCodePassword::where('code', $request['code'])
            ->first();

        $user = User::query()->firstWhere('email' , $passwordReset['email']);

        //update user password
        $input['password'] = bcrypt($request['password']); //

        $user -> update([
            'password' => $input['password'],
        ]);
        $user->save();

        // delete current code we can use DB   or use this $passwordReset->delete();
        DB::table('reset_code_passwords')->where('email' ,$passwordReset['email'])->delete();
        return response()->json(['message' => 'password  has been successsfully reset']);
    }

}
