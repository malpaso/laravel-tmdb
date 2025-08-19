<?php

use malpaso\LaravelTmdb\Services\MovieService;

beforeEach(function (): void {
    $this->mockClient = mockTmdbClient();
    $this->movieService = new MovieService($this->mockClient);
});

afterEach(function (): void {
    Mockery::close();
});

describe('MovieService', function (): void {
    
    it('can get movie details', function (): void {
        $movieId = 550;
        $expectedResponse = mockMovieResponse($movieId);

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with("movie/{$movieId}", [])
            ->andReturn($expectedResponse);

        $result = $this->movieService->details($movieId);

        expect($result)->toBe($expectedResponse);
    });

    it('can get movie details with append to response', function (): void {
        $movieId = 550;
        $appendToResponse = ['credits', 'videos'];
        $expectedParams = ['append_to_response' => 'credits,videos'];
        $expectedResponse = mockMovieResponse($movieId);

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with("movie/{$movieId}", $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->movieService->details($movieId, $appendToResponse);

        expect($result)->toBe($expectedResponse);
    });

    it('can get movie credits', function (): void {
        $movieId = 550;
        $expectedResponse = [
            'cast' => [
                [
                    'name' => 'Edward Norton',
                    'character' => 'The Narrator',
                    'order' => 0,
                ]
            ],
            'crew' => [
                [
                    'name' => 'David Fincher',
                    'job' => 'Director',
                ]
            ]
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with("movie/{$movieId}/credits")
            ->andReturn($expectedResponse);

        $result = $this->movieService->credits($movieId);

        expect($result)->toBe($expectedResponse);
    });

    it('can get popular movies', function (): void {
        $page = 1;
        $expectedResponse = [
            'page' => 1,
            'results' => [mockMovieResponse()],
            'total_pages' => 500,
            'total_results' => 10000,
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('movie/popular', ['page' => $page])
            ->andReturn($expectedResponse);

        $result = $this->movieService->popular($page);

        expect($result)->toBe($expectedResponse)
            ->and($result['results'])->toHaveCount(1)
            ->and($result['page'])->toBe(1);
    });

    it('can discover movies with filters', function (): void {
        $filters = [
            'sort_by' => 'popularity.desc',
            'primary_release_year' => 2023,
            'with_genres' => '28,12',
        ];

        $expectedResponse = [
            'page' => 1,
            'results' => [mockMovieResponse()],
            'total_pages' => 100,
            'total_results' => 2000,
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('discover/movie', $filters)
            ->andReturn($expectedResponse);

        $result = $this->movieService->discover($filters);

        expect($result)->toBe($expectedResponse);
    });

    it('can rate a movie', function (): void {
        $movieId = 550;
        $rating = 8.5;
        $sessionId = 'test-session-id';

        $expectedData = ['value' => $rating];
        $expectedParams = ['session_id' => $sessionId];
        $expectedResponse = [
            'status_code' => 1,
            'status_message' => 'Success.',
        ];

        $this->mockClient
            ->shouldReceive('post')
            ->once()
            ->with("movie/{$movieId}/rating", $expectedData, $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->movieService->rate($movieId, $rating, $sessionId);

        expect($result)->toBe($expectedResponse);
    });

    it('can delete movie rating', function (): void {
        $movieId = 550;
        $sessionId = 'test-session-id';
        $expectedParams = ['session_id' => $sessionId];
        $expectedResponse = [
            'status_code' => 13,
            'status_message' => 'The item/record was deleted successfully.',
        ];

        $this->mockClient
            ->shouldReceive('delete')
            ->once()
            ->with("movie/{$movieId}/rating", $expectedParams)
            ->andReturn($expectedResponse);

        $result = $this->movieService->deleteRating($movieId, $sessionId);

        expect($result)->toBe($expectedResponse);
    });

    it('can get movie videos', function (): void {
        $movieId = 550;
        $expectedResponse = [
            'results' => [
                [
                    'key' => 'SUXWAEX2jlg',
                    'name' => 'Fight Club | #TBT Trailer',
                    'site' => 'YouTube',
                    'type' => 'Trailer',
                ]
            ]
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with("movie/{$movieId}/videos")
            ->andReturn($expectedResponse);

        $result = $this->movieService->videos($movieId);

        expect($result)->toBe($expectedResponse);
    });

    it('can get similar movies', function (): void {
        $movieId = 550;
        $page = 1;
        $expectedResponse = [
            'page' => 1,
            'results' => [mockMovieResponse(807)], // Different movie ID
            'total_pages' => 10,
            'total_results' => 200,
        ];

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with("movie/{$movieId}/similar", ['page' => $page])
            ->andReturn($expectedResponse);

        $result = $this->movieService->similar($movieId, $page);

        expect($result)->toBe($expectedResponse);
    });

});

describe('MovieService edge cases', function (): void {

    it('handles empty append to response array', function (): void {
        $movieId = 550;
        $expectedResponse = mockMovieResponse($movieId);

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with("movie/{$movieId}", [])
            ->andReturn($expectedResponse);

        $result = $this->movieService->details($movieId, []);

        expect($result)->toBe($expectedResponse);
    });

    it('can get latest movie', function (): void {
        $expectedResponse = mockMovieResponse(999999);

        $this->mockClient
            ->shouldReceive('get')
            ->once()
            ->with('movie/latest')
            ->andReturn($expectedResponse);

        $result = $this->movieService->latest();

        expect($result)->toBe($expectedResponse);
    });

});