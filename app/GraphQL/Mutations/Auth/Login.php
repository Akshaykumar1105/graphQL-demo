<?php

namespace App\Graphql\Mutations\Auth;

use Closure;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class Login extends Mutation{

    public function __construct(private AuthService $authService){

    }

    protected $attributes = [
        'name' => 'login',
        'description' => 'A mutation for login'
    ];
    

    public function type(): Type
    {
        return GraphQL::type("loginUser");
    }

    public function args(): array
    {
        return [
            'email' => [
                "type" => Type::string()
            ],
            'password' => [
                "type" => Type::string(),
                'rules' => ['required', 'regex:' . config('site.password.regex')],
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->authService->login($args);
    }
}
