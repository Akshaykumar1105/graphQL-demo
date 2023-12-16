<?php

namespace App\Graphql\Mutations\Blog;

use Closure;
use App\Services\BlogService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
class DeleteBlog extends Mutation
{

    public function __construct(private BlogService $blogService){

    }

    protected $attributes = [
        'name' => 'delete blog',
        'description' => 'A mutation for delete blog'
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
                'rules' => [ 'required','exists:blogs,id'],
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->blogService->destroy($args['id']);
    }
}
