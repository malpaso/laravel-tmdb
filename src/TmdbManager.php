<?php

namespace malpaso\LaravelTmdb;

use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;
use malpaso\LaravelTmdb\Services\ConfigurationService;
use malpaso\LaravelTmdb\Services\MovieService;
use malpaso\LaravelTmdb\Services\PersonService;
use malpaso\LaravelTmdb\Services\SearchService;
use malpaso\LaravelTmdb\Services\TvService;

class TmdbManager
{
    protected ?MovieService $movieService = null;
    protected ?TvService $tvService = null;
    protected ?PersonService $personService = null;
    protected ?SearchService $searchService = null;
    protected ?ConfigurationService $configurationService = null;

    public function __construct(protected TmdbClientInterface $client)
    {
    }

    /**
     * Get the movie service.
     */
    public function movies(): MovieService
    {
        if (!$this->movieService instanceof \malpaso\LaravelTmdb\Services\MovieService) {
            $this->movieService = new MovieService($this->client);
        }

        return $this->movieService;
    }

    /**
     * Get the TV service.
     */
    public function tv(): TvService
    {
        if (!$this->tvService instanceof \malpaso\LaravelTmdb\Services\TvService) {
            $this->tvService = new TvService($this->client);
        }

        return $this->tvService;
    }

    /**
     * Get the person service.
     */
    public function people(): PersonService
    {
        if (!$this->personService instanceof \malpaso\LaravelTmdb\Services\PersonService) {
            $this->personService = new PersonService($this->client);
        }

        return $this->personService;
    }

    /**
     * Get the search service.
     */
    public function search(): SearchService
    {
        if (!$this->searchService instanceof \malpaso\LaravelTmdb\Services\SearchService) {
            $this->searchService = new SearchService($this->client);
        }

        return $this->searchService;
    }

    /**
     * Get the configuration service.
     */
    public function configuration(): ConfigurationService
    {
        if (!$this->configurationService instanceof \malpaso\LaravelTmdb\Services\ConfigurationService) {
            $this->configurationService = new ConfigurationService($this->client);
        }

        return $this->configurationService;
    }

    /**
     * Get the underlying client.
     */
    public function client(): TmdbClientInterface
    {
        return $this->client;
    }

    /**
     * Proxy method calls to the client.
     *
     * @param string $method Method name to call on the client
     * @param array<int, mixed> $arguments Method arguments to pass to the client
     * @return mixed Result from the client method call
     */
    public function __call(string $method, array $arguments)
    {
        return $this->client->$method(...$arguments);
    }
}