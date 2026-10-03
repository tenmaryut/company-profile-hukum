import { defineConfig, devices } from '@playwright/test';

// E2E_BASE_URL bisa diarahkan ke situs produksi; tanpa itu, server lokal dijalankan otomatis.
const baseURL = process.env.E2E_BASE_URL ?? 'http://127.0.0.1:8002';

export default defineConfig({
    testDir: 'tests/e2e',
    fullyParallel: false,
    workers: 1,
    retries: 0,
    reporter: [['list']],
    timeout: 60_000,
    use: {
        baseURL,
        locale: 'id-ID',
        timezoneId: 'Asia/Jakarta',
        trace: 'retain-on-failure',
        screenshot: 'only-on-failure',
    },
    projects: [{ name: 'chromium', use: { ...devices['Desktop Chrome'] } }],
    webServer: process.env.E2E_BASE_URL
        ? undefined
        : {
              command: 'bash scripts/e2e-server.sh',
              url: `${baseURL}/up`,
              reuseExistingServer: false,
              timeout: 120_000,
              stdout: 'ignore',
              stderr: 'ignore',
          },
});
