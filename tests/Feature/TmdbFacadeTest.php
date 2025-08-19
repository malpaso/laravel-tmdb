<?php

use malpaso\LaravelTmdb\Facades\Tmdb;

describe('Tmdb Facade Integration', function (): void {

    it('can resolve the tmdb manager from the facade', function (): void {
        $manager = Tmdb::getFacadeRoot();
        
        expect($manager)->toBeInstanceOf(\malpaso\LaravelTmdb\TmdbManager::class);
    });

    it('can access movie service through facade', function (): void {
        $movieService = Tmdb::movies();
        
        expect($movieService)->toBeInstanceOf(\malpaso\LaravelTmdb\Services\MovieService::class);
    });

    it('can access tv service through facade', function (): void {
        $tvService = Tmdb::tv();
        
        expect($tvService)->toBeInstanceOf(\malpaso\LaravelTmdb\Services\TvService::class);
    });

    it('can access search service through facade', function (): void {
        $searchService = Tmdb::search();
        
        expect($searchService)->toBeInstanceOf(\malpaso\LaravelTmdb\Services\SearchService::class);
    });

    it('can access people service through facade', function (): void {
        $peopleService = Tmdb::people();
        
        expect($peopleService)->toBeInstanceOf(\malpaso\LaravelTmdb\Services\PersonService::class);
    });

    it('can access configuration service through facade', function (): void {
        $configService = Tmdb::configuration();
        
        expect($configService)->toBeInstanceOf(\malpaso\LaravelTmdb\Services\ConfigurationService::class);
    });

    it('can access client through facade', function (): void {
        $client = Tmdb::client();
        
        expect($client)->toBeInstanceOf(\malpaso\LaravelTmdb\Contracts\TmdbClientInterface::class);
    });

});

describe('Service Provider Registration', function (): void {

    it('registers the tmdb client in the container', function (): void {
        $client = app(\malpaso\LaravelTmdb\Contracts\TmdbClientInterface::class);
        
        expect($client)->toBeInstanceOf(\malpaso\LaravelTmdb\TmdbClient::class);
    });

    it('registers the tmdb manager in the container', function (): void {
        $manager = app('tmdb');
        
        expect($manager)->toBeInstanceOf(\malpaso\LaravelTmdb\TmdbManager::class);
    });

    it('can resolve manager through interface', function (): void {
        $manager = app(\malpaso\LaravelTmdb\TmdbManager::class);
        
        expect($manager)->toBeInstanceOf(\malpaso\LaravelTmdb\TmdbManager::class);
    });

});