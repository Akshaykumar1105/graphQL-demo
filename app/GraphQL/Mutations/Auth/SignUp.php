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
            'firstName' => [
                "type" => Type::string(),
                'rules' => ['required'],
                "alias" => 'first_name',
            ],
            'lastName' => [
                "type" => Type::string(),
                'rules' => ['required'],
                "alias" => 'last_name',
            ],
            'email' => [
                "type" => Type::string(),
                'rules' => ['required', 'email', 'unique:users,email'],
            ],
            'password' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'min:8', 'regex:' . config('site.password.regex')],
            ],
            'confirmPassword' => [
                "type" => Type::string(),
                'rules' => ['required'],
                "alias" => 'confirm_password',
            ],
            'mediaId' => [
                "type" => Type::int(),
                'rules' => ['nullable', 'exists:media,id'],
                "alias" => 'media_id',
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
