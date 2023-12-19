<?php

namespace App\Services;

use App\Models\User;
use App\Helpers\Helper;
use Plank\Mediable\Media;
use App\Mail\ForgotPassword;
use App\Services\UserOtpService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(private UserOtpService $userOtpService, private User $userObj, private UserService $userService)
    {
        //
    }

    public function signUp($inputs)
    {
        $user = $this->userObj->create($inputs)->assignRole(config('site.roles.customer'));

        if ($inputs['media_id']) {
            $media = Media::find($inputs['media_id']);

            $user->attachMedia($media, ['avatar']);
        }
        
        return $this->userService->resource($user->id, $inputs);
    }

    public function login($inputs)
    {
        $user = $this->userObj->whereEmail($inputs['email'])->first();

        if (!$user || !Hash::check($inputs['password'], $user->password)) {
            throw ValidationException::withMessages([
                 __('auth.password'),
            ]);
        }

        return collect([
            "user" => $user,
            "token" => $user->createToken(config('site.access_token'))->plainTextToken
        ]);
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        return true;
    }

    public function forgotPassword($inputs)
    {
        $user = $this->userObj->whereEmail($inputs['email'])->first();

        $otp = Helper::generateOTP(config('site.generateOtpLength'));

        $this->userOtpService->store($user, $otp);

        try {
            Mail::to($user->email)->send(new ForgotPassword($user, $otp));
        } catch (\Exception $e) {
            Log::info('Forgot Password mail failed.' . $e->getMessage());
        }

        return true;
    }

    public function resetPassword($inputs)
    {
        $user = $this->userObj->whereEmail($inputs['email'])->first();

        $otp = $this->userOtpService->otpExists($user, $inputs['otp']);

        $isOtpExpired = $this->userOtpService->isOtpExpired($otp);

        if ($isOtpExpired) {
            $otp->delete();
            return false;
        }
    
        $user->password = $inputs['password'];
        $user->save();
    
        $otp->delete();
    
        return true;
    }

    public function changePassword($inputs)
    {
        $user = auth('sanctum')->user();

        $newPassword = trim($inputs['password']);

        if (Hash::check(trim($inputs['current_password']), $user->password)) {
            $user->password = $newPassword;
            $user->save();
            return true;
        }

        return false;
    }
}
