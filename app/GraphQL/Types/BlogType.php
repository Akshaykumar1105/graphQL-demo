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
            'categoryId' => [
                "type" => Type::int(),
                "description" => "category of the blog",
                "alias" => 'category_id',
            ],
            "summary" => [
                "type" => Type::string(),
                "description" => "Summary of the blog",
            ],
            "description" => [
                "type" => Type::string(),
                "description" => "Full description of the blog",
            ],
            "isPublished" => [
                "type" => Type::string(),
                "description" => "Indicates whether the blog is published",
                "alias" => 'is_published',
            ],
            "createdAt" => [
                "type" => Type::string(),
                "description" => "blog created time",
                "alias" => 'created_at',
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
