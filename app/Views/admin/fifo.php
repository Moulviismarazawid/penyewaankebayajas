<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center gap-3 mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-ordered text-gold">
        <line x1="10" x2="21" y1="6" y2="6"/><line x1="10" x2="21" y1="12" y2="12"/><line x1="10" x2="21" y1="18" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/>
    </svg>
    <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Antrean FIFO</h1>
</div>
<p class="text-neutral-600 dark:text-neutral-300 mb-6">Konfirmasi pesanan berdasarkan urutan `queued_at` paling awal.</p>

<div class="overflow-x-auto rounded-2xl shadow-xl border border-gold/20">
    <table class="min-w-full text-sm">
        <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
            <tr>
                <th class="p-4 text-left font-semibold">Kode</th>
                <th class="p-4 text-left font-semibold">Waktu Antrean</th>
                <th class="p-4 text-center font-semibold">Status</th>
                <th class="p-4 text-center font-semibold w-24">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if(empty($queue)): ?>
            <tr class="border-t border-gold/20">
                <td colspan="4" class="p-4 text-center text-neutral-600 dark:text-neutral-300">
                    Tidak ada pesanan dalam antrean.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach($queue as $r): ?>
                <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                    <td class="p-4 font-medium text-neutral-900 dark:text-white"><?= esc($r['code']) ?></td>
                    <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['queued_at']) ?></td>
                    <td class="p-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            <?= esc(ucfirst($r['status'])) ?>
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <form method="post" action="/admin/rentals/confirm/<?= $r['id'] ?>" onsubmit="return confirm('Konfirmasi pesanan ini?')">
                            <?= csrf_field() ?>
                            <button class="bg-gold text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">
                                Konfirmasi
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>