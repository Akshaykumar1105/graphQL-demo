<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'userType',
        'description'   => 'A user',
        'model'         => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'The id of the user',
            ],
            'firstName' => [
                'type' => Type::string(),
                'description' => 'The first name of user',
                "alias" => 'first_name',
            ],
            'lastName' => [
                'type' => Type::string(),
                'description' => 'The last name of user',
                "alias" => 'last_name',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user',
            ],
            'mobileNo' => [
                'type' => Type::string(),
                'description' => 'Mobile number of user',
                "alias" => 'mobile_no',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'full name of user',
                'selectable'  => false,
                'resolve'     => function(User $user) {
                    return $user->name;
                }
            ],
            'media' => [
                'type' => Type::listOf(GraphQL::type('mediaType')),
                'description' => 'user avatar',
            ]
        ];
    }
}
