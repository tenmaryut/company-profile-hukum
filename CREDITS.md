# Kredit dan lisensi aset

Semua gambar di situs ini dibuat sendiri (SVG/CSS atau dihasilkan skrip) atau memakai aset berlisensi terbuka di bawah. Tidak ada foto orang sungguhan.

| Aset | Sumber | Lisensi | Catatan |
|---|---|---|---|
| Font Newsreader (600, 500 italic, subset latin) | [Production Type / Newsreader](https://github.com/productiontype/Newsreader), lewat paket npm `@fontsource/newsreader` | SIL Open Font License 1.1 (`resources/fonts/OFL-Newsreader.txt`) | Di-host sendiri di `resources/fonts/` |
| Ikon garis (timbangan, palu, dokumen, gembok, dll.) | [Lucide](https://lucide.dev) (`lucide-static` 1.50) | ISC | Path SVG disalin ke `resources/views/components/ikon.blade.php` dan `scripts/generate-images.mjs` |
| Logo firma fiktif, ilustrasi beranda, peta ilustrasi, avatar tim (8 varian) | Buatan sendiri (SVG) | Bagian dari proyek ini | `resources/views/components/` |
| Sampul artikel | Buatan sendiri: `scripts/generate-images.mjs` (SVG → WebP lewat sharp) memakai ikon Lucide | Bagian dari proyek ini + ISC (ikon) | `database/content/covers/` |
| Favicon, ikon apple-touch, logo PNG | Buatan sendiri: `scripts/generate-images.mjs` | Bagian dari proyek ini | `public/` |
| Gambar Open Graph default | Buatan sendiri: `scripts/og-image.mjs` (Chromium Playwright, font Newsreader) | Bagian dari proyek ini + OFL (font) | `public/images/og-default.png` |
| Font panel admin (Inter) | Bawaan Filament, di-host lokal | SIL Open Font License 1.1 | `public/fonts/filament/` |

Teks artikel ditulis untuk situs ini dengan rujukan ke sumber resmi; log verifikasinya ada di `database/content/verifikasi.md`.
