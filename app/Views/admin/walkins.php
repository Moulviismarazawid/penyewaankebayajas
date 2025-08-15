<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center gap-3 mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus text-gold">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>
    </svg>
    <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Catatan Walk-in</h1>
</div>
<p class="text-neutral-600 dark:text-neutral-300 mb-6">Kelola catatan pelanggan yang datang langsung ke toko.</p>

<form method="post" action="/admin/walkins/store" class="p-6 bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-gold/20 mb-8">
    <?= csrf_field() ?>
    <h2 class="text-xl font-bold mb-4 text-neutral-900 dark:text-white">Tambah Pelanggan Baru</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input name="customer_name" placeholder="Nama pelanggan" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" required>
        <input name="phone" placeholder="Nomor WA (opsional)" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors">
        <input name="note" placeholder="Catatan" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors">
    </div>
    <div class="mt-6 text-right">
        <button type="submit" class="bg-gold text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">
            Catat
        </button>
    </div>
</form>

<div class="overflow-x-auto rounded-2xl shadow-xl border border-gold/20">
    <table class="min-w-full text-sm">
        <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
            <tr>
                <th class="p-4 text-left font-semibold">Nama</th>
                <th class="p-4 text-left font-semibold">Nomor WA</th>
                <th class="p-4 text-left font-semibold">Catatan</th>
                <th class="p-4 text-left font-semibold">Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($rows)): ?>
                <tr class="border-t border-gold/20">
                    <td colspan="4" class="p-4 text-center text-neutral-600 dark:text-neutral-300">
                        Tidak ada data walk-in.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach($rows as $r): ?>
                    <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                        <td class="p-4 font-medium text-neutral-900 dark:text-white"><?= esc($r['customer_name']) ?></td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['phone'] ?: '-') ?></td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['note'] ?: '-') ?></td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>