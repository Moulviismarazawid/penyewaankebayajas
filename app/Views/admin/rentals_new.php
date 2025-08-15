<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="flex items-center justify-between mb-4">
  <h1 class="text-2xl font-bold">Buat Order (Admin)</h1>
  <a href="/admin/rentals" class="text-sm px-3 py-2 rounded border border-black/10 dark:border-white/10">Kembali ke Daftar</a>
</div>

<form method="post" action="/admin/rentals/store" class="grid gap-4 md:grid-cols-2 bg-white dark:bg-neutral-800 p-6 rounded-2xl border border-gold/20 shadow">
  <?= csrf_field() ?>

  <!-- Sumber Pelanggan -->
  <div class="md:col-span-2">
    <label class="block text-sm mb-1">Sumber Pelanggan</label>
    <div class="flex flex-wrap gap-3">
      <label class="inline-flex items-center gap-2">
        <input type="radio" name="customer_source" value="user" checked>
        <span>Pilih User Terdaftar</span>
      </label>
      <label class="inline-flex items-center gap-2">
        <input type="radio" name="customer_source" value="manual">
        <span>Input Manual / Walk-in</span>
      </label>
    </div>
  </div>

  <!-- Pilih user -->
  <div class="md:col-span-2" id="pickUserBox">
    <label class="block text-sm mb-1">Pilih User</label>
    <select name="user_id" id="user_id"
      class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10">
      <option value="">— pilih —</option>
      <?php foreach ($users as $u): ?>
        <option value="<?= $u['id'] ?>" data-email="<?= esc($u['email']) ?>" data-phone="<?= esc($u['phone']) ?>">
          <?= esc($u['full_name']) ?> — <?= esc($u['email']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Input manual -->
  <div class="md:col-span-2 hidden" id="manualBox">
    <div class="grid md:grid-cols-2 gap-3">
      <label class="block">
        <span class="text-sm">Nama</span>
        <input name="full_name" class="mt-1 w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" placeholder="Nama pelanggan">
      </label>
      <label class="block">
        <span class="text-sm">NIK (opsional)</span>
        <input name="nik" class="mt-1 w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" placeholder="NIK">
      </label>
      <label class="block">
        <span class="text-sm">Email (opsional)</span>
        <input name="email" type="email" class="mt-1 w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" placeholder="email@domain.com">
      </label>
      <label class="block">
        <span class="text-sm">No. WA (opsional)</span>
        <input name="phone" class="mt-1 w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" placeholder="08xxxxxxxxxx">
      </label>
      <label class="block md:col-span-2">
        <span class="text-sm">Alamat (opsional)</span>
        <textarea name="address" rows="2" class="mt-1 w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" placeholder="Alamat pengantaran/pengambilan"></textarea>
      </label>
    </div>
  </div>

  <!-- Tanggal -->
  <div>
    <label class="text-sm block">Tanggal Mulai</label>
    <input type="date" name="start_date" required
      class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10">
  </div>
  <div>
    <label class="text-sm block">Tanggal Selesai</label>
    <input type="date" name="end_date" required
      class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10">
  </div>

  <!-- ITEMS (repeater) -->
  <div class="md:col-span-2">
    <div class="flex items-center justify-between mb-2">
      <label class="text-sm font-semibold">Item Produk</label>
      <button type="button" id="addRow" class="px-3 py-1 rounded bg-gold text-black">Tambah Item</button>
    </div>

    <div id="itemsWrap" class="space-y-3">
      <div class="grid md:grid-cols-6 gap-2 item-row">
        <div class="md:col-span-5">
          <select name="items[0][product_id]" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" required>
            <option value="">— pilih produk —</option>
            <?php foreach ($products as $p): ?>
              <option value="<?= $p['id'] ?>"> <?= esc($p['name']) ?> (Rp<?= number_format($p['price_per_day'],0,',','.') ?>/hari)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="md:col-span-1 flex gap-2">
          <input type="number" min="1" value="1" name="items[0][qty]" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" required>
          <button type="button" class="rmRow px-3 py-2 rounded border border-black/10 dark:border-white/10">×</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Catatan -->
  <div class="md:col-span-2">
    <label class="text-sm block">Catatan (opsional)</label>
    <textarea name="notes" rows="3" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-neutral-800 border border-black/10 dark:border-white/10" placeholder="Catatan khusus, ukuran, request, dll."></textarea>
  </div>

  <div class="md:col-span-2 text-right">
    <button class="bg-gold text-black font-medium px-6 py-2 rounded-xl">Buat Order</button>
  </div>
</form>

<script>
  // Toggle sumber pelanggan
  const srcRadios = document.querySelectorAll('input[name="customer_source"]');
  const pickUserBox = document.getElementById('pickUserBox');
  const manualBox = document.getElementById('manualBox');

  function toggleSource() {
    const v = document.querySelector('input[name="customer_source"]:checked')?.value;
    pickUserBox.classList.toggle('hidden', v !== 'user');
    manualBox.classList.toggle('hidden', v !== 'manual');
  }
  srcRadios.forEach(r => r.addEventListener('change', toggleSource));
  toggleSource();

  // Repeater item
  const itemsWrap = document.getElementById('itemsWrap');
  const addBtn = document.getElementById('addRow');
  addBtn.addEventListener('click', () => {
    const idx = itemsWrap.querySelectorAll('.item-row').length;
    const tpl = itemsWrap.firstElementChild.cloneNode(true);
    // bersihkan nilai
    tpl.querySelectorAll('select, input').forEach(el => {
      if (el.tagName === 'SELECT') el.selectedIndex = 0;
      if (el.type === 'number') el.value = 1;
    });
    // set name baru
    tpl.querySelectorAll('select[name], input[name]').forEach(el => {
      el.name = el.name.replace(/\[\d+\]/, '['+idx+']');
    });
    itemsWrap.appendChild(tpl);
    bindRemove();
  });

  function bindRemove() {
    itemsWrap.querySelectorAll('.rmRow').forEach(btn => {
      btn.onclick = () => {
        const rows = itemsWrap.querySelectorAll('.item-row');
        if (rows.length > 1) btn.closest('.item-row').remove();
      };
    });
  }
  bindRemove();
</script>

<?= $this->endSection() ?>
