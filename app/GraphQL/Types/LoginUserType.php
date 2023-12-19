<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as FacadesGraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoginUserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'loginUserType',
        'description' => 'A type of login user'
    ];

    public function fields(): array
    {
        return [
            "user" => [
                'type' => FacadesGraphQL::type('userType'),
                'description' => "user"
            ],
            "token" => [
                "type" => Type::string(),
                "description" => "login token",
            ]
        ];
    }
}
