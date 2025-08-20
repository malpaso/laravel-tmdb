A comprehensive Laravel wrapper for The Movie Database (TMDB) API v3. This package provides an elegant and easy-to-use interface for accessing movie, TV show, and person data from TMDB.

## Features

- 🎬 Complete TMDB API v3 coverage
- 🚀 Laravel integration with service provider and facade
- 💾 Built-in caching support
- 🔧 Configurable HTTP client
- 🎯 Type-safe interfaces
- 🧪 Comprehensive test coverage
- 📖 Detailed documentation
- 🔐 Bearer token and API key authentication
- 🌍 Multi-language and region support
- ⚡ Rate limiting awareness

## Installation

Install the package via Composer:

```bash
composer require malpaso/laravel-tmdb
```

### Laravel Auto-Discovery

The package will automatically register itself via Laravel's package discovery.

### Manual Registration (if needed)

If auto-discovery is disabled, add the service provider to `config/app.php`:

```php
'providers' => [
    // ...
    malpaso\LaravelTmdb\TmdbServiceProvider::class,
],
```

And optionally add the facade:

```php
'aliases' => [
    // ...
    'Tmdb' => malpaso\LaravelTmdb\Facades\Tmdb::class,
],
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=tmdb-config
```

Add your TMDB credentials to your `.env` file:

```env
# Get your API credentials from https://www.themoviedb.org/settings/api
TMDB_ACCESS_TOKEN=your_access_token_here
# OR use API key (Bearer token is preferred)
TMDB_API_KEY=your_api_key_here

# Optional configuration
TMDB_LANGUAGE=en-US
TMDB_REGION=US
TMDB_CACHE_ENABLED=true
TMDB_CACHE_TTL=3600
```

## Testing

