<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Blog;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;


class BlogInput extends InputType
{
    protected $attributes = [
        'name' => 'blogInput',
        'description' => 'A type of blog input',
        'model' => Blog::class
    ];

    public function fields(): array
    {
        return [
            'categoryId' => [
                "type" => Type::int(),
                'rules' => ['required', 'exists:categories,id'],
                "alias" => 'category_id',
            ],
            'title' => [
                "type" => Type::string(),
                'rules' => ['required', 'string'],
            ],
            'summary' => [
                "type" => Type::string(),
                'rules' => ['required', 'string'],
            ],
            'description' => [
                "type" => Type::string(),
                'rules' => ['required'],
            ],
            'is_published' => [
                "type" => Type::boolean(),
                'rules' => ['required'],
            ],
            'mediaId' => [
                "type" => Type::int(),
                'rules' => ['required', 'exists:media,id'],
                "alias" => 'media_id',
            ]
        ];
    }
}
