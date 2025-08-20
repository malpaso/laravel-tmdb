<?php

return [
    /*
    |--------------------------------------------------------------------------
    | TMDB API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for The Movie Database (TMDB) API integration.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your TMDB API key. You can get this from:
    | https://www.themoviedb.org/settings/api
    |
    */
    'api_key' => env('TMDB_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Access Token
    |--------------------------------------------------------------------------
    |
    | Your TMDB API Read Access Token (Bearer token).
    | This is the preferred authentication method.
    |
    */
    'access_token' => env('TMDB_ACCESS_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for TMDB API requests.
    |
    */
    'base_url' => env('TMDB_BASE_URL', 'https://api.themoviedb.org/3'),

    /*
    |--------------------------------------------------------------------------
    | Image Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for TMDB images. This will be fetched from the API
    | configuration endpoint if not set.
    |
    */
    'image_base_url' => env('TMDB_IMAGE_BASE_URL', 'https://image.tmdb.org/t/p/'),

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | The default language for API requests.
    |
    */
    'language' => env('TMDB_LANGUAGE', 'en-US'),

    /*
    |--------------------------------------------------------------------------
    | Default Region
    |--------------------------------------------------------------------------
    |
    | The default region for API requests.
    |
    */
    'region' => env('TMDB_REGION', 'US'),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure caching for API responses.
    |
    */
    'cache' => [
        'enabled' => env('TMDB_CACHE_ENABLED', true),
        'ttl' => env('TMDB_CACHE_TTL', 3600), // 1 hour
        'prefix' => env('TMDB_CACHE_PREFIX', 'tmdb'),
    ],

    /*
    |--------------------------------------------------------------------------
    | HTTP Client Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the HTTP client.
    |
    */
    'http' => [
        'timeout' => env('TMDB_HTTP_TIMEOUT', 30),
        'connect_timeout' => env('TMDB_HTTP_CONNECT_TIMEOUT', 10),
        'verify' => env('TMDB_HTTP_VERIFY_SSL', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | TMDB API rate limiting configuration.
    | TMDB allows 40 requests per 10 seconds.
    |
    */
    'rate_limit' => [
        'requests_per_window' => 40,
        'window_seconds' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log
    |--------------------------------------------------------------------------
    |
    */
    'log' => [
        'enabled' => true,
        // Keep the path empty or remove it entirely to default to storage/logs/tmdb.log
        'path' => storage_path('logs/tmdb.log')
    ]
];