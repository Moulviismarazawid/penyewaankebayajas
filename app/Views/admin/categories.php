<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center gap-3 mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag text-gold">
        <path d="M12.586 12.586a2 2 0 1 1-2.828-2.828l7.21-7.21a2.828 2.828 0 0 1 4 4z"/><path d="M17.5 4.5l-8.5 8.5"/><path d="m14 11-3 3"/>
    </svg>
    <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Kelola Kategori</h1>
</div>

<form method="post" action="/admin/categories/store" class="flex flex-col md:flex-row gap-2 mb-8 p-4 bg-white dark:bg-neutral-800 rounded-xl shadow-md border border-gold/20">
    <?= csrf_field() ?>
    <div class="flex-1">
        <label for="name" class="sr-only">Nama Kategori</label>
        <input name="name" id="name" placeholder="Nama kategori baru" class="w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors" required>
    </div>
    <button class="bg-gold text-white font-semibold px-6 py-2 rounded-lg shadow-sm hover:bg-yellow-600 transition-colors">
        Tambah Kategori
    </button>
</form>

<div class="overflow-x-auto rounded-xl shadow-xl border border-gold/20">
    <table class="min-w-full text-sm">
        <thead class="bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-300">
            <tr>
                <th class="p-4 text-left font-semibold">Nama Kategori</th>
                <th class="p-4 text-center font-semibold w-52">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr class="border-t border-gold/20 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors duration-200">
                <td class="p-4 text-neutral-900 dark:text-white font-medium"><?= esc($r['name']) ?></td>
                <td class="p-4">
                    <div class="flex flex-col md:flex-row gap-2 justify-center items-center">
                        <form method="post" action="/admin/categories/update/<?= $r['id'] ?>" class="flex gap-2">
                            <?= csrf_field() ?>
                            <input name="name" value="<?= esc($r['name']) ?>" class="px-3 py-1 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold text-neutral-900 dark:text-white">
                            <button class="bg-blue-600 text-white px-3 py-1 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                        </form>
                        <form method="post" action="/admin/categories/delete/<?= $r['id'] ?>" onsubmit="return confirm('Yakin ingin menghapus kategori <?= esc($r['name']) ?>?')">
                            <?= csrf_field() ?>
                            <button class="bg-red-600 text-white px-3 py-1 rounded-lg shadow-sm hover:bg-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>