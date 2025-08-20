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
     * @param int $movieId Movie ID
     * @param array<int, string> $appendToResponse Additional data to append (credits, videos, etc.)
     * @return array<string, mixed> Movie details from TMDB API
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
     *
     * @param int $movieId Movie ID
     * @return array<string, mixed> Movie credits from TMDB API
     */
    public function credits(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/credits");
    }

    /**
     * Get movie videos (trailers, teasers, etc.).
     *
     * @param int $movieId Movie ID
     * @return array<string, mixed> Movie videos from TMDB API
     */
    public function videos(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/videos");
    }

    /**
     * Get movie images (backdrops, posters).
     *
     * @param int $movieId Movie ID
     * @param array<string, mixed> $params Additional query parameters
     * @return array<string, mixed> Movie images from TMDB API
     */
    public function images(int $movieId, array $params = []): array
    {
        return $this->client->get("movie/{$movieId}/images", $params);
    }

    /**
     * Get movie reviews.
     *
     * @param int $movieId Movie ID
     * @param int $page Page number for pagination
     * @return array<string, mixed> Movie reviews from TMDB API
     */
    public function reviews(int $movieId, int $page = 1): array
    {
        return $this->client->get("movie/{$movieId}/reviews", ['page' => $page]);
    }

    /**
     * Get similar movies.
     *
     * @param int $movieId Movie ID
     * @param int $page Page number for pagination
     * @return array<string, mixed> Similar movies from TMDB API
     */
    public function similar(int $movieId, int $page = 1): array
    {
        return $this->client->get("movie/{$movieId}/similar", ['page' => $page]);
    }

    /**
     * Get movie recommendations.
     *
     * @param int $movieId Movie ID
     * @param int $page Page number for pagination
     * @return array<string, mixed> Movie recommendations from TMDB API
     */
    public function recommendations(int $movieId, int $page = 1): array
    {
        return $this->client->get("movie/{$movieId}/recommendations", ['page' => $page]);
    }

    /**
     * Get external IDs for a movie.
     *
     * @param int $movieId Movie ID
     * @return array<string, mixed> External IDs from TMDB API
     */
    public function externalIds(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/external_ids");
    }

    /**
     * Get movie release dates.
     *
     * @param int $movieId Movie ID
     * @return array<string, mixed> Movie release dates from TMDB API
     */
    public function releaseDates(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/release_dates");
    }

    /**
     * Get movie watch providers.
     *
     * @param int $movieId Movie ID
     * @return array<string, mixed> Watch providers from TMDB API
     */
    public function watchProviders(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/watch/providers");
    }

    /**
     * Get movie keywords.
     *
     * @param int $movieId Movie ID
     * @return array<string, mixed> Movie keywords from TMDB API
     */
    public function keywords(int $movieId): array
    {
        return $this->client->get("movie/{$movieId}/keywords");
    }

    /**
     * Get popular movies.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> Popular movies from TMDB API
     */
    public function popular(int $page = 1): array
    {
        return $this->client->get('movie/popular', ['page' => $page]);
    }

    /**
     * Get top rated movies.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> Top rated movies from TMDB API
     */
    public function topRated(int $page = 1): array
    {
        return $this->client->get('movie/top_rated', ['page' => $page]);
    }

    /**
     * Get upcoming movies.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> Upcoming movies from TMDB API
     */
    public function upcoming(int $page = 1): array
    {
        return $this->client->get('movie/upcoming', ['page' => $page]);
    }

    /**
     * Get now playing movies.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> Now playing movies from TMDB API
     */
    public function nowPlaying(int $page = 1): array
    {
        return $this->client->get('movie/now_playing', ['page' => $page]);
    }

    /**
     * Get latest movie.
     *
     * @return array<string, mixed> Latest movie from TMDB API
     */
    public function latest(): array
    {
        return $this->client->get('movie/latest');
    }

    /**
     * Discover movies based on filters.
     *
     * @param array<string, mixed> $filters Discovery filters
     * @return array<string, mixed> Discovered movies from TMDB API
     */
    public function discover(array $filters = []): array
    {
        return $this->client->get('discover/movie', $filters);
    }

    /**
     * Rate a movie (requires authentication).
     *
     * @param int $movieId Movie ID
     * @param float $rating Rating from 0.5 to 10.0
     * @param string|null $sessionId Optional session ID for authentication
     * @return array<string, mixed> Rating response from TMDB API
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
     *
     * @param int $movieId Movie ID
     * @param string|null $sessionId Optional session ID for authentication
     * @return array<string, mixed> Delete rating response from TMDB API
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