<?php

namespace malpaso\LaravelTmdb\Services;

use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;

class SearchService
{
    public function __construct(protected TmdbClientInterface $client)
    {
    }

    /**
     * Search for movies.
     *
     * @param array $params Additional parameters (year, primary_release_year, etc.)
     */
    public function movies(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/movie', $params);
    }

    /**
     * Search for TV shows.
     *
     * @param array $params Additional parameters (first_air_date_year, etc.)
     */
    public function tv(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/tv', $params);
    }

    /**
     * Search for people.
     *
     * @param array $params Additional parameters (include_adult, etc.)
     */
    public function people(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/person', $params);
    }

    /**
     * Search for companies.
     */
    public function companies(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/company', $params);
    }

    /**
     * Search for collections.
     */
    public function collections(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/collection', $params);
    }

    /**
     * Search for keywords.
     */
    public function keywords(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/keyword', $params);
    }

    /**
     * Multi search across movies, TV shows, and people.
     */
    public function multi(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/multi', $params);
    }

    /**
     * Search with pagination support.
     *
     * @param string $type Search type (movie, tv, person, multi, etc.)
     */
    public function paginated(string $type, string $query, int $page = 1, array $params = []): array
    {
        $params['query'] = $query;
        $params['page'] = $page;
        
        return $this->client->get("search/{$type}", $params);
    }

    /**
     * Advanced movie search with multiple filters.
     */
    public function moviesAdvanced(string $query, array $filters = []): array
    {
        $params = array_merge($filters, ['query' => $query]);
        
        return $this->client->get('search/movie', $params);
    }

    /**
     * Advanced TV search with multiple filters.
     */
    public function tvAdvanced(string $query, array $filters = []): array
    {
        $params = array_merge($filters, ['query' => $query]);
        
        return $this->client->get('search/tv', $params);
    }
}