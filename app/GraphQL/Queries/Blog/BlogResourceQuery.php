<?php

namespace App\GraphQL\Queries\Blog;

use App\Models\User as ModelsUser;
use App\Services\BlogService;
use App\Traits\SelectFieldTrait;
use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class BlogResourceQuery extends Query
{
    use SelectFieldTrait;

    public function __construct(private BlogService $blogService)
    {
    }

    protected $attributes = [
        'name' => 'blog resource',
    ];

    public function type(): Type
    {
        return GraphQL::type('blogType');
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'ID of the blog',
                'rules' => ['nullable', 'exists:blogs,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();
        return $this->blogService->resource($args, $select, $with);
    }
}
