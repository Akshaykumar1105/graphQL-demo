<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;


class BlogFilterInput extends InputType
{
    protected $attributes = [
        'name' => 'blogFilterInput',
        'description' => 'A type of blog filter input',
    ];

    public function fields(): array
    {
        return [
            'categoryId' => [
                "type" => Type::int(),
                'rules' => ['nullable', 'exists:categories,id'],
                "alias" => 'category_id',
            ],
            'isPublished' => [
                "type" => Type::boolean(),
                'rules' => ['nullable', 'boolean'],
                "alias" => 'is_published',
            ],
        ];
    }
}
