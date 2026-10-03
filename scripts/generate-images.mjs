// Membuat aset gambar buatan sendiri (lihat CREDITS.md):
// - public/favicon.svg, public/favicon.ico, public/apple-touch-icon.png, public/images/logo-512.png
// - database/content/covers/<slug>.webp untuk tiap artikel di database/content/articles/*.md
// Jalankan: node scripts/generate-images.mjs   (butuh sharp; NODE_PATH global atau npm i -D sharp)
import { mkdirSync, readdirSync, readFileSync, writeFileSync } from 'node:fs';
import { createRequire } from 'node:module';
import path from 'node:path';

const require = createRequire(import.meta.url);
const sharp = require('sharp');
const root = path.resolve(path.dirname(new URL(import.meta.url).pathname), '..');

const PINE = '#1d4d45';
const BRASS = '#b8862f';
const PAPER = '#f7f3ea';

const logoMark = (size = 48) => `<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 48 48">
  <circle cx="24" cy="24" r="23" fill="${PINE}"/>
  <circle cx="24" cy="24" r="19.5" fill="none" stroke="${BRASS}" stroke-width="1"/>
  <g fill="none" stroke="${PAPER}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
    <path d="M24 14v19M18.5 33.5h11M13.5 17.5h21M13.5 17.5 10 26M13.5 17.5 17 26M34.5 17.5 31 26M34.5 17.5 38 26"/>
    <path d="M9 26h9a4.5 4.5 0 0 1-9 0zM30 26h9a4.5 4.5 0 0 1-9 0z"/>
  </g>
  <circle cx="24" cy="13.5" r="1.7" fill="${BRASS}"/>
</svg>`;

// Ikon garis Lucide (ISC) untuk motif sampul.
const MOTIFS = {
    timbangan: '<path d="M12 3v18"/><path d="m19 8 3 8a5 5 0 0 1-6 0zV7"/><path d="M3 7h1a17 17 0 0 0 8-2 17 17 0 0 0 8 2h1"/><path d="m5 8 3 8a5 5 0 0 1-6 0zV7"/><path d="M7 21h10"/>',
    palu: '<path d="m14 13-8.381 8.38a1 1 0 0 1-3.001-3l8.384-8.381"/><path d="m16 16 6-6"/><path d="m21.5 10.5-8-8"/><path d="m8 8 6-6"/><path d="m8.5 7.5 8 8"/>',
    dokumen: '<path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
    gembok: '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
    tangan: '<path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.88.88a1 1 0 1 1-3-3l2.81-2.81a5.79 5.79 0 0 1 7.06-.87l.47.28a2 2 0 0 0 1.42.25L21 4"/><path d="m21 3 1 11h-2"/><path d="M3 3 2 14l6.5 6.5a1 1 0 1 0 3-3"/><path d="M3 4h8"/>',
    perisai: '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
    buku: '<path d="M12 5v16"/><path d="M16 13h2"/><path d="M16 9h2"/><path d="M20.001 19A2 2 0 0022 17V5a2 2 0 00-1.999-2L16 3.002A5 5 0 0012 5a5 5 0 00-4-2H4a2 2 0 00-2 2v12a2 2 0 001.999 2H8a5 5 0 014 2 5 5 0 014-2z"/><path d="M6 13h2"/><path d="M6 9h2"/>',
    gedung: '<path d="M10 18v-7"/><path d="M11.119 2.205a2 2 0 0 1 1.762 0l7.84 3.846A.5.5 0 0 1 20.5 7h-17a.5.5 0 0 1-.22-.949z"/><path d="M14 18v-7"/><path d="M18 18v-7"/><path d="M3 22h18"/><path d="M6 18v-7"/>',
};

const PALETTES = [
    { bg: PINE, circle: '#2a6158', icon: '#f1d687', card: '#f7f3ea', line: '#c6b89c', accent: '#b8862f', grid: '#ffffff' },
    { bg: '#efe8d8', circle: '#ecd9ae', icon: PINE, card: '#fffdf8', line: '#dacfba', accent: '#b8862f', grid: '#17202b' },
    { bg: '#17202b', circle: '#26323f', icon: '#ecd9ae', card: '#efe8d8', line: '#c6b89c', accent: '#d9a648', grid: '#ffffff' },
    { bg: '#d9e9e3', circle: '#b4d2c7', icon: '#163c36', card: '#fffdf8', line: '#b4d2c7', accent: '#7a5518', grid: '#163c36' },
];

