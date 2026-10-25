# Nalar Saksama: company profile kantor hukum + CMS

Situs demo portofolio Tenma: company profile kantor hukum **fiktif** "Kantor Hukum Nalar Saksama", lengkap dengan CMS supaya klien bisa mengubah isinya sendiri. Firma, tim, alamat, dan kontaknya tidak nyata, dan isinya bukan nasihat hukum.

- Situs: https://hukum.tail482cb9.ts.net (nilai `HUKUM_URL` di `/root/tenma-ws/portofolio/domain.env`, satu-satunya sumber alamat; lihat [Pindah domain](#pindah-domain)).
- Panel admin: https://hukum.tail482cb9.ts.net/admin. Akun demo tertera di halaman login, dan semua data direset tiap malam pukul 00.00 WIB.
- Situs dibuka publik lewat Tailscale Funnel, yang menangani TLS dan menyembunyikan alamat server (lihat [Di balik proxy](#di-balik-proxy-tailscale-funnel)).

## Fitur

- **Halaman publik**: beranda, profil, bidang praktik (daftar dan detail), tim (avatar ilustrasi), FAQ, kontak dengan peta ilustrasi statis (tanpa iframe pihak ketiga), pemberitahuan privasi, dan halaman 404/500 khusus. Banner demo tampil di setiap halaman, termasuk panel admin.
- **Artikel hukum**: daftar, kategori, pencarian, dan detail dengan daftar isi, catatan kaki, serta bilah progres baca. Enam artikel orisinal (KUHP Nasional, KUHAP baru, pelindungan data pribadi, perjanjian, hubungan industrial, bantuan hukum) dengan log verifikasi sumber di `database/content/verifikasi.md`.
- **Form konsultasi**: validasi di server, CSRF, honeypot + jebakan waktu, rate limit per IP, persetujuan pemberitahuan privasi, notifikasi admin lewat queue (tanpa data pribadi), dan penghapusan otomatis setelah 7 hari (`model:prune` tiap jam). Tombol WhatsApp memakai nomor placeholder yang sengaja tidak valid.
- **Panel admin (Filament)**: bidang praktik, tim, artikel bergambar (JPG/PNG/WebP ≤ 2 MB, dikonversi ke WebP dan dibersihkan dari EXIF lewat queue), kategori, FAQ, teks halaman, dan permintaan konsultasi. Akun demo hanya melihat data contoh dan kiriman dari browsernya sendiri, serta tidak bisa mengubah email/kata sandinya.
- **SEO**: meta description, canonical, Open Graph/Twitter Card, `sitemap.xml`, `robots.txt`, dan data terstruktur JSON-LD (`LegalService`, `Article`, `BreadcrumbList`, `FAQPage`).

## Animasi (putaran 2)

Semua animasi memakai CSS saja: halaman publik tetap tanpa JavaScript dan CSP-nya tanpa `unsafe-inline`. Yang dianimasikan hanya transform dan opacity, dan semuanya mati bila pengguna memilih `prefers-reduced-motion: reduce`. Kode ada di bagian akhir `resources/css/app.css`.

| Animasi | Teknik |
|---|---|
| Hero: label, judul, dan subjudul muncul bertahap; garis tinta tergambar; baris memo "tertulis", centang muncul, lalu segel distempel | `@keyframes` dengan jeda bertahap (`.hero-reveal`, `.memo-*`) |
| Kartu bidang praktik, tim, artikel, langkah kerja, dan nilai muncul saat di-scroll | Scroll-driven animation `animation-timeline: view()` di dalam `@supports` (progressive enhancement) |
| Kartu terangkat saat hover/fokus | `transform` + bayangan di pseudo-elemen yang dianimasikan lewat opacity (`.lift`) |
| Transisi antarhalaman | Cross-document View Transitions (`@view-transition { navigation: auto; }`); header dan banner tetap di tempat |
| FAQ membuka halus | Animasi masuk pada isi `<details>` yang terbuka |
| Bilah progres baca di halaman artikel | `view-timeline` pada isi artikel + `timeline-scope` |

Rekaman WebM dan screenshotnya ada di `docs/animasi/` (dibuat dengan `REKAM=1 npx playwright test tests/e2e/rekam-animasi.spec.ts`).

## Stack

Laravel 13 · Blade · Tailwind CSS 4 · Filament 5 (Livewire 4) · SQLite · PHPUnit · Playwright · php8.3-fpm + Caddy · systemd.

## Menjalankan secara lokal

```bash
composer install
npm install && npm run build
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve --port=8002
```

Masuk ke `/admin` dengan akun demo `demo@nalarsaksama.example` / `coba-demo-saksama`. Akun admin asli dibuat dengan `php artisan app:create-admin <email>`.

## Test

```bash
php artisan test          # PHPUnit: halaman publik, form, akses admin, upload, reset demo, retensi 7 hari, kesiapan domain
npx playwright test       # e2e (kirim form, login admin demo), animasi + reduced motion, responsif & screenshot 360–1440 px
```

Playwright menjalankan `scripts/e2e-server.sh` (database terpisah `database/e2e.sqlite`, port 8002). Untuk menguji situs yang sudah dideploy: `E2E_BASE_URL=$(grep ^HUKUM_URL= /root/tenma-ws/portofolio/domain.env | cut -d= -f2-) npx playwright test`. Screenshot tersimpan di `docs/screenshots/`, laporan Lighthouse (`scripts/lighthouse.sh`) di `docs/lighthouse/`.

## Deploy

`deploy/deploy.sh` (sebagai root) membangun aset, menyinkronkan kode ke `/srv/web/company-profile-hukum`, memasang dependensi tanpa dev, menjalankan migrasi, lalu meng-cache config/route/view. Jalankan sekali dengan `--install` untuk membuat `.env` produksi, database di `/var/lib/company-profile-hukum`, data demo, dan akun admin asli (kredensial di `/root/tenma-ws/portofolio/rahasia/company-profile-hukum.txt`). Setiap deploy juga memasang pool PHP-FPM, unit systemd, dan situs Caddy dari folder `deploy/`.

| Komponen | Berkas |
|---|---|
| Situs Caddy (template `http://<host>` untuk mode tunnel; php_fastcgi, `import gerbang_staging`, header keamanan, CSP) | `deploy/company-profile-hukum.caddy.tmpl` |
| Pool PHP-FPM khusus (`open_basedir`) | `deploy/php-fpm-pool.conf` |
| Worker queue | `deploy/systemd/company-profile-hukum-queue.service` |
| Scheduler tiap menit | `deploy/systemd/company-profile-hukum-scheduler.{service,timer}` |
| Reset data demo 00.00 WIB | `deploy/systemd/company-profile-hukum-demo-reset.{service,timer}` |

## Di balik proxy (Tailscale Funnel)

Alur permintaan: pengunjung → Tailscale Funnel (HTTPS) → Caddy di `http://127.0.0.1:80` (mode tunnel, dikelola agen utama) → php8.3-fpm. PHP menerima `REMOTE_ADDR` 127.0.0.1 plus `X-Forwarded-For`, `X-Forwarded-Proto: https`, dan `X-Forwarded-Host`.

- `bootstrap/app.php` hanya memercayai proxy `127.0.0.1` (`trustProxies`). Dengan begitu `$request->ip()` adalah IP pengunjung asli (dipakai rate limit form dan tabel sesi), dan skema https terdeteksi: cookie `Secure`, URL absolut/canonical/Open Graph https, redirect https, tanpa mixed content. Header `X-Forwarded-*` dari alamat lain diabaikan.
- Aplikasi tidak memakai header identitas akun Tailscale (`Tailscale-User-*`); Caddy membuangnya lewat snippet `gerbang_staging`.
- Bukti otomatis ada di `tests/Feature/BehindProxyTest.php`. Uji manual rate limit per pengunjung dari server (data sengaja tidak valid supaya tidak ada yang tersimpan): ambil cookie sesi dan `_token` dari `GET http://127.0.0.1:80/kontak` dengan header `Host: hukum.tail482cb9.ts.net`, lalu kirim `POST /kontak` dengan `X-Forwarded-For` berbeda. Satu pengunjung mendapat `X-RateLimit-Remaining` 4 → 0 lalu `Retry-After` pada kiriman ke-6, sedangkan pengunjung lain tetap punya kuota sendiri.

## Pindah domain

Semua alamat dibaca dari `/root/tenma-ws/portofolio/domain.env`: `HUKUM_URL` untuk situs ini dan `PORTOFOLIO_URL` untuk tautan ke portofolio pembuat. Tidak ada alamat yang ditulis langsung di kode, konten, konfigurasi, atau berkas deploy (dijaga oleh `tests/Feature/DomainReadinessTest.php`). Pola IP server dibaca test itu dari `~/.config/git/denylist-publik` saat runtime, sama dengan hook git, jadi IP maupun polanya tidak pernah ditulis di repo.

1. Ubah `HUKUM_URL` (dan bila perlu `PORTOFOLIO_URL`) di `domain.env`, misalnya `HUKUM_URL=https://hukum.contoh.id`. Pastikan DNS domain itu sudah mengarah ke server.
2. Jalankan `deploy/deploy.sh` sebagai root. Skrip menulis `APP_URL` dan `PORTFOLIO_URL` ke `.env` produksi, membuat ulang cache, lalu membuat `/etc/caddy/sites/company-profile-hukum.caddy` dari template dengan host yang baru.
3. Skrip memvalidasi konfigurasi lalu me-reload Caddy. Kalau perlu me-reload manual: `caddy validate --config /etc/caddy/Caddyfile && systemctl reload caddy`.
4. Dalam mode tunnel, TLS ditangani Tailscale Funnel; arahkan Funnel atau domain baru ke `http://127.0.0.1:80` (diatur agen utama).

## Struktur penting

- `app/Http/Controllers/`: halaman publik, form konsultasi, sitemap/robots.
- `app/Filament/`: resource admin, tema, avatar lokal, pembatasan akun demo.
- `app/Console/Commands/`: `demo:reset`, `app:create-admin`.
- `database/content/`: artikel dan teks halaman (Markdown) + sampul, dimuat `DemoContentSeeder`.
- `resources/views/`: Blade (komponen ikon `<x-ikon>`, avatar ilustrasi, peta ilustrasi).

Aset dan lisensinya tercantum di [CREDITS.md](CREDITS.md).

## Status

Putaran 1 (2 Oktober 2026), putaran 2, dan putaran 4 (3 Oktober 2026) selesai. Hasil uji terakhir terhadap https://hukum.tail482cb9.ts.net: PHPUnit 63 test lulus, Playwright 13 test lulus, Lighthouse mobile beranda dan artikel 100/100/100/100 dengan CLS 0 (laporan di `docs/lighthouse/`).

Catatan pemeliharaan konten: artikel dan bidang ketenagakerjaan perlu ditinjau ulang setelah UU ketenagakerjaan baru diundangkan (RUU-nya dijadwalkan disahkan DPR awal Oktober 2026), begitu pula bagian pelindungan data pribadi saat PP 33/2026 mulai berlaku pada 16 Januari 2027.
