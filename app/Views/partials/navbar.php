<?php $isLogged = (bool) session('user_id'); ?>

<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 bg-white dark:bg-neutral-900 shadow-md">
  <div class="container mx-auto h-16 px-4 flex items-center justify-between">
    <a href="<?= site_url('/') ?>" class="flex items-center gap-2 font-extrabold text-lg">
      <img
        src="<?= base_url('images/logo.jpg') ?>"
        alt="Logo Sewa Kebaya Jas"
        class="h-8 w-auto" loading="lazy" decoding="async">
      <span class="text-neutral-900 dark:text-white">Sewa Kebaya Jas Bandar Lampung</span>
    </a>

    <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-neutral-600 dark:text-neutral-300">
      <a class="hover:text-gold transition-colors" href="<?= site_url('/') ?>">Home</a>
      <a class="hover:text-gold transition-colors" href="<?= site_url('produk') ?>">Produk</a>
      <a class="hover:text-gold transition-colors" href="<?= site_url('about') ?>">Tentang Kami</a>
      <a class="hover:text-gold transition-colors" href="<?= site_url('order/riwayat') ?>">Riwayat</a>
      <a class="hover:text-gold transition-colors" href="<?= site_url('cart') ?>">Keranjang</a>

      <button data-theme-toggle aria-label="Toggle theme"
              class="inline-flex w-9 h-9 items-center justify-center rounded-lg border border-gold/40 text-neutral-600 dark:text-neutral-300 hover:border-gold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun dark:hidden">
          <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon hidden dark:inline">
          <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
        </svg>
      </button>

      <?php if ($isLogged): ?>
        <a class="hover:text-gold transition-colors" href="<?= site_url('auth/logout') ?>">Logout</a>
      <?php else: ?>
        <a class="hover:text-gold transition-colors" href="<?= site_url('auth/login') ?>">Login</a>
      <?php endif; ?>
    </nav>

    <div class="md:hidden flex items-center gap-2">
      <button data-theme-toggle aria-label="Toggle theme"
              class="inline-flex w-10 h-10 items-center justify-center rounded-lg border border-gold/40 text-neutral-600 dark:text-neutral-300 hover:border-gold transition-colors">
        <!-- icon sun/moon sama seperti di atas -->
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun dark:hidden">
          <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon hidden dark:inline">
          <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
        </svg>
      </button>

      <button @click="mobileMenuOpen = true"
              class="inline-flex w-10 h-10 items-center justify-center rounded-lg border border-gold/40 text-neutral-600 dark:text-neutral-300 hover:border-gold transition-colors"
              aria-expanded="false" aria-controls="mobileNav" aria-label="Buka menu">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
      </button>
    </div>
  </div>

  <!-- mobile menu -->
  <div x-show="mobileMenuOpen"
       x-transition:enter="transition ease-out duration-300 transform"
       x-transition:enter-start="opacity-0 -translate-y-full"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-200 transform"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 -translate-y-full"
       class="md:hidden fixed top-16 left-0 right-0 z-40 bg-white dark:bg-neutral-900 shadow-md p-5 flex flex-col gap-3">
    <a @click="mobileMenuOpen = false" class="py-2 px-2 rounded font-medium text-neutral-600 dark:text-neutral-300 hover:bg-gold/10 hover:text-gold" href="<?= site_url('/') ?>">Home</a>
    <a @click="mobileMenuOpen = false" class="py-2 px-2 rounded font-medium text-neutral-600 dark:text-neutral-300 hover:bg-gold/10 hover:text-gold" href="<?= site_url('produk') ?>">Produk</a>
    <a @click="mobileMenuOpen = false" class="py-2 px-2 rounded font-medium text-neutral-600 dark:text-neutral-300 hover:bg-gold/10 hover:text-gold" href="<?= site_url('about') ?>">Tentang Kami</a>
    <a @click="mobileMenuOpen = false" class="py-2 px-2 rounded font-medium text-neutral-600 dark:text-neutral-300 hover:bg-gold/10 hover:text-gold" href="<?= site_url('order/riwayat') ?>">Riwayat</a>
    <a @click="mobileMenuOpen = false" class="py-2 px-2 rounded font-medium text-neutral-600 dark:text-neutral-300 hover:bg-gold/10 hover:text-gold" href="<?= site_url('cart') ?>">Keranjang</a>
    <hr class="my-2 border-neutral-200 dark:border-neutral-700">
    <?php if ($isLogged): ?>
      <a @click="mobileMenuOpen = false" class="py-2 px-2 rounded font-medium text-neutral-600 dark:text-neutral-300 hover:bg-red-500/10 hover:text-red-500" href="<?= site_url('auth/logout') ?>">Logout</a>
    <?php else: ?>
      <a @click="mobileMenuOpen = false" class="py-2 px-2 rounded font-medium text-neutral-600 dark:text-neutral-300 hover:bg-gold/10 hover:text-gold" href="<?= site_url('auth/login') ?>">Login</a>
    <?php endif; ?>
  </div>

  <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="md:hidden fixed inset-0 bg-black/50 z-30"></div>
</header>
