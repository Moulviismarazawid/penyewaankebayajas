<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-extrabold mb-6 text-neutral-900 dark:text-white">Katalog Produk</h1>

<div x-data="{ open: false }" class="relative z-10 mb-8">
  <!-- Toggle filter -->
  <button @click="open = true"
          class="fixed bottom-8 right-8 z-30 p-4 bg-gold text-white rounded-full shadow-lg hover:scale-105 transition-transform duration-200 lg:static lg:p-3 lg:mb-4 lg:inline-block">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal lg:hidden">
      <line x1="21" x2="14" y1="4" y2="4"/><line x1="10" x2="3" y1="4" y2="4"/><line x1="21" x2="12" y1="12" y2="12"/><line x1="8" x2="3" y1="12" y2="12"/><line x1="21" x2="16" y1="20" y2="20"/><line x1="12" x2="3" y1="20" y2="20"/><line x1="14" x2="14" y1="2" y2="6"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="16" x2="16" y1="18" y2="22"/>
    </svg>
    <span class="hidden lg:inline-block">Filter Produk</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal hidden lg:inline-block lg:ml-2">
      <line x1="21" x2="14" y1="4" y2="4"/><line x1="10" x2="3" y1="4" y2="4"/><line x1="21" x2="12" y1="12" y2="12"/><line x1="8" x2="3" y1="12" y2="12"/><line x1="21" x2="16" y1="20" y2="20"/><line x1="12" x2="3" y1="20" y2="20"/><line x1="14" x2="14" y1="2" y2="6"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="16" x2="16" y1="18" y2="22"/>
    </svg>
  </button>

  <!-- Drawer filter -->
  <div x-show="open" @click.outside="open = false"
       x-transition:enter="transition ease-in-out duration-300 transform"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in-out duration-300 transform"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="fixed inset-y-0 left-0 w-64 md:w-80 bg-white dark:bg-neutral-800 p-6 shadow-xl z-20 overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold text-neutral-900 dark:text-white">Filter Produk</h2>
      <button @click="open = false" type="button" class="text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
    </div>

    <form method="get" class="space-y-4" id="filter-form">
      <div>
        <label for="q" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Cari Produk</label>
        <div class="relative">
          <input name="q" id="q" value="<?= esc($q) ?>" placeholder="Cari nama produk..."
                 class="w-full pl-12 pr-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
          </svg>
        </div>
      </div>

      <div>
        <label for="kategori" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Kategori</label>
        <select name="kategori" id="kategori" class="w-full px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold">
          <option value="">Semua Kategori</option>
          <?php foreach($categories as $c): ?>
            <option value="<?= esc($c['slug']) ?>" <?= $cat==$c['slug']?'selected':'' ?>><?= esc($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="ukuran" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Ukuran</label>
        <select name="ukuran" id="ukuran" class="w-full px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold">
          <option value="">Semua Ukuran</option>
          <?php foreach(['S','M','L','XL','XXL'] as $s): ?>
            <option value="<?= $s ?>" <?= $size==$s?'selected':'' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="min" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Harga Minimum</label>
        <input type="number" name="min" id="min" value="<?= esc($min) ?>" placeholder="Harga Min."
               class="w-full px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold">
      </div>
      <div>
        <label for="max" class="block text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-1">Harga Maksimum</label>
        <input type="number" name="max" id="max" value="<?= esc($max) ?>" placeholder="Harga Maks."
               class="w-full px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold">
      </div>

      <div class="flex flex-col md:flex-row gap-2 mt-6">
        <a href="/produk" class="w-full px-6 py-3 border border-neutral-300 dark:border-neutral-600 text-neutral-900 dark:text-white font-bold rounded-xl shadow-md hover:bg-neutral-100 dark:hover:bg-neutral-700 text-center">
          Reset
        </a>
        <button type="submit" class="w-full px-6 py-3 bg-gold text-white font-bold rounded-xl shadow-lg hover:bg-yellow-600">
          Terapkan Filter
        </button>
      </div>
    </form>
  </div>

  <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/50 z-10"></div>
</div>

<!-- Grid Produk -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
  <?php foreach($products as $p): ?>
    <?php
      // Ambil gambar pertama dari kolom JSON `images` (atau string tunggal)
      $img = null;
      if (!empty($p['images'])) {
        $raw = json_decode($p['images'], true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($raw) && !empty($raw)) {
          $img = $raw[0];
        } elseif (is_string($p['images'])) {
          $img = $p['images'];
        }
      }
      $imgUrl = $img ? base_url(ltrim($img,'/')) : null;
    ?>
    <div class="border border-gold/30 rounded-3xl overflow-hidden bg-white dark:bg-neutral-800 shadow-lg hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
      <!-- Gambar -->
      <div class="relative w-full aspect-[4/3] bg-neutral-200 dark:bg-neutral-700">
        <?php if($imgUrl): ?>
          <img src="<?= $imgUrl ?>" alt="<?= esc($p['name']) ?>"
               class="absolute inset-0 w-full h-full object-cover" loading="lazy" decoding="async">
        <?php else: ?>
          <div class="absolute inset-0 flex items-center justify-center text-neutral-500 dark:text-neutral-400 font-medium">
            Belum ada gambar
          </div>
        <?php endif; ?>
      </div>

      <div class="p-5">
        <div class="font-bold text-xl line-clamp-2 text-neutral-900 dark:text-white"><?= esc($p['name']) ?></div>
        <div class="text-sm mt-1 text-neutral-600 dark:text-neutral-300">Rp<?= number_format($p['price_per_day'],0,',','.') ?> / hari</div>

        <div class="mt-4 flex justify-between items-center gap-2">
          <a href="/produk/<?= esc($p['slug']) ?>" class="text-sm font-medium text-gold hover:underline hover:text-yellow-600">Detail Produk</a>

          <?php $isLogged = (bool) session('user_id'); ?>
          <?php if ($isLogged): ?>
            <form method="post" action="/order/quick">
              <?= csrf_field() ?>
              <input type="hidden" name="product_id" value="<?= esc($p['id']) ?>">
              <input type="hidden" name="qty" value="1">
              <button class="text-sm bg-gold text-white font-medium px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600">
                Sewa
              </button>
            </form>
          <?php else: ?>
            <a href="/auth/login" class="text-sm bg-gold text-white font-medium px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600">
              Sewa
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="mt-8 flex justify-center">
  <?= $pager->links('products', 'tw_gold') ?>
</div>

<?= $this->endSection() ?>
