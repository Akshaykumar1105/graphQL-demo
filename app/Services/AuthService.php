<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Mail\ForgetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\UserOtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Plank\Mediable\Media;

class AuthService
{
    public function __construct(private UserOtpService $userOtpService, private User $userObj)
    {
        //
    }

    public function signUp($args, $getSelectFields)
    {
        $user = $this->userObj->create($args);
        $media = Media::find($args['media_id']);
        $user->attachMedia($media, ['avatar']);
        $user->assignRole(config('site.roles.customer'));
        return $user;
    }

    public function login($args)
    {
        $user = $this->userObj->whereEmail($args['email'])->first();
        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return collect([
            "user" => $user,
            "token" => $user->createToken('App')->plainTextToken
        ]);
    }

    public function logout()
    {
        if (auth('sanctum')->check()) {
            Auth::user()->tokens()->delete();
            return true;
        }
        return false;
    }

    public function forgetPassword($args)
    {
        $user = $this->userObj->whereEmail($args['email'])->first();
        if ($user) {
            $otp = Helper::generateOTP(config('site.generateOtpLength'));
            $this->userOtpService->store($user, $otp);
            Mail::to($user->email)->send(new ForgetPassword($user, $otp));
            return true;
        }
        return false;
    }

    public function resetPassword($args)
    {
        $user = $this->userObj->whereEmail($args['email'])->first();
        $otp = $this->userOtpService->otpExists($user, $args['otp']);
        if ($user) {
            $expied = $this->userOtpService->isOtpExpired($otp);
            if ($expied) {
                $user->password = $args['password'];
                $user->save();
                return true;
            }
        }
        return false;
    }

    public function changePassword($args)
    {
        $user = auth('sanctum')->user();
        $newPassword = trim($args['password']);
        if (Hash::check($args['current_password'], $user->password)) {
            $user->password = $newPassword;
            $user->save();
            return true;
        }
        return false;
    }
}
