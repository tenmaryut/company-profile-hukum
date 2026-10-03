<div class="rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-gray-800 dark:border-amber-500/40 dark:bg-amber-500/10 dark:text-gray-100" data-demo-account>
    <p class="font-semibold">Akun demo untuk pengunjung</p>
    <dl class="mt-2 grid grid-cols-[auto_1fr] gap-x-3 gap-y-1">
        <dt class="text-gray-600 dark:text-gray-300">Email</dt>
        <dd><code data-demo-email class="select-all font-mono">{{ config('firm.demo_account.email') }}</code></dd>
        <dt class="text-gray-600 dark:text-gray-300">Kata sandi</dt>
        <dd><code data-demo-password class="select-all font-mono">{{ config('firm.demo_account.password') }}</code></dd>
    </dl>
    <p class="mt-2 text-gray-600 dark:text-gray-300">Semua data direset tiap malam. Akun demo hanya melihat contoh permintaan konsultasi dan kiriman dari browsernya sendiri.</p>
</div>
