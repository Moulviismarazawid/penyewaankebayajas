<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<h1 class="text-2xl font-bold mb-4">Checkout</h1>

<form method="post" action="/order/confirm" class="grid md:grid-cols-2 gap-4">
  <?= csrf_field() ?>

  <input class="px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10"
         name="nik" placeholder="NIK" value="<?= esc($customer['nik'] ?? '') ?>" required>

  <input class="px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10"
         name="full_name" placeholder="Nama Lengkap"
         value="<?= esc($customer['full_name'] ?? (session('name') ?? ($user['full_name'] ?? ''))) ?>" required>

  <!-- EMAIL dari registrasi: readonly -->
  <input class="px-3 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-black/10 dark:border-white/10"
         name="email" placeholder="Email (dari registrasi)" readonly
         value="<?= esc($customer['email'] ?? ($user['email'] ?? session('email'))) ?>">

  <input class="px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10"
         name="phone" placeholder="Nomor WA" value="<?= esc($customer['phone'] ?? ($user['phone'] ?? '')) ?>" required>

  <input class="px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10 md:col-span-2"
         name="address" placeholder="Alamat Lengkap" value="<?= esc($customer['address'] ?? '') ?>" required>

  <div>
    <label class="text-sm">Tanggal Mulai</label>
    <input type="date" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10"
           name="start_date" required>
  </div>

  <div>
    <label class="text-sm">Tanggal Selesai</label>
    <input type="date" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10"
           name="end_date" required>
  </div>

  <textarea class="px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10 md:col-span-2"
            name="notes" placeholder="Catatan (opsional)"></textarea>

  <div class="md:col-span-2 text-right">
    <button class="bg-gold text-black px-6 py-2 rounded-xl">Buat Invoice & Simpan</button>
  </div>
</form>

<?= $this->endSection() ?>
