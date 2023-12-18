<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;
use Rebing\GraphQL\Support\Facades\GraphQL;


class MediaInput extends InputType
{
    protected $attributes = [
        'name' => 'mediaInput',
        'description' => 'A type of media input',
    ];

    public function fields(): array
    {
        return [
            'image' => [
                'type' => GraphQL::type('Upload'),
                'rules' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:15000'],
            ],
            'image_type' => [
                'type' => Type::string(),
                'rules' => ['required', 'in:' . implode(',', config('site.mediaType'))],
            ]
        ];
    }
}
