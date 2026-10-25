<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    /*
     * Which routes to document. String or array form; use Scramble::routes() for custom selection.
     *
     * 'api_path' => [
     *     'include' => 'api',
     *     'exclude' => ['api/internal'],
     * ],
     *
     * Without *, patterns match path segments (api matches api and api/users, not apiary).
     * With *, Str::is is used (e.g. api/v*).
     *
     * One static include → default server is /{include} and paths are stripped (/users).
     * Multiple includes or wildcards → server defaults to / and paths stay full (/api/users).
     * Override with `servers`, or use Scramble::registerApi() for separate bases.
     */
    'api_path' => [
        'include' => 'v2',
        'exclude' => [
            'v2/push',
            'v2/push/*',
            'v2/admin',
            'v2/admin/*',
            'v2/{fallbackPlaceholder}',
        ],
    ],

    /*
     * Your API domain. By default, app domain is used. This is also a part of the default API routes
     * matcher, so when implementing your own, make sure you use this config if needed.
     */
    'api_domain' => env('API_DOMAIN', null),

    /*
     * The path where your OpenAPI specification will be exported.
     */
    'export_path' => 'api.json',

    /*
     * Cache configuration for the generated OpenAPI document.
     *
     * Use `scramble:cache` to warm the cache and `scramble:clear` to invalidate it.
     */
    'cache' => [
        'key' => 'scramble.openapi',
        'store' => 'file',
    ],

    'info' => [
        /*
         * API version.
         */
        'version' => env('API_VERSION', '2.0.0'),

        /*
         * Description rendered on the home page of the API documentation (`/docs/api`).
         */
        'description' => <<<'INTRO'
Welcome to the Transit Tracker API Documentation! The API is completely free, as long as it is used without excess. Transit Tracker data is free of charge, but it is mandatory to credit agency data when specified. Credits are registered in the `v2/agencies` API, in the `license` object.

Bienvenue à la documentation de l'API de Transit Tracker! L'API est complètement gratuite, tant qu'elle est utilisée sans excès. Les données de Transit Tracker sont libre de droit, mais il est obligatoire de créditer les données des agences lorsque spécifié. Les crédits sont inscrits dans l'API `v2/agencies`, dans l'objet `license`.
INTRO,
    ],

    'ui' => [
        'title' => 'Transit Tracker API',
    ],

    /*
     * Load Scramble's development tools on documentation pages. An explicit
     * SCRAMBLE_DEV_TOOLS value takes precedence over APP_DEBUG.
     */
    'dev_tools' => [
        'enabled' => env('SCRAMBLE_DEV_TOOLS', env('APP_DEBUG', false)),
    ],

    'renderer' => 'scalar',

    'renderers' => [
        /*
         * Stoplight Elements config options: https://docs.stoplight.io/docs/elements/b074dc47b2826-elements-configuration-options
         */
        'elements' => [
            'view' => 'scramble::docs',
            'theme' => 'light',
            'hideTryIt' => false,
            'hideSchemas' => false,
            'logo' => '',
            'tryItCredentialsPolicy' => 'include',
            'layout' => 'responsive',
            'router' => 'hash',
        ],
        /*
         * Scalar API reference config options: https://scalar.com/products/api-references/configuration
         */
        'scalar' => [
            'view' => 'scramble::scalar',
            'cdn' => 'https://cdn.jsdelivr.net/npm/@scalar/api-reference',
            'theme' => 'none',
            'proxyUrl' => 'https://proxy.scalar.com',
            'darkMode' => false,
            'showDeveloperTools' => 'never',
            'agent' => ['disabled' => true],
            'credentials' => 'include',
            'customCss' => <<<'CSS'
:root {
    --scalar-font: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    --scalar-radius: 8px;
    --scalar-radius-lg: 12px;
}

.light-mode {
    --scalar-color-1: #00101e;
    --scalar-color-2: #2b3137;
    --scalar-color-3: #595f66;
    --scalar-color-accent: #00639a;
    --scalar-background-1: #ffffff;
    --scalar-background-2: #f6f9ff;
    --scalar-background-3: #ebf4ff;
    --scalar-border-color: #dee3eb;
    --scalar-sidebar-background-1: #f6f9ff;
    --scalar-sidebar-color-1: #001d32;
    --scalar-sidebar-color-2: #41474d;
    --scalar-sidebar-border-color: #dee3eb;
    --scalar-sidebar-item-hover-background: #e1efff;
    --scalar-sidebar-item-active-background: #cbe5ff;
}

.dark-mode {
    --scalar-color-1: #f6f9ff;
    --scalar-color-2: #c2c7ce;
    --scalar-color-3: #8c9198;
    --scalar-color-accent: #62b2f3;
    --scalar-background-1: #001526;
    --scalar-background-2: #001d32;
    --scalar-background-3: #002c48;
    --scalar-border-color: #00385a;
    --scalar-sidebar-background-1: #00101e;
    --scalar-sidebar-color-1: #e7f2ff;
    --scalar-sidebar-color-2: #a7acb3;
    --scalar-sidebar-border-color: #002c48;
    --scalar-sidebar-item-hover-background: #002c48;
    --scalar-sidebar-item-active-background: #00385a;
}
CSS,
        ],
    ],

    /*
     * The list of servers of the API. By default, when `null`, server URL will be created from
     * `scramble.api_path` and `scramble.api_domain` config variables. When providing an array, you
     * will need to specify the local server URL manually (if needed).
     *
     * Example of non-default config (final URLs are generated using Laravel `url` helper):
     *
     * ```php
     * 'servers' => [
     *     'Live' => 'api',
     *     'Prod' => 'https://scramble.dedoc.co/api',
     * ],
     * ```
     */
    'servers' => null,

    /**
     * Determines how Scramble stores the descriptions of enum cases.
     * Available options:
     * - 'description' – Case descriptions are stored as the enum schema's description using table formatting.
     * - 'extension' – Case descriptions are stored in the `x-enumDescriptions` enum schema extension.
     *
     *    @see https://redocly.com/docs-legacy/api-reference-docs/specification-extensions/x-enum-descriptions
     * - false - Case descriptions are ignored.
     */
    'enum_cases_description_strategy' => 'description',

    /**
     * Determines how Scramble stores the names of enum cases.
     * Available options:
     * - 'names' – Case names are stored in the `x-enumNames` enum schema extension.
     * - 'varnames' - Case names are stored in the `x-enum-varnames` enum schema extension.
     * - false - Case names are not stored.
     */
    'enum_cases_names_strategy' => false,

    /**
     * When Scramble encounters deep objects in query parameters, it flattens the parameters so the generated
     * OpenAPI document correctly describes the API. Flattening deep query parameters is relevant until
     * OpenAPI 3.2 is released and query string structure can be described properly.
     *
     * For example, this nested validation rule describes the object with `bar` property:
     * `['foo.bar' => ['required', 'int']]`.
     *
     * When `flatten_deep_query_parameters` is `true`, Scramble will document the parameter like so:
     * `{"name":"foo[bar]", "schema":{"type":"int"}, "required":true}`.
     *
     * When `flatten_deep_query_parameters` is `false`, Scramble will document the parameter like so:
     *  `{"name":"foo", "schema": {"type":"object", "properties":{"bar":{"type": "int"}}, "required": ["bar"]}, "required":true}`.
     */
    'flatten_deep_query_parameters' => true,

    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],

    /*
     * Automatically document API security (OpenAPI `security` / `securitySchemes`) based on route
     * middleware.
     *
     * Disabled by default. Uncomment the line below to enable `MiddlewareAuthSecurityStrategy`.
     * When at least one documented route uses middleware matching the configured patterns (by default
     * `auth` and `auth:*`), bearer auth is applied globally. Routes without matching middleware are
     * marked as public (`security: []`).
     *
     * Set to `null` explicitly to disable. If you already configure security manually via
     * `afterOpenApiGenerated` / `extendOpenApi`, keep this disabled to avoid duplicate schemes.
     *
     * Customize with a class-string or [class, options]:
     *
     * 'security_strategy' => [
     *     \Dedoc\Scramble\SecurityDocumentation\MiddlewareAuthSecurityStrategy::class,
     *     [
     *         'middleware' => ['auth', 'auth:*'],
     *         'scheme' => \Dedoc\Scramble\Support\Generator\SecurityScheme::http('bearer'),
     *     ],
     * ],
     */
    // 'security_strategy' => \Dedoc\Scramble\SecurityDocumentation\MiddlewareAuthSecurityStrategy::class,
    'security_strategy' => null,
];