function coverSvg(motif, index) {
    const p = PALETTES[index % PALETTES.length];
    const icon = MOTIFS[motif] ?? MOTIFS.timbangan;
    const gridLines = Array.from({ length: 13 }, (_, i) => `<path d="M0 ${48 * (i + 1)}H1200"/>`).join('');
    const cardLines = [0, 1, 2, 3, 4, 5]
        .map((i) => `<rect x="${720 + (i % 2 ? 0 : 0)}" y="${248 + i * 34}" width="${[300, 260, 320, 210, 290, 180][i]}" height="12" rx="6" fill="${p.line}"/>`)
        .join('');

    return `<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="630" viewBox="0 0 1200 630">
  <rect width="1200" height="630" fill="${p.bg}"/>
  <g stroke="${p.grid}" stroke-opacity=".06" stroke-width="1">${gridLines}</g>
  <circle cx="330" cy="330" r="232" fill="${p.circle}"/>
  <circle cx="330" cy="330" r="268" fill="none" stroke="${p.accent}" stroke-opacity=".55" stroke-width="2" stroke-dasharray="3 9"/>
  <g transform="translate(186 186) scale(12)" fill="none" stroke="${p.icon}" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round">${icon}</g>
  <g transform="rotate(-5 860 330)">
    <rect x="680" y="150" width="400" height="360" rx="18" fill="${p.card}" opacity=".55"/>
  </g>
  <rect x="690" y="140" width="400" height="360" rx="18" fill="${p.card}"/>
  <rect x="720" y="176" width="190" height="20" rx="6" fill="${p.accent}"/>
  ${cardLines}
  <circle cx="1030" cy="452" r="34" fill="none" stroke="${p.accent}" stroke-width="3"/>
  <circle cx="1030" cy="452" r="25" fill="none" stroke="${p.accent}" stroke-width="1.5" stroke-dasharray="2 4"/>
</svg>`;
}

function icoFromPng(png, size) {
    // ICO dengan satu gambar PNG (didukung semua peramban modern).
    const header = Buffer.alloc(6);
    header.writeUInt16LE(0, 0);
    header.writeUInt16LE(1, 2);
    header.writeUInt16LE(1, 4);
    const entry = Buffer.alloc(16);
    entry.writeUInt8(size >= 256 ? 0 : size, 0);
    entry.writeUInt8(size >= 256 ? 0 : size, 1);
    entry.writeUInt8(0, 2);
    entry.writeUInt8(0, 3);
    entry.writeUInt16LE(1, 4);
    entry.writeUInt16LE(32, 6);
    entry.writeUInt32LE(png.length, 8);
    entry.writeUInt32LE(6 + 16, 12);
    return Buffer.concat([header, entry, png]);
}

async function main() {
    mkdirSync(path.join(root, 'public/images'), { recursive: true });

    writeFileSync(path.join(root, 'public/favicon.svg'), logoMark(48));

    const favPng = await sharp(Buffer.from(logoMark(32))).resize(32, 32).png().toBuffer();
    writeFileSync(path.join(root, 'public/favicon.ico'), icoFromPng(favPng, 32));

    const padded = (size, pad) =>
        sharp({ create: { width: size, height: size, channels: 4, background: PAPER } })
            .composite([{ input: Buffer.from(logoMark(size - pad * 2)), top: pad, left: pad }])
            .png({ compressionLevel: 9 });

    await padded(180, 18).toFile(path.join(root, 'public/apple-touch-icon.png'));
    await padded(512, 48).toFile(path.join(root, 'public/images/logo-512.png'));

    const articlesDir = path.join(root, 'database/content/articles');
    const coversDir = path.join(root, 'database/content/covers');
    mkdirSync(coversDir, { recursive: true });

    let files = [];
    try {
        files = readdirSync(articlesDir).filter((f) => f.endsWith('.md')).sort();
    } catch {
        console.log('Belum ada artikel di database/content/articles; sampul dilewati.');
    }

    for (const [index, file] of files.entries()) {
        const text = readFileSync(path.join(articlesDir, file), 'utf8');
        const meta = Object.fromEntries(
            (text.match(/^---\n([\s\S]*?)\n---/)?.[1] ?? '')
                .split('\n')
                .map((line) => line.match(/^([a-z_]+):\s*(.*)$/))
                .filter(Boolean)
                .map((m) => [m[1], m[2].trim()]),
        );
        const out = path.join(coversDir, `${meta.slug}.webp`);
        await sharp(Buffer.from(coverSvg(meta.cover_motif, index))).webp({ quality: 82 }).toFile(out);
        console.log(`sampul: ${path.relative(root, out)} (${meta.cover_motif})`);
    }

    console.log('selesai');
}

main().catch((error) => {
    console.error(error);
    process.exit(1);
});
