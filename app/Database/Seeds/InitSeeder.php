<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class InitSeeder extends Seeder
{
    public function run()
    {
        // Admin
        $this->db->table('users')->insert([
            'role' => 'admin',
            'full_name' => 'Administrator',
            'email' => 'admin@sewakebaya.com',
            'phone' => '628123456789',
            'password_hash' => password_hash('Admin123!', PASSWORD_DEFAULT),
            'created_at' => Time::now(),
        ]);

        // Categories (kebaya, jas) – bisa ditambah via admin
        $this->db->table('categories')->insertBatch([
            ['slug'=>'kebaya','name'=>'Kebaya'],
            ['slug'=>'jas','name'=>'Jas'],
        ]);

        // Sample products
        $this->db->table('products')->insertBatch([
            [
                'sku'=>'KBY-001','slug'=>'kebaya-brokat-gold','name'=>'Kebaya Brokat Gold',
                'category_id'=>1,'size'=>'M','color'=>'Gold','price_per_day'=>75000,'stock'=>3,
                'images'=>json_encode(['/images/kebaya1.jpg']),
                'meta_title'=>'Sewa Kebaya Brokat Gold Bandar Lampung',
                'meta_desc'=>'Sewa kebaya brokat warna emas, elegan untuk resepsi & wisuda.',
            ],
            [
                'sku'=>'JAS-001','slug'=>'jas-hitam-slimfit','name'=>'Jas Hitam Slimfit',
                'category_id'=>2,'size'=>'L','color'=>'Hitam','price_per_day'=>90000,'stock'=>2,
                'images'=>json_encode(['/images/jas1.jpg']),
                'meta_title'=>'Sewa Jas Hitam Slimfit Bandar Lampung',
                'meta_desc'=>'Sewa jas hitam slimfit formal & elegan.',
            ],
        ]);
    }
}
