import { expect, test, type Page } from '@playwright/test';
import { mkdirSync } from 'node:fs';
import { loginAsDemo } from './helpers';

// Lebar layar yang diuji: ponsel kecil, tablet, laptop, desktop.
const WIDTHS = [360, 768, 1024, 1440];
const OUT = 'docs/screenshots';

async function noHorizontalOverflow(page: Page): Promise<void> {
    const overflow = await page.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
    expect(overflow, 'halaman tidak boleh bergeser horizontal').toBeLessThanOrEqual(0);
}

async function shoot(page: Page, name: string, width: number): Promise<void> {
    // Screenshot full-page tidak menggulir halaman, jadi muat dulu gambar lazy-load.
    await page.evaluate(async () => {
        const images = [...document.querySelectorAll<HTMLImageElement>('img[loading="lazy"]')];
        images.forEach((img) => (img.loading = 'eager'));
        await Promise.all(images.map((img) => (img.complete ? null : new Promise((done) => img.addEventListener('load', done, { once: true })))));
    });
    await page.screenshot({ path: `${OUT}/${name}-${width}.jpg`, fullPage: true, type: 'jpeg', quality: 60 });
}

// Screenshot memakai reduced motion: kartu yang muncul saat di-scroll (scroll-driven animation)
// langsung tampil, karena screenshot full-page tidak menggulir halaman.
test.use({ reducedMotion: 'reduce' });

test.beforeAll(() => {
    mkdirSync(OUT, { recursive: true });
});

test('halaman publik responsif 360–1440 px', async ({ page, request }) => {
    // Puluhan halaman di 4 lebar layar dalam satu test: di CPU VPS yang lambat butuh lebih dari 60 detik.
    test.slow();
    const sitemap = await (await request.get('/sitemap.xml')).text();
    const urls = [...sitemap.matchAll(/<loc>([^<]+)<\/loc>/g)].map((m) => new URL(m[1]).pathname);
    const firstArea = urls.find((u) => u.startsWith('/bidang-praktik/'));
    const firstArticle = urls.find((u) => u.startsWith('/artikel/') && !u.startsWith('/artikel/kategori/'));

    const pages: [string, string][] = [
        ['beranda', '/'],
        ['profil', '/profil'],
        ['bidang-praktik', '/bidang-praktik'],
        ['bidang-praktik-detail', firstArea!],
        ['tim', '/tim'],
        ['artikel', '/artikel'],
        ['artikel-detail', firstArticle!],
        ['artikel-pencarian', '/artikel?q=perjanjian'],
        ['faq', '/faq'],
        ['kontak', '/kontak'],
        ['privasi', '/privasi'],
        ['404', '/halaman-yang-tidak-ada'],
    ];

    for (const width of WIDTHS) {
        await page.setViewportSize({ width, height: 900 });

        for (const [name, path] of pages) {
            await page.goto(path);
            await expect(page.getByRole('note', { name: 'Pemberitahuan situs demo' })).toBeVisible();
            await noHorizontalOverflow(page);
            await shoot(page, name, width);
        }
    }

    // Menu seluler (tanpa JavaScript) bisa dibuka di layar kecil.
    await page.setViewportSize({ width: 360, height: 900 });
    await page.goto('/');
    await page.getByText('Menu', { exact: true }).click();
    await expect(page.getByRole('navigation', { name: 'Navigasi seluler' })).toBeVisible();
    await shoot(page, 'menu-seluler', 360);
});

test('panel admin responsif 360–1440 px', async ({ page }) => {
    test.slow();
    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto('/admin/login');
    await shoot(page, 'admin-login', 1440);
    await page.setViewportSize({ width: 360, height: 900 });
    await page.goto('/admin/login');
    await noHorizontalOverflow(page);
    await shoot(page, 'admin-login', 360);

    await loginAsDemo(page);

    await page.goto('/admin/artikel');
    const editHref = await page.locator('a[href*="/admin/artikel/"][href$="/edit"]').first().getAttribute('href');
    await page.goto('/admin/permintaan-konsultasi');
    const viewHref = await page.locator('a[href*="/admin/permintaan-konsultasi/"]').first().getAttribute('href');

    const pages: [string, string][] = [
        ['admin-dasbor', '/admin'],
        ['admin-bidang-praktik', '/admin/bidang-praktik'],
        ['admin-tim', '/admin/tim'],
        ['admin-artikel', '/admin/artikel'],
        ['admin-artikel-edit', new URL(editHref!, 'http://x').pathname],
        ['admin-faq', '/admin/faq'],
        ['admin-teks-halaman', '/admin/teks-halaman'],
        ['admin-konsultasi', '/admin/permintaan-konsultasi'],
        ['admin-konsultasi-detail', new URL(viewHref!, 'http://x').pathname],
    ];

    for (const width of WIDTHS) {
        await page.setViewportSize({ width, height: 900 });

        for (const [name, path] of pages) {
            await page.goto(path);
            await page.waitForLoadState('networkidle');
            await noHorizontalOverflow(page);
            await shoot(page, name, width);
        }
    }
});
