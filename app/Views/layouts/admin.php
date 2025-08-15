<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= esc($title ?? 'Admin') ?> — Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class', theme: { extend: { colors: { gold:'#C9A227' } } } };
    (function(){
      const s = localStorage.getItem('theme');
      if (s==='dark' || (!s && matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-white text-black dark:bg-neutral-900 dark:text-neutral-100">

  <!-- TOPBAR -->
  <header class="sticky top-0 z-50 bg-white/95 dark:bg-neutral-900/95 backdrop-blur border-b border-gold/30">
    <div class="h-14 px-4 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <button id="adminNavToggle" class="md:hidden inline-flex w-10 h-10 items-center justify-center rounded-lg border border-gold/40" aria-label="Buka menu">
          <i data-lucide="menu"></i>
        </button>
        <span class="font-semibold">Admin Panel</span>
      </div>
      <div class="flex items-center gap-2">
        <button data-theme-toggle aria-label="Toggle theme" class="inline-flex w-10 h-10 items-center justify-center rounded-lg border border-gold/40">
          <i data-lucide="sun" class="dark:hidden"></i><i data-lucide="moon" class="hidden dark:inline"></i>
        </button>
        <a class="hover:text-gold text-sm" href="/">Lihat Situs</a>
      </div>
    </div>
  </header>

  <?php
    // helper kecil untuk active state menu
    $path = function() { return '/'.trim(uri_string(), '/'); };
    $is = function(string $prefix) use ($path) {
      return strpos($path(), $prefix) === 0;
    };
    $item = function(string $href, string $label) use ($is) {
      $active = $is($href) ? 'bg-gold/10 text-gold font-medium' : 'hover:bg-gold/10';
      return '<a class="block py-2 px-3 rounded '.$active.'" href="'.$href.'">'.$label.'</a>';
    };
  ?>

  <!-- SIDEBAR (fixed di kiri pada md+, drawer di mobile) -->
  <div id="adminDrawerBackdrop" class="fixed inset-0 bg-black/40 hidden md:hidden z-40"></div>

  <aside id="adminSidebar"
    class="fixed z-50 md:z-40 top-0 md:top-14 left-0 h-full md:h-[calc(100vh-56px)] w-72 md:w-64 bg-white dark:bg-neutral-900 border-r border-gold/30 p-4 transform -translate-x-full md:translate-x-0 transition-transform overflow-y-auto">
    <div class="flex items-center justify-between mb-4 md:hidden">
      <span class="font-bold text-gold">Menu</span>
      <button id="adminNavClose" class="inline-flex w-9 h-9 items-center justify-center rounded-lg border border-gold/40" aria-label="Tutup menu">
        <i data-lucide="x"></i>
      </button>
    </div>
    <nav class="space-y-2 text-sm">
      <?= $item('/admin', 'Dashboard') ?>
      <?= $item('/admin/categories', 'Kategori') ?>
      <?= $item('/admin/products', 'Produk') ?>
      <?= $item('/admin/banners', 'Banner') ?>
      <?= $item('/admin/rentals', 'Rental') ?>
      <?= $item('/admin/fifo', 'FIFO') ?>
      <?= $item('/admin/walkins', 'Walk-in') ?>
      <?= $item('/admin/reports', 'Laporan') ?>
      <a class="block py-2 px-3 rounded text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20" href="/auth/logout">Logout</a>
    </nav>
  </aside>

  <!-- KONTEN: padding kiri mengikuti lebar sidebar pada md+ -->
  <main class="md:ml-64 pt-4 pb-10 px-4 md:px-8 min-h-screen">
    <div class="max-w-screen-2xl mx-auto">
      <?= $this->renderSection('content') ?>
    </div>
  </main>

  <script>
    lucide.createIcons();

    // Sidebar drawer (mobile)
    (function(){
      const btnOpen = document.getElementById('adminNavToggle');
      const btnClose = document.getElementById('adminNavClose');
      const sidebar = document.getElementById('adminSidebar');
      const backdrop = document.getElementById('adminDrawerBackdrop');

      const open = ()=>{ sidebar.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); };
      const close = ()=>{ sidebar.classList.add('-translate-x-full'); backdrop.classList.add('hidden'); };

      btnOpen?.addEventListener('click', open);
      btnClose?.addEventListener('click', close);
      backdrop?.addEventListener('click', close);

      // Theme toggle
      const btns=document.querySelectorAll('[data-theme-toggle]');
      const apply=(m)=>{ document.documentElement.classList.toggle('dark', m==='dark'); localStorage.setItem('theme', m); };
      btns.forEach(b=>b.addEventListener('click',()=>{apply(document.documentElement.classList.contains('dark')?'light':'dark');}));
    })();
  </script>

  <?php if(session()->getFlashdata('success')): ?>
  <script>Swal.fire({icon:'success',title:'Berhasil',text:'<?= esc(session()->getFlashdata('success')) ?>'});</script>
  <?php endif; if(session()->getFlashdata('error')): ?>
  <script>Swal.fire({icon:'error',title:'Gagal',text:'<?= esc(session()->getFlashdata('error')) ?>'});</script>
  <?php endif; ?>
</body>
</html>
