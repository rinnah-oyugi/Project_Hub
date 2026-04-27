# ProjectHub Production Deployment Guide

## 🚀 Quick Deployment Steps

### 1. Environment Configuration
Copy the production environment settings from `production-env-config.md` to your `.env` file:
- Replace `your-domain.com` with your actual domain
- Configure your SMTP settings for email delivery
- Set `APP_DEBUG=false` and `APP_ENV=production`

### 2. Database Setup
Run the migrations to ensure the queue tables exist:
```bash
php artisan migrate
```

### 3. Application Cache
Optimize your application for production:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Queue Worker Setup
Start the queue worker to process email jobs:
```bash
# For development/testing
php artisan queue:work

# For production (recommended)
php artisan queue:work --daemon
```

### 5. Production Queue Worker (Supervisor)
Install Supervisor to manage the queue worker process:

Create `/etc/supervisor/conf.d/projecthub-worker.conf`:
```ini
[program:projecthub-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

Start Supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start projecthub-worker:*
```

## 📧 Email System Features

### Triggers
- **Chapter Approved**: When supervisor sets status to "approved"
- **Chapter Re-opened**: When supervisor re-opens an approved chapter
- **Revision Requested**: When supervisor sets status to "revision_requested"

### Queue System
- Uses database driver for reliability
- Asynchronous processing maintains fast user experience
- Built-in retry mechanism for failed emails
- Rate limiting prevents spamming (30-second cooldown)

### Email Templates
- Professional Amber & Indigo theme matching the web app
- Responsive design for all devices
- Includes supervisor comments and dashboard links
- Environment-agnostic URLs

## 🔒 Security Features

### Production Hardening
- `APP_DEBUG=false` - Prevents information leakage
- `SESSION_SECURE_COOKIE=true` - HTTPS-only cookies
- `SESSION_ENCRYPT=true` - Encrypted session data
- `SESSION_SAME_SITE=strict` - CSRF protection
- `LOG_LEVEL=error` - Reduced log verbosity

### Anti-Spam Protection
- 30-second rate limiting on status changes
- Cache-based cooldown system
- Form validation on all inputs

## 🛠️ Maintenance Commands

### Queue Management
```bash
# View failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush

# Monitor queue status
php artisan queue:monitor
```

### Cache Management
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild production caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔍 Testing the Email System

### Local Testing
1. Set `MAIL_MAILER=log` in your `.env` to see emails in logs
2. Test chapter approval/rejection actions
3. Check `storage/logs/laravel.log` for email content

### Production Testing
1. Configure real SMTP settings
2. Test with a test chapter
3. Monitor queue worker logs
4. Verify email delivery

## 📋 Environment-Agnostic URLs

The system automatically generates correct URLs whether running on:
- Local XAMPP: `http://127.0.0.1:8000`
- Production VPS: `https://your-domain.com`

The `route('dashboard')` helper ensures links work in any environment.

## ⚡ Performance Optimizations

- **Asynchronous Emails**: No waiting for SMTP responses
- **Database Queues**: Reliable job storage
- **Cached Routes**: Faster response times
- **Optimized Assets**: Production-ready compilation

## 🚨 Troubleshooting

### Emails Not Sending
1. Check queue worker is running: `ps aux | grep queue:work`
2. Verify SMTP configuration in `.env`
3. Check failed jobs: `php artisan queue:failed`
4. Review logs: `tail -f storage/logs/laravel.log`

### Queue Issues
1. Clear cache: `php artisan cache:clear`
2. Restart queue worker
3. Check database connection
4. Verify jobs table exists

### Performance Issues
1. Ensure queue worker is in daemon mode
2. Monitor memory usage
3. Check log file sizes
4. Optimize database queries

---

**Ready for production!** 🎉

Your ProjectHub application now has a robust, production-ready queued notification system that will scale with your user base while maintaining excellent performance.
