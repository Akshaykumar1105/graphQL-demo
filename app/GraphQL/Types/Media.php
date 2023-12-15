<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as FacadesGraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Media extends GraphQLType
{
    protected $attributes = [
        'name' => 'mediaType',
        'description' => 'A type'
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
            "mime_type" => [
                'type' => Type::string(),
                'description' => "mime type of media"
            ],
            "size" => [
                'type' => Type::string(),
                'description' => "size of media"
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => "created media time"
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => "updated media time"
            ]
         ];
    }
}
