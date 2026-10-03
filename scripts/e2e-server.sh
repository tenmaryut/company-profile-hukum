#!/usr/bin/env bash
# Server lokal untuk test Playwright: database terpisah (database/e2e.sqlite) yang
# dibuat ulang dan diisi data demo setiap kali dijalankan. Port 8002 (port dev hukum).
set -euo pipefail
cd "$(dirname "$0")/.."

export APP_ENV=local APP_DEBUG=false APP_URL=http://127.0.0.1:8002 \
    DB_CONNECTION=sqlite DB_DATABASE="$PWD/database/e2e.sqlite" \
    QUEUE_CONNECTION=sync SESSION_DRIVER=database CACHE_STORE=database \
    MAIL_MAILER=log LOG_CHANNEL=single PHP_CLI_SERVER_WORKERS=4

php artisan config:clear --quiet
rm -f database/e2e.sqlite
touch database/e2e.sqlite
php artisan migrate:fresh --seed --force --no-interaction --quiet
[[ -e public/storage ]] || php artisan storage:link --quiet

cd public
exec php -S 127.0.0.1:8002 ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php
