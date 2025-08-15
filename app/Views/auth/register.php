<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<section class="max-w-md mx-auto">
    <div class="border border-gold/30 rounded-2xl p-8 bg-white dark:bg-neutral-800 shadow-xl">

        <div class="flex items-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus text-gold">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>
            </svg>
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Daftar Akun</h1>
        </div>
        
        <?php if(session()->getFlashdata('errors')): ?>
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
            <ul>
                <?php foreach(session('errors') as $error): ?>
                    <li>- <?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <form method="post" action="/auth/register" class="space-y-4">
            <?= csrf_field() ?>
            <label class="block">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Nama Lengkap</span>
                <input class="mt-1 w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors"
                       name="full_name" placeholder="Nama Lengkap" value="<?= old('full_name') ?>" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Email</span>
                <input class="mt-1 w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors"
                       name="email" placeholder="Alamat Email" value="<?= old('email') ?>" required>
            </label>
            <label class="block">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Nomor WhatsApp</span>
                <input class="mt-1 w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors"
                       name="phone" placeholder="Contoh: 08123456789" value="<?= old('phone') ?>" required>
            </label>

            <label x-data="{ show: false }" class="block">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Password</span>
                <div class="relative">
                    <input class="mt-1 w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors"
                           :type="show ? 'text' : 'password'" name="password" placeholder="Password" required>
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-500 hover:text-gold transition-colors">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-10-7-10-7a1.8 1.8 0 0 1 2.22-2.58M17.2 9.61a6 6 0 0 1-5.22 2.39"/><path d="M12 12v3"/><path d="M15.08 17.5a6.01 6.01 0 0 0 2.8-6.19"/><path d="M5.36 10.27a6.01 6.01 0 0 0 1.25 1.54"/><path d="M12 7V4"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </label>

            <label x-data="{ show: false }" class="block">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Konfirmasi Password</span>
                <div class="relative">
                    <input class="mt-1 w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors"
                           :type="show ? 'text' : 'password'" name="password_confirm" placeholder="Konfirmasi Password" required>
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-500 hover:text-gold transition-colors">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-10-7-10-7a1.8 1.8 0 0 1 2.22-2.58M17.2 9.61a6 6 0 0 1-5.22 2.39"/><path d="M12 12v3"/><path d="M15.08 17.5a6.01 6.01 0 0 0 2.8-6.19"/><path d="M5.36 10.27a6.01 6.01 0 0 0 1.25 1.54"/><path d="M12 7V4"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </label>

            <button type="submit" class="w-full bg-gold text-white font-bold px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">
                Daftar
            </button>
        </form>

        <div class="text-sm mt-4 text-center">
            <a class="hover:text-gold transition-colors" href="<?= site_url('auth/login') ?>">Sudah punya akun? Masuk</a>
        </div>
    </div>
</section>

<?= $this->endSection() ?>