<?php

namespace App\GraphQL\Queries\Blog;

use App\Services\BlogService;
use App\Traits\SelectFieldTrait;
use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class BlogCollectionQuery extends Query
{
    use SelectFieldTrait;

    public function __construct(private BlogService $blogService)
    {
    }

    protected $attributes = [
        'name' => 'blog collection',
    ];

    public function type(): Type
    {
        return GraphQL::paginate('blogType');
    }

    public function args(): array
    {
        return [
            'search' => [
                'type' => Type::string(),
                'description' => 'Search base on title and summary',
                'rules' => ['nullable']
            ],
            'category_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the category to filter on',
                'rules' => ['nullable']
            ],
            'limit' => [
                'type' => Type::int(),
                'description' => 'pagination limit',
                'rules' => ['nullable']
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'pagination page',
                'rules' => ['nullable']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        return $this->blogService->collection($fields, $args);
    }
}
