<?php

namespace malpaso\LaravelTmdb\Contracts;

interface TmdbClientInterface
{
    /**
     * Make a GET request to the TMDB API.
     *
     * @param string $endpoint API endpoint
     * @param array<string, mixed> $params Query parameters
     * @return array<string, mixed> Decoded JSON response from TMDB API
     */
    public function get(string $endpoint, array $params = []): array;

    /**
     * Make a POST request to the TMDB API.
     *
     * @param string $endpoint API endpoint
     * @param array<string, mixed> $data Request body data
     * @param array<string, mixed> $params Query parameters
     * @return array<string, mixed> Decoded JSON response from TMDB API
     */
    public function post(string $endpoint, array $data = [], array $params = []): array;

    /**
     * Make a PUT request to the TMDB API.
     *
     * @param string $endpoint API endpoint
     * @param array<string, mixed> $data Request body data
     * @param array<string, mixed> $params Query parameters
     * @return array<string, mixed> Decoded JSON response from TMDB API
     */
    public function put(string $endpoint, array $data = [], array $params = []): array;

    /**
     * Make a DELETE request to the TMDB API.
     *
     * @param string $endpoint API endpoint
     * @param array<string, mixed> $params Query parameters
     * @return array<string, mixed> Decoded JSON response from TMDB API
     */
    public function delete(string $endpoint, array $params = []): array;

    /**
     * Set the language for API requests.
     *
     * @param string $language Language code (e.g., 'en-US', 'es-ES')
     * @return self Fluent interface for method chaining
     */
    public function language(string $language): self;

    /**
     * Set the region for API requests.
     *
     * @param string $region Region code (e.g., 'US', 'ES')
     * @return self Fluent interface for method chaining
     */
    public function region(string $region): self;

    /**
     * Disable caching for the next request.
     *
     * @return self Fluent interface for method chaining
     */
    public function withoutCache(): self;

    /**
     * Set custom cache TTL for the next request.
     *
     * @param int $ttl Cache TTL in seconds
     * @return self Fluent interface for method chaining
     */
    public function cacheTtl(int $ttl): self;
}