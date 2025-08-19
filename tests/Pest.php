<?php

use malpaso\LaravelTmdb\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)->in('Feature', 'Unit', 'Integration');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function mockTmdbClient(): Mockery\MockInterface
{
    return Mockery::mock(\malpaso\LaravelTmdb\Contracts\TmdbClientInterface::class);
}

function mockMovieResponse(int $id = 550): array
{
    return [
        'id' => $id,
        'title' => 'Fight Club',
        'overview' => 'A ticking-time-bomb insomniac and a slippery soap salesman channel primal male aggression into a shocking new form of therapy.',
        'release_date' => '1999-10-15',
        'adult' => false,
        'backdrop_path' => '/87hTDiay2N2qWyX4Ds7ybXi9h8I.jpg',
        'poster_path' => '/pB8BM7pdSp6B6Ih7QZ4DrQ3PmJK.jpg',
        'popularity' => 61.416,
        'vote_average' => 8.433,
        'vote_count' => 24914,
    ];
}

function mockTvShowResponse(int $id = 1399): array
{
    return [
        'id' => $id,
        'name' => 'Game of Thrones',
        'overview' => 'Seven noble families fight for control of the mythical land of Westeros.',
        'first_air_date' => '2011-04-17',
        'last_air_date' => '2019-05-19',
        'number_of_episodes' => 73,
        'number_of_seasons' => 8,
        'status' => 'Ended',
        'popularity' => 369.594,
        'vote_average' => 8.3,
        'vote_count' => 11504,
    ];
}

function mockPersonResponse(int $id = 287): array
{
    return [
        'id' => $id,
        'name' => 'Brad Pitt',
        'biography' => 'William Bradley Pitt is an American actor and film producer.',
        'birthday' => '1963-12-18',
        'deathday' => null,
        'place_of_birth' => 'Shawnee, Oklahoma, USA',
        'popularity' => 10.647,
        'profile_path' => '/kU3B75TyRiCgE270EyZnHjfivoq.jpg',
        'adult' => false,
        'known_for_department' => 'Acting',
    ];
}