# StackPilot Deployment Guide

This document describes how StackPilot would be prepared and operated in a production-like environment.

Even if StackPilot is not deployed publicly, these steps represent professional Laravel deployment standards.

---

## Environment Overview

StackPilot is designed as a containerized Laravel + Vue application.

Core components:

- Laravel API backend
- Vue SPA frontend
- MySQL database
- Redis cache
- Queue workers
- Scheduler
- CI pipeline

---

## Production Build (Local Simulation)

To simulate production locally:

```bash
./vendor/bin/sail down
APP_ENV=production ./vendor/bin/sail up -d
```

Build frontend assets:

```bash
./vendor/bin/sail npm run build
```

Clear and cache config:

```bash
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan config:cache
./vendor/bin/sail artisan route:cache
./vendor/bin/sail artisan view:cache
```

Optimize autoload:

```bash
./vendor/bin/sail composer install --optimize-autoloader --no-dev
```

---

## Environment Variables

Create `.env.production`:

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=stackpilot
DB_USERNAME=sail
DB_PASSWORD=password

SANCTUM_STATEFUL_DOMAINS=localhost

CACHE_DRIVER=redis
QUEUE_CONNECTION=database
SESSION_DRIVER=redis
```

Never commit `.env.production`.

---

## Database Migration

```bash
./vendor/bin/sail artisan migrate --force
```

---

## Queue Workers

Run queue workers:

```bash
./vendor/bin/sail artisan queue:work --daemon
```

In production this would be managed by Supervisor or systemd.

---

## Scheduler

Run scheduler:

```bash
./vendor/bin/sail artisan schedule:work
```

This handles:

- Token cleanup
- Scheduled jobs
- Maintenance tasks

---

## Logging

Laravel logs to:

```
storage/logs/laravel.log
```

Recommended:

- Rotate logs daily
- Ship logs to centralized storage if deployed

---

## Backups

Suggested backup strategy:

- Daily database dumps
- Weekly full storage backup
- Offsite storage (S3 or similar)

Laravel backup packages may be integrated if needed.

---

## Security Checklist

- APP_DEBUG=false
- HTTPS enforced
- Secrets stored in environment
- CORS locked down
- Rate limiting enabled
- Policies enforced
- CI required before release

---

## CI Release Flow

1. Push to `main`
2. GitHub Actions runs:
   - Pint
   - PHPUnit
   - Frontend build
3. If green:
   - Build production assets
   - Deploy artifacts

---

## Rollback Strategy

If deployment fails:

- Restore previous container image
- Roll back database migrations if needed
- Restore latest backup

---

## Production Readiness Summary

StackPilot includes:

- Full test suite
- CI pipeline
- Authorization policies
- API resources
- Docker environment
- Documentation

This ensures safe and repeatable deployment.

---

End of deployment guide.
