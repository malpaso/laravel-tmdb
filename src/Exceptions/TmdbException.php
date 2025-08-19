<?php

namespace malpaso\LaravelTmdb\Exceptions;

use Exception;

class TmdbException extends Exception
{
    /**
     * Create a new TMDB exception instance.
     *
     * @param string $message Exception message
     * @param int $code HTTP status code or error code
     * @param array<string, mixed> $response Raw API response data
     * @param Exception|null $previous Previous exception for chaining
     */
    public function __construct(string $message = '', int $code = 0, protected array $response = [], ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the API response data.
     *
     * @return array<string, mixed> Raw API response data from TMDB
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * Create an exception for authentication errors (401).
     *
     * @param array<string, mixed> $response Raw API response data
     * @return self TMDB exception instance
     */
    public static function authenticationFailed(array $response = []): self
    {
        return new self(
            'TMDB API authentication failed. Please check your API key or access token.',
            401,
            $response
        );
    }

    /**
     * Create an exception for resource not found errors (404).
     *
     * @param string $resource Name of the resource that was not found
     * @param array<string, mixed> $response Raw API response data
     * @return self TMDB exception instance
     */
    public static function resourceNotFound(string $resource = 'Resource', array $response = []): self
    {
        return new self(
            "{$resource} not found.",
            404,
            $response
        );
    }

    /**
     * Create an exception for rate limit errors (429).
     *
     * @param array<string, mixed> $response Raw API response data
     * @return self TMDB exception instance
     */
    public static function rateLimitExceeded(array $response = []): self
    {
        return new self(
            'TMDB API rate limit exceeded. Please wait before making more requests.',
            429,
            $response
        );
    }

    /**
     * Create an exception for validation errors (422).
     *
     * @param string $message Specific validation error message
     * @param array<string, mixed> $response Raw API response data
     * @return self TMDB exception instance
     */
    public static function validationError(string $message, array $response = []): self
    {
        return new self(
            "Validation error: {$message}",
            422,
            $response
        );
    }

    /**
     * Create an exception for server errors (500).
     *
     * @param array<string, mixed> $response Raw API response data
     * @return self TMDB exception instance
     */
    public static function serverError(array $response = []): self
    {
        return new self(
            'TMDB API server error. Please try again later.',
            500,
            $response
        );
    }
}