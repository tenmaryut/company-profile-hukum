# company-profile-hukum

Company profile kantor hukum FIKTIF "Kantor Hukum Nalar Saksama" + CMS (portofolio Tenma). Brief, aturan bersama, dan progress: `/root/tenma-ws/portofolio/` (baca `progress/company-profile-hukum.md` dulu).

## Stack dan perintah
- Laravel 13, Blade, Tailwind CSS 4, Filament 5 (panel `/admin`), SQLite, PHPUnit (Pest 5 butuh PHP 8.4, server PHP 8.3).
- Dev: `php artisan serve --port=8002` (atau `scripts/e2e-server.sh` untuk DB terpisah); aset: `npm run build`.
- Test: `php artisan test` (PHPUnit) dan `npx playwright test` (e2e + screenshot ke `docs/screenshots/`, butuh port 8002 kosong).
- Deploy: `deploy/deploy.sh` sebagai root (ke `/srv/web/company-profile-hukum`, DB di `/var/lib/company-profile-hukum`). Pertama kali `--install`.
- Gambar: `node scripts/generate-images.mjs` (favicon, logo, sampul artikel), `node scripts/og-image.mjs` (gambar OG).

## Konvensi
- Alamat situs hanya dari `/root/tenma-ws/portofolio/domain.env` (`HUKUM_URL`, `PORTOFOLIO_URL`). Jangan menulis domain staging atau IP server di repo (di luar `docs/`); `DomainReadinessTest` menjaganya dengan membaca pola IP dari `~/.config/git/denylist-publik` saat runtime; jangan menulis IP atau polanya (regex, potongan string) di repo. Caddy dibuat dari `deploy/company-profile-hukum.caddy.tmpl` dan wajib memuat `import gerbang_staging`.
- Mode tunnel (putaran 4): Tailscale Funnel → Caddy `http://127.0.0.1:80` → PHP. Laravel hanya memercayai proxy `127.0.0.1` (`trustProxies` di `bootstrap/app.php`), dan hanya header `X-Forwarded-For`/`-Proto` (Host dan Port kiriman pengunjung bisa lolos lewat Funnel); jangan pakai header `Tailscale-User-*`. Uji dari server mungkin lewat relay di `/etc/hosts` (jangan diubah).
- Halaman publik tanpa JavaScript (menu dan FAQ memakai `<details>`); tidak ada style/script inline karena CSP ketat di Caddy.
- Animasi hanya CSS (transform/opacity) di akhir `resources/css/app.css`, di dalam `@media (prefers-reduced-motion: no-preference)`; scroll-driven di dalam `@supports`. Kelas: `.hero-reveal`, `.memo-*`, `.reveal`, `.lift`, `.read-progress`. Rekaman: `REKAM=1 npx playwright test tests/e2e/rekam-animasi.spec.ts`.
- Komponen ikon bernama `<x-ikon>` (bukan `x-icon`, bentrok dengan blade-icons milik Filament).
- Konten demo ada di `database/content/` (Markdown) dan dimuat `DemoContentSeeder`; `demo:reset` mengembalikannya tiap malam.
- Konten hukum wajib terverifikasi ke sumber resmi (aturan di `~/.claude/CLAUDE.md`); catat di `database/content/verifikasi.md`.
- Upload gambar hanya JPG/PNG/WebP ≤ 2 MB (`App\Filament\Support\ImageUpload`), dikonversi ke WebP lewat queue.
- Akun demo hanya melihat permintaan konsultasi contoh dan kiriman dari browsernya sendiri (cookie `ns_pengirim`).
