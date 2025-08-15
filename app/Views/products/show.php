<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?php
// Guard: kalau controller tidak kirim $product
$product = $product ?? null;
if (!$product) {
  echo '<div class="p-4 rounded-xl bg-red-100 text-red-800">Produk tidak ditemukan.</div>';
  echo $this->endSection();
  return;
}

// Helper URL aman (fallback jika helper url belum diload)
$toUrl = function(string $path): string {
  $p = ltrim($path, '/');
  if (function_exists('base_url')) return base_url($p);
  return '/' . $p;
};

// Siapkan daftar gambar dari kolom `images` (JSON atau string tunggal)
$images = [];
if (!empty($product['images'])) {
  $raw = json_decode($product['images'], true);
  if (json_last_error() === JSON_ERROR_NONE && is_array($raw)) {
    $images = $raw;
  } elseif (is_string($product['images'])) {
    $images = [$product['images']];
  }
}
$imgMain = isset($images[0]) ? $toUrl($images[0]) : null;
?>

<!-- Breadcrumb sederhana -->
<nav class="text-sm mb-4 text-neutral-600 dark:text-neutral-400">
  <a href="/" class="hover:text-gold">Home</a>
  <span class="mx-2">/</span>
  <a href="/produk" class="hover:text-gold">Produk</a>
  <span class="mx-2">/</span>
  <span class="text-neutral-900 dark:text-white"><?= esc($product['name']) ?></span>
</nav>

<div class="grid gap-6 md:grid-cols-2">
  <!-- Gambar -->
  <div>
    <div class="relative w-full aspect-[4/3] rounded-2xl overflow-hidden border border-gold/30 bg-neutral-100 dark:bg-neutral-800">
      <?php if ($imgMain): ?>
        <img src="<?= $imgMain ?>" alt="<?= esc($product['name']) ?>" class="absolute inset-0 w-full h-full object-cover">
      <?php else: ?>
        <div class="absolute inset-0 flex items-center justify-center text-neutral-500 dark:text-neutral-400">
          Belum ada gambar
        </div>
      <?php endif; ?>
    </div>

    <?php if (count($images) > 1): ?>
      <div class="mt-3 grid grid-cols-5 gap-2">
        <?php foreach($images as $im): $u = $toUrl($im); ?>
          <img src="<?= $u ?>" class="w-full aspect-square object-cover rounded border border-neutral-300 dark:border-neutral-700" alt="">
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Info Produk -->
  <div>
    <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white"><?= esc($product['name']) ?></h1>

    <div class="mt-3 space-y-1 text-neutral-700 dark:text-neutral-300">
      <div>Kategori: <span class="font-medium"><?= esc($product['category_name'] ?? '-') ?></span></div>
      <div>Ukuran: <span class="font-medium"><?= esc($product['size'] ?: '-') ?></span></div>
      <div>Warna: <span class="font-medium"><?= esc($product['color'] ?: '-') ?></span></div>
      <div>Stok: <span class="font-medium"><?= (int)($product['stock'] ?? 0) ?></span></div>
    </div>

    <div class="mt-4 text-2xl font-bold">
      Rp<?= number_format($product['price_per_day'], 0, ',', '.') ?>
      <span class="text-sm font-normal">/ hari</span>
    </div>

    <div class="mt-6 flex flex-wrap gap-3">
      <?php $isLogged = (bool) session('user_id'); ?>
      <?php if ($isLogged && !empty($product['is_active'])): ?>
        <form method="post" action="/order/quick" class="inline">
          <?= csrf_field() ?>
          <input type="hidden" name="product_id" value="<?= esc($product['id']) ?>">
          <input type="hidden" name="qty" value="1">
          <button class="bg-gold text-black px-6 py-3 rounded-xl font-semibold shadow hover:brightness-95">
            Sewa Sekarang
          </button>
        </form>
      <?php elseif(!$isLogged): ?>
        <a href="/auth/login" class="bg-gold text-black px-6 py-3 rounded-xl font-semibold shadow hover:brightness-95">
          Login untuk Sewa
        </a>
      <?php else: ?>
        <button disabled class="bg-neutral-300 text-neutral-600 dark:bg-neutral-700 dark:text-neutral-400 px-6 py-3 rounded-xl font-semibold cursor-not-allowed">
          Produk tidak aktif
        </button>
      <?php endif; ?>

      <a href="/produk" class="px-6 py-3 rounded-xl border border-gold/30 hover:bg-gold/10">
        Kembali ke Katalog
      </a>
    </div>

    <?php if (!empty($product['meta_desc'])): ?>
      <p class="mt-6 text-neutral-700 dark:text-neutral-300 leading-relaxed">
        <?= esc($product['meta_desc']) ?>
      </p>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>
