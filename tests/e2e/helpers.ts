import { expect, type Page } from '@playwright/test';

/** Masuk ke panel admin memakai akun demo yang tertera di halaman login. */
export async function loginAsDemo(page: Page): Promise<void> {
    await page.goto('/admin/login');
    const email = (await page.locator('[data-demo-email]').innerText()).trim();
    const password = (await page.locator('[data-demo-password]').innerText()).trim();

    await page.locator('input[type="email"]').fill(email);
    await page.locator('input[type="password"]').fill(password);
    await page.getByRole('button', { name: /masuk/i }).click();

    await expect(page).toHaveURL(/\/admin\/?$/);
}
