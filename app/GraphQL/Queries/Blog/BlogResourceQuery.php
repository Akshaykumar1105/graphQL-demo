<?php

namespace App\GraphQL\Queries\Blog;

use Closure;
use App\Services\BlogService;
use App\Traits\SelectFieldTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BlogResourceQuery extends Query
{
    use SelectFieldTrait;

    public function __construct(private BlogService $blogService)
    {
    }

    protected $attributes = [
        'name' => 'blog resource',
        'description' => 'A query for blog'
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
                'rules' => ['required', 'exists:blogs,id']
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();
        $args['with'] = $fileds->getRelations();

        return $this->blogService->resource($args['id'], $args);
    }
}
