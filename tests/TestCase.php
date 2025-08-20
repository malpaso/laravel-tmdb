<?php

namespace malpaso\LaravelTmdb\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use malpaso\LaravelTmdb\TmdbServiceProvider;
use Dotenv\Dotenv;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            TmdbServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Tmdb' => \malpaso\LaravelTmdb\Facades\Tmdb::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Load .env file if it exists
        $this->loadEnvironmentVariables();
        
        // Set up test environment
        $app['config']->set('database.default', 'testing');
        $app['config']->set('cache.default', 'array');
        
        // Load TMDB config from environment variables
        $app['config']->set('tmdb.access_token', env('TMDB_ACCESS_TOKEN'));
        $app['config']->set('tmdb.api_key', env('TMDB_API_KEY'));
        $app['config']->set('tmdb.base_url', env('TMDB_BASE_URL', 'https://api.themoviedb.org/3'));
        $app['config']->set('tmdb.language', env('TMDB_LANGUAGE', 'en-US'));
        $app['config']->set('tmdb.region', env('TMDB_REGION', 'US'));
        $app['config']->set('tmdb.cache.enabled', false); // Always disable cache in tests
        $app['config']->set('tmdb.cache.ttl', env('TMDB_CACHE_TTL', 3600));
        $app['config']->set('tmdb.cache.prefix', env('TMDB_CACHE_PREFIX', 'tmdb'));
        $app['config']->set('tmdb.http.timeout', env('TMDB_HTTP_TIMEOUT', 30));
        $app['config']->set('tmdb.http.connect_timeout', env('TMDB_HTTP_CONNECT_TIMEOUT', 10));
        $app['config']->set('tmdb.http.verify', env('TMDB_HTTP_VERIFY_SSL', true));
    }

    /**
     * Load environment variables from .env file if it exists.
     */
    protected function loadEnvironmentVariables(): void
    {
        $envPath = __DIR__ . '/..';
        $envFile = $envPath . '/.env';
        
        if (file_exists($envFile)) {
            $dotenv = Dotenv::createImmutable($envPath);
            $dotenv->safeLoad();
        }
    }

    /**
     * Check if integration tests can run (credentials are available).
     */
    protected function canRunIntegrationTests(): bool
    {
        $accessToken = config('tmdb.access_token');
        $apiKey = config('tmdb.api_key');
        
        return !empty($accessToken) || !empty($apiKey);
    }

    /**
     * Skip test if integration credentials are not available.
     */
    protected function skipIfNoCredentials(): void
    {
        if (!$this->canRunIntegrationTests()) {
            $this->markTestSkipped(
                'TMDB credentials not provided. Set TMDB_ACCESS_TOKEN or TMDB_API_KEY in your .env file to run integration tests.'
            );
        }
    }
}