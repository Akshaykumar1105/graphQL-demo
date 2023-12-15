<?php

namespace App\GraphQL\Queries\User;

use Closure;
use App\Services\UserService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UserResource extends Query
{

    public function __construct(private UserService $userService)
    {
    }

    protected $attributes = [
        'name' => 'users',
    ];

    public function type(): Type
    {
        return GraphQL::type('userType');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'ID of the user',
                'rules' => ['required']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->userService->resource($args, $getSelectFields);
    }
}
