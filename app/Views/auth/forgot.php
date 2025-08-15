<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>
<section class="max-w-md mx-auto">
  <div class="border border-gold/30 rounded-2xl p-6 bg-white dark:bg-neutral-800">
    <h1 class="text-2xl font-bold mb-4">Lupa Password</h1>
    <form method="post" action="/auth/forgot" class="space-y-3">
      <?= csrf_field() ?>
      <input class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" name="email" placeholder="Email" required>
      <button class="bg-gold text-black px-4 py-2 rounded-xl">Kirim Link Reset</button>
    </form>
  </div>
</section>
<?= $this->endSection() ?>
