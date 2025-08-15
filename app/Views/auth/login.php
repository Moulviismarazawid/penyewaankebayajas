<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<section class="max-w-md mx-auto">
    <div class="border border-gold/30 rounded-2xl p-8 bg-white dark:bg-neutral-800 shadow-xl">

        <div class="flex items-center gap-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in text-gold">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/>
            </svg>
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Masuk</h1>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 px-4 py-3 text-sm">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/login') ?>" class="space-y-4">
            <?= csrf_field() ?>

            <label class="block">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Email</span>
                <input
                    class="mt-1 w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors"
                    name="email" type="email" inputmode="email" autocomplete="email"
                    value="<?= old('email') ?>" required>
            </label>

            <label x-data="{ show: false }" class="block">
                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Password</span>
                <div class="relative">
                    <input
                        class="mt-1 w-full px-4 py-2 rounded-lg bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 focus:outline-none focus:ring-2 focus:ring-gold transition-colors"
                        :type="show ? 'text' : 'password'" name="password" autocomplete="current-password" required>
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-500 hover:text-gold transition-colors">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-10-7-10-7a1.8 1.8 0 0 1 2.22-2.58M17.2 9.61a6 6 0 0 1-5.22 2.39"/><path d="M12 12v3"/><path d="M15.08 17.5a6.01 6.01 0 0 0 2.8-6.19"/><path d="M5.36 10.27a6.01 6.01 0 0 0 1.25 1.54"/><path d="M12 7V4"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                    </button>
                </div>
            </label>

            <button type="submit" class="w-full bg-gold text-white font-bold px-4 py-2 rounded-lg shadow-md hover:bg-yellow-600 transition-colors">
                Masuk
            </button>
        </form>

        <div class="text-sm mt-4 text-center">
            <a class="hover:text-gold transition-colors" href="<?= site_url('auth/register') ?>">Buat akun baru</a>
            <span class="mx-2 text-neutral-400">|</span>
            <a class="hover:text-gold transition-colors" href="<?= site_url('auth/forgot') ?>">Lupa password?</a>
        </div>

        <div class="relative my-6">
            <hr class="border-neutral-200 dark:border-neutral-700">
            <span class="absolute left-1/2 -translate-x-1/2 -top-3 bg-white dark:bg-neutral-800 px-2 text-xs text-neutral-500">
                atau
            </span>
        </div>
        
        <a href="<?= base_url('auth/google') ?>"
           class="w-full inline-flex items-center justify-center gap-2 border border-neutral-300 dark:border-neutral-600 rounded-lg px-4 py-2 bg-neutral-50 dark:bg-neutral-900 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5">
                <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.6 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20c11.5 0 19.7-8.1 19.7-19.5 0-1.3-.1-2.2-.1-4z"/>
                <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.3 16.5 18.8 12 24 12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 15.5 4 8.2 8.9 6.3 14.7z"/>
                <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.5-5.3l-6.2-5.1C29.4 35.2 26.9 36 24 36c-5.3 0-9.7-3.4-11.3-8.1l-6.4 5C8.2 39.1 15.5 44 24 44z"/>
                <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.2-3.5 5.7-6.5 7.1l6.2 5.1C37.8 37.7 40 33.2 40 27.5c0-1.3-.1-2.2-.4-3z"/>
            </svg>
            <span class="font-medium">Masuk dengan Google</span>
        </a>
    </div>
</section>

<?= $this->endSection() ?>