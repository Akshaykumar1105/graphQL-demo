<?php

namespace App\Graphql\Mutations\Auth;

use Closure;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class ResetPassword extends Mutation
{

    public function __construct(private AuthService $authService){

    }

    protected $attributes = [
        'name' => 'forgetPassword',
        'description' => 'A mutation for forget password'
    ];


    public function type(): Type
    {
        return type::boolean();
    }

    public function args(): array
    {
        return [
            'email' => [
                "type" => Type::string(),
                'rules' => ['required', 'email', 'exists:users,email'],
            ],
            'password' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'min:8', 'regex:' . config('site.password.regex')],
            ],
            'confirm_password' => [
                "type" => Type::string(),
                'rules' => ['required', 'same:password'],
            ],
            'otp' => [
                "type" => Type::string(),
                'rules' => ['required', 'exists:user_otps,otp'],
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->authService->resetPassword($args);
    }
}
