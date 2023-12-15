<?php

namespace App\Graphql\Mutations\Auth;

use Closure;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class ForgetPassword extends Mutation{

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
                'rules' => ['required', 'email',  'exists:users,email'],
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
       return $this->authService->forgetPassword($args);
    }
}
