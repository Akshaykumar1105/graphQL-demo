<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\InputType;


class UpdateUserInput extends InputType
{
    protected $attributes = [
        'name' => 'updateUserInput',
        'description' => 'A type of update user input',
        'model' => User::class
    ];

    public function fields(): array
    {
        return [
            'firstName' => [
                "type" => Type::string(),
                'rules' => ['required'],
                "alias" => 'first_name',
            ],
            'lastName' => [
                "type" => Type::string(),
                'rules' => ['required'],
                "alias" => 'last_name',
            ],
            'email' => [
                "type" => Type::string(),
                'rules' => ['required', 'email', 'unique:users,email,'. Auth::id()],
            ],
            'mobileNo' => [
                "alias" => 'mobile_no',
                "type" => Type::string(),
                'rules' => ['required', 'digits:10', 'numeric'],
            ],
            'mediaId' => [
                "type" => Type::int(),
                'rules' => ['required', 'exists:media,id'],
                "alias" => 'media_id',
            ]
        ];
    }
}
