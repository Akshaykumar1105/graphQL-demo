<?php

namespace App\Services;

use App\Models\User;
use App\Helpers\Helper;
use Plank\Mediable\Media;
use App\Mail\ForgotPassword;
use App\Services\UserOtpService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(private UserOtpService $userOtpService, private User $userObj)
    {
        //
    }

    public function signUp($args)
    {
        $user = $this->userObj->create($args['input'])->assignRole(config('site.roles.customer'));

        $media = Media::find($args['media_id']);

        $user->attachMedia($media, ['avatar']);

        return $user->select($args['select']);
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
        Auth::user()->tokens()->delete();

        return true;
    }

    public function forgotPassword($args)
    {
        $user = $this->userObj->whereEmail($args['email'])->first();

        $otp = Helper::generateOTP(config('site.generateOtpLength'));

        $this->userOtpService->store($user, $otp);

        try {
            Mail::to($user->email)->send(new ForgotPassword($user, $otp));
        } catch (\Exception $e) {
            Log::info('Forgot Password mail failed.' . $e->getMessage());
        }

        return true;
    }

    public function resetPassword($args)
    {
        $user = $this->userObj->whereEmail($args['email'])->first();

        $otp = $this->userOtpService->otpExists($user, $args['otp']);

        if ($otp) {
            $user->password = $args['password'];
            $user->save();
            return true;
        }

        return false;
    }

    public function changePassword($args)
    {
        $user = auth('sanctum')->user();

        $newPassword = trim($args['password']);

        if (Hash::check(trim($args['current_password']), $user->password)) {
            $user->password = $newPassword;
            $user->save();
            return true;
        }

        return false;
    }
}
