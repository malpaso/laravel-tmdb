<?php

use malpaso\LaravelTmdb\Facades\Tmdb;

describe('TMDB API Integration Tests', function (): void {
    
    beforeEach(function (): void {
        // Skip integration tests if no real credentials are provided
        $accessToken = config('tmdb.access_token');
        $apiKey = config('tmdb.api_key');
        
        if (empty($accessToken) && empty($apiKey)) {
            $this->markTestSkipped(
                'TMDB credentials not provided. Set TMDB_ACCESS_TOKEN or TMDB_API_KEY in your .env file to run integration tests.'
            );
        }
        
        // Log which authentication method is being used (for debugging)
        if (!empty($accessToken)) {
            echo "\nUsing Bearer Token authentication\n";
        } elseif (!empty($apiKey)) {
            echo "\nUsing API Key authentication\n";  
        }
    });

    it('can get movie details from real API', function (): void {
        $movie = Tmdb::movies()->details(550); // Fight Club
        
        expect($movie)->toHaveKey('id', 550)
            ->and($movie)->toHaveKey('title')
            ->and($movie)->toHaveKey('overview')
            ->and($movie['title'])->toBe('Fight Club');
    })->group('integration', 'slow');

    it('can search for movies via real API', function (): void {
        $results = Tmdb::search()->movies('Inception');
        
        expect($results)->toHaveKey('results')
            ->and($results['results'])->toBeArray()
            ->and($results['results'])->not->toBeEmpty();
        
        // Find Inception in results
        $inception = collect($results['results'])->firstWhere('title', 'Inception');
        expect($inception)->not->toBeNull()
            ->and($inception['id'])->toBe(27205);
    })->group('integration', 'slow');

    it('can get popular movies from real API', function (): void {
        $popular = Tmdb::movies()->popular();
        
        expect($popular)->toHaveKey('results')
            ->and($popular)->toHaveKey('page', 1)
            ->and($popular['results'])->toBeArray()
            ->and($popular['results'])->not->toBeEmpty()
            ->and(count($popular['results']))->toBeGreaterThan(0);
    })->group('integration', 'slow');

    it('can get TV show details from real API', function (): void {
        $tvShow = Tmdb::tv()->details(1399); // Game of Thrones
        
        expect($tvShow)->toHaveKey('id', 1399)
            ->and($tvShow)->toHaveKey('name')
            ->and($tvShow['name'])->toBe('Game of Thrones');
    })->group('integration', 'slow');

    it('can get person details from real API', function (): void {
        $person = Tmdb::people()->details(287); // Brad Pitt
        
        expect($person)->toHaveKey('id', 287)
            ->and($person)->toHaveKey('name')
            ->and($person['name'])->toBe('Brad Pitt');
    })->group('integration', 'slow');

    it('can get API configuration from real API', function (): void {
        $config = Tmdb::configuration()->details();
        
        expect($config)->toHaveKey('images')
            ->and($config['images'])->toHaveKey('secure_base_url')
            ->and($config['images'])->toHaveKey('poster_sizes')
            ->and($config['images']['secure_base_url'])->toStartWith('https://');
    })->group('integration', 'slow');

    it('handles API errors gracefully', function (): void {
        expect(fn() => Tmdb::movies()->details(999999999))
            ->toThrow(\malpaso\LaravelTmdb\Exceptions\TmdbException::class);
    })->group('integration', 'slow');

    it('can use language parameter', function (): void {
        $movieEn = Tmdb::movies()->details(550);
        $movieEs = Tmdb::language('es-ES')->movies()->details(550);
        
        expect($movieEn['title'])->toBe('Fight Club')
            ->and($movieEs['title'])->toBe('El club de la lucha');
    })->group('integration', 'slow');

});