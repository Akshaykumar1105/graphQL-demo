<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Blog;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as FacadesGraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;


class BlogType extends GraphQLType
{
    protected $attributes = [
        'name' => 'blogType',
        'description' => 'A type of blog',
        'model' => Blog::class
    ];

    public function fields(): array
    {
        return [
            "id" => [
                'type' => Type::int(),
                'description' => "blog id"
            ],
            "title" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "slug" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "category_id" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "summary" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "description" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "is_published" => [
                "type" => Type::string(),
                "description" => "Name of user",
            ],
            "created_at" => [
                "type" => Type::string(),
                "description" => "blog created time",
            ],
            "user" => [
                "type" => GraphQL::type('userType'),
                "description" => "user of the blog",
            ],
            "category" => [
                "is_realtion" => true,
                "type" => GraphQL::type('categoryType'),
                "description" => "Blog Category",
            ],
            'media' => [
                "type" => Type::listOf(GraphQL::type('mediaType')),
                "description" => "Blog media",
            ]
        ];
    }
}
