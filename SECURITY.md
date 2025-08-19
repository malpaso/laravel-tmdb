# Security Policy

## Supported Versions

We provide security updates for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability within this package, please send an email to [your.email@example.com](mailto:your.email@example.com). All security vulnerabilities will be promptly addressed.

Please do not create a public GitHub issue for security vulnerabilities.

## Security Considerations

When using this package:

1. **API Credentials**: Never commit your TMDB API keys or access tokens to version control
2. **Environment Variables**: Store credentials in `.env` files and exclude them from version control
3. **Rate Limiting**: Be aware of TMDB's rate limits to avoid being blocked
4. **Caching**: Cached responses may contain sensitive data - ensure your cache is secure
5. **Input Validation**: Always validate user input before passing to API methods

## Best Practices

- Use environment variables for all sensitive configuration
- Implement proper error handling to avoid exposing sensitive information
- Consider implementing rate limiting in your application
- Regularly update the package to get the latest security fixes
- Monitor your API usage for unusual patterns

## Responsible Disclosure

We follow responsible disclosure practices. If you report a vulnerability:

1. We'll acknowledge receipt within 48 hours
2. We'll provide a timeline for resolution
3. We'll keep you informed of progress
4. We'll credit you in the security advisory (if desired)

Thank you for helping keep this package secure!