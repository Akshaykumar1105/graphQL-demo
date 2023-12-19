<?php

namespace App\Graphql\Mutations\User;

use Closure;
use App\Services\MediaService;
use App\Services\UserService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;


class UpdateUserProfile extends Mutation
{

    public function __construct(private UserService $userService)
    {
    }

    protected $attributes = [
        'name' => 'updateUserProfile',
        'description' => 'A mutation for update user profile '
    ];


    public function type(): Type
    {
        return GraphQL::type("userType");
    }

    public function args(): array
    {
        return [
            'input' => [
                'type' => GraphQL::type("updateUserInput"),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();

        return $this->userService->update($args['input']);
    }
}
