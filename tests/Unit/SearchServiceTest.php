<?php

use malpaso\LaravelTmdb\Services\SearchService;

beforeEach(function (): void {
    $this->mockClient = mockTmdbClient();
    $this->searchService = new SearchService($this->mockClient);
});

afterEach(function (): void {
    Mockery::close();
});

describe('SearchService', function (): void {

    it('can search for movies', function (): void {
        $query = 'Fight Club';
        $expectedParams = ['query' => $query];
        $expectedResponse = [
            'page' => 1,
            'results' => [mockMovieResponse()],
            'total_pages' => 1,
            'total_results' => 1,
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/movie', $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->searchService->movies($query);

        expect($result)->toBe($expectedResponse)
            ->and($result['results'])->toHaveCount(1);
    });

    it('can search for movies with additional parameters', function (): void {
        $query = 'Fight Club';
        $params = ['year' => 1999, 'include_adult' => false];
        $expectedParams = ['query' => $query, 'year' => 1999, 'include_adult' => false];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/movie', $expectedParams)
            ->andReturn([]);

        $this->searchService->movies($query, $params);
    });

    it('can search for tv shows', function (): void {
        $query = 'Game of Thrones';
        $expectedParams = ['query' => $query];
        $expectedResponse = [
            'page' => 1,
            'results' => [mockTvShowResponse()],
            'total_pages' => 1,
            'total_results' => 1,
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/tv', $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->searchService->tv($query);

        expect($result)->toBe($expectedResponse);
    });

    it('can search for people', function (): void {
        $query = 'Brad Pitt';
        $expectedParams = ['query' => $query];
        $expectedResponse = [
            'page' => 1,
            'results' => [mockPersonResponse()],
            'total_pages' => 1,
            'total_results' => 1,
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/person', $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->searchService->people($query);

        expect($result)->toBe($expectedResponse);
    });

    it('can perform multi search', function (): void {
        $query = 'Christopher Nolan';
        $expectedParams = ['query' => $query];
        $expectedResponse = [
            'page' => 1,
            'results' => [
                array_merge(mockMovieResponse(), ['media_type' => 'movie']),
                array_merge(mockPersonResponse(), ['media_type' => 'person']),
            ],
            'total_pages' => 1,
            'total_results' => 2,
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/multi', $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->searchService->multi($query);

        expect($result)->toBe($expectedResponse)
            ->and($result['results'])->toHaveCount(2);
    });

    it('can search for companies', function (): void {
        $query = 'Marvel';
        $expectedParams = ['query' => $query];
        $expectedResponse = [
            'page' => 1,
            'results' => [
                [
                    'id' => 420,
                    'name' => 'Marvel Studios',
                    'logo_path' => '/hUzeosd33nzE5MCNsZxCGEKTXaQ.png',
                ]
            ],
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/company', $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->searchService->companies($query);

        expect($result)->toBe($expectedResponse);
    });

    it('can search with pagination', function (): void {
        $type = 'movie';
        $query = 'Marvel';
        $page = 2;
        $expectedParams = ['query' => $query, 'page' => $page];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with("search/{$type}", $expectedParams)
            ->andReturn([]);

        $this->searchService->paginated($type, $query, $page);
    });

    it('can perform advanced movie search', function (): void {
        $query = 'Action';
        $filters = [
            'primary_release_year' => 2023,
            'with_genres' => '28',
            'sort_by' => 'popularity.desc',
        ];
        $expectedParams = array_merge($filters, ['query' => $query]);

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/movie', $expectedParams)
            ->andReturn([]);

        $this->searchService->moviesAdvanced($query, $filters);
    });

    it('can perform advanced tv search', function (): void {
        $query = 'Drama';
        $filters = [
            'first_air_date_year' => 2023,
            'with_genres' => '18',
        ];
        $expectedParams = array_merge($filters, ['query' => $query]);

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/tv', $expectedParams)
            ->andReturn([]);

        $this->searchService->tvAdvanced($query, $filters);
    });

    it('can search for collections', function (): void {
        $query = 'Marvel Cinematic Universe';
        $expectedParams = ['query' => $query];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/collection', $expectedParams)
            ->andReturn([]);

        $this->searchService->collections($query);
    });

    it('can search for keywords', function (): void {
        $query = 'superhero';
        $expectedParams = ['query' => $query];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('search/keyword', $expectedParams)
            ->andReturn([]);

        $this->searchService->keywords($query);
    });

});