<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;
use Rebing\GraphQL\Support\Facades\GraphQL;


class ResetPasswordInput extends InputType
{
    protected $attributes = [
        'name' => 'resetPasswordInput',
        'description' => 'A type of reset password input',
    ];

    public function fields(): array
    {
        return [
            'email' => [
                "type" => Type::string(),
                'rules' => ['required', 'email', 'exists:users,email'],
            ],
            'password' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'min:8', 'regex:' . config('site.password.regex'), 'confirmed'],
            ],
            'passwordConfirmation' => [
                'alias' => 'password_confirmation',
                "type" => Type::string(),
                'rules' => ['required','string'],
            ],
            'otp' => [
                "type" => Type::int(),
                'rules' => ['required', 'exists:user_otps,otp'],
            ],
        ];
    }
}
