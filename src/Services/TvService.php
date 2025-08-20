<?php

namespace malpaso\LaravelTmdb\Services;

use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;

class TvService
{
    public function __construct(protected TmdbClientInterface $client)
    {
    }

    /**
     * Get TV show details by ID.
     *
     * @param int $tvId TV show ID
     * @param array<int, string> $appendToResponse Additional data to append (credits, videos, etc.)
     * @return array<string, mixed> TV show details from TMDB API
     */
    public function details(int $tvId, array $appendToResponse = []): array
    {
        $params = [];
        
        if ($appendToResponse !== []) {
            $params['append_to_response'] = implode(',', $appendToResponse);
        }

        return $this->client->get("tv/{$tvId}", $params);
    }

    /**
     * Get TV show credits (cast and crew).
     *
     * @param int $tvId TV show ID
     * @return array<string, mixed> TV show credits from TMDB API
     */
    public function credits(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/credits");
    }

    /**
     * Get TV show videos.
     *
     * @param int $tvId TV show ID
     * @return array<string, mixed> TV show videos from TMDB API
     */
    public function videos(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/videos");
    }

    /**
     * Get TV show images.
     *
     * @param int $tvId TV show ID
     * @param array<string, mixed> $params Additional query parameters
     * @return array<string, mixed> TV show images from TMDB API
     */
    public function images(int $tvId, array $params = []): array
    {
        return $this->client->get("tv/{$tvId}/images", $params);
    }

    /**
     * Get TV show reviews.
     *
     * @param int $tvId TV show ID
     * @param int $page Page number for pagination
     * @return array<string, mixed> TV show reviews from TMDB API
     */
    public function reviews(int $tvId, int $page = 1): array
    {
        return $this->client->get("tv/{$tvId}/reviews", ['page' => $page]);
    }

    /**
     * Get similar TV shows.
     *
     * @param int $tvId TV show ID
     * @param int $page Page number for pagination
     * @return array<string, mixed> Similar TV shows from TMDB API
     */
    public function similar(int $tvId, int $page = 1): array
    {
        return $this->client->get("tv/{$tvId}/similar", ['page' => $page]);
    }

    /**
     * Get TV show recommendations.
     *
     * @param int $tvId TV show ID
     * @param int $page Page number for pagination
     * @return array<string, mixed> TV show recommendations from TMDB API
     */
    public function recommendations(int $tvId, int $page = 1): array
    {
        return $this->client->get("tv/{$tvId}/recommendations", ['page' => $page]);
    }

    /**
     * Get external IDs for a TV show.
     *
     * @param int $tvId TV show ID
     * @return array<string, mixed> External IDs from TMDB API
     */
    public function externalIds(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/external_ids");
    }

    /**
     * Get TV show watch providers.
     *
     * @param int $tvId TV show ID
     * @return array<string, mixed> Watch providers from TMDB API
     */
    public function watchProviders(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/watch/providers");
    }

    /**
     * Get TV show keywords.
     *
     * @param int $tvId TV show ID
     * @return array<string, mixed> TV show keywords from TMDB API
     */
    public function keywords(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/keywords");
    }

    /**
     * Get season details.
     *
     * @param int $tvId TV show ID
     * @param int $seasonNumber Season number
     * @param array<int, string> $appendToResponse Additional data to append
     * @return array<string, mixed> Season details from TMDB API
     */
    public function season(int $tvId, int $seasonNumber, array $appendToResponse = []): array
    {
        $params = [];
        
        if ($appendToResponse !== []) {
            $params['append_to_response'] = implode(',', $appendToResponse);
        }

        return $this->client->get("tv/{$tvId}/season/{$seasonNumber}", $params);
    }

    /**
     * Get episode details.
     *
     * @param int $tvId TV show ID
     * @param int $seasonNumber Season number
     * @param int $episodeNumber Episode number
     * @param array<int, string> $appendToResponse Additional data to append
     * @return array<string, mixed> Episode details from TMDB API
     */
    public function episode(int $tvId, int $seasonNumber, int $episodeNumber, array $appendToResponse = []): array
    {
        $params = [];
        
        if ($appendToResponse !== []) {
            $params['append_to_response'] = implode(',', $appendToResponse);
        }

        return $this->client->get("tv/{$tvId}/season/{$seasonNumber}/episode/{$episodeNumber}", $params);
    }

    /**
     * Get popular TV shows.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> Popular TV shows from TMDB API
     */
    public function popular(int $page = 1): array
    {
        return $this->client->get('tv/popular', ['page' => $page]);
    }

    /**
     * Get top rated TV shows.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> Top rated TV shows from TMDB API
     */
    public function topRated(int $page = 1): array
    {
        return $this->client->get('tv/top_rated', ['page' => $page]);
    }

    /**
     * Get TV shows airing today.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> TV shows airing today from TMDB API
     */
    public function airingToday(int $page = 1): array
    {
        return $this->client->get('tv/airing_today', ['page' => $page]);
    }

    /**
     * Get TV shows on the air.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> TV shows on the air from TMDB API
     */
    public function onTheAir(int $page = 1): array
    {
        return $this->client->get('tv/on_the_air', ['page' => $page]);
    }

    /**
     * Get latest TV show.
     *
     * @return array<string, mixed> Latest TV show from TMDB API
     */
    public function latest(): array
    {
        return $this->client->get('tv/latest');
    }

    /**
     * Discover TV shows based on filters.
     *
     * @param array<string, mixed> $filters Discovery filters
     * @return array<string, mixed> Discovered TV shows from TMDB API
     */
    public function discover(array $filters = []): array
    {
        return $this->client->get('discover/tv', $filters);
    }

    /**
     * Rate a TV show (requires authentication).
     *
     * @param int $tvId TV show ID
     * @param float $rating Rating from 0.5 to 10.0
     * @param string|null $sessionId Optional session ID for authentication
     * @return array<string, mixed> Rating response from TMDB API
     */
    public function rate(int $tvId, float $rating, ?string $sessionId = null): array
    {
        $data = ['value' => $rating];
        $params = [];
        
        if ($sessionId) {
            $params['session_id'] = $sessionId;
        }

        return $this->client->post("tv/{$tvId}/rating", $data, $params);
    }

    /**
     * Delete TV show rating (requires authentication).
     *
     * @param int $tvId TV show ID
     * @param string|null $sessionId Optional session ID for authentication
     * @return array<string, mixed> Delete rating response from TMDB API
     */
    public function deleteRating(int $tvId, ?string $sessionId = null): array
    {
        $params = [];
        
        if ($sessionId) {
            $params['session_id'] = $sessionId;
        }

        return $this->client->delete("tv/{$tvId}/rating", $params);
    }
}