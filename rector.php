<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

/**
 * Rector Configuration for Laravel TMDB API Wrapper Package
 * 
 * This configuration is tailored for:
 * - Laravel package development patterns
 * - API wrapper architecture with mutable state management  
 * - Pest testing framework compatibility
 * - PHP 8.1+ modern features adoption
 */
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets([
        // Core PHP version upgrades - targeting PHP 8.1
        LevelSetList::UP_TO_PHP_81,
        
        // Quality improvements suited for API wrappers
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,
        SetList::INSTANCEOF,
    ])
    ->withSkip([
        // ========================================
        // Skip Files That Need Special Handling
        // ========================================
        
        // Test configuration files - Pest framework compatibility
        __DIR__ . '/tests/Pest.php',
        __DIR__ . '/tests/TestCase.php', // Orchestra TestBench needs mutable state
        
        // ========================================
        // Skip Rules Incompatible with API Wrapper Patterns  
        // ========================================
        
        // Readonly classes break service factory patterns and dependency injection
        \Rector\Php82\Rector\Class_\ReadOnlyClassRector::class,
        
        // ========================================
        // Skip Readonly Properties for Stateful Classes
        // ========================================
        \Rector\Php81\Rector\Property\ReadOnlyPropertyRector::class => [
            // HTTP client with mutable request state
            __DIR__ . '/src/TmdbClient.php', // Language, region, cache settings need to be mutable
            
            // Service manager with lazy-loaded services
            __DIR__ . '/src/TmdbManager.php', // Service instances need to be mutable for lazy loading
            
            // Test classes that need mutable state
            __DIR__ . '/tests/TestCase.php', // Orchestra TestBench requires mutable properties
        ],
    ])
    // Enable all PHP 8.1 features
    ->withPhpSets(php81: true);