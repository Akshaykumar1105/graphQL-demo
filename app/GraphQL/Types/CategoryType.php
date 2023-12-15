<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL as FacadesGraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'categoryType',
        'description' => 'A type category',
        'model' => Category::class,
    ];

    public function fields(): array
    {
        return [
            "id" => [
                'type' => Type::int(),
                'description' => "id for category"
            ],
            "name" => [
                'type' => Type::string(),
                'description' => "name of category"
            ],

        ];
    }
}
