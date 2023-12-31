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
                'rules' => ['required', 'string', 'max:64'],
            ],
            'summary' => [
                "type" => Type::string(),
                'rules' => ['required', 'string', 'max:155'],
            ],
            'description' => [
                "type" => Type::string(),
                'rules' => ['required'],
            ],
            'isPublished' => [
                "type" => Type::boolean(),
                'rules' => ['required', 'boolean'],
                "alias" => 'is_published',
            ],
            'mediaId' => [
                "type" => Type::int(),
                'rules' => ['required', 'exists:media,id'],
                "alias" => 'media_id',
            ]
        ];
    }
}
