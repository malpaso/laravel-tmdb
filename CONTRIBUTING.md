# Contributing

Thank you for considering contributing to the Laravel TMDB package! Please read through this guide to understand how to contribute effectively.

## Development Setup

1. Fork the repository
2. Clone your fork: `git clone https://github.com/malpaso/laravel-tmdb.git`
3. Install dependencies: `composer install`
4. Copy `.env.example` to `.env` and add your TMDB credentials
5. Run tests: `composer test`

## Development Guidelines

### Code Style

- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Add type hints for all parameters and return types
- Write docblocks for all public methods

### Testing

- All new features must include tests
- Tests should use Pest framework
- Aim for high test coverage (minimum 80%)
- Use the provided mock helpers for consistent test data
- Write both unit and feature tests where appropriate

### Development Workflow

Follow this workflow for contributing:

```bash
# 1. Create feature branch
git checkout -b feature/your-feature-name

# 2. Write your feature/fix with tests

# 3. Run the complete quality check suite
composer test           # Run tests
composer analyse        # Static analysis with PHPStan
composer refactor-dry   # Check what Rector would change

# 4. Apply automatic code improvements
composer refactor       # Apply Rector improvements

# 5. Run tests again to ensure refactoring didn't break anything
composer test

# 6. Commit your changes
git add .
git commit -m "feat: add your feature description"

# 7. Push and create pull request
git push origin feature/your-feature-name
```

**Quality Gates:**
- ✅ All tests must pass
- ✅ PHPStan level 8 must pass
- ✅ Rector should have no suggestions (run dry-run)
- ✅ Code coverage should be maintained or improved

**Pro tip:** You can run all quality checks in one command:
```bash
composer test && composer analyse && composer refactor-dry
```

### Pull Requests

1. Create a feature branch: `git checkout -b feature/your-feature-name`
2. Make your changes
3. Add tests for new functionality
4. Ensure all tests pass: `composer test`
5. Run static analysis: `composer analyse`
6. Run code refactoring check: `composer refactor-dry`
7. Commit your changes with descriptive commit messages
7. Push to your fork: `git push origin feature/your-feature-name`
8. Create a pull request

### Commit Messages

Use conventional commit messages:
- `feat: add new movie rating functionality`
- `fix: resolve caching issue with TV shows`
- `docs: update README with new examples`
- `test: add tests for search service`
- `refactor: improve error handling`

### Adding New Features

When adding new TMDB API endpoints:

1. Add the method to the appropriate service class
2. Update the interface if necessary
3. Add comprehensive tests
4. Update documentation
5. Add examples to the README

### Bug Reports

When reporting bugs, please include:
- Steps to reproduce the issue
- Expected behavior
- Actual behavior
- PHP and Laravel versions
- Package version

### Feature Requests

For new features:
- Explain the use case
- Provide examples of how it would be used
- Reference TMDB API documentation if applicable

## Code Review Process

1. All pull requests require review
2. Reviews will check for:
   - Code quality and style
   - Test coverage
   - Documentation updates
   - Backward compatibility
   - Modern PHP practices (via Rector)

## Questions?

Feel free to open an issue for any questions about contributing!