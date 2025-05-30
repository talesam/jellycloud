# 🔒 Security Policy

## Supported Versions

Use this section to tell people about which versions of JellyCloud are currently being supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| 2.0.x   | ✅ Yes              |
| < 2.0   | ❌ No               |

## Reporting a Vulnerability

The JellyCloud team takes security vulnerabilities seriously. We appreciate your efforts to responsibly disclose your findings, and will make every effort to acknowledge your contributions.

### How to Report

**Please do NOT report security vulnerabilities through public GitHub issues.**

Instead, please report security vulnerabilities through one of the following methods:

1. **Email**: Send details to `security@jellycloud.com`
2. **Private Security Advisory**: Use GitHub's private vulnerability reporting feature

### What to Include

When reporting a vulnerability, please include:

- **Type of issue** (e.g. buffer overflow, SQL injection, cross-site scripting, etc.)
- **Full paths** of source file(s) related to the manifestation of the issue
- **Location** of the affected source code (tag/branch/commit or direct URL)
- **Special configuration** required to reproduce the issue
- **Step-by-step instructions** to reproduce the issue
- **Proof-of-concept or exploit code** (if possible)
- **Impact** of the issue, including how an attacker might exploit it

### Response Timeline

- **Acknowledgment**: Within 48 hours
- **Initial Assessment**: Within 1 week
- **Status Updates**: Weekly until resolved
- **Resolution**: Target within 30 days for high-severity issues

### Security Measures in JellyCloud

#### Authentication & Authorization
- ✅ Secure session management
- ✅ CSRF protection on all forms
- ✅ Password hashing using bcrypt
- ✅ Input validation and sanitization
- ✅ Rate limiting on authentication endpoints

#### File Security
- ✅ File type validation
- ✅ Path traversal protection
- ✅ Upload size limits
- ✅ Secure file storage
- ✅ Antivirus scanning recommendations

#### Database Security
- ✅ Prepared statements (SQL injection protection)
- ✅ Database encryption at rest
- ✅ Minimal privileges principle
- ✅ Regular security updates

#### Infrastructure Security
- ✅ Docker container isolation
- ✅ Non-root user execution
- ✅ Secure defaults
- ✅ TLS/SSL encryption support
- ✅ Security headers

### Security Best Practices for Deployment

#### Environment Configuration
```bash
# Use strong, unique passwords
MAIL_PASSWORD=strong-unique-password
API_TOKEN=cryptographically-secure-random-token

# Disable debug in production
APP_DEBUG=false
DEBUG=false

# Enable HTTPS
APP_URL=https://your-domain.com
```

#### Docker Security
```yaml
# Use non-root user
user: "1000:1000"

# Read-only file system where possible
read_only: true

# Limit resources
deploy:
  resources:
    limits:
      memory: 512M
      cpus: '0.5'
```

#### Web Server Configuration
```nginx
# Security headers
add_header X-Frame-Options DENY;
add_header X-Content-Type-Options nosniff;
add_header X-XSS-Protection "1; mode=block";
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
add_header Content-Security-Policy "default-src 'self'";

# Hide server information
server_tokens off;

# Limit request size
client_max_body_size 100M;
```

### Security Checklist for Contributors

When contributing code, please ensure:

- [ ] Input validation on all user inputs
- [ ] Output encoding to prevent XSS
- [ ] Use prepared statements for database queries
- [ ] Implement proper authentication checks
- [ ] Add CSRF tokens to forms
- [ ] Validate file uploads thoroughly
- [ ] Use secure random number generation
- [ ] Implement proper error handling (no sensitive info in errors)
- [ ] Use HTTPS for all sensitive communications
- [ ] Follow principle of least privilege

### Known Security Considerations

#### File Upload Security
- Files are stored outside the web root
- File type validation using MIME type and extension
- Maximum file size limits enforced
- Antivirus scanning recommended for production

#### Session Management
- Secure session cookies
- Session regeneration after login
- Automatic session timeout
- Secure session storage

#### API Security
- API rate limiting
- Token-based authentication
- Input validation on all endpoints
- Proper error handling

### Security Updates

Security updates will be released as patch versions (e.g., 2.0.1, 2.0.2) and will include:

- **Security advisory** describing the issue (after fix is available)
- **Upgrade instructions** for affected users
- **Mitigation strategies** for users who cannot upgrade immediately

### Third-Party Dependencies

JellyCloud uses the following third-party components:

- **PHP**: Latest stable version recommended
- **PHPMailer**: For secure email sending
- **Bootstrap**: For UI components
- **Font Awesome**: For icons

We regularly monitor these dependencies for security vulnerabilities and update them as needed.

### Security Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)
- [Docker Security Best Practices](https://docs.docker.com/develop/security-best-practices/)
- [NIST Cybersecurity Framework](https://www.nist.gov/cyberframework)

### Hall of Fame

We would like to thank the following individuals for responsibly disclosing security vulnerabilities:

- *No reports yet - be the first!*

---

**Thank you for helping keep JellyCloud secure!** 🔒🍇
