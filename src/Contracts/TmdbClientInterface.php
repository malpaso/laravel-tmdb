<?php

namespace malpaso\LaravelTmdb\Contracts;

interface TmdbClientInterface
{
    /**
     * Make a GET request to the TMDB API.
     */
    public function get(string $endpoint, array $params = []): array;

    /**
     * Make a POST request to the TMDB API.
     */
    public function post(string $endpoint, array $data = [], array $params = []): array;

    /**
     * Make a PUT request to the TMDB API.
     */
    public function put(string $endpoint, array $data = [], array $params = []): array;

    /**
     * Make a DELETE request to the TMDB API.
     */
    public function delete(string $endpoint, array $params = []): array;

    /**
     * Set the language for API requests.
     */
    public function language(string $language): self;

    /**
     * Set the region for API requests.
     */
    public function region(string $region): self;

    /**
     * Disable caching for the next request.
     */
    public function withoutCache(): self;

    /**
     * Set custom cache TTL for the next request.
     */
    public function cacheTtl(int $ttl): self;
}