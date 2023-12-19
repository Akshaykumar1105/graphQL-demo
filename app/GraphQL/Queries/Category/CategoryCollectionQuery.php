<?php

namespace App\GraphQL\Queries\Category;

use Closure;
use App\Services\CategoryService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CategoryCollectionQuery extends Query
{

    public function __construct(private CategoryService $categoryService)
    {
    }

    protected $attributes = [
        'name' => 'categoryCollection',
        'description' => 'A query for list of category'
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
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();
        $args['with'] = $fileds->getRelations();

        return $this->categoryService->collection($args);
    }
}
