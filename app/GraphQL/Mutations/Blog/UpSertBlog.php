<?php

namespace App\Graphql\Mutations\Blog;

use Closure;
use App\Services\BlogService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;


class UpSertBlog extends Mutation
{

    public function __construct(private BlogService $blogService){

    }

    protected $attributes = [
        'name' => 'blog',
        'description' => 'A mutation for blog create and update blog'
    ];


    public function type(): Type
    {
        return GraphQL::type("blogType");
    }

    public function args(): array
    {
        return [
            'id' => [
                "type" => Type::int(),
                'rules' => [ 'nullable','exists:blogs,id'],
            ],
            'input' => [
                "type" => GraphQL::type("blogInput"),
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $fileds = $getSelectFields();
        $args['select'] = $fileds->getSelect();
        $args['with'] = $fileds->getRelations();

        if(!isset($args['id'])){
          return  $this->blogService->store($args['input']);
        }

        return $this->blogService->update($args['id'], $args['input']);
    }
}
