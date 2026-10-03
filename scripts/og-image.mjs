// Membuat gambar Open Graph default (1200x630) dengan Chromium Playwright,
// supaya font Newsreader (OFL) ikut dipakai. Jalankan: node scripts/og-image.mjs
import { chromium } from '@playwright/test';
import { readFileSync } from 'node:fs';
import path from 'node:path';

const root = path.resolve(path.dirname(new URL(import.meta.url).pathname), '..');
const font = (file) => readFileSync(path.join(root, 'resources/fonts', file)).toString('base64');
const logo = readFileSync(path.join(root, 'public/favicon.svg'), 'utf8');

const html = `<!doctype html><html lang="id"><head><meta charset="utf-8"><style>
@font-face{font-family:Newsreader;font-weight:600;src:url(data:font/woff2;base64,${font('newsreader-latin-600-normal.woff2')}) format('woff2')}
@font-face{font-family:Newsreader;font-style:italic;font-weight:500;src:url(data:font/woff2;base64,${font('newsreader-latin-500-italic.woff2')}) format('woff2')}
*{box-sizing:border-box;margin:0}
body{width:1200px;height:630px;background:#f7f3ea;font-family:system-ui,'DejaVu Sans',sans-serif;color:#17202b;position:relative;overflow:hidden}
.band{position:absolute;inset:0 auto 0 0;width:14px;background:#1d4d45}
.wrap{position:absolute;inset:0;padding:72px 84px 64px 96px;display:flex;flex-direction:column}
.brand{display:flex;align-items:center;gap:22px}
.brand svg{width:88px;height:88px}
.kicker{font-size:20px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:#7a5518}
.name{font-family:Newsreader,serif;font-weight:600;font-size:44px;line-height:1.05}
h1{margin-top:58px;font-family:Newsreader,serif;font-weight:600;font-size:76px;line-height:1.04;letter-spacing:-.01em;max-width:900px}
h1 em{font-weight:500;color:#1d4d45}
.note{margin-top:auto;display:inline-flex;align-self:flex-start;align-items:center;gap:14px;background:#f1d687;color:#2b2208;font-size:24px;font-weight:600;padding:14px 22px;border-radius:999px}
.seal{position:absolute;right:-90px;top:-90px;width:380px;height:380px;border-radius:50%;border:2px dashed #b8862f;opacity:.55}
.seal2{position:absolute;right:-40px;top:-40px;width:280px;height:280px;border-radius:50%;background:#ecd9ae;opacity:.6}
</style></head><body>
<div class="seal2"></div><div class="seal"></div><div class="band"></div>
<div class="wrap">
  <div class="brand">${logo}<div><div class="kicker">Kantor Hukum</div><div class="name">Nalar Saksama</div></div></div>
  <h1>Penjelasan hukum yang runtut, <em>langkah yang terukur.</em></h1>
  <div class="note">Situs demo portofolio · Firma fiktif, bukan nasihat hukum</div>
</div></body></html>`;

const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1200, height: 630 } });
await page.setContent(html, { waitUntil: 'load' });
await page.evaluate(() => document.fonts.ready);
await page.screenshot({ path: path.join(root, 'public/images/og-default.png') });
await browser.close();
console.log('public/images/og-default.png');
