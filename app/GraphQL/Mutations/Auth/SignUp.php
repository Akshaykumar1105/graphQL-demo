<?php

namespace App\Graphql\Mutations\Auth;

use Closure;
use App\Services\AuthService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Request;
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
            'input' => [
                "type" => GraphQL::type("userInput"),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();
        $args['with'] = $fileds->getRelations();

        return $this->authService->signUp($args);
    }
}
