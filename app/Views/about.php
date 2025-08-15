<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto py-8">
    
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-extrabold text-neutral-900 dark:text-white leading-tight">
            Tentang <span class="text-gold">Kami</span>
        </h1>
        <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-300 max-w-2xl mx-auto">
            Kami hadir untuk membantu Anda tampil memukau di setiap momen spesial. Temukan koleksi kebaya dan jas terbaik di Bandar Lampung.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div class="order-2 md:order-1">
            <h2 class="text-3xl font-bold text-neutral-900 dark:text-white">
                Sempurnakan Setiap Momen Spesial Anda
            </h2>
            <p class="mt-4 text-base text-neutral-600 dark:text-neutral-300">
                Kami adalah penyedia layanan sewa kebaya dan jas terpercaya di Bandar Lampung. Dengan pengalaman bertahun-tahun, kami memahami bahwa setiap acara memiliki keunikan tersendiri. Oleh karena itu, kami menyediakan koleksi yang lengkap dan selalu mengikuti tren terbaru untuk memastikan Anda mendapatkan pilihan terbaik.
            </p>
            <p class="mt-4 text-base text-neutral-600 dark:text-neutral-300">
                Kami berkomitmen untuk memberikan pelayanan yang ramah dan profesional, mulai dari konsultasi pemilihan busana, penyesuaian ukuran, hingga proses sewa yang mudah dan cepat. Kepuasan Anda adalah prioritas kami.
            </p>
        </div>
        <div class="order-1 md:order-2">
            <div class="h-72 md:h-96 w-full rounded-3xl bg-neutral-200 dark:bg-neutral-800 shadow-xl overflow-hidden">
                <img src="https://images.unsplash.com/photo-1549429532-6804a11f5999?q=80&w=2942&auto=format&fit=crop" alt="Tim Kami" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
    
    <div class="bg-neutral-100 dark:bg-neutral-900 rounded-3xl p-8 md:p-12 mt-16 shadow-inner border border-gold/20">
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white">Misi Kami</h3>
                <p class="mt-3 text-neutral-600 dark:text-neutral-400">
                    Menyediakan pilihan busana sewa terbaik dengan harga terjangkau dan proses yang mudah, sehingga setiap pelanggan dapat tampil percaya diri dan elegan tanpa harus membeli.
                </p>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white">Nilai-Nilai Kami</h3>
                <ul class="mt-3 space-y-2 text-neutral-600 dark:text-neutral-400">
                    <li class="flex items-start gap-2">
                        <i data-lucide="gem" class="w-5 h-5 text-gold flex-shrink-0 mt-1"></i>
                        <span>**Kualitas**: Menjaga kualitas setiap busana agar tetap bersih dan terawat.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="smile" class="w-5 h-5 text-gold flex-shrink-0 mt-1"></i>
                        <span>**Pelayanan Prima**: Memberikan konsultasi yang ramah dan profesional.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="hand-heart" class="w-5 h-5 text-gold flex-shrink-0 mt-1"></i>
                        <span>**Kemudahan**: Memastikan proses sewa yang cepat dan transparan.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="text-center mt-16">
        <h3 class="text-3xl font-bold text-neutral-900 dark:text-white">Siap untuk Tampil Memukau?</h3>
        <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-300">
            Hubungi kami sekarang untuk mendapatkan konsultasi gratis dan jadwalkan sesi fitting Anda.
        </p>
        <a href="https://wa.me/nomor-whatsapp-anda" target="_blank" class="inline-flex items-center gap-2 mt-6 bg-green-500 text-white font-bold px-8 py-4 rounded-full shadow-lg hover:bg-green-600 transition-colors duration-200">
            <i data-lucide="message-circle" class="w-6 h-6"></i> Hubungi Kami via WhatsApp
        </a>
    </div>

</div>

<?= $this->endSection() ?>