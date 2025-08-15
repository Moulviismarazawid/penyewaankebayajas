<!doctype html>
<html lang="id" class="">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= esc($title ?? 'Sewa Kebaya Jas Bandar Lampung') ?></title>
  <meta name="description" content="<?= esc($description ?? 'Sewa kebaya & jas di Bandar Lampung. Koleksi lengkap, harga ramah, proses mudah.') ?>">
  <link rel="canonical" href="<?= current_url(); ?>" />
  <meta property="og:title" content="<?= esc($title ?? 'Sewa Kebaya Jas Bandar Lampung') ?>" />
  <meta property="og:description" content="<?= esc($description ?? 'Sewa kebaya & jas di Bandar Lampung. Koleksi lengkap, harga ramah, proses mudah.') ?>" />
  <meta property="og:type" content="website" /><meta property="og:url" content="<?= current_url(); ?>" />
  <meta name="robots" content="index,follow" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .pagination-wrapper { padding: 16px 0; }

.pagination{
  list-style:none;
  display:flex;                 /* <- bikin horizontal, bukan numpuk */
  gap:8px;
  justify-content:center;
  align-items:center;
  margin:24px 0 8px;
  padding:0;
}

.pagination li{ display:inline-flex; }

.pagination a,
.pagination span{
  min-width:40px;
  height:40px;
  padding:0 14px;
  display:flex;
  justify-content:center;
  align-items:center;
  border:1px solid #E6D9B0;    /* gold-200 */
  border-radius:999px;          /* pill */
  background:#fff;
  color:#444;
  font-weight:600;
  text-decoration:none;
  box-shadow:0 1px 2px rgba(0,0,0,.04);
  transition:transform .12s ease, box-shadow .12s ease, background .12s ease;
}

.pagination a:hover{
  transform:translateY(-1px);
  box-shadow:0 6px 12px rgba(201,162,39,.18);
}

.pagination .active span{
  background:#C9A227;           /* gold brand */
  color:#fff;
  border-color:#C9A227;
}

.pagination .disabled span{
  opacity:.5;
  cursor:not-allowed;
  background:#f9f7f2;
}

@media (max-width: 480px){
  .pagination a, .pagination span{
    min-width:34px;
    height:34px;
    padding:0 10px;
    font-size:14px;
  }
}

  </style>
  <script>
    tailwind.config = { darkMode:'class', theme: { extend: { colors: { gold:'#C9A227' } } } };
    // Theme bootstrap
    (function(){
      const s = localStorage.getItem('theme');
      if (s==='dark' || (!s && window.matchMedia('(prefers-color-scheme: dark)').matches))
        document.documentElement.classList.add('dark');
    })();
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
   
</head>
<body class="min-h-screen bg-white text-black dark:bg-neutral-900 dark:text-neutral-100">
  <?= $this->include('partials/navbar') ?>
  <main class="container mx-auto px-4 py-6 min-h-screen"><?= $this->renderSection('content') ?></main>
  <?= $this->include('partials/footer') ?>


  <script>
    lucide.createIcons();
    // Toggle Theme (navbar button id=themeToggle)
    (function(){
      const btns = document.querySelectorAll('[data-theme-toggle]');
      const apply = (mode)=>{ document.documentElement.classList.toggle('dark', mode==='dark'); localStorage.setItem('theme',mode); btns.forEach(b=>b.setAttribute('data-current',mode)); };
      btns.forEach(b=>b.addEventListener('click', ()=>{ const cur = document.documentElement.classList.contains('dark')?'dark':'light'; apply(cur==='dark'?'light':'dark'); }));
    })();
  </script>
  <?php if(session()->getFlashdata('success')): ?>
  <script>Swal.fire({icon:'success',title:'Berhasil',text:'<?= esc(session()->getFlashdata('success')) ?>'});</script>
  
  <?php endif; if(session()->getFlashdata('error')): ?>
  <script>Swal.fire({icon:'error',title:'Gagal',text:'<?= esc(session()->getFlashdata('error')) ?>'});</script>
  <?php endif; ?>
  
</body>
</html>
