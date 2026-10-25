#!/usr/bin/env bash
# Deploy situs company-profile-hukum ke /srv/web/company-profile-hukum (jalankan sebagai root).
#
#   deploy/deploy.sh            deploy kode terbaru (build aset, sinkron berkas, migrasi, cache)
#
# Alamat situs dibaca dari domain.env bersama (HUKUM_URL, PORTOFOLIO_URL). Untuk pindah domain:
# ubah domain.env, jalankan deploy/deploy.sh, selesai (Caddy di-reload otomatis).
#   deploy/deploy.sh --install  sekali di awal: .env produksi, database, data demo, akun admin asli,
#                               pool PHP-FPM, unit systemd, dan situs Caddy (SKIP_SEED=1: tanpa data demo)
#   SKIP_SERVICES=1 deploy/deploy.sh   kode dan konfigurasi diperbarui, tetapi layanan tidak dinyalakan
#                               atau dimuat ulang (mis. selama situs sengaja dimatikan untuk pemeliharaan)
#
# Kode dan vendor milik root (grup www-data, hanya-baca). storage/, bootstrap/cache, dan database
# milik www-data. Perintah artisan yang menyentuh database dijalankan sebagai www-data.
set -euo pipefail

APP=company-profile-hukum
SRC="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DEST=/srv/web/$APP
DATA=/var/lib/$APP
SECRETS=/root/tenma-ws/portofolio/rahasia/$APP.txt
ADMIN_EMAIL=admin@nalarsaksama.example
DOMAIN_ENV="${DOMAIN_ENV:-/root/tenma-ws/portofolio/domain.env}"

INSTALL=false
[[ "${1:-}" == "--install" ]] && INSTALL=true

[[ $EUID -eq 0 ]] || { echo "Jalankan sebagai root." >&2; exit 1; }

