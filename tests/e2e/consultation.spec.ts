import { expect, test } from '@playwright/test';
import { loginAsDemo } from './helpers';

test('pengunjung mengirim form konsultasi lalu melihatnya di panel admin demo', async ({ page }) => {
    const name = `Pengunjung E2E ${Date.now()}`;

    await page.goto('/kontak');
    await expect(page.getByRole('note', { name: 'Pemberitahuan situs demo' })).toBeVisible();

    await page.getByLabel('Nama').fill(name);
    await page.getByLabel('Email').fill('e2e@contoh.example');
    await page.getByLabel('Nomor telepon').fill('+62 812 0000 0000');
    await page.getByLabel('Bidang hukum').selectOption({ index: 1 });
    await page.getByLabel(/Uraian singkat/).fill('Ini kiriman uji otomatis dari Playwright untuk memastikan form berjalan.');
    await page.getByLabel(/Saya telah membaca/).check();

    // Jebakan waktu anti-spam menolak kiriman yang diisi kurang dari 3 detik.
    await page.waitForTimeout(3_200);
    await page.getByRole('button', { name: 'Kirim permintaan' }).click();

    await expect(page.getByRole('status')).toContainText('Permintaan konsultasi terkirim');

    await loginAsDemo(page);
    await page.goto('/admin/permintaan-konsultasi');
    await expect(page.getByText(name)).toBeVisible();
    await expect(page.getByText('Contoh: Andi Pratama')).toBeVisible();
});

test('form menolak kiriman tidak lengkap dengan pesan berbahasa Indonesia', async ({ page }) => {
    await page.goto('/kontak');
    await page.waitForTimeout(3_200);
    await page.getByRole('button', { name: 'Kirim permintaan' }).click();

    const alert = page.getByRole('alert');
    await expect(alert).toContainText('Periksa kembali isian berikut');
    await expect(alert).toContainText('Nama wajib diisi');
    await expect(page.getByLabel('Nama')).toHaveAttribute('aria-invalid', 'true');
});
