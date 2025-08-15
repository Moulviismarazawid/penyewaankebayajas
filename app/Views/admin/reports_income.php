<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="text-2xl font-bold mb-4">Laporan Pendapatan</h1>
<div class="grid md:grid-cols-3 gap-4">
  <div class="border border-gold/20 rounded-xl p-4 bg-white dark:bg-neutral-800">
    <div class="text-sm text-black/70 dark:text-neutral-300">Pendapatan Sewa</div>
    <div class="text-2xl font-bold"><?= number_format($sewa,0,',','.') ?></div>
  </div>
  <div class="border border-gold/20 rounded-xl p-4 bg-white dark:bg-neutral-800">
    <div class="text-sm text-black/70 dark:text-neutral-300">Pendapatan Denda</div>
    <div class="text-2xl font-bold"><?= number_format($denda,0,',','.') ?></div>
  </div>
  <div class="border border-gold/20 rounded-xl p-4 bg-white dark:bg-neutral-800">
    <div class="text-sm text-black/70 dark:text-neutral-300">Total</div>
    <div class="text-2xl font-bold text-gold"><?= number_format($total,0,',','.') ?></div>
  </div>
</div>
<?= $this->endSection() ?>
