# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel package that provides a comprehensive wrapper for The Movie Database (TMDB) API v3. The package offers movies, TV shows, people, and search functionality with built-in caching, error handling, and Laravel service container integration.

**Package namespace**: `malpaso\LaravelTmdb`

## Common Development Commands

### Testing
```bash
# Run all tests
composer test

# Run unit tests only (excludes integration tests)
composer test-unit

# Run integration tests only
composer test-integration

# Run tests with coverage report
composer test-coverage
```

### Code Quality
```bash
# Run PHPStan static analysis (level 8)
composer analyse

# Run Rector refactoring (dry-run to preview changes)
composer refactor-dry

# Apply Rector refactoring
composer refactor

# Run all quality checks
composer test && composer analyse && composer refactor-dry
```

## Architecture Overview

### Core Components

**TmdbClient** (`src/TmdbClient.php`): HTTP client wrapper that handles API requests, authentication, caching, error handling, and request/response transformation.

**TmdbManager** (`src/TmdbManager.php`): Main entry point that provides access to service instances (movies, TV, people, search, configuration). Uses lazy loading for service instantiation.

**Service Layer** (`src/Services/`): Domain-specific services for different TMDB API endpoints:
- `MovieService`: Movie details, credits, videos, images, lists
- `TvService`: TV shows, seasons, episodes
- `PersonService`: People, credits, images
- `SearchService`: Search across movies, TV, people
- `ConfigurationService`: API configuration, image URLs

**Laravel Integration**:
- `TmdbServiceProvider`: Registers services, publishes config, validates credentials
- `Facades/Tmdb.php`: Laravel facade for easy static access

### Key Architectural Patterns

**Service Provider Pattern**: Laravel service provider handles dependency injection, configuration publishing, and credential validation.

**Facade Pattern**: Provides static access interface while maintaining dependency injection underneath.

**Repository Pattern**: Services act as repositories for TMDB API data with consistent interfaces.

**Chain of Responsibility**: Client supports method chaining for configuration (language, region, caching options).

**Lazy Loading**: Services are instantiated only when accessed through the manager.

### Configuration System

The package uses cascading configuration:
1. Environment variables (`.env` file)
2. Published config file (`config/tmdb.php`) 
3. Package defaults

Authentication supports both Bearer tokens (preferred) and API keys.

### Testing Strategy

**Three-tier testing approach**:
- **Unit tests** (`tests/Unit/`): Test individual service methods with mocked HTTP client
- **Feature tests** (`tests/Feature/`): Test Laravel integration (facades, service provider)
- **Integration tests** (`tests/Integration/`): Test actual API calls (requires real credentials)

**Test helpers** (`tests/Pest.php`):
- Mock client factory
- Sample response fixtures
- Consistent test data across test suites

**Environment Setup for Tests**:
- The TestCase automatically loads `.env` file from the package root for test configuration
- Integration tests require real TMDB credentials in `.env` file
- Set either `TMDB_ACCESS_TOKEN` (preferred) or `TMDB_API_KEY` for integration tests
- Unit and feature tests work without real credentials (use mocks)

### Error Handling

Custom `TmdbException` class with specific error types:
- 401: Authentication failed
- 404: Resource not found
- 422: Validation errors
- 429: Rate limit exceeded
- 5xx: Server errors

### Caching Strategy

Built-in caching for GET requests:
- Uses Laravel's cache manager
- Configurable TTL per request or globally
- Cache keys include method, endpoint, and parameters
- Can be disabled per request or globally

## Development Guidelines

### Code Style
- PHP 8.1+ features (constructor property promotion, readonly properties, union types)
- PHPStan level 8 static analysis
- Pest testing framework with descriptive test names
- PSR-4 autoloading with `malpaso\LaravelTmdb` namespace

### Testing Requirements
- Unit tests must use mocked HTTP client, never real API calls
- Integration tests should be marked with `@group integration`
- All new service methods require corresponding tests
- Mock helpers should be used for consistent test data

### Configuration Changes
- Environment variables should be documented in `.env.example`
- Config file changes require corresponding documentation updates
- Authentication methods must support both Bearer tokens and API keys

### Service Method Patterns
- Service methods should accept ID parameters and optional append/query arrays
- Return arrays (decoded JSON responses) rather than objects
- Use type declarations for all parameters and return types
- Handle API errors through TmdbException with appropriate error codes