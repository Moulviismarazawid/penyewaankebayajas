<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?php if (!empty($banners)): ?>
  <div 
    x-data="bannerSlider(<?= count($banners) ?>)" 
    x-init="init()" 
    class="relative rounded-3xl overflow-hidden shadow-2xl border border-gold/30 mb-8 select-none"
  >
    <!-- Frame dengan rasio tetap; object-contain agar gambar tidak terpotong -->
    <div class="relative w-full aspect-[16/7] bg-black">
      <!-- Track -->
      <div 
        class="absolute inset-0 flex transition-transform duration-500 ease-out"
        :style="`transform: translateX(-${active * 100}%);`"
        @mouseenter="stop()" 
        @mouseleave="start()"
        @touchstart="onTouchStart"
        @touchmove="onTouchMove"
        @touchend="onTouchEnd"
      >
        <?php foreach ($banners as $index => $b): ?>
          <?php $bannerImg = !empty($b['image_url']) ? base_url(ltrim($b['image_url'],'/')) : null; ?>
          <!-- Slide -->
          <section class="w-full h-full flex-shrink-0 relative">
            <?php if ($bannerImg): ?>
              <img 
                src="<?= $bannerImg ?>" 
                alt="<?= esc($b['title'] ?? 'Banner') ?>" 
                class="absolute inset-0 w-full h-full object-contain"
                loading="eager" decoding="async"
              >
              <!-- lapisan gradasi biar teks kebaca -->
              <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/20 to-transparent"></div>
            <?php endif; ?>

            <div class="absolute inset-0 z-10 p-6 md:p-10 flex items-end md:items-center">
              <div class="max-w-xl text-white">
                <h1 class="text-3xl md:text-5xl font-extrabold drop-shadow-lg">
                  <?= esc($b['title'] ?? '') ?>
                </h1>
                <?php if (!empty($b['subtitle'])): ?>
                  <p class="mt-3 md:mt-4 text-base md:text-lg text-white/90 drop-shadow-md">
                    <?= esc($b['subtitle']) ?>
                  </p>
                <?php endif; ?>
                <?php if (!empty($b['button_text']) && !empty($b['button_link'])): ?>
                  <a href="<?= esc($b['button_link']) ?>" 
                     class="mt-6 inline-flex items-center bg-gold text-neutral-900 px-6 py-3 rounded-full font-semibold shadow-md hover:opacity-90 transition">
                    <?= esc($b['button_text']) ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </section>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Prev/Next -->
    <button @click="prev()" class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 p-2 md:p-3 bg-white/30 backdrop-blur-sm text-white rounded-full hover:bg-white/50">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
    </button>
    <button @click="next()" class="absolute right-3 md:right-4 top-1/2 -translate-y-1/2 p-2 md:p-3 bg-white/30 backdrop-blur-sm text-white rounded-full hover:bg-white/50">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-3 md:bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
      <?php foreach ($banners as $i => $b): ?>
        <button 
          @click="go(<?= $i ?>)" 
          class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full transition"
          :class="active === <?= $i ?> ? 'bg-white' : 'bg-white/50'">
        </button>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Alpine component -->
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('bannerSlider', (len) => ({
        active: 0,
        len,
        timer: null,
        touchStartX: 0,
        moved: false,

        init(){ this.start(); },
        start(){ this.stop(); this.timer = setInterval(() => this.next(), 5000); },
        stop(){ if (this.timer) clearInterval(this.timer); this.timer = null; },

        next(){ this.active = (this.active + 1) % this.len; },
        prev(){ this.active = (this.active - 1 + this.len) % this.len; },
        go(i){ this.active = i % this.len; this.start(); },

        onTouchStart(e){ this.stop(); this.touchStartX = e.touches[0].clientX; this.moved = false; },
        onTouchMove(e){
          const dx = e.touches[0].clientX - this.touchStartX;
          if (Math.abs(dx) > 40) this.moved = true;
        },
        onTouchEnd(e){
          const dx = (e.changedTouches?.[0]?.clientX ?? 0) - this.touchStartX;
          if (Math.abs(dx) > 60) { dx < 0 ? this.next() : this.prev(); }
          this.start();
        }
      }));
    });
  </script>
<?php else: ?>
  <!-- Fallback jika belum ada banner -->
  <section class="rounded-3xl border border-gold/30 p-8 bg-white dark:bg-neutral-800 shadow-xl">
    <div class="grid md:grid-cols-2 gap-8 items-center">
      <div>
        <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">Sewa Kebaya & Jas Bandar Lampung</h1>
        <p class="mt-3 text-lg text-neutral-600 dark:text-neutral-300">Temukan koleksi kebaya & jas berkualitas tinggi dengan proses sewa yang mudah dan harga yang ramah di kantong.</p>
        <a href="/produk" class="inline-flex items-center mt-6 bg-gold text-neutral-900 px-6 py-3 rounded-full font-semibold shadow-md hover:opacity-90 transition">
          Lihat Katalog 
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="ml-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      </div>
      <div class="bg-neutral-100 dark:bg-neutral-700 rounded-2xl p-6 border border-gold/20 shadow-inner">
        <p class="font-bold text-lg mb-2 text-neutral-900 dark:text-white">Cara Pesan</p>
        <ol class="list-decimal list-inside text-base text-neutral-600 dark:text-neutral-300 space-y-2">
          <li>Pilih produk yang kamu suka</li>
          <li>Login atau Daftar akun</li>
          <li>Klik tombol "Sewa" & isi checkout</li>
          <li>Konfirmasi pesanan via WhatsApp</li>
        </ol>
      </div>
    </div>
  </section>
<?php endif; ?>

<section class="mt-12">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Produk Terbaru</h2>
    <a class="text-gold hover:underline font-medium transition-colors duration-200" href="/produk">Lihat semua</a>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach (($products ?? []) as $p): ?>
      <?php
        $img = null;
        if (!empty($p['images'])) {
          $raw = json_decode($p['images'], true);
          if (json_last_error() === JSON_ERROR_NONE && is_array($raw) && !empty($raw)) {
            $first = $raw[0];
            if (is_string($first) && $first !== '') $img = $first;
          } elseif (is_string($p['images'])) {
            $img = $p['images'];
          }
        }
        $imgUrl = $img ? base_url(ltrim($img,'/')) : null;
      ?>
      <div class="border border-gold/30 rounded-3xl overflow-hidden bg-white dark:bg-neutral-800 shadow-lg hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
        <div class="relative w-full aspect-[4/3] bg-neutral-200 dark:bg-neutral-700">
          <?php if ($imgUrl): ?>
            <img src="<?= $imgUrl ?>" alt="<?= esc($p['name']) ?>" class="absolute inset-0 w-full h-full object-cover" loading="lazy" decoding="async">
          <?php else: ?>
            <div class="absolute inset-0 flex items-center justify-center text-neutral-500 dark:text-neutral-400 font-medium">Belum ada gambar</div>
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
                <button class="text-sm bg-gold text-white font-medium px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600">Sewa</button>
              </form>
            <?php else: ?>
              <a href="/auth/login" class="text-sm bg-gold text-white font-medium px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600">Sewa</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?= $this->endSection() ?>
