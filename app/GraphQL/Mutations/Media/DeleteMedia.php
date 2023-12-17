<?php

namespace App\Graphql\Mutations\Media;

use Closure;
use App\Services\MediaService;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\ResolveInfo;

class DeleteMedia extends Mutation
{

    public function __construct(private MediaService $mediaService)
    {
    }

    protected $attributes = [
        'name' => 'deleteMedia',
        'description' => 'A mutation for delete media'
    ];


    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'rules' => ['required', 'exists:media,id'],
            ],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return $this->mediaService->destroy($args['id']);
    }
}
