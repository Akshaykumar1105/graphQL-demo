<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Blog;
use GraphQL\Type\Definition\Type;
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
                "description" => "Title of the blog",
            ],
            "slug" => [
                "type" => Type::string(),
                "description" => "Slug of the blog",
            ],
            "category_id" => [
                "type" => Type::string(),
                "description" => "Category of the blog",
            ],
            "summary" => [
                "type" => Type::string(),
                "description" => "Summary of the blog",
            ],
            "description" => [
                "type" => Type::string(),
                "description" => "Full description of the blog",
            ],
            "is_published" => [
                "type" => Type::string(),
                "description" => "Indicates whether the blog is published",
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
