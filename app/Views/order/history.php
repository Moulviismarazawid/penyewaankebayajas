<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<div class="flex items-center gap-3 mb-6">
    <i data-lucide="receipt-text" class="text-gold w-8 h-8"></i>
    <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Riwayat Sewa</h1>
</div>

<?php if(empty($rows)): ?>
    <div class="text-center p-12 bg-white dark:bg-neutral-800 rounded-3xl shadow-xl border border-gold/20">
        <p class="text-xl font-medium text-neutral-600 dark:text-neutral-300">Belum ada transaksi sewa.</p>
        <p class="mt-2 text-neutral-500 dark:text-neutral-400">Ayo, mulai pengalaman sewa pertamamu dari <a href="/produk" class="text-gold font-semibold hover:underline">katalog produk</a>.</p>
    </div>
<?php else: ?>
    <div class="overflow-x-auto rounded-xl shadow-xl border border-gold/20">
        <table class="min-w-full text-sm">
            <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
                <tr>
                    <th class="p-4 text-left">Kode</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Mulai</th>
                    <th class="p-4 text-left">Selesai</th>
                    <th class="p-4 text-left">Jatuh Tempo</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($rows as $r): ?>
                    <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                        <td class="p-4 font-bold text-neutral-900 dark:text-white"><?= esc($r['code']) ?></td>
                        <td class="p-4">
                            <?php if($r['status']=='pending'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                            <?php elseif($r['status']=='aktif'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                            <?php elseif($r['status']=='batal'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Batal</span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['start_date'] ?: '-') ?></td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['end_date'] ?: '-') ?></td>
                        <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['due_date'] ?: '-') ?></td>
                        <td class="p-4">
                            <a class="inline-flex items-center gap-1 text-gold font-medium hover:underline transition-colors duration-200" href="/order/wa/<?= esc($r['code']) ?>">
                                <i data-lucide="message-circle" class="w-4 h-4"></i> Konfirmasi via WA
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>