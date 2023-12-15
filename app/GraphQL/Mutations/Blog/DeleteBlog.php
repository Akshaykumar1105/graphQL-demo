<?php

namespace App\Graphql\Mutations\Blog;

use App\Services\BlogService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;


class DeleteBlog extends Mutation
{

    public function __construct(private BlogService $blogservice){

    }

    protected $attributes = [
        'name' => 'deleteBlog',
        'description' => 'A mutation for login'
    ];


    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                "type" => Type::int(),
                'rules' => [ 'nullable','exists:blogs,id'],
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->blogservice->destroy($args);
    }
}
