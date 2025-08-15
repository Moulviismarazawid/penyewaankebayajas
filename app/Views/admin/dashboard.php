<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center gap-3 mb-8">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard text-gold">
        <rect width="7" height="9" x="3" y="3" rx="1"/>
        <rect width="7" height="5" x="14" y="3" rx="1"/>
        <rect width="7" height="9" x="14" y="12" rx="1"/>
        <rect width="7" height="5" x="3" y="16" rx="1"/>
    </svg>
    <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Dashboard Admin</h1>
</div>

<section class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-lg transition-transform duration-200 hover:scale-[1.03]">
        <div class="flex items-center gap-4 mb-2">
            <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-800/30 text-yellow-600 dark:text-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-timer">
                    <circle cx="12" cy="12" r="10"/><path d="M12 10v6"/><path d="M12 10l3-3"/>
                </svg>
            </div>
            <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Transaksi Pending</div>
        </div>
        <div class="text-4xl font-extrabold text-neutral-900 dark:text-white mt-4">
            <?= (int)($stat['pending'] ?? 0) ?>
        </div>
    </div>
    
    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-lg transition-transform duration-200 hover:scale-[1.03]">
        <div class="flex items-center gap-4 mb-2">
            <div class="p-3 rounded-full bg-green-100 dark:bg-green-800/30 text-green-600 dark:text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-8.67"/><path d="m9 11 3 3L22 4"/>
                </svg>
            </div>
            <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Transaksi Aktif</div>
        </div>
        <div class="text-4xl font-extrabold text-neutral-900 dark:text-white mt-4">
            <?= (int)($stat['aktif'] ?? 0) ?>
        </div>
    </div>

    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-lg transition-transform duration-200 hover:scale-[1.03]">
        <div class="flex items-center gap-4 mb-2">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-800/30 text-blue-600 dark:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-archive">
                    <rect width="20" height="5" x="2" y="3" rx="1"/><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"/><path d="M10 12h4"/>
                </svg>
            </div>
            <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Transaksi Selesai</div>
        </div>
        <div class="text-4xl font-extrabold text-neutral-900 dark:text-white mt-4">
            <?= (int)($stat['selesai'] ?? 0) ?>
        </div>
    </div>

    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-lg transition-transform duration-200 hover:scale-[1.03]">
        <div class="flex items-center gap-4 mb-2">
            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-800/30 text-purple-600 dark:text-purple-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-box">
                    <path d="M21 8a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2z"/>
                    <path d="M7 16V8"/>
                    <path d="M12 16V8"/>
                    <path d="M17 16V8"/>
                    <line x1="3" x2="21" y1="12" y2="12"/>
                </svg>
            </div>
            <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-300">Total Produk</div>
        </div>
        <div class="text-4xl font-extrabold text-neutral-900 dark:text-white mt-4">
            <?= (int)($stat['produk'] ?? 0) ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>