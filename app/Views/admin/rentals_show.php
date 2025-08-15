<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt text-gold">
            <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1z"/><path d="M8 7h8"/><path d="M8 12h8"/><path d="M8 17h8"/>
        </svg>
        <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Detail Pemesanan</h1>
    </div>
    <a href="/admin/rentals" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-xl">
        <div class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Kode Invoice</div>
        <div class="text-2xl font-extrabold text-neutral-900 dark:text-white"><?= esc($r['code']) ?></div>
        <div class="mt-3 text-sm font-medium">Status:
            <?php if($r['status'] == 'pending'): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
            <?php elseif($r['status'] == 'aktif'): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
            <?php elseif($r['status'] == 'batal'): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Batal</span>
            <?php else: ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Selesai</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-xl">
        <div class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Periode Sewa</div>
        <div class="text-xl font-bold text-neutral-900 dark:text-white">
            <?= esc($r['start_date'] ?: '-') ?> s/d <?= esc($r['end_date'] ?: '-') ?>
        </div>
        <div class="mt-3 text-sm font-medium">Durasi: <span class="font-semibold"><?= (int)$days ?></span> hari</div>
    </div>
    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-xl">
        <div class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Jatuh Tempo</div>
        <div class="text-2xl font-extrabold text-neutral-900 dark:text-white"><?= esc($r['due_date'] ?: '-') ?></div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-xl">
        <div class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Nama Pemesan</div>
        <div class="font-bold text-xl text-neutral-900 dark:text-white">
            <?= esc($cust['full_name'] ?? $user['full_name'] ?? '-') ?>
        </div>
        <div class="mt-3 text-sm">NIK: <span class="font-medium"><?= esc($cust['nik'] ?? '-') ?></span></div>
    </div>
    <div class="rounded-2xl border border-gold/30 bg-white dark:bg-neutral-800 p-6 shadow-xl">
        <div class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Kontak</div>
        <div class="text-sm mt-1">Email: <span class="font-medium"><?= esc($cust['email'] ?? $user['email'] ?? '-') ?></span></div>
        <div class="text-sm mt-1">WA/Telp: <span class="font-medium"><?= esc($cust['phone'] ?? $user['phone'] ?? '-') ?></span></div>
        <?php if(!empty($r['wa_payload'])): ?>
            <details class="mt-4">
                <summary class="text-gold font-medium cursor-pointer">Pesan WA</summary>
                <pre class="mt-2 text-xs bg-neutral-100 dark:bg-neutral-900 p-3 rounded-lg overflow-auto border border-neutral-300 dark:border-neutral-600"><?= esc($r['wa_payload']) ?></pre>
            </details>
        <?php endif; ?>
    </div>
</div>

<h2 class="text-xl font-bold mb-4 text-neutral-900 dark:text-white">Item Sewa</h2>
<div class="mb-8 overflow-x-auto rounded-2xl shadow-xl border border-gold/20">
    <table class="min-w-full text-sm">
        <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
            <tr>
                <th class="p-4 text-left font-semibold">Nama Barang</th>
                <th class="p-4 text-right font-semibold">Harga/Hari</th>
                <th class="p-4 text-center font-semibold">Jumlah</th>
                <th class="p-4 text-center font-semibold">Hari</th>
                <th class="p-4 text-right font-semibold">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $it): 
                $sub = (int)$it['daily_price_snapshot'] * (int)$it['qty'] * (int)$days; ?>
                <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                    <td class="p-4 text-neutral-900 dark:text-white font-medium"><?= esc($it['product_name'] ?? 'Produk #'.$it['product_id']) ?></td>
                    <td class="p-4 text-right text-neutral-600 dark:text-neutral-300">Rp<?= number_format($it['daily_price_snapshot'],0,',','.') ?></td>
                    <td class="p-4 text-center text-neutral-600 dark:text-neutral-300"><?= (int)$it['qty'] ?></td>
                    <td class="p-4 text-center text-neutral-600 dark:text-neutral-300"><?= (int)$days ?></td>
                    <td class="p-4 text-right text-neutral-900 dark:text-white font-semibold">Rp<?= number_format($sub,0,',','.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="border-t-2 border-gold/50 bg-neutral-100 dark:bg-neutral-900">
                <td colspan="4" class="p-4 text-right font-bold text-neutral-900 dark:text-white">Total Sewa</td>
                <td class="p-4 text-right font-bold text-gold">Rp<?= number_format($rentTotal,0,',','.') ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<?php if(!empty($fines)): ?>
    <h2 class="text-xl font-bold mb-4 text-neutral-900 dark:text-white">Denda</h2>
    <div class="mb-8 overflow-x-auto rounded-2xl shadow-xl border border-gold/20">
        <table class="min-w-full text-sm">
            <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
                <tr>
                    <th class="p-4 text-left font-semibold">Jenis</th>
                    <th class="p-4 text-left font-semibold">Catatan</th>
                    <th class="p-4 text-right font-semibold">Nominal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($fines as $f): ?>
                <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                    <td class="p-4 text-neutral-900 dark:text-white font-medium"><?= esc($f['type']) ?></td>
                    <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($f['note'] ?? '-') ?></td>
                    <td class="p-4 text-right text-red-600 dark:text-red-400 font-semibold">Rp<?= number_format($f['amount'],0,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-red-500/50 bg-neutral-100 dark:bg-neutral-900">
                    <td colspan="2" class="p-4 text-right font-bold text-neutral-900 dark:text-white">Total Denda</td>
                    <td class="p-4 text-right font-bold text-red-600 dark:text-red-400">Rp<?= number_format($fineTotal,0,',','.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php endif; ?>

<div class="text-right mt-8">
    <div class="inline-block p-6 rounded-2xl bg-gold/10 border border-gold shadow-xl">
        <div class="text-sm font-medium text-neutral-600 dark:text-neutral-300 mb-1">Total yang harus dibayar</div>
        <div class="text-4xl font-extrabold text-gold">Rp<?= number_format($grandTotal,0,',','.') ?></div>
    </div>
</div>

<?= $this->endSection() ?>