<?php

namespace malpaso\LaravelTmdb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \malpaso\LaravelTmdb\Services\MovieService movies()
 * @method static \malpaso\LaravelTmdb\Services\TvService tv()
 * @method static \malpaso\LaravelTmdb\Services\PersonService people()
 * @method static \malpaso\LaravelTmdb\Services\SearchService search()
 * @method static \malpaso\LaravelTmdb\Services\ConfigurationService configuration()
 * @method static \malpaso\LaravelTmdb\TmdbClient client()
 * @method static array get(string $endpoint, array $params = [])
 * @method static array post(string $endpoint, array $data = [], array $params = [])
 * @method static array put(string $endpoint, array $data = [], array $params = [])
 * @method static array delete(string $endpoint, array $params = [])
 * @method static self language(string $language)
 * @method static self region(string $region)
 * @method static self withoutCache()
 * @method static self cacheTtl(int $ttl)
 *
 * @see \malpaso\LaravelTmdb\TmdbManager
 */
class Tmdb extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'tmdb';
    }
}