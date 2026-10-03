import { expect, test, type Page } from '@playwright/test';

// Mengumpulkan nama animasi CSS yang aktif di halaman (termasuk scroll-driven dan view transition).
const activeAnimations = (page: Page) =>
    page.evaluate(() => document.getAnimations().map((a) => (a as CSSAnimation).animationName ?? a.constructor.name));

// Mencatat apakah halaman baru dibuka dengan cross-document view transition (event pagereveal).
async function trackViewTransitions(page: Page): Promise<void> {
    await page.addInitScript(() => {
        window.addEventListener('pagereveal', (event) => {
            (window as unknown as { __vt: boolean }).__vt = Boolean((event as Event & { viewTransition: unknown }).viewTransition);
        });
    });
}

test.describe('animasi aktif (tanpa preferensi gerak)', () => {
    test.use({ reducedMotion: 'no-preference' });

    test('hero, kartu, FAQ, progres baca, dan transisi halaman beranimasi', async ({ page }) => {
        await trackViewTransitions(page);
        await page.goto('/');

        const names = await activeAnimations(page);
        expect(names).toEqual(expect.arrayContaining(['ns-rise', 'ns-draw', 'ns-stamp', 'ns-reveal']));
        await expect(page.locator('h1')).toHaveCSS('animation-name', 'ns-rise');

        // Kartu di bawah lipatan masih tersembunyi, lalu muncul saat di-scroll.
        const lastCard = page.locator('.reveal').last();
        expect(Number(await lastCard.evaluate((el) => getComputedStyle(el).opacity))).toBeLessThan(0.5);
        await lastCard.evaluate((el) => el.scrollIntoView({ block: 'center' }));
        await expect
            .poll(async () => Number(await lastCard.evaluate((el) => getComputedStyle(el).opacity)), { timeout: 10_000 })
            .toBeGreaterThan(0.95);

        // Kartu terangkat saat hover.
        const card = page.locator('.lift').first();
        await card.scrollIntoViewIfNeeded();
        await card.hover();
        await expect.poll(() => card.evaluate((el) => getComputedStyle(el).transform)).not.toBe('none');

        // Transisi antarhalaman memakai cross-document View Transitions.
        await page.getByRole('navigation', { name: 'Navigasi utama' }).getByRole('link', { name: 'FAQ' }).click();
        await page.waitForURL('**/faq');
        expect(await page.evaluate(() => (window as unknown as { __vt?: boolean }).__vt)).toBe(true);

        // FAQ membuka dengan animasi.
        const second = page.locator('details.faq-item').nth(1);
        await second.locator('summary').click();
        await expect(second.locator('summary + *')).toHaveCSS('animation-name', 'ns-rise');

        // Bilah progres baca artikel bergerak mengikuti scroll.
        await page.goto('/artikel/kuhp-nasional-pokok-perubahan');
        const bar = page.locator('.read-progress');
        await expect(bar).toHaveCSS('display', 'block');
        await expect(bar).toHaveCSS('animation-name', 'ns-progress');
        const scaleAt = () => bar.evaluate((el) => new DOMMatrix(getComputedStyle(el).transform).a);
        const before = await scaleAt();
        await page.evaluate(() => {
            const body = document.querySelector<HTMLElement>('.article-body')!;
            window.scrollTo(0, body.getBoundingClientRect().top + window.scrollY + body.offsetHeight / 2);
        });
        await expect.poll(scaleAt, { timeout: 10_000 }).toBeGreaterThan(before + 0.1);
    });
});

test.describe('prefers-reduced-motion: reduce', () => {
    test.use({ reducedMotion: 'reduce' });

    for (const path of ['/', '/bidang-praktik', '/tim', '/artikel', '/faq', '/artikel/kuhp-nasional-pokok-perubahan']) {
        test(`tidak ada animasi di ${path}`, async ({ page }) => {
            await page.goto(path);
            expect(await activeAnimations(page)).toEqual([]);

            await page.mouse.wheel(0, 1500);
            await page.waitForTimeout(150);
            expect(await activeAnimations(page)).toEqual([]);

            // Semua konten langsung terlihat penuh, tidak menunggu animasi.
            const hidden = await page.evaluate(() =>
                [...document.querySelectorAll('.reveal, .hero-reveal > *, .memo-sheet')].filter((el) => getComputedStyle(el).opacity !== '1').length,
            );
            expect(hidden).toBe(0);
            await expect(page.locator('.read-progress')).toBeHidden();
        });
    }

    test('hover, FAQ, dan pindah halaman tanpa gerak', async ({ page }) => {
        await trackViewTransitions(page);
        await page.goto('/');

        const card = page.locator('.lift').first();
        await card.hover();
        expect(await card.evaluate((el) => getComputedStyle(el).transform)).toBe('none');

        await page.getByRole('navigation', { name: 'Navigasi utama' }).getByRole('link', { name: 'FAQ' }).click();
        await page.waitForURL('**/faq');
        expect(await page.evaluate(() => (window as unknown as { __vt?: boolean }).__vt)).toBe(false);

        const second = page.locator('details.faq-item').nth(1);
        await second.locator('summary').click();
        await expect(second.locator('summary + *')).toHaveCSS('animation-name', 'none');
        expect(await activeAnimations(page)).toEqual([]);
    });
});
