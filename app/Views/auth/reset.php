<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>
<section class="max-w-md mx-auto">
  <div class="border border-gold/30 rounded-2xl p-6 bg-white dark:bg-neutral-800">
    <h1 class="text-2xl font-bold mb-4">Reset Password</h1>
    <form method="post" action="/auth/reset" class="space-y-3">
      <?= csrf_field() ?>
      <input type="hidden" name="token" value="<?= esc($token) ?>">
      <input class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" type="password" name="password" placeholder="Password Baru" required>
      <input class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" type="password" name="password_confirm" placeholder="Konfirmasi Password" required>
      <button class="bg-gold text-black px-4 py-2 rounded-xl">Update Password</button>
    </form>
  </div>
</section>
<?= $this->endSection() ?>
