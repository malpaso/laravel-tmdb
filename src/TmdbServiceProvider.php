<?php

namespace malpaso\LaravelTmdb;

use GuzzleHttp\Client;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\ServiceProvider;
use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;

class TmdbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/tmdb.php', 'tmdb'
        );

        $this->registerClient();
        $this->registerManager();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishConfig();
        $this->validateConfig();
    }

    /**
     * Register the TMDB client.
     */
    protected function registerClient(): void
    {
        $this->app->singleton(TmdbClientInterface::class, function ($app): \malpaso\LaravelTmdb\TmdbClient {
            $config = $app['config']['tmdb'];
            
            $httpClient = new Client([
                'base_uri' => $config['base_url'],
                'timeout' => $config['http']['timeout'] ?? 30,
                'connect_timeout' => $config['http']['connect_timeout'] ?? 10,
                'verify' => $config['http']['verify'] ?? true,
            ]);

            return new TmdbClient(
                $httpClient,
                $app[CacheManager::class],
                $config
            );
        });

        $this->app->alias(TmdbClientInterface::class, 'tmdb.client');
    }

    /**
     * Register the TMDB manager.
     */
    protected function registerManager(): void
    {
        $this->app->singleton('tmdb', fn($app): \malpaso\LaravelTmdb\TmdbManager => new TmdbManager($app[TmdbClientInterface::class]));

        $this->app->alias('tmdb', TmdbManager::class);
    }

    /**
     * Publish the configuration file.
     */
    protected function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/tmdb.php' => config_path('tmdb.php'),
        ], 'tmdb-config');
    }

    /**
     * Validate the configuration.
     */
    protected function validateConfig(): void
    {
        $config = $this->app->make('config')->get('tmdb');

        if (empty($config['api_key']) && empty($config['access_token'])) {
            throw new \InvalidArgumentException(
                'TMDB API key or access token is required. Please set TMDB_API_KEY or TMDB_ACCESS_TOKEN in your .env file.'
            );
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string> List of service identifiers provided by this service provider
     */
    public function provides(): array
    {
        return [
            'tmdb',
            'tmdb.client',
            TmdbManager::class,
            TmdbClientInterface::class,
        ];
    }
}