import { expect, test } from '@playwright/test';
import { loginAsDemo } from './helpers';

test('akun demo bisa masuk dan membuka halaman pengelolaan konten', async ({ page }) => {
    await page.goto('/admin');
    await expect(page).toHaveURL(/\/admin\/login/);
    await expect(page.locator('[data-demo-account]')).toBeVisible();

    await loginAsDemo(page);
    await expect(page.getByRole('note')).toContainText('Situs demo portofolio');
    await expect(page.getByText('Ringkasan situs')).toBeVisible();

    for (const [path, heading] of [
        ['/admin/bidang-praktik', /bidang praktik/i],
        ['/admin/tim', /tim/i],
        ['/admin/artikel', /artikel/i],
        ['/admin/faq', /faq/i],
        ['/admin/permintaan-konsultasi', /permintaan konsultasi/i],
    ] as const) {
        await page.goto(path);
        await expect(page.getByRole('heading', { level: 1 })).toContainText(heading);
    }

    // Akun demo tidak boleh membuka halaman profil (ganti email/kata sandi).
    const response = await page.goto('/admin/profile');
    expect(response?.status()).toBe(403);
});
