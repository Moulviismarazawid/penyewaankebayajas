<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeViews extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'make:views';
    protected $description = 'Generate folders & empty view files for Sewa Kebaya Jas Bandar Lampung.';
    protected $usage       = 'make:views [--force]';
    protected $options     = [
        '--force' => 'Overwrite existing files if they already exist.',
    ];

    public function run(array $params)
    {
        $force = CLI::getOption('force') ?? in_array('--force', $params, true);

        $base = APPPATH . 'Views' . DIRECTORY_SEPARATOR;
        $dirs = ['layouts','partials','products','cart','order','auth','admin'];

        // 1) Buat folder
        foreach ($dirs as $d) {
            $path = $base . $d;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
                CLI::write("DIR   : Views/{$d} (created)", 'green');
            } else {
                CLI::write("DIR   : Views/{$d} (exists)", 'yellow');
            }
        }

        // 2) Daftar file view yang dibutuhkan (sesuai rancangan di atas)
        $files = [
            // Layouts & Partials
            'layouts/master.php'        => $this->stub('Master layout (paste konten layout master dari jawaban sebelumnya)'),
            'layouts/admin.php'         => $this->stub('Admin layout (paste konten admin layout dari jawaban sebelumnya)'),
            'partials/navbar.php'       => $this->stub('Navbar partial (paste konten navbar)'),
            'partials/footer.php'       => $this->stub('Footer partial (paste konten footer)'),

            // Pages (Frontend)
            'home.php'                  => $this->stub('Home page (paste konten home)'),
            'products/index.php'        => $this->stub('Produk index (paste konten produk list & filter)'),
            'products/show.php'         => $this->stub('Produk detail (paste konten produk detail)'),
            'cart/index.php'            => $this->stub('Cart (paste konten keranjang)'),
            'order/checkout.php'        => $this->stub('Checkout (paste konten checkout)'),
            'order/history.php'         => $this->stub('Riwayat (paste konten riwayat)'),
            'about.php'                 => $this->stub('About (paste konten about)'),

            // Auth
            'auth/login.php'            => $this->stub('Auth login (paste konten login)'),
            'auth/register.php'         => $this->stub('Auth register (paste konten register)'),
            'auth/forgot.php'           => $this->stub('Auth forgot password (paste konten forgot)'),
            'auth/reset.php'            => $this->stub('Auth reset password (paste konten reset)'),

            // Admin pages
            'admin/dashboard.php'       => $this->stub('Admin Dashboard (paste konten dashboard)'),
            'admin/categories.php'      => $this->stub('Admin Kategori (paste konten kategori)'),
            'admin/products.php'        => $this->stub('Admin Produk (paste konten produk)'),
            'admin/rentals.php'         => $this->stub('Admin Rentals (paste konten rentals)'),
            'admin/fifo.php'            => $this->stub('Admin FIFO (paste konten FIFO)'),
            'admin/walkins.php'         => $this->stub('Admin Walk-ins (paste konten walk-ins)'),
            'admin/reports_income.php'  => $this->stub('Admin Laporan Pendapatan (paste konten laporan)'),
        ];

        // 3) Tulis file
        foreach ($files as $rel => $content) {
            $path = $base . $rel;
            if (is_file($path) && !$force) {
                CLI::write("SKIP  : Views/{$rel} (exists, use --force to overwrite)", 'yellow');
                continue;
            }
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0777, true);
            }
            file_put_contents($path, $content);
            CLI::write("FILE  : Views/{$rel} (created)", 'green');
        }

        // 4) Siapkan folder public/images
        $publicImages = FCPATH . 'images';
        if (!is_dir($publicImages)) {
            mkdir($publicImages, 0777, true);
            CLI::write('DIR   : public/images (created)', 'green');
        } else {
            CLI::write('DIR   : public/images (exists)', 'yellow');
        }

        CLI::write("\nSelesai ✅  — Semua folder & file view sudah dibuat.", 'light_green');
        CLI::write("Langkah berikut:\n 1) Paste isi view dari jawaban sebelumnya ke masing-masing file.\n 2) Jalankan: php spark serve\n", 'white');
    }

    private function stub(string $label): string
    {
        // Placeholder minimal (tidak menulis ulang kode view aslinya)
        $banner = "/**\n * $label\n * Proyek: Sewa Kebaya Jas Bandar Lampung (CI4)\n * Catatan: Tailwind CDN, Lucide, SweetAlert2\n * TODO: Paste konten view lengkap dari panduan sebelumnya.\n */";
        return <<<PHP
<?php
$banner

// Hanya placeholder. Silakan tempel konten view asli di sini.
?>
PHP;
    }
}
