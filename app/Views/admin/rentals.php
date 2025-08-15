<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div x-data="{ formOpen: false }" class="space-y-6">

    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-check text-gold">
                <path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="m9 16 2 2 4-4"/>
            </svg>
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Kelola Rental</h1>
        </div>
        
        <button @click="formOpen = !formOpen" class="bg-gold text-white font-semibold p-3 rounded-full shadow-md hover:bg-yellow-600 transition-colors">
            <svg x-show="!formOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            <svg x-show="formOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>

    <div x-show="formOpen" x-transition.duration.300ms>
        <form method="post" action="/admin/rentals/create" class="p-6 bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-gold/20">
            <?= csrf_field() ?>
            <h2 class="text-xl font-bold mb-4 text-neutral-900 dark:text-white">Buat Invoice Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                <select name="user_id" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" required>
                    <option value="">Pilih User</option>
                    <?php foreach($users as $u): ?><option value="<?= $u['id'] ?>"><?= esc($u['full_name']) ?> — <?= esc($u['email']) ?></option><?php endforeach; ?>
                </select>
                <select name="product_id" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" required>
                    <option value="">Pilih Produk</option>
                    <?php foreach($products as $p): ?><option value="<?= $p['id'] ?>"><?= esc($p['name']) ?> (Rp<?= number_format($p['price_per_day'],0,',','.') ?>/hari)</option><?php endforeach; ?>
                </select>
                <input name="qty" type="number" min="1" value="1" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors">
                <button type="submit" class="bg-gold text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">Buat Invoice</button>
            </div>
        </form>
    </div>
    <a href="/admin/rentals/new" class="inline-flex items-center px-4 py-2 rounded-xl border border-gold/40 hover:bg-gold/10">
  + Buat Order (Form Lengkap)
</a>


    <div class="overflow-x-auto rounded-2xl shadow-xl border border-gold/20">
        <table class="min-w-full text-sm">
            <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
                <tr>
                    <th class="p-4 text-left font-semibold">Kode</th>
                    <th class="p-4 text-left font-semibold">Status</th>
                    <th class="p-4 text-left font-semibold">Mulai</th>
                    <th class="p-4 text-left font-semibold">Jatuh Tempo</th>
                    <th class="p-4 text-left font-semibold">Denda</th>
                    <th class="p-4 text-center font-semibold w-72">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($rows as $r): ?>
                <?php $ft = (int)($r['fines_total'] ?? 0); ?>
                <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                    <td class="p-4 font-medium text-neutral-900 dark:text-white"><?= esc($r['code']) ?></td>
                    <td class="p-4">
                        <?php if($r['status'] == 'pending'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                        <?php elseif($r['status'] == 'aktif'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                        <?php elseif($r['status'] == 'batal'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Batal</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Selesai</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['start_date']) ?></td>
                    <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['due_date']) ?></td>
                    <td class="p-4">
                        <?php if($ft > 0): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                Rp<?= number_format($ft,0,',','.') ?>
                            </span>
                        <?php else: ?>
                            <span class="text-neutral-400">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-wrap gap-2 items-center justify-center">
                            <a href="/admin/rentals/<?= $r['id'] ?>" class="flex items-center gap-1 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white px-3 py-1 rounded-lg border border-neutral-300 dark:border-neutral-600 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                                Detail
                            </a>
                            <?php if($r['status'] == 'pending'): ?>
                                <form method="post" action="/admin/rentals/confirm/<?= $r['id'] ?>">
                                    <?= csrf_field() ?>
                                    <button class="bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 transition-colors">Konfirmasi</button>
                                </form>
                                <form method="post" action="/admin/rentals/cancel/<?= $r['id'] ?>">
                                    <?= csrf_field() ?>
                                    <button class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700 transition-colors">Batal</button>
                                </form>
                            <?php elseif($r['status'] == 'aktif'): ?>
                                <form method="post" action="/admin/rentals/finish/<?= $r['id'] ?>">
                                    <?= csrf_field() ?>
                                    <button class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition-colors">Selesai</button>
                                </form>
                                <details class="group">
                                    <summary class="cursor-pointer bg-neutral-100 dark:bg-neutral-700 px-3 py-1 rounded-lg text-neutral-600 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600 transition-colors">
                                        Tambah Denda
                                    </summary>
                                    <div class="absolute right-0 w-64 mt-2 p-3 bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gold/20 z-10">
                                        <form method="post" action="/admin/fines/add/<?= $r['id'] ?>" class="space-y-2">
                                            <?= csrf_field() ?>
                                            <input name="amount" type="number" placeholder="Jumlah denda" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold text-sm" required>
                                            <input name="note" placeholder="Catatan denda" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold text-sm">
                                            <button class="w-full bg-gold text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">Simpan Denda</button>
                                        </form>
                                    </div>
                                </details>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<?= $this->endSection() ?>