<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Media extends GraphQLType
{
    protected $attributes = [
        'name' => 'mediaType',
        'description' => 'A type media'
    ];

    public function fields(): array
    {
        return [
            "id" => [
                'type' => Type::int(),
                'description' => "media"
            ],
            "disk" => [
                'type' => Type::string(),
                'description' => "disk of media"
            ],
            "directory" => [
                'type' => Type::string(),
                'description' => "directory of media"
            ],
            "filename" => [
                'type' => Type::string(),
                'description' => "filename of media"
            ],
            "extension" => [
                'type' => Type::string(),
                'description' => "extension of media"
            ],
            "mimeType" => [
                'type' => Type::string(),
                'description' => "mime type of media",
                "alias" => 'mime_type',
            ],
            "size" => [
                'type' => Type::string(),
                'description' => "size of media"
            ],
            'createdAt' => [
                'type' => Type::string(),
                'description' => "created media time",
                "alias" => 'created_at',
            ],
            'updatedAt' => [
                'type' => Type::string(),
                'description' => "updated media time",
                "alias" => 'updated_at',
            ]
         ];
    }
}
