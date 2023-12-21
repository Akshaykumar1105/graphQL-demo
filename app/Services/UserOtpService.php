<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\UserOtp;

class UserOtpService
{

    public function __construct(private UserOtp $userOtpObj)
    {
        //
    }

    public function store($user, $otp)
    {
        $this->userOtpObj->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'used_for' => config('site.otp_used_for.reset_password')
        ]);
    }

    public function otpExists($user, $otp)
    {
        $otp = $this->userOtpObj->whereUserId($user->id)->whereOtp($otp)->first();

        return $otp;
    }

    public function isOtpExpired($otp)
    {
        $currentTime = Carbon::now();
        $expirationTime = $otp->created_at->addMinutes(config('site.otp_expiration_time'));
        
        return $currentTime->greaterThan($expirationTime);
    }
}
