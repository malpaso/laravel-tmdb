<?php

namespace malpaso\LaravelTmdb\Services;

use malpaso\LaravelTmdb\Contracts\TmdbClientInterface;

class ConfigurationService
{
    public function __construct(protected TmdbClientInterface $client)
    {
    }

    /**
     * Get API configuration details.
     */
    public function details(): array
    {
        return $this->client->get('configuration');
    }

    /**
     * Get available countries.
     */
    public function countries(): array
    {
        return $this->client->get('configuration/countries');
    }

    /**
     * Get available jobs.
     */
    public function jobs(): array
    {
        return $this->client->get('configuration/jobs');
    }

    /**
     * Get available languages.
     */
    public function languages(): array
    {
        return $this->client->get('configuration/languages');
    }

    /**
     * Get primary translations.
     */
    public function primaryTranslations(): array
    {
        return $this->client->get('configuration/primary_translations');
    }

    /**
     * Get available timezones.
     */
    public function timezones(): array
    {
        return $this->client->get('configuration/timezones');
    }

    /**
     * Get image base URL and available sizes.
     */
    public function images(): array
    {
        $config = $this->details();
        return $config['images'] ?? [];
    }

    /**
     * Build image URL with the specified size.
     */
    public function imageUrl(string $filePath, string $size = 'original'): string
    {
        $imageConfig = $this->images();
        $baseUrl = $imageConfig['secure_base_url'] ?? 'https://image.tmdb.org/t/p/';
        
        return $baseUrl . $size . $filePath;
    }

    /**
     * Get all available poster sizes.
     */
    public function posterSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['poster_sizes'] ?? [];
    }

    /**
     * Get all available backdrop sizes.
     */
    public function backdropSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['backdrop_sizes'] ?? [];
    }

    /**
     * Get all available profile sizes.
     */
    public function profileSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['profile_sizes'] ?? [];
    }

    /**
     * Get all available logo sizes.
     */
    public function logoSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['logo_sizes'] ?? [];
    }

    /**
     * Get all available still sizes.
     */
    public function stillSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['still_sizes'] ?? [];
    }
}