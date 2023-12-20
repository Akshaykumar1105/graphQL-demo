<?php

namespace App\GraphQL\Queries\Blog;

use Closure;
use App\Services\BlogService;
use App\Traits\SelectFieldTrait;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BlogCollectionQuery extends Query
{
    use SelectFieldTrait;

    public function __construct(private BlogService $blogService)
    {
    }

    protected $attributes = [
        'name' => 'blogCollection',
        'description' => 'A query for list of blogs'
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
            'input' => [
                'type' => GraphQL::type('blogFilterInput')
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();
        $args['with'] = $fileds->getRelations();

        if (isset($args['with']['user'])) {
            unset($args['with']['user']);
        }
        
        return $this->blogService->collection($args);
    }
}
