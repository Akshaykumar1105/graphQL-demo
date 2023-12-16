<?php

namespace App\Graphql\Mutations\Auth;

use Closure;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class Logout extends Mutation{

    public function __construct(private AuthService $authService){

    }

    protected $attributes = [
        'name' => 'Logout',
        'description' => 'A mutation for logout'
    ];
    

    public function type(): Type
    {
        return type::boolean();
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->authService->logout();
    }
}
