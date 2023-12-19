<?php

declare(strict_types=1);

return [
    'route' => [
        // The prefix for routes; do NOT use a leading slash!
        'prefix' => 'graphql',

        // The controller/method to use in GraphQL request.
        // Also supported array syntax: `[\Rebing\GraphQL\GraphQLController::class, 'query']`
        'controller' => \Rebing\GraphQL\GraphQLController::class . '@query',

        // Any middleware for the graphql route group
        // This middleware will apply to all schemas
        'middleware' => [],

        // Additional route group attributes
        //
        // Example:
        //
        // 'group_attributes' => ['guard' => 'api']
        //
        'group_attributes' => [],
    ],

    // The name of the default schema
    // Used when the route group is directly accessed
    'default_schema' => 'default',

    'batching' => [
        // Whether to support GraphQL batching or not.
        // See e.g. https://www.apollographql.com/blog/batching-client-graphql-queries-a685f5bcd41b/
        // for pro and con
        'enable' => true,
    ],

   
    'schemas' => [
        'default' => [
            'query' => [
                "blogCollection" => \App\GraphQL\Queries\Blog\BlogCollectionQuery::class,
                "blogResource" => \App\GraphQL\Queries\Blog\BlogResourceQuery::class,
                'userCollection' => \App\GraphQL\Queries\User\UserCollection::class,
                "categoryCollection" => \App\GraphQL\Queries\Category\CategoryCollectionQuery::class,
                "userResource" => \App\GraphQL\Queries\User\UserResource::class,
            ],
            'mutation' => [
               "logout" => App\Graphql\Mutations\Auth\Logout::class,
               "changePassword" => App\Graphql\Mutations\Auth\ChangePassword::class,
               "blog" => App\Graphql\Mutations\Blog\UpSertBlog::class,
               "deleteBlog" => \App\GraphQl\Mutations\Blog\DeleteBlog::class,
               "updateUserProfile" => \App\GraphQL\Mutations\User\UpdateUserProfile::class,
            ],
        

            // Laravel HTTP middleware
            'middleware' => ['auth:sanctum'],

            // Which HTTP methods to support; must be given in UPPERCASE!
            'method' => ['GET', 'POST'],

            // An array of middlewares, overrides the global ones
            'execution_middleware' => null,
        ],
        'open' => [
            'query' => [
                'userCollection' => \App\GraphQL\Queries\User\UserCollection::class,
            ],
            'mutation' => [
                "login" => App\Graphql\Mutations\Auth\Login::class,
                "signUp" => App\Graphql\Mutations\Auth\SignUp::class,
                "forgotPassword" => App\Graphql\Mutations\Auth\ForgotPassword::class,
                "resetPassword" => App\Graphql\Mutations\Auth\ResetPassword::class,
                "uploadMedia" => App\Graphql\Mutations\Media\UploadMedia::class,
                "deleteMedia" =>\App\Graphql\Mutations\Media\DeleteMedia::class,
            ],
            // The types only available in this schema
           
            // Laravel HTTP middleware
            'middleware' => null,

            // Which HTTP methods to support; must be given in UPPERCASE!
            'method' => ['GET', 'POST'],

            // An array of middlewares, overrides the global ones
            'execution_middleware' => null,
        ],
    ],
    
    'types' => [
        "userType" => App\GraphQL\Types\UserType::class,
        "loginUser" => \App\GraphQL\Types\LoginUser::class,
        "blogType" => \App\GraphQL\Types\BlogType::class,
        \Rebing\GraphQL\Support\UploadType::class,
        "mediaType" => \App\GraphQL\Types\Media::class,
        "categoryType" => \App\GraphQL\Types\CategoryType::class,
        "userInput" => \App\GraphQL\Types\UserInput::class,
        "blogInput" => \App\GraphQL\Types\BlogInput::class,
        "updateUserInput" => \App\GraphQL\Types\UpdateUserInput::class,
        'mediaInput' => \App\GraphQL\Types\MediaInput::class,
        'blogFilterInput' => \App\GraphQL\Types\BlogFilterInput::class,
        'resetPasswordInput' => \App\GraphQL\Types\ResetPasswordInput::class,
        // ExampleRelationType::class,
        // \Rebing\GraphQL\Support\UploadType::class,
    ],

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter' => [\App\GraphQL\ErrorHandler::class, 'formatError'],

    /*
     * Custom Error Handling
     *
     * Expected handler signature is: function (array $errors, callable $formatter): array
     *
     * The default handler will pass exceptions to laravel Error Handling mechanism
     */
    'errors_handler' => [\Rebing\GraphQL\GraphQL::class, 'handleErrors'],

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://webonyx.github.io/graphql-php/security
     * for details. Disabled by default.
     */
    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    /*
     * You can define your own simple pagination type.
     * Reference \Rebing\GraphQL\Support\SimplePaginationType::class
     */
    'simple_pagination_type' => \Rebing\GraphQL\Support\SimplePaginationType::class,

    /*
     * Overrides the default field resolver
     * See http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver
     *
     * Example:
     *
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */
    'defaultFieldResolver' => null,

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers' => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options' => 0,

    /*
     * Automatic Persisted Queries (APQ)
     * See https://www.apollographql.com/docs/apollo-server/performance/apq/
     *
     * Note 1: this requires the `AutomaticPersistedQueriesMiddleware` being enabled
     *
     * Note 2: even if APQ is disabled per configuration and, according to the "APQ specs" (see above),
     *         to return a correct response in case it's not enabled, the middleware needs to be active.
     *         Of course if you know you do not have a need for APQ, feel free to remove the middleware completely.
     */
    'apq' => [
        // Enable/Disable APQ - See https://www.apollographql.com/docs/apollo-server/performance/apq/#disabling-apq
        'enable' => env('GRAPHQL_APQ_ENABLE', false),

        // The cache driver used for APQ
        'cache_driver' => env('GRAPHQL_APQ_CACHE_DRIVER', config('cache.default')),

        // The cache prefix
        'cache_prefix' => config('cache.prefix') . ':graphql.apq',

        // The cache ttl in seconds - See https://www.apollographql.com/docs/apollo-server/performance/apq/#adjusting-cache-time-to-live-ttl
        'cache_ttl' => 300,
    ],

    /*
     * Execution middlewares
     */
    'execution_middleware' => [
        \Rebing\GraphQL\Support\ExecutionMiddleware\ValidateOperationParamsMiddleware::class,
        // AutomaticPersistedQueriesMiddleware listed even if APQ is disabled, see the docs for the `'apq'` configuration
        \Rebing\GraphQL\Support\ExecutionMiddleware\AutomaticPersistedQueriesMiddleware::class,
        \Rebing\GraphQL\Support\ExecutionMiddleware\AddAuthUserContextValueMiddleware::class,
        // \Rebing\GraphQL\Support\ExecutionMiddleware\UnusedVariablesMiddleware::class,
    ],
];
