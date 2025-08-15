<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-extrabold mb-6 text-neutral-900 dark:text-white">Keranjang Belanja</h1>
<div class="max-w-3xl mx-auto">
    <?php if(!$cart): ?>
        <div class="text-center p-12 bg-white dark:bg-neutral-800 rounded-3xl shadow-xl border border-gold/20">
            <p class="text-xl font-medium text-neutral-600 dark:text-neutral-300">Keranjang Anda masih kosong.</p>
            <p class="mt-2 text-neutral-500 dark:text-neutral-400">Ayo, cari produk yang kamu inginkan dan mulai belanja!</p>
            <a href="/produk" class="inline-block mt-6 px-6 py-3 bg-gold text-white font-semibold rounded-full shadow-lg hover:bg-yellow-600 transition-colors duration-200">
                Lihat Semua Produk
            </a>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php $subtotal=0; foreach($cart as $c): $subtotal += $c['price']*$c['qty']; ?>
            <div class="flex items-center justify-between p-4 bg-white dark:bg-neutral-800 rounded-2xl shadow-md border border-gold/20">
                <div class="flex-1">
                    <div class="font-bold text-lg text-neutral-900 dark:text-white"><?= esc($c['name']) ?></div>
                    <div class="text-sm mt-1 text-neutral-600 dark:text-neutral-300">
                        Rp<?= number_format($c['price'],0,',','.') ?>/hari &times; <?= $c['qty'] ?> barang
                    </div>
                </div>
                
                <form method="post" action="/cart/remove">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= esc($c['product_id']) ?>">
                    <button class="flex items-center gap-1 text-sm bg-neutral-100 dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2 rounded-lg shadow-sm hover:bg-red-500 hover:text-white transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-8 p-6 bg-white dark:bg-neutral-800 rounded-2xl shadow-xl border border-gold/20">
            <div class="flex justify-between items-center text-xl font-bold">
                <span class="text-neutral-900 dark:text-white">Subtotal/hari</span>
                <span class="text-gold">Rp<?= number_format($subtotal,0,',','.') ?></span>
            </div>
            
            <hr class="my-6 border-t border-neutral-200 dark:border-neutral-700">

            <div class="flex flex-col sm:flex-row gap-3">
                <form method="post" action="/cart/clear" class="w-full sm:w-auto flex-1">
                    <?= csrf_field() ?>
                    <button class="w-full flex items-center justify-center gap-2 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white border border-neutral-300 dark:border-neutral-600 px-6 py-3 rounded-xl font-semibold shadow-md hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-x"><path d="M4 19.5a2.5 2.5 0 0 1 5 0"/><path d="M13.75 6.25l-2.5 2.5m2.5 0l-2.5-2.5"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/><path d="M14 19.5a2.5 2.5 0 0 1 5 0"/><path d="M10 21h8"/></svg>
                        <span>Kosongkan</span>
                    </button>
                </form>
                
                <a href="<?= session('user_id') ? '/order/checkout' : '/auth/login' ?>" class="w-full sm:w-auto flex-1 text-center bg-gold text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:bg-yellow-600 transition-colors duration-200">
                    Lanjut Checkout
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>