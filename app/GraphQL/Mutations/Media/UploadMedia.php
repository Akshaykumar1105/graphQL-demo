<?php

namespace App\Graphql\Mutations\Media;

use Closure;
use App\Services\MediaService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;


class UploadMedia extends Mutation
{

    public function __construct(private MediaService $mediaService)
    {
    }

    protected $attributes = [
        'name' => 'uploadMedia',
        'description' => 'A mutation for upload img'
    ];


    public function type(): Type
    {
        return GraphQL::type("mediaType");
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'rules' => ['nullable', 'exists:media,id'],
            ],
            'image' => [
                'type' => GraphQL::type('Upload'),
                'rules' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:15000'],
            ],
            'image_type' => [
                'type' => Type::string(),
                'rules' => ['required', 'in:' . implode(',', config('site.mediaType'))],
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->mediaService->store($args);
    }
}
