<?php

namespace malpaso\LaravelTmdb\Exceptions;

use Exception;

class TmdbException extends Exception
{
    public function __construct(string $message = '', int $code = 0, protected array $response = [], Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the API response data.
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * Create an exception for authentication errors.
     */
    public static function authenticationFailed(array $response = []): static
    {
        return new static(
            'TMDB API authentication failed. Please check your API key or access token.',
            401,
            $response
        );
    }

    /**
     * Create an exception for resource not found errors.
     */
    public static function resourceNotFound(string $resource = 'Resource', array $response = []): static
    {
        return new static(
            "{$resource} not found.",
            404,
            $response
        );
    }

    /**
     * Create an exception for rate limit errors.
     */
    public static function rateLimitExceeded(array $response = []): static
    {
        return new static(
            'TMDB API rate limit exceeded. Please wait before making more requests.',
            429,
            $response
        );
    }

    /**
     * Create an exception for validation errors.
     */
    public static function validationError(string $message, array $response = []): static
    {
        return new static(
            "Validation error: {$message}",
            422,
            $response
        );
    }

    /**
     * Create an exception for server errors.
     */
    public static function serverError(array $response = []): static
    {
        return new static(
            'TMDB API server error. Please try again later.',
            500,
            $response
        );
    }
}