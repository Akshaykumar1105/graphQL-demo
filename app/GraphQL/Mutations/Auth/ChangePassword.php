<?php

namespace App\Graphql\Mutations\Auth;

use Closure;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class ChangePassword extends Mutation{

    public function __construct(private AuthService $authService){

    }

    protected $attributes = [
        'name' => 'changePassword',
        'description' => 'A mutation for change password'
    ];
    

    public function type(): Type
    {
        return type::boolean();
    }

    public function args(): array
    {
        return [
            'currentPassword' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'min:8', 'regex:' . config('site.password.regex')],
                "alias" => 'current_password',
            ],
            'password' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'min:8', 'regex:' . config('site.password.regex')],
            ],
            'confirmPassword' => [
                "type" => Type::string(),
                'rules' => ['required', 'same:password'],
                "alias" => 'confirm_password',
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->authService->changePassword($args);
    }
}
