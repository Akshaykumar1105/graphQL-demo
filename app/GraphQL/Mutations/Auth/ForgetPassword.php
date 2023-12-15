<?php

namespace App\Graphql\Mutations\Auth;

use App\Helpers\Helper;
use App\Mail\ForgetPassword as MailForgetPassword;
use App\Models\User as ModelsUser;
use App\Services\AuthService;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Mail;
use Rebing\GraphQL\Support\Mutation;

class ForgetPassword extends Mutation{

    public function __construct(private AuthService $authService){

    }
   

    protected $attributes = [
        'name' => 'forgetPassword',
        'description' => 'A mutation for forget password'
    ];
    

    public function type(): Type
    {
        return type::boolean();
    }

    public function args(): array
    {
        return [
            'email' => [
                "type" => Type::string(),
                'rules' => ['required', 'email',  'exists:users,email'],
            ]
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
       return $this->authService->forgetPassword($args);
    }
}
