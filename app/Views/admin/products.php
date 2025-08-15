<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div x-data="{ formOpen: false }" class="space-y-6">

    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag text-gold">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Kelola Produk</h1>
        </div>
        
        <button @click="formOpen = !formOpen" class="bg-gold text-white font-semibold px-6 py-2 rounded-xl shadow-md hover:bg-yellow-600 transition-colors flex items-center gap-2">
            <svg x-show="!formOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            <span x-text="formOpen ? 'Tutup Form' : 'Tambah Produk'"></span>
        </button>
    </div>

    <div x-show="formOpen" x-transition.duration.300ms class="p-6 bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-gold/20 mb-8">
        <form method="post" action="/admin/products/store" enctype="multipart/form-data" class="space-y-4">
            <?= csrf_field() ?>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Form Tambah Produk</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <input name="sku" placeholder="SKU" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" required>
                <input name="name" placeholder="Nama Produk" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors md:col-span-2" required>

                <select name="category_id" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors">
                    <?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option><?php endforeach; ?>
                </select>

                <input name="size" placeholder="Ukuran (S/M/L)" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors">
                <input name="color" placeholder="Warna" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors">
                <input name="price_per_day" type="number" min="0" placeholder="Harga/hari" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" required>
                <input name="stock" type="number" min="0" placeholder="Stok" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" required>

                <label class="flex items-center gap-2 mt-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded-sm border-neutral-300 text-gold focus:ring-gold">
                    <span class="text-neutral-600 dark:text-neutral-300">Aktif</span>
                </label>

                <input name="meta_title" placeholder="Meta Title" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors md:col-span-2">
                <input name="meta_desc" placeholder="Meta Description" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors md:col-span-3">

                <div class="md:col-span-3">
                    <label class="block text-sm font-medium mb-1">Gambar Produk (boleh banyak)</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                           class="block w-full text-sm text-neutral-600 dark:text-neutral-300
                                  file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                  file:bg-gold file:text-white file:font-semibold
                                  hover:file:bg-yellow-600 transition-colors">
                    <div id="preview-create" class="mt-3 flex flex-wrap gap-3"></div>
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="bg-gold text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">
                    Tambah Produk
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto rounded-2xl shadow-xl border border-gold/20">
        <table class="min-w-full text-sm">
            <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
                <tr>
                    <th class="p-4 text-left font-semibold">Nama</th>
                    <th class="p-4 text-left font-semibold">Kategori</th>
                    <th class="p-4 text-left font-semibold">Harga/Hari</th>
                    <th class="p-4 text-left font-semibold">Stok</th>
                    <th class="p-4 text-left font-semibold">Aktif</th>
                    <th class="p-4 text-left font-semibold">Gambar</th>
                    <th class="p-4 text-center font-semibold w-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($rows as $r): ?>
                <?php $imgs = []; if (!empty($r['images'])) { $di = json_decode($r['images'], true); if (is_array($di)) $imgs = $di; } ?>
                <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                    <td class="p-4 font-medium text-neutral-900 dark:text-white"><?= esc($r['name']) ?></td>
                    <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= esc($r['category_name']) ?></td>
                    <td class="p-4 text-neutral-600 dark:text-neutral-300">Rp<?= number_format($r['price_per_day'],0,',','.') ?></td>
                    <td class="p-4 text-neutral-600 dark:text-neutral-300"><?= (int)$r['stock'] ?></td>
                    <td class="p-4 text-center">
                        <span class="inline-block w-2.5 h-2.5 rounded-full <?= $r['is_active']?'bg-green-500':'bg-red-500' ?>"></span>
                    </td>
                    
                    <td class="p-4">
                        <?php if(!empty($imgs)): ?>
                            <img src="<?= base_url(ltrim($imgs[0], '/')) ?>" alt="<?= esc($r['name']) ?>" class="w-12 h-12 object-cover rounded-lg shadow" loading="lazy">
                        <?php else: ?>
                            <span class="text-neutral-400">-</span>
                        <?php endif; ?>
                    </td>

                    <td class="p-4 relative">
                        <details class="group">
                            <summary class="cursor-pointer text-gold flex items-center justify-center gap-1 font-medium hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-more-horizontal group-open:hidden"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x hidden group-open:block"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </summary>
                            <div class="absolute right-0 w-[22rem] mt-2 p-4 bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gold/20 z-10">
                                <form method="post" action="/admin/products/update/<?= $r['id'] ?>" enctype="multipart/form-data" class="space-y-3 mb-3">
                                    <?= csrf_field() ?>
                                    <input name="sku" value="<?= esc($r['sku']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="SKU">
                                    <input name="name" value="<?= esc($r['name']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="Nama Produk">
                                    <select name="category_id" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                                        <?php foreach($categories as $c): ?><option value="<?= $c['id'] ?>" <?= $c['id']==$r['category_id']?'selected':'' ?>><?= esc($c['name']) ?></option><?php endforeach; ?>
                                    </select>
                                    <input name="size" value="<?= esc($r['size']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="Ukuran">
                                    <input name="color" value="<?= esc($r['color']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="Warna">
                                    <input name="price_per_day" type="number" min="0" value="<?= esc($r['price_per_day']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="Harga/hari">
                                    <input name="stock" type="number" min="0" value="<?= esc($r['stock']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="Stok">
                                    <label class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" <?= $r['is_active']?'checked':'' ?> class="rounded-sm border-neutral-300 text-gold focus:ring-gold"> Aktif
                                    </label>
                                    <input name="meta_title" value="<?= esc($r['meta_title']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="Meta Title">
                                    <input name="meta_desc" value="<?= esc($r['meta_desc']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-sm focus:outline-none focus:ring-2 focus:ring-gold" placeholder="Meta Description">

                                    <?php if(!empty($imgs)): ?>
                                        <div class="grid grid-cols-4 gap-2">
                                            <?php foreach($imgs as $img): ?>
                                                <label class="relative block">
                                                    <img src="<?= base_url(ltrim($img,'/')) ?>" class="w-full h-16 object-cover rounded-lg border border-neutral-300 dark:border-neutral-700 shadow-sm" loading="lazy" alt="Gambar Produk">
                                                    <input type="checkbox" name="remove_images[]" value="<?= esc($img) ?>" class="absolute top-1 left-1 w-4 h-4 rounded-sm border-red-500 text-red-500 bg-white/50 backdrop-blur-sm focus:ring-red-500 cursor-pointer">
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                        <p class="text-xs text-neutral-500 mt-1">Centang untuk hapus gambar terpilih.</p>
                                    <?php endif; ?>

                                    <div>
                                        <label class="block text-sm font-medium text-neutral-600 dark:text-neutral-300 mb-1">Tambah Gambar Baru</label>
                                        <input type="file" name="images[]" multiple accept="image/*"
                                               class="block w-full text-sm text-neutral-600 dark:text-neutral-300
                                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                                      file:bg-gold file:text-white file:font-semibold
                                                      hover:file:bg-yellow-600 transition-colors">
                                    </div>
                                    <button type="submit" class="w-full bg-gold text-white font-semibold px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors mt-3">Simpan Perubahan</button>
                                </form>

                                <form method="post" action="/admin/products/delete/<?= $r['id'] ?>" onsubmit="return confirm('Hapus produk ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="w-full bg-red-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition-colors mt-2">Hapus Produk</button>
                                </form>
                            </div>
                        </details>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelector('input[name="images[]"]')?.addEventListener('change', function(e){
  const wrap = document.getElementById('preview-create');
  if (!wrap) return;
  wrap.innerHTML = '';
  [...e.target.files].forEach(f => {
    const img = document.createElement('img');
    img.className = 'w-20 h-20 object-cover rounded-lg shadow-sm border border-neutral-300 dark:border-neutral-700';
    img.src = URL.createObjectURL(f);
    img.loading = 'lazy';
    wrap.appendChild(img);
  });
});
</script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<?= $this->endSection() ?>