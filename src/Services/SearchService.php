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
     * @param string $query Search query string
     * @param array<string, mixed> $params Additional parameters (year, primary_release_year, etc.)
     * @return array<string, mixed> Movie search results from TMDB API
     */
    public function movies(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/movie', $params);
    }

    /**
     * Search for TV shows.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $params Additional parameters (first_air_date_year, etc.)
     * @return array<string, mixed> TV show search results from TMDB API
     */
    public function tv(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/tv', $params);
    }

    /**
     * Search for people.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $params Additional parameters (include_adult, etc.)
     * @return array<string, mixed> People search results from TMDB API
     */
    public function people(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/person', $params);
    }

    /**
     * Search for companies.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $params Additional query parameters
     * @return array<string, mixed> Company search results from TMDB API
     */
    public function companies(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/company', $params);
    }

    /**
     * Search for collections.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $params Additional query parameters
     * @return array<string, mixed> Collection search results from TMDB API
     */
    public function collections(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/collection', $params);
    }

    /**
     * Search for keywords.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $params Additional query parameters
     * @return array<string, mixed> Keyword search results from TMDB API
     */
    public function keywords(string $query, array $params = []): array
    {
        $params['query'] = $query;
        
        return $this->client->get('search/keyword', $params);
    }

    /**
     * Multi search across movies, TV shows, and people.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $params Additional query parameters
     * @return array<string, mixed> Multi search results from TMDB API
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
     * @param string $query Search query string
     * @param int $page Page number for pagination
     * @param array<string, mixed> $params Additional query parameters
     * @return array<string, mixed> Paginated search results from TMDB API
     */
    public function paginated(string $type, string $query, int $page = 1, array $params = []): array
    {
        $params['query'] = $query;
        $params['page'] = $page;
        
        return $this->client->get("search/{$type}", $params);
    }

    /**
     * Advanced movie search with multiple filters.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $filters Advanced search filters (year, include_adult, etc.)
     * @return array<string, mixed> Advanced movie search results from TMDB API
     */
    public function moviesAdvanced(string $query, array $filters = []): array
    {
        $params = array_merge($filters, ['query' => $query]);
        
        return $this->client->get('search/movie', $params);
    }

    /**
     * Advanced TV search with multiple filters.
     *
     * @param string $query Search query string
     * @param array<string, mixed> $filters Advanced search filters (first_air_date_year, etc.)
     * @return array<string, mixed> Advanced TV search results from TMDB API
     */
    public function tvAdvanced(string $query, array $filters = []): array
    {
        $params = array_merge($filters, ['query' => $query]);
        
        return $this->client->get('search/tv', $params);
    }
}