<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div x-data="{ formOpen: false }" class="space-y-6">

    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image text-gold">
                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
            </svg>
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Kelola Banner Home</h1>
        </div>
        
        <button @click="formOpen = !formOpen" class="bg-gold text-white font-semibold px-6 py-2 rounded-xl shadow-md hover:bg-yellow-600 transition-colors flex items-center gap-2">
            <svg x-show="!formOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            <span x-text="formOpen ? 'Tutup Form' : 'Tambah Banner'"></span>
        </button>
    </div>

    <div x-show="formOpen" x-transition.duration.300ms class="p-6 bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-gold/20">
        <form method="post" action="/admin/banners/store" class="space-y-4">
            <?= csrf_field() ?>
            <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Form Tambah Banner</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <input name="title" placeholder="Judul" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" />
                <input name="subtitle" placeholder="Subjudul" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" />
                <input name="image_url" placeholder="URL Gambar (/images/hero.jpg)" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" />
                <input name="button_text" placeholder="Teks Tombol (opsional)" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" />
                <input name="button_link" placeholder="Link Tombol (opsional)" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" />
                <input name="sort_order" type="number" value="1" placeholder="Urutan Tampil" class="px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" />
                <label class="inline-flex items-center gap-2 text-neutral-600 dark:text-neutral-300">
                    <input type="checkbox" name="is_active" checked class="rounded-sm border-neutral-300 text-gold focus:ring-gold"> Aktif
                </label>
            </div>
            <div class="mt-4 text-right">
                <button type="submit" class="bg-gold text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">
                    Tambah Banner
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto rounded-2xl shadow-xl border border-gold/20">
        <table class="min-w-full text-sm">
            <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
                <tr>
                    <th class="p-4 text-left font-semibold">Preview</th>
                    <th class="p-4 text-left font-semibold">Judul</th>
                    <th class="p-4 text-center font-semibold">Urutan</th>
                    <th class="p-4 text-center font-semibold">Aktif</th>
                    <th class="p-4 text-center font-semibold w-24">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach(($rows ?? []) as $r): ?>
                <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                    <td class="p-4">
                        <?php if($r['image_url']): ?>
                            <img src="<?= esc($r['image_url']) ?>" alt="Banner <?= esc($r['title']) ?>" class="h-16 w-32 object-cover rounded-md shadow">
                        <?php else: ?>
                            <div class="h-16 w-32 rounded-md bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center text-xs text-neutral-500">
                                No Image
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <div class="font-semibold text-neutral-900 dark:text-white"><?= esc($r['title']) ?></div>
                        <div class="text-xs text-neutral-600 dark:text-neutral-300"><?= esc($r['subtitle']) ?></div>
                    </td>
                    <td class="p-4 text-center text-neutral-600 dark:text-neutral-300"><?= (int)$r['sort_order'] ?></td>
                    <td class="p-4 text-center">
                        <span class="inline-block w-2.5 h-2.5 rounded-full <?= $r['is_active']?'bg-green-500':'bg-red-500' ?>"></span>
                    </td>
                    <td class="p-4 text-center">
                        <details class="group">
                            <summary class="cursor-pointer text-gold flex items-center justify-center gap-1 font-medium hover:underline focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-more-horizontal group-open:hidden"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x hidden group-open:block"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </summary>
                            <div class="absolute right-0 w-80 mt-2 p-4 bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gold/20 z-10">
                                <form method="post" action="/admin/banners/update/<?= $r['id'] ?>" class="space-y-3 mb-3">
                                    <?= csrf_field() ?>
                                    <input name="title" value="<?= esc($r['title']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white text-sm" placeholder="Judul">
                                    <input name="subtitle" value="<?= esc($r['subtitle']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white text-sm" placeholder="Subjudul">
                                    <input name="image_url" value="<?= esc($r['image_url']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white text-sm" placeholder="URL Gambar">
                                    <input name="button_text" value="<?= esc($r['button_text']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white text-sm" placeholder="Teks Tombol">
                                    <input name="button_link" value="<?= esc($r['button_link']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white text-sm" placeholder="Link Tombol">
                                    <input name="sort_order" type="number" value="<?= esc($r['sort_order']) ?>" class="w-full px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white text-sm" placeholder="Urutan">
                                    <label class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                                        <input type="checkbox" name="is_active" <?= $r['is_active']?'checked':'' ?> class="rounded-sm border-neutral-300 text-gold focus:ring-gold"> Aktif
                                    </label>
                                    <button class="w-full bg-gold text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">
                                        Simpan Perubahan
                                    </button>
                                </form>
                                <form method="post" action="/admin/banners/delete/<?= $r['id'] ?>" onsubmit="return confirm('Hapus banner ini?')">
                                    <?= csrf_field() ?>
                                    <button class="w-full bg-red-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition-colors mt-2">
                                        Hapus Banner
                                    </button>
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
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<?= $this->endSection() ?>