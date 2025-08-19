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
     * @param array $appendToResponse Additional data to append
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
     */
    public function credits(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/credits");
    }

    /**
     * Get TV show videos.
     */
    public function videos(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/videos");
    }

    /**
     * Get TV show images.
     */
    public function images(int $tvId, array $params = []): array
    {
        return $this->client->get("tv/{$tvId}/images", $params);
    }

    /**
     * Get TV show reviews.
     */
    public function reviews(int $tvId, int $page = 1): array
    {
        return $this->client->get("tv/{$tvId}/reviews", ['page' => $page]);
    }

    /**
     * Get similar TV shows.
     */
    public function similar(int $tvId, int $page = 1): array
    {
        return $this->client->get("tv/{$tvId}/similar", ['page' => $page]);
    }

    /**
     * Get TV show recommendations.
     */
    public function recommendations(int $tvId, int $page = 1): array
    {
        return $this->client->get("tv/{$tvId}/recommendations", ['page' => $page]);
    }

    /**
     * Get external IDs for a TV show.
     */
    public function externalIds(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/external_ids");
    }

    /**
     * Get TV show watch providers.
     */
    public function watchProviders(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/watch/providers");
    }

    /**
     * Get TV show keywords.
     */
    public function keywords(int $tvId): array
    {
        return $this->client->get("tv/{$tvId}/keywords");
    }

    /**
     * Get season details.
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
     */
    public function popular(int $page = 1): array
    {
        return $this->client->get('tv/popular', ['page' => $page]);
    }

    /**
     * Get top rated TV shows.
     */
    public function topRated(int $page = 1): array
    {
        return $this->client->get('tv/top_rated', ['page' => $page]);
    }

    /**
     * Get TV shows airing today.
     */
    public function airingToday(int $page = 1): array
    {
        return $this->client->get('tv/airing_today', ['page' => $page]);
    }

    /**
     * Get TV shows on the air.
     */
    public function onTheAir(int $page = 1): array
    {
        return $this->client->get('tv/on_the_air', ['page' => $page]);
    }

    /**
     * Get latest TV show.
     */
    public function latest(): array
    {
        return $this->client->get('tv/latest');
    }

    /**
     * Discover TV shows based on filters.
     */
    public function discover(array $filters = []): array
    {
        return $this->client->get('discover/tv', $filters);
    }

    /**
     * Rate a TV show (requires authentication).
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