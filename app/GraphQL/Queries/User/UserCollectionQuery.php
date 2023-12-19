<?php

namespace App\GraphQL\Queries\User;

use Closure;
use App\Services\UserService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UserCollectionQuery extends Query
{

    public function __construct(private UserService $userService)
    {
    }

    protected $attributes = [
        'name' => 'userCollection',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('userType');
    }

    public function args(): array
    {
        return [
            'search' => [
                'type' => Type::string(),
                'description' => 'Search base on title and summary',
                'rules' => ['nullable']
            ],
            'limit' => [
                'type' => Type::int(),
                'description' => 'pagination limit',
                'rules' => ['nullable']
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'pagination page',
                'rules' => ['nullable']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();
        $args['with'] = $fileds->getRelations();

        return $this->userService->collection($args);
    }
}
