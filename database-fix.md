# Database Connection Fix

## The Problem
Your error shows Laravel trying to connect to MySQL, but your project is configured for SQLite.

## Quick Fix

### Option 1: Use SQLite (Recommended for XAMPP)
Update your `.env` file to use SQLite:

```env
DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=projecthub
# DB_USERNAME=root
# DB_PASSWORD=
```

### Option 2: Use MySQL (If you prefer)
If you want to use MySQL with XAMPP:

1. Make sure MySQL is running in XAMPP
2. Create database `projecthub` in phpMyAdmin
3. Update `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projecthub
DB_USERNAME=root
DB_PASSWORD=
```

## After Fixing Database
Run these commands:
```bash
php artisan config:clear
php artisan migrate
```

## Verification
Test by registering a new user - should work without 500 error.

