<?php

namespace malpaso\LaravelTmdb\Services;

use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;

class PersonService
{
    public function __construct(protected TmdbClientInterface $client)
    {
    }

    /**
     * Get person details by ID.
     *
     * @param int $personId Person ID
     * @param array<int, string> $appendToResponse Additional data to append (movie_credits, tv_credits, etc.)
     * @return array<string, mixed> Person details from TMDB API
     */
    public function details(int $personId, array $appendToResponse = []): array
    {
        $params = [];
        
        if ($appendToResponse !== []) {
            $params['append_to_response'] = implode(',', $appendToResponse);
        }

        return $this->client->get("person/{$personId}", $params);
    }

    /**
     * Get person movie credits.
     *
     * @param int $personId Person ID
     * @return array<string, mixed> Person's movie credits from TMDB API
     */
    public function movieCredits(int $personId): array
    {
        return $this->client->get("person/{$personId}/movie_credits");
    }

    /**
     * Get person TV credits.
     *
     * @param int $personId Person ID
     * @return array<string, mixed> Person's TV credits from TMDB API
     */
    public function tvCredits(int $personId): array
    {
        return $this->client->get("person/{$personId}/tv_credits");
    }

    /**
     * Get combined credits (movies and TV).
     *
     * @param int $personId Person ID
     * @return array<string, mixed> Person's combined credits from TMDB API
     */
    public function combinedCredits(int $personId): array
    {
        return $this->client->get("person/{$personId}/combined_credits");
    }

    /**
     * Get person images.
     *
     * @param int $personId Person ID
     * @return array<string, mixed> Person's images from TMDB API
     */
    public function images(int $personId): array
    {
        return $this->client->get("person/{$personId}/images");
    }

    /**
     * Get external IDs for a person.
     *
     * @param int $personId Person ID
     * @return array<string, mixed> Person's external IDs from TMDB API
     */
    public function externalIds(int $personId): array
    {
        return $this->client->get("person/{$personId}/external_ids");
    }

    /**
     * Get popular people.
     *
     * @param int $page Page number for pagination
     * @return array<string, mixed> Popular people from TMDB API
     */
    public function popular(int $page = 1): array
    {
        return $this->client->get('person/popular', ['page' => $page]);
    }

    /**
     * Get latest person.
     *
     * @return array<string, mixed> Latest person from TMDB API
     */
    public function latest(): array
    {
        return $this->client->get('person/latest');
    }

    /**
     * Get translations for a person.
     *
     * @param int $personId Person ID
     * @return array<string, mixed> Person's translations from TMDB API
     */
    public function translations(int $personId): array
    {
        return $this->client->get("person/{$personId}/translations");
    }

    /**
     * Get changes for a person.
     *
     * @param int $personId Person ID
     * @param string|null $startDate Optional start date for changes (YYYY-MM-DD)
     * @param string|null $endDate Optional end date for changes (YYYY-MM-DD)
     * @param int $page Page number for pagination
     * @return array<string, mixed> Person's changes from TMDB API
     */
    public function changes(int $personId, ?string $startDate = null, ?string $endDate = null, int $page = 1): array
    {
        $params = ['page' => $page];
        
        if ($startDate) {
            $params['start_date'] = $startDate;
        }
        
        if ($endDate) {
            $params['end_date'] = $endDate;
        }

        return $this->client->get("person/{$personId}/changes", $params);
    }
}