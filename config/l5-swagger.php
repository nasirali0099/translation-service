<?php

return [

    'default' => 'default',

    'documentations' => [

        'default' => [
            'api' => [
                'title' => 'Translation Service API',
            ],

            'routes' => [
                'docs' => 'api/documentation',
                'oauth2_callback' => 'api/oauth2-callback',
                'middleware' => [
                    'api' => [],
                    'asset' => [],
                    'docs' => [],
                    'oauth2_callback' => [],
                ],
            ],

            'paths' => [
                'docs' => storage_path('api-docs'),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',

                'annotations' => [
                    base_path('app/Swagger'),
                    base_path('app/Http/Controllers'),
                ],

                'excludes' => [],

                'base' => base_path(),

                'use_absolute_path' => true,

                'format_to_use_for_docs' => 'json',
            ],

            'securityDefinitions' => [
                'securitySchemes' => [],
            ],
        ],
    ],

    'defaults' => [

        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
        ],

        'paths' => [
            'docs' => storage_path('api-docs'),
            'views' => resource_path('views/vendor/l5-swagger'),

            'base' => base_path(),

            'use_absolute_path' => true,

            'docs_json' => 'api-docs.json',
            'docs_yaml' => 'api-docs.yaml',

            'annotations' => [
                base_path('app'),
            ],

            'excludes' => [],
        ],

        'generate_always' => true,
        'generate_yaml_copy' => false,

        'proxy' => false,

        'additional_config_url' => null,

        'operations_sort' => null,

        'validator_url' => null,

        'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', 'http://127.0.0.1:8000'),
        ],

        'ui' => [
            'display' => [
                'doc_expansion' => 'none',
                'filter' => true,
            ],

            'authorization' => [
                'persist_authorization' => true,
                'oauth2' => [
                    'use_pkce_with_authorization_code_grant' => false,
                ],
            ],
        ],
    ],
];