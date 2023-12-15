<?php

namespace App\Graphql\Mutations\Auth;

use Closure;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;


class SignUp extends Mutation
{
    public function __construct(private AuthService $authService){

    }

    protected $attributes = [
        'name' => 'signUp',
        'description' => 'A mutation for user sign up'
    ];


    public function type(): Type
    {
        return GraphQL::type("userType");
    }

    public function args(): array
    {
        return [
            'first_name' => [
                "type" => Type::string(),
                'rules' => ['required'],
            ],
            'last_name' => [
                "type" => Type::string(),
                'rules' => ['required'],
            ],
            'email' => [
                "type" => Type::string(),
                'rules' => ['required', 'email', 'unique:users,email'],
            ],
            'password' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'min:8', 'regex:' . config('site.password.regex')],
            ],
            'confirm_password' => [
                "type" => Type::string(),
                'rules' => ['required', 'same:password'],
            ],
            'mediaId' => [
                "type" => Type::int(),
                'rules' => ['required'],
                "alias" => 'media_id',
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->authService->signUp($args, $getSelectFields);
    }
}