This package uses [Pest](https://pestphp.com/) for testing, which provides a more elegant testing experience.

Run the tests:

```bash
composer test
```

Run tests with coverage:

```bash
composer test-coverage
```

Run static analysis:

```bash
composer analyse
```

Run code refactoring (dry-run):

```bash
composer refactor-dry
```

Apply code refactoring:

```bash
composer refactor
```

### Code Quality Tools

This package uses several tools to maintain high code quality:

- **[Pest](https://pestphp.com/)** - Elegant testing framework
- **[PHPStan](https://phpstan.org/)** - Static analysis (level 8)
- **[Rector](https://getrector.org/)** - Automated refactoring and code modernization

### Running Quality Checks

```bash
# Run all quality checks
composer test && composer analyse && composer refactor-dry
```

### Writing Tests

The package includes comprehensive test coverage using Pest. Here's an example of how tests are structured:

```php
// tests/Unit/MovieServiceTest.php
it('can get movie details', function () {
    $mockClient = mockTmdbClient();
    $movieService = new MovieService($mockClient);
    
    $mockClient
        ->shouldReceive('get')
        ->once()
        ->with('movie/550', [])
        ->andReturn(mockMovieResponse());

    $result = $movieService->details(550);

    expect($result)->toBe(mockMovieResponse());
});
```

The test suite includes:
- Unit tests for all service classes
- Feature tests for facade integration
- Mock helpers for consistent test data
- Edge case coverage

### Test Helpers

The package provides several test helpers in `tests/Pest.php`:

- `mockTmdbClient()` - Creates a mock TMDB client
- `mockMovieResponse()` - Returns sample movie data
- `mockTvShowResponse()` - Returns sample TV show data
- `mockPersonResponse()` - Returns sample person data# Laravel TMDB Package

## Usage

### Using the Facade

```php
use malpaso\LaravelTmdb\Facades\Tmdb;

// Get movie details
$movie = Tmdb::movies()->details(550); // Fight Club

// Search for movies
$results = Tmdb::search()->movies('Inception');

// Get popular movies
$popular = Tmdb::movies()->popular();

// Get TV show details
$tvShow = Tmdb::tv()->details(1399); // Game of Thrones

// Search for people
$people = Tmdb::search()->people('Brad Pitt');
```

### Using Dependency Injection

```php
use malpaso\LaravelTmdb\TmdbManager;

class MovieController extends Controller
{
    public function show(TmdbManager $tmdb, int $id)
    {
        $movie = $tmdb->movies()->details($id, [
            'credits', 
            'videos', 
            'similar'
        ]);
        
        return view('movies.show', compact('movie'));
    }
}
```

### Language and Region Support

```php
// Set language and region for requests
$movie = Tmdb::language('es-ES')
    ->region('ES')
    ->movies()
    ->details(550);

// Or use the client directly
$results = Tmdb::client()
    ->language('fr-FR')
    ->get('movie/popular');
```

### Caching Control

```php
// Disable cache for a specific request
$liveData = Tmdb::withoutCache()
    ->movies()
    ->popular();

// Set custom cache TTL (in seconds)
$cachedData = Tmdb::cacheTtl(7200)
    ->movies()
    ->topRated();
```

## API Reference

### Movies

```php
// Movie details with additional data
$movie = Tmdb::movies()->details(550, ['credits', 'videos', 'reviews']);

// Movie credits (cast and crew)
$credits = Tmdb::movies()->credits(550);

// Movie videos (trailers, teasers)
$videos = Tmdb::movies()->videos(550);

// Movie images
$images = Tmdb::movies()->images(550);

// Movie reviews
$reviews = Tmdb::movies()->reviews(550);

// Similar movies
$similar = Tmdb::movies()->similar(550);

// Movie recommendations
$recommendations = Tmdb::movies()->recommendations(550);

// Movie lists
$popular = Tmdb::movies()->popular();
$topRated = Tmdb::movies()->topRated();
$upcoming = Tmdb::movies()->upcoming();
$nowPlaying = Tmdb::movies()->nowPlaying();
$latest = Tmdb::movies()->latest();

// Discover movies with filters
$discovered = Tmdb::movies()->discover([
    'sort_by' => 'popularity.desc',
    'primary_release_year' => 2023,
    'with_genres' => '28,12', // Action, Adventure
]);

// Rate a movie (requires authentication)
$rating = Tmdb::movies()->rate(550, 8.5, $sessionId);
```

### TV Shows

```php
// TV show details
$tvShow = Tmdb::tv()->details(1399);

// TV show credits
$credits = Tmdb::tv()->credits(1399);

// Season details
$season = Tmdb::tv()->season(1399, 1);

// Episode details
$episode = Tmdb::tv()->episode(1399, 1, 1);

// TV show lists
$popular = Tmdb::tv()->popular();
$topRated = Tmdb::tv()->topRated();
$airingToday = Tmdb::tv()->airingToday();
$onTheAir = Tmdb::tv()->onTheAir();

// Discover TV shows
$discovered = Tmdb::tv()->discover([
    'sort_by' => 'popularity.desc',
    'first_air_date_year' => 2023,
]);
```

### People

```php
// Person details
$person = Tmdb::people()->details(287); // Brad Pitt

// Person's movie credits
$movieCredits = Tmdb::people()->movieCredits(287);

// Person's TV credits
$tvCredits = Tmdb::people()->tvCredits(287);

// Combined credits
$allCredits = Tmdb::people()->combinedCredits(287);

// Person images
$images = Tmdb::people()->images(287);

// Popular people
$popular = Tmdb::people()->popular();
```

### Search

```php
// Search movies
$movies = Tmdb::search()->movies('The Matrix');

// Search TV shows
$tvShows = Tmdb::search()->tv('Breaking Bad');

// Search people
$people = Tmdb::search()->people('Tom Hanks');

// Multi search (movies, TV, people)
$results = Tmdb::search()->multi('Christopher Nolan');

// Advanced search with filters
$movies = Tmdb::search()->moviesAdvanced('Action', [
    'year' => 2023,
    'primary_release_year' => 2023,
    'include_adult' => false,
]);

// Paginated search
$results = Tmdb::search()->paginated('movie', 'Marvel', 2);
```

### Configuration

```php
// Get API configuration
$config = Tmdb::configuration()->details();

// Get available countries
$countries = Tmdb::configuration()->countries();

// Get available languages
$languages = Tmdb::configuration()->languages();

// Build image URLs
$imageUrl = Tmdb::configuration()->imageUrl('/path/to/image.jpg', 'w500');

// Get available image sizes
$posterSizes = Tmdb::configuration()->posterSizes();
$backdropSizes = Tmdb::configuration()->backdropSizes();
```

### Low-level Client Access

```php
// Direct API calls
$response = Tmdb::get('movie/550');
$response = Tmdb::post('movie/550/rating', ['value' => 8.5]);
$response = Tmdb::put('movie/550/rating', ['value' => 9.0]);
$response = Tmdb::delete('movie/550/rating');
```

## Error Handling

The package provides specific exceptions for different error scenarios:

```php
use malpaso\LaravelTmdb\Exceptions\TmdbException;

try {
    $movie = Tmdb::movies()->details(999999);
} catch (TmdbException $e) {
    switch ($e->getCode()) {
        case 401:
            // Authentication failed
            break;
        case 404:
            // Resource not found
            break;
        case 429:
            // Rate limit exceeded
            break;
        default:
            // Other API error
            break;
    }
    
    // Get the raw API response
    $response = $e->getResponse();
}
```

## Rate Limiting

TMDB allows 40 requests per 10 seconds. The package is aware of these limits but doesn't enforce them automatically. Consider implementing your own rate limiting logic for high-traffic applications.

## Caching

The package includes built-in caching for GET requests. Configure caching in the `config/tmdb.php` file:

```php
'cache' => [
    'enabled' => true,
    'ttl' => 3600, // 1 hour
    'prefix' => 'tmdb',
],
```

## Testing

```bash
composer test
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

- [Bill Tindal](https://github.com/malpaso)
- [All Contributors](../../contributors)
- [The Movie Database](https://www.themoviedb.org/) for providing the API

## Disclaimer

This package uses the TMDB API but is not endorsed or certified by TMDB.

## TMDB Attribution

This product uses the TMDB API but is not endorsed or certified by TMDB.

![TMDB Logo](https://www.themoviedb.org/assets/2/v4/logos/v2/blue_square_2-d537fb228cf3ded904ef09b136fe3fec72548ebc1fea3fbbd1ad9e36364db38b.svg)