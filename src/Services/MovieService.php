<?php

namespace malpaso\LaravelTmdb\Services;

use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;

class MovieService
{
    public function __construct(protected TmdbClientInterface $client)
    {
    }

    /**
     * Get movie details by ID.
     *
     * @param array $appendToResponse Additional data to append (credits, videos, etc.)
     */
    public function details(int $movieId, array $appendToResponse = []): array
    {
        $params = [];
        
        if ($appendToResponse !== []) {
            $params['append_to_response'] = implode(',', $appendToResponse);
        }

        return $this->client->get("movie/{$movieId}", $params);
    }

    /**
     * Get movie credits (cast and crew).
     */
    public function credits(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/credits");
    }

    /**
     * Get movie videos (trailers, teasers, etc.).
     */
    public function videos(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/videos");
    }

    /**
     * Get movie images (backdrops, posters).
     */
    public function images(int $movieId, array $params = []): array
    {
        return $this->client->get("movie/{$movieId}/images", $params);
    }

    /**
     * Get movie reviews.
     */
    public function reviews(int $movieId, int $page = 1): array
    {
        return $this->client->get("movie/{$movieId}/reviews", ['page' => $page]);
    }

    /**
     * Get similar movies.
     */
    public function similar(int $movieId, int $page = 1): array
    {
        return $this->client->get("movie/{$movieId}/similar", ['page' => $page]);
    }

    /**
     * Get movie recommendations.
     */
    public function recommendations(int $movieId, int $page = 1): array
    {
        return $this->client->get("movie/{$movieId}/recommendations", ['page' => $page]);
    }

    /**
     * Get external IDs for a movie.
     */
    public function externalIds(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/external_ids");
    }

    /**
     * Get movie release dates.
     */
    public function releaseDates(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/release_dates");
    }

    /**
     * Get movie watch providers.
     */
    public function watchProviders(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/watch/providers");
    }

    /**
     * Get movie keywords.
     */
    public function keywords(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/keywords");
    }

    /**
     * Get popular movies.
     */
    public function popular(int $page = 1): array
    {
        return $this->client->get('movie/popular', ['page' => $page]);
    }

    /**
     * Get top rated movies.
     */
    public function topRated(int $page = 1): array
    {
        return $this->client->get('movie/top_rated', ['page' => $page]);
    }

    /**
     * Get upcoming movies.
     */
    public function upcoming(int $page = 1): array
    {
        return $this->client->get('movie/upcoming', ['page' => $page]);
    }

    /**
     * Get now playing movies.
     */
    public function nowPlaying(int $page = 1): array
    {
        return $this->client->get('movie/now_playing', ['page' => $page]);
    }

    /**
     * Get latest movie.
     */
    public function latest(): array
    {
        return $this->client->get('movie/latest');
    }

    /**
     * Discover movies based on filters.
     */
    public function discover(array $filters = []): array
    {
        return $this->client->get('discover/movie', $filters);
    }

    /**
     * Rate a movie (requires authentication).
     *
     * @param float $rating Rating from 0.5 to 10.0
     */
    public function rate(int $movieId, float $rating, ?string $sessionId = null): array
    {
        $data = ['value' => $rating];
        $params = [];
        
        if ($sessionId) {
            $params['session_id'] = $sessionId;
        }

        return $this->client->post("movie/{$movieId}/rating", $data, $params);
    }

    /**
     * Delete movie rating (requires authentication).
     */
    public function deleteRating(int $movieId, ?string $sessionId = null): array
    {
        $params = [];
        
        if ($sessionId) {
            $params['session_id'] = $sessionId;
        }

        return $this->client->delete("movie/{$movieId}/rating", $params);
    }
}