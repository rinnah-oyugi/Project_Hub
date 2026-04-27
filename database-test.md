# MySQL Connection Test Guide

## Step 1: Start MySQL in XAMPP
1. Open XAMPP Control Panel
2. Click "Start" next to MySQL
3. Wait for green background
4. Also start Apache

## Step 2: Create Database
1. Click "Admin" next to MySQL
2. In phpMyAdmin: Click "New"
3. Enter: `projecthub`
4. Click "Create"

## Step 3: Test Connection
Run this command after starting MySQL:
```bash
php artisan tinker
```

Then in tinker, run:
```php
\DB::connection()->getPdo();
```

If successful: Shows PDO connection info
If error: Shows connection error details

## Step 4: Run Migrations
Once connected:
```bash
php artisan migrate
```

## Step 5: Test Login
Try logging in as admin:
- Email: admin@projecthub.com
- Password: admin123

## Common Issues & Fixes

### "Access denied for user 'root'@'localhost'"
- Fix: Set DB_PASSWORD= (empty) in .env
- MySQL default password is empty in XAMPP

### "No connection could be made"
- Fix: Make sure MySQL is running in XAMPP
- Check port 3306 isn't blocked

### "Database doesn't exist"
- Fix: Create 'projecthub' database in phpMyAdmin
- Or run: php artisan migrate (will create if configured)

## Quick Commands
```bash
# Clear all caches
php artisan optimize:clear

# Check migration status
php artisan migrate:status

# Test database connection
php artisan tinker --execute="echo \DB::connection()->getDatabaseName();"
```

## .env Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projecthub
DB_USERNAME=root
DB_PASSWORD=
```

After fixing, try login and password reset again.
