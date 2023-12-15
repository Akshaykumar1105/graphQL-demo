<?php

namespace App\GraphQL\Queries\Category;

use Closure;
use App\Services\CategoryService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CategoryCollection extends Query
{

    public function __construct(private CategoryService $categoryService)
    {
    }

    protected $attributes = [
        'name' => 'categoryCollection',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('categoryType'));
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->categoryService->collection();
    }
}
