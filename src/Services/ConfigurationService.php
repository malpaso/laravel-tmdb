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
     *
     * @return array<string, mixed> API configuration from TMDB
     */
    public function details(): array
    {
        return $this->client->get('configuration');
    }

    /**
     * Get available countries.
     *
     * @return array<string, mixed> Available countries from TMDB API
     */
    public function countries(): array
    {
        return $this->client->get('configuration/countries');
    }

    /**
     * Get available jobs.
     *
     * @return array<string, mixed> Available jobs from TMDB API
     */
    public function jobs(): array
    {
        return $this->client->get('configuration/jobs');
    }

    /**
     * Get available languages.
     *
     * @return array<string, mixed> Available languages from TMDB API
     */
    public function languages(): array
    {
        return $this->client->get('configuration/languages');
    }

    /**
     * Get primary translations.
     *
     * @return array<string, mixed> Primary translations from TMDB API
     */
    public function primaryTranslations(): array
    {
        return $this->client->get('configuration/primary_translations');
    }

    /**
     * Get available timezones.
     *
     * @return array<string, mixed> Available timezones from TMDB API
     */
    public function timezones(): array
    {
        return $this->client->get('configuration/timezones');
    }

    /**
     * Get image base URL and available sizes.
     *
     * @return array<string, mixed> Image configuration from TMDB API
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
     *
     * @return array<int, string> Available poster sizes from TMDB API
     */
    public function posterSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['poster_sizes'] ?? [];
    }

    /**
     * Get all available backdrop sizes.
     *
     * @return array<int, string> Available backdrop sizes from TMDB API
     */
    public function backdropSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['backdrop_sizes'] ?? [];
    }

    /**
     * Get all available profile sizes.
     *
     * @return array<int, string> Available profile sizes from TMDB API
     */
    public function profileSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['profile_sizes'] ?? [];
    }

    /**
     * Get all available logo sizes.
     *
     * @return array<int, string> Available logo sizes from TMDB API
     */
    public function logoSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['logo_sizes'] ?? [];
    }

    /**
     * Get all available still sizes.
     *
     * @return array<int, string> Available still sizes from TMDB API
     */
    public function stillSizes(): array
    {
        $imageConfig = $this->images();
        return $imageConfig['still_sizes'] ?? [];
    }
}