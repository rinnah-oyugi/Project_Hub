# Production Environment Configuration


```env
APP_NAME="ProjectHub"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
# Production URL - replace with your actual domain
APP_URL=https://your-domain.com

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_PATH=/
SESSION_DOMAIN=your-domain.com
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@your-domain.com
MAIL_PASSWORD=your-email-password
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

## Key Production Security Changes:

1. **APP_DEBUG=false** - Prevents sensitive information leakage
2. **APP_ENV=production** - Enables production optimizations
3. **SESSION_SECURE_COOKIE=true** - Ensures cookies are only sent over HTTPS
4. **SESSION_ENCRYPT=true** - Encrypts session data
5. **SESSION_SAME_SITE=strict** - Prevents CSRF attacks
6. **LOG_LEVEL=error** - Reduces log verbosity in production
7. **QUEUE_CONNECTION=database** - Uses database queue driver
8. **SESSION_DOMAIN** - Set to your actual domain for proper cookie handling

## Deployment Steps:

1. Replace `your-domain.com` with your actual domain
2. Configure your SMTP settings for email delivery
3. Run `php artisan key:generate` if APP_KEY is empty
4. Run `php artisan config:cache` and `php artisan route:cache`
