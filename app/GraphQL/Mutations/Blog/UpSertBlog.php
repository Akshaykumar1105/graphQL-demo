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

    public function __construct(private BlogService $blogservice){

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
                "name" => "blog_id",
                "type" => Type::int(),
                'rules' => [ 'nullable','exists:blogs,id'],
            ],
            'category_id' => [
                "type" => Type::int(),
                'rules' => ['required', 'exists:categories,id'],
            ],
            'title' => [
                "type" => Type::string(),
                'rules' => ['required', 'string'],
            ],
            'summary' => [
                "type" => Type::string(),
                'rules' => ['required', 'string'],
            ],
            'description' => [
                "type" => Type::string(),
                'rules' => ['required'],
            ],
            'is_published' => [
                "type" => Type::boolean(),
                'rules' => ['required'],
            ],
            'mediaId' => [
                "type" => Type::int(),
                'rules' => ['required', 'exists:media,id'],
                "alias" => 'media_id',
            ]
            
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if(!isset($args['id'])){
          return  $this->blogservice->store($args);
        }

        return $this->blogservice->update($args);
    }
}
