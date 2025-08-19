<?php

namespace malpaso\LaravelTmdb;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Arr;
use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;
use malpaso\LaravelTmdb\Exceptions\TmdbException;

class TmdbClient implements TmdbClientInterface
{
    protected ?string $language = null;
    protected ?string $region = null;
    protected bool $useCache = true;
    protected ?int $cacheTtl = null;

    public function __construct(protected Client $httpClient, protected CacheManager $cache, protected array $config)
    {
        $this->useCache = $this->config['cache']['enabled'] ?? true;
    }

    /**
     * Make a GET request to the TMDB API.
     *
     * @throws TmdbException
     */
    public function get(string $endpoint, array $params = []): array
    {
        return $this->makeRequest('GET', $endpoint, [], $params);
    }

    /**
     * Make a POST request to the TMDB API.
     *
     * @throws TmdbException
     */
    public function post(string $endpoint, array $data = [], array $params = []): array
    {
        return $this->makeRequest('POST', $endpoint, $data, $params);
    }

    /**
     * Make a PUT request to the TMDB API.
     *
     * @throws TmdbException
     */
    public function put(string $endpoint, array $data = [], array $params = []): array
    {
        return $this->makeRequest('PUT', $endpoint, $data, $params);
    }

    /**
     * Make a DELETE request to the TMDB API.
     *
     * @throws TmdbException
     */
    public function delete(string $endpoint, array $params = []): array
    {
        return $this->makeRequest('DELETE', $endpoint, [], $params);
    }

    /**
     * Set the language for API requests.
     */
    public function language(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Set the region for API requests.
     */
    public function region(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Disable caching for the next request.
     */
    public function withoutCache(): self
    {
        $this->useCache = false;
        return $this;
    }

    /**
     * Set custom cache TTL for the next request.
     */
    public function cacheTtl(int $ttl): self
    {
        $this->cacheTtl = $ttl;
        return $this;
    }

    /**
     * Make a request to the TMDB API.
     *
     * @throws TmdbException
     */
    protected function makeRequest(string $method, string $endpoint, array $data = [], array $params = []): array
    {
        $url = $this->buildUrl($endpoint);
        $params = $this->prepareParams($params);
        
        $cacheKey = $this->getCacheKey($method, $endpoint, $params, $data);
        
        // Try to get from cache for GET requests
        if ($method === 'GET' && $this->useCache && $this->cache->has($cacheKey)) {
            $this->resetRequestOptions();
            return $this->cache->get($cacheKey);
        }

        try {
            $options = $this->buildRequestOptions($method, $data, $params);
            $response = $this->httpClient->request($method, $url, $options);
            $responseData = json_decode($response->getBody()->getContents(), true);

            // Cache GET requests
            if ($method === 'GET' && $this->useCache) {
                $ttl = $this->cacheTtl ?? $this->config['cache']['ttl'];
                $this->cache->put($cacheKey, $responseData, $ttl);
            }

            $this->resetRequestOptions();
            return $responseData;

        } catch (ClientException $e) {
            $this->resetRequestOptions();
            $this->handleClientException($e);
        } catch (ServerException $e) {
            $this->resetRequestOptions();
            throw TmdbException::serverError($this->getResponseData($e));
        } catch (RequestException $e) {
            $this->resetRequestOptions();
            throw new TmdbException("Request failed: " . $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Build the full URL for the request.
     */
    protected function buildUrl(string $endpoint): string
    {
        $baseUrl = rtrim((string) $this->config['base_url'], '/');
        $endpoint = ltrim($endpoint, '/');
        
        return "{$baseUrl}/{$endpoint}";
    }

    /**
     * Prepare query parameters for the request.
     */
    protected function prepareParams(array $params): array
    {
        // Add default parameters
        if ($this->language) {
            $params['language'] = $this->language;
        } elseif (isset($this->config['language'])) {
            $params['language'] = $this->config['language'];
        }

        if ($this->region) {
            $params['region'] = $this->region;
        } elseif (isset($this->config['region'])) {
            $params['region'] = $this->config['region'];
        }

        return $params;
    }

    /**
     * Build request options for Guzzle.
     */
    protected function buildRequestOptions(string $method, array $data, array $params): array
    {
        $options = [
            'timeout' => $this->config['http']['timeout'] ?? 30,
            'connect_timeout' => $this->config['http']['connect_timeout'] ?? 10,
            'verify' => $this->config['http']['verify'] ?? true,
            'headers' => $this->getAuthHeaders(),
        ];

        if ($params !== []) {
            $options['query'] = $params;
        }

        if ($data !== [] && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            $options['json'] = $data;
        }

        return $options;
    }

    /**
     * Get authentication headers.
     */
    protected function getAuthHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        // Prefer access token over API key
        if (!empty($this->config['access_token'])) {
            $headers['Authorization'] = 'Bearer ' . $this->config['access_token'];
        }

        return $headers;
    }

    /**
     * Generate cache key for the request.
     */
    protected function getCacheKey(string $method, string $endpoint, array $params, array $data): string
    {
        $prefix = $this->config['cache']['prefix'] ?? 'tmdb';

        return implode(':', [
            $prefix,
            $method,
            str_replace('/', '_', $endpoint),
            md5(serialize($params) . serialize($data))
        ]);
    }

    /**
     * Handle client exceptions (4xx errors).
     *
     * @throws TmdbException
     */
    protected function handleClientException(ClientException $e): void
    {
        $statusCode = $e->getResponse()->getStatusCode();
        $responseData = $this->getResponseData($e);

        switch ($statusCode) {
            case 401:
                throw TmdbException::authenticationFailed($responseData);
            case 404:
                throw TmdbException::resourceNotFound('Resource', $responseData);
            case 422:
                $message = Arr::get($responseData, 'status_message', 'Validation failed');
                throw TmdbException::validationError($message, $responseData);
            case 429:
                throw TmdbException::rateLimitExceeded($responseData);
            default:
                $message = Arr::get($responseData, 'status_message', $e->getMessage());
                throw new TmdbException($message, $statusCode, $responseData);
        }
    }

    /**
     * Get response data from exception.
     */
    protected function getResponseData(RequestException $e): array
    {
        if ($e->hasResponse()) {
            $body = $e->getResponse()->getBody()->getContents();
            return json_decode($body, true) ?: [];
        }

        return [];
    }

    /**
     * Reset request-specific options.
     */
    protected function resetRequestOptions(): void
    {
        $this->language = null;
        $this->region = null;
        $this->useCache = $this->config['cache']['enabled'] ?? true;
        $this->cacheTtl = null;
    }
}