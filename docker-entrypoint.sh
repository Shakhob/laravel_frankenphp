#!/bin/bash
set -e

until php artisan migrate --force; do
  echo "Migration failed, probably DB is not ready - waiting 5 seconds..."
  sleep 5
done

php artisan config:cache
php artisan route:cache || true
php artisan view:cache || true

# Запускаем через artisan octane с сервером FrankenPHP
exec php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000 --workers=${OCTANE_WORKERS:-8}
