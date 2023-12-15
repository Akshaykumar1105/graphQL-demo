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
    ];
?>