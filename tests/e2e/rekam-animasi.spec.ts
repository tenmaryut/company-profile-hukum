import { test, type Browser, type Page } from '@playwright/test';
import { mkdirSync } from 'node:fs';

// Rekaman WebM animasi utama untuk docs/animasi/. Hanya jalan dengan REKAM=1:
//   REKAM=1 npx playwright test tests/e2e/rekam-animasi.spec.ts
const OUT = 'docs/animasi';
const SIZE = { width: 1280, height: 720 };

test.skip(!process.env.REKAM, 'Set REKAM=1 untuk membuat rekaman animasi.');
test.use({ reducedMotion: 'no-preference' });

async function record(browser: Browser, name: string, run: (page: Page) => Promise<void>, size = SIZE): Promise<void> {
    mkdirSync(OUT, { recursive: true });
    const context = await browser.newContext({
        viewport: size,
        reducedMotion: 'no-preference',
        recordVideo: { dir: 'test-results/rekaman', size },
    });
    const page = await context.newPage();
    await run(page);
    const video = page.video();
    await context.close();
    await video?.saveAs(`${OUT}/${name}.webm`);
}

async function smoothScroll(page: Page, distance: number, steps = 24): Promise<void> {
    for (let i = 0; i < steps; i++) {
        await page.mouse.wheel(0, distance / steps);
        await page.waitForTimeout(60);
    }
}

test('rekam animasi hero beranda', async ({ browser }) => {
    await record(browser, '01-hero-beranda', async (page) => {
        await page.goto('/');
        await page.waitForTimeout(400);
        await page.screenshot({ path: `${OUT}/hero-awal.png` });
        await page.waitForTimeout(2600);
        await page.screenshot({ path: `${OUT}/hero-akhir.png` });
    });
});

test('rekam kartu muncul saat scroll dan terangkat saat hover', async ({ browser }) => {
    await record(browser, '02-kartu-scroll-hover', async (page) => {
        await page.goto('/');
        await page.waitForTimeout(2200);
        await smoothScroll(page, 1100);
        await page.waitForTimeout(400);
        const cards = page.locator('#ns-bidang-praktik ~ ul .lift, ul .lift');
        await cards.nth(0).hover();
        await page.waitForTimeout(500);
        await cards.nth(1).hover();
        await page.waitForTimeout(500);
        await page.screenshot({ path: `${OUT}/kartu-hover.png` });
        await smoothScroll(page, 1600, 30);
        await page.waitForTimeout(600);
    });
});

test('rekam transisi antarhalaman', async ({ browser }) => {
    await record(browser, '03-transisi-halaman', async (page) => {
        await page.goto('/');
        await page.waitForTimeout(2200);
        const nav = page.getByRole('navigation', { name: 'Navigasi utama' });
        for (const label of ['Profil', 'Bidang Praktik', 'Artikel', 'FAQ']) {
            await nav.getByRole('link', { name: label }).click();
            await page.waitForLoadState('load');
            await page.waitForTimeout(900);
        }
    });
});

test('rekam FAQ membuka halus', async ({ browser }) => {
    await record(browser, '04-faq', async (page) => {
        await page.goto('/faq');
        await page.waitForTimeout(600);
        const items = page.locator('details.faq-item summary');
        for (const i of [1, 2, 3]) {
            await items.nth(i).click();
            await page.waitForTimeout(700);
        }
        await page.screenshot({ path: `${OUT}/faq-terbuka.png` });
        await items.nth(2).click();
        await page.waitForTimeout(500);
    });
});

test('rekam bilah progres baca artikel', async ({ browser }) => {
    await record(browser, '05-progres-baca', async (page) => {
        await page.goto('/artikel/kuhp-nasional-pokok-perubahan');
        await page.waitForTimeout(500);
        await smoothScroll(page, 2400, 40);
        await page.waitForTimeout(300);
        await page.screenshot({ path: `${OUT}/progres-baca.png` });
        await smoothScroll(page, 2200, 30);
        await page.waitForTimeout(400);
    });
});

test('rekam animasi di layar ponsel', async ({ browser }) => {
    await record(
        browser,
        '06-ponsel-360',
        async (page) => {
            await page.goto('/');
            await page.waitForTimeout(2400);
            await smoothScroll(page, 2200, 40);
            await page.waitForTimeout(400);
        },
        { width: 360, height: 740 },
    );
});
