<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class BannerSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('banners')->insert([
            'title'       => 'Sewa Kebaya & Jas Bandar Lampung',
            'subtitle'    => 'Koleksi lengkap, harga ramah, proses mudah.',
            'button_text' => 'Lihat Katalog',
            'button_link' => '/produk',
            'image_url'   => '/images/banner_default.jpg',
            'is_active'   => 1,
            'sort_order'  => 1,
            'created_at'  => Time::now(),
        ]);
    }
}
