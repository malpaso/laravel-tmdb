<?php

describe('Environment Configuration', function (): void {
    
    it('can load environment variables for tests', function (): void {
        // Check that configuration is accessible
        $accessToken = config('tmdb.access_token');
        $apiKey = config('tmdb.api_key');
        $baseUrl = config('tmdb.base_url');
        
        // At least one authentication method should be available
        expect($accessToken || $apiKey)->toBeTrue('Either TMDB_ACCESS_TOKEN or TMDB_API_KEY should be set in .env file');
        
        // Base URL should be set
        expect($baseUrl)->not->toBeEmpty();
        expect($baseUrl)->toStartWith('https://');
    });
    
    it('has correct cache configuration for tests', function (): void {
        // Cache should be disabled in tests by default
        $cacheEnabled = config('tmdb.cache.enabled');
        expect($cacheEnabled)->toBeFalse('Cache should be disabled in tests');
    });
    
    it('can access tmdb client from service container', function (): void {
        $client = app(\malpaso\LaravelTmdb\Contracts\TmdbClientInterface::class);
        expect($client)->toBeInstanceOf(\malpaso\LaravelTmdb\TmdbClient::class);
    });
    
});