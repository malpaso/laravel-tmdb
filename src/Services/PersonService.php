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
     */
    public function movieCredits(int $personId): array
    {
        return $this->client->get("person/{$personId}/movie_credits");
    }

    /**
     * Get person TV credits.
     */
    public function tvCredits(int $personId): array
    {
        return $this->client->get("person/{$personId}/tv_credits");
    }

    /**
     * Get combined credits (movies and TV).
     */
    public function combinedCredits(int $personId): array
    {
        return $this->client->get("person/{$personId}/combined_credits");
    }

    /**
     * Get person images.
     */
    public function images(int $personId): array
    {
        return $this->client->get("person/{$personId}/images");
    }

    /**
     * Get external IDs for a person.
     */
    public function externalIds(int $personId): array
    {
        return $this->client->get("person/{$personId}/external_ids");
    }

    /**
     * Get popular people.
     */
    public function popular(int $page = 1): array
    {
        return $this->client->get('person/popular', ['page' => $page]);
    }

    /**
     * Get latest person.
     */
    public function latest(): array
    {
        return $this->client->get('person/latest');
    }

    /**
     * Get translations for a person.
     */
    public function translations(int $personId): array
    {
        return $this->client->get("person/{$personId}/translations");
    }

    /**
     * Get changes for a person.
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