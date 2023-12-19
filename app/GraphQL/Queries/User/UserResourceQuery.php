<?php

namespace App\GraphQL\Queries\User;

use Closure;
use App\Services\UserService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UserResourceQuery extends Query
{

    public function __construct(private UserService $userService)
    {
    }

    protected $attributes = [
        'name' => 'userResource',
        'description' => 'A query for show user'
    ];

    public function type(): Type
    {
        return GraphQL::type('userType');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();
        $args['with'] = $fileds->getRelations();
        
        if (!in_array('users.first_name', $args['select']) || !in_array('users.last_name', $args['select'])) {
            $args['select'][] = 'users.first_name';
            $args['select'][] = 'users.last_name';
        }

        $authId = auth('sanctum')->user()->id;

        return $this->userService->resource($authId, $args);
    }
}