domain_value() { grep -E "^$1=" "$DOMAIN_ENV" | tail -1 | cut -d= -f2- | tr -d '"'"'"; }
URL="$(domain_value HUKUM_URL)"
PORTFOLIO_URL="$(domain_value PORTOFOLIO_URL)"
HOST="${URL#https://}"
HOST="${HOST%%/*}"
[[ "$URL" == https://* && -n "$HOST" ]] || { echo "HUKUM_URL di $DOMAIN_ENV harus berupa https://host" >&2; exit 1; }

# Tulis/ganti satu kunci di .env produksi.
set_env() {
    local key="$1" value="$2" file="$DEST/.env"
    if grep -qE "^$key=" "$file"; then
        sed -i "s#^$key=.*#$key=$value#" "$file"
    else
        printf '%s=%s\n' "$key" "$value" >> "$file"
    fi
}

as_www() { runuser -u www-data -- "$@"; }
artisan() { (cd "$DEST" && as_www /usr/bin/php artisan "$@"); }
step() { printf '\n==> %s\n' "$*"; }

step "Build aset (Vite)"
cd "$SRC"
npm ci --no-audit --no-fund --loglevel=error
npm run build

step "Sinkron berkas ke $DEST"
install -d -o root -g www-data -m 0751 "$DEST"
rsync -a --delete \
    --exclude='/.git/' --exclude='/node_modules/' --exclude='/vendor/' --exclude='/tests/' \
    --exclude='/docs/' --exclude='/scripts/' --exclude='/deploy/' --exclude='/storage/' \
    --exclude='/bootstrap/cache/*.php' --exclude='/bootstrap/cache/filament/' \
    --exclude='/.env' --exclude='/.env.*' --exclude='/public/storage' --exclude='/public/hot' \
    --exclude='/database/*.sqlite*' --exclude='/playwright-report/' --exclude='/test-results/' \
    --exclude='/.phpunit.cache/' --exclude='/.claude/' \
    "$SRC"/ "$DEST"/

for dir in storage/app/public storage/app/private storage/framework/cache/data storage/framework/sessions \
    storage/framework/views storage/framework/testing storage/logs bootstrap/cache; do
    install -d "$DEST/$dir"
done
ln -sfn ../storage/app/public "$DEST/public/storage"

step "Composer (tanpa dev)"
cd "$DEST"
COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader \
    --no-interaction --no-progress --no-scripts --quiet

step "Database dan .env"
install -d -o www-data -g www-data -m 0700 "$DATA"
if [[ ! -f "$DEST/.env" ]]; then
    $INSTALL || { echo ".env belum ada; jalankan dengan --install." >&2; exit 1; }
    APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
    cat > "$DEST/.env" <<ENV
APP_NAME="Nalar Saksama"
APP_ENV=production
APP_KEY=$APP_KEY
APP_DEBUG=false
APP_URL=$URL
APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID
APP_MAINTENANCE_DRIVER=file
BCRYPT_ROUNDS=12
LOG_CHANNEL=daily
LOG_LEVEL=warning
LOG_DAILY_DAYS=14
DB_CONNECTION=sqlite
DB_DATABASE=$DATA/database.sqlite
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
QUEUE_CONNECTION=database
CACHE_STORE=database
FILESYSTEM_DISK=local
MAIL_MAILER=log
MAIL_FROM_ADDRESS="halo@nalarsaksama.example"
MAIL_FROM_NAME="Nalar Saksama"
DEMO_PASSWORD=coba-demo-saksama
FIRM_WHATSAPP=620000000000
ENV
fi
[[ -f "$DATA/database.sqlite" ]] || install -o www-data -g www-data -m 0600 /dev/null "$DATA/database.sqlite"

# Alamat selalu mengikuti domain.env, juga untuk .env yang sudah ada.
set_env APP_URL "$URL"
set_env PORTFOLIO_URL "$PORTFOLIO_URL"

# Buang cache bootstrap lama (bisa merujuk paket/konfigurasi versi sebelumnya), lalu terbitkan
# ulang aset Filament (JS/CSS/font, tidak disimpan di git) ke public/ yang milik root.
rm -rf "$DEST"/bootstrap/cache/*.php "$DEST"/bootstrap/cache/filament
(cd "$DEST" && /usr/bin/php artisan filament:assets --quiet)

step "Izin berkas"
chown -R root:www-data "$DEST"
find "$DEST" -path "$DEST/storage" -prune -o -path "$DEST/bootstrap/cache" -prune -o -type d -exec chmod 0750 {} +
find "$DEST" -path "$DEST/storage" -prune -o -path "$DEST/bootstrap/cache" -prune -o -type f -exec chmod 0640 {} +
chmod 0751 "$DEST"
find "$DEST/public" -type d -exec chmod 0755 {} +
find "$DEST/public" -type f -exec chmod 0644 {} +
chown -R www-data:www-data "$DEST/storage" "$DEST/bootstrap/cache"
find "$DEST/storage" "$DEST/bootstrap/cache" -type d -exec chmod 0700 {} +
find "$DEST/storage" "$DEST/bootstrap/cache" -type f -exec chmod 0600 {} +
# Caddy hanya boleh menelusuri jalur ke berkas unggahan publik.
chmod 0711 "$DEST/storage" "$DEST/storage/app"
find "$DEST/storage/app/public" -type d -exec chmod 0755 {} +
find "$DEST/storage/app/public" -type f -exec chmod 0644 {} +
# .env hanya terbaca www-data (caddy anggota grup www-data, jadi grupnya root).
chown www-data:root "$DEST/.env"
chmod 0400 "$DEST/.env"

step "Artisan: discover, migrasi, cache"
artisan package:discover --quiet
artisan migrate --force --no-interaction
artisan optimize --quiet

if $INSTALL; then
    step "Data demo dan akun admin asli"
    # SKIP_SEED=1: isi data demo belakangan dengan `php artisan demo:reset --force` (sebagai www-data).
    if [[ "${SKIP_SEED:-0}" != 1 && "$(as_www sqlite3 "$DATA/database.sqlite" 'select count(*) from articles;')" == "0" ]]; then
        artisan db:seed --force --no-interaction
    fi
    if [[ ! -f "$SECRETS" ]]; then
        password="$(head -c 48 /dev/urandom | base64 | tr -dc 'A-Za-z0-9' | head -c 24)"
        printf '%s' "$password" | artisan app:create-admin "$ADMIN_EMAIL" --password-stdin
        install -d -m 0700 "$(dirname "$SECRETS")"
        (
            umask 077
            cat > "$SECRETS" <<TXT
Akun admin asli company-profile-hukum (Nalar Saksama)
Panel : $URL/admin
Email : $ADMIN_EMAIL
Sandi : $password
Dibuat: $(date '+%Y-%m-%d %H:%M %Z') oleh deploy/deploy.sh --install
Ganti sandi lewat menu profil di panel, lalu perbarui file ini.
TXT
        )
        chmod 0600 "$SECRETS"
        echo "Kredensial admin asli disimpan di $SECRETS"
    fi
fi

step "PHP-FPM pool, systemd, dan Caddy (dari deploy/)"
install -m 0644 "$SRC/deploy/php-fpm-pool.conf" /etc/php/8.3/fpm/pool.d/$APP.conf
php-fpm8.3 -t
install -m 0644 "$SRC"/deploy/systemd/$APP-*.service "$SRC"/deploy/systemd/$APP-*.timer /etc/systemd/system/
systemctl daemon-reload
[[ "${SKIP_SERVICES:-0}" == 1 ]] || systemctl enable --now $APP-queue.service $APP-scheduler.timer $APP-demo-reset.timer
backup="$(mktemp)"
cp -a /etc/caddy/sites/$APP.caddy "$backup" 2>/dev/null || true
sed "s#__HUKUM_HOST__#$HOST#g" "$SRC/deploy/$APP.caddy.tmpl" > "/etc/caddy/sites/$APP.caddy"
chmod 0644 "/etc/caddy/sites/$APP.caddy"
if ! caddy validate --config /etc/caddy/Caddyfile --adapter caddyfile >/dev/null 2>&1; then
    # Jangan biarkan berkas rusak mengganggu situs lain saat Caddy di-reload.
    [[ -s "$backup" ]] && install -m 0644 "$backup" /etc/caddy/sites/$APP.caddy
    rm -f "$backup"
    echo "Konfigurasi Caddy tidak valid; berkas lama dipulihkan." >&2
    exit 1
fi
rm -f "$backup"

if [[ "${SKIP_SERVICES:-0}" == 1 ]]; then
    step "Selesai tanpa menyalakan layanan (SKIP_SERVICES=1): $URL"
    exit 0
fi

step "Muat ulang layanan"
systemctl reload php8.3-fpm
artisan queue:restart --quiet
systemctl restart $APP-queue.service
systemctl reload caddy

step "Selesai: $URL"
