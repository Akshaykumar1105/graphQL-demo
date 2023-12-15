<?php

namespace App\Services;

use App\Models\UserOtp;
use Carbon\Carbon;

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
            'otp_for' => config('site.otp_for.reset_password')
        ]);
    }

    public function otpExists($user, $otp)
    {
        return $this->userOtpObj->whereUserId($user->id)->whereOtp($otp)->first();
    }

    public function isOtpExpired($otp)
    {
        $currentTime = Carbon::now();
        $expirationTime = $otp->created_at->addMinutes(config('site.otp_expiration_time'));
        
        return $currentTime->lessThan($expirationTime);
    }
}
