<?php 
    return [
        'roles' => [
            'admin' => 'admin',
            'customer' => 'customer',
        ],

        'generateOtpLength' => 6,

        'otp_expiration_time' => 10,

        'mediaType' => [
            'avatar',
            'blog'
        ],

        'password' => [
            'regex' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).*$/",
        ],

        'otp_used_for' => [
            'reset_password' => 'reset-password',
        ],
    ];
?>