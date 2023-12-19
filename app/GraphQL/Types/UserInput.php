<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;


class UserInput extends InputType
{
    protected $attributes = [
        'name' => 'userInput',
        'description' => 'A type of user input',
        'model' => User::class
    ];

    public function fields(): array
    {
        return [
            'firstName' => [
                "type" => Type::string(),
                'rules' => ['required', 'max:16'],
                "alias" => 'first_name',
            ],
            'lastName' => [
                "type" => Type::string(),
                'rules' => ['required', 'max:16'],
                "alias" => 'last_name',
            ],
            'email' => [
                "type" => Type::string(),
                'rules' => ['required', 'email', 'unique:users,email'],
            ],
            'password' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'min:8', 'regex:' . config('site.password.regex')],
            ],
            'confirmPassword' => [
                "type" => Type::string(),
                'rules' => ['required'],
                "alias" => 'confirm_password',
            ],
            'mediaId' => [
                "type" => Type::int(),
                'rules' => ['nullable', 'exists:media,id'],
                "alias" => 'media_id',
            ],
        ];
    }
}
