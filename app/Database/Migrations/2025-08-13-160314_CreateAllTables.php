<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAllTables extends Migration
{
    public function up()
    {
        // users
        $this->forge->addField([
            'id'            => ['type'=>'INT','auto_increment'=>true],
            'role'          => ['type'=>'ENUM','constraint'=>['admin','user'],'default'=>'user'],
            'full_name'     => ['type'=>'VARCHAR','constraint'=>191,'null'=>true],
            'email'         => ['type'=>'VARCHAR','constraint'=>191],
            'phone'         => ['type'=>'VARCHAR','constraint'=>20,'null'=>true],
            'password_hash' => ['type'=>'VARCHAR','constraint'=>255],
            'active'        => ['type'=>'TINYINT','default'=>1],
            'last_login'    => ['type'=>'DATETIME','null'=>true],
            'created_at'    => ['type'=>'DATETIME','null'=>true],
            'updated_at'    => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('phone');
        $this->forge->createTable('users');

        // customers (detail profil untuk checkout)
        $this->forge->addField([
            'id'        => ['type'=>'INT','auto_increment'=>true],
            'user_id'   => ['type'=>'INT'],
            'nik'       => ['type'=>'VARCHAR','constraint'=>32],
            'full_name' => ['type'=>'VARCHAR','constraint'=>191],
            'email'     => ['type'=>'VARCHAR','constraint'=>191],
            'phone'     => ['type'=>'VARCHAR','constraint'=>20],
            'address'   => ['type'=>'TEXT','null'=>true],
            'created_at'=> ['type'=>'DATETIME','null'=>true],
            'updated_at'=> ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nik');
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('phone');
        $this->forge->createTable('customers');

        // categories
        $this->forge->addField([
            'id'        => ['type'=>'INT','auto_increment'=>true],
            'slug'      => ['type'=>'VARCHAR','constraint'=>128],
            'name'      => ['type'=>'VARCHAR','constraint'=>128],
            'created_at'=> ['type'=>'DATETIME','null'=>true],
            'updated_at'=> ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('categories');

        // products
        $this->forge->addField([
            'id'             => ['type'=>'INT','auto_increment'=>true],
            'sku'            => ['type'=>'VARCHAR','constraint'=>64],
            'slug'           => ['type'=>'VARCHAR','constraint'=>191],
            'name'           => ['type'=>'VARCHAR','constraint'=>191],
            'category_id'    => ['type'=>'INT'],
            'size'           => ['type'=>'VARCHAR','constraint'=>32,'null'=>true], // S, M, L, XL dst
            'color'          => ['type'=>'VARCHAR','constraint'=>64,'null'=>true],
            'price_per_day'  => ['type'=>'INT','default'=>0],
            'stock'          => ['type'=>'INT','default'=>0],
            'images'         => ['type'=>'TEXT','null'=>true], // JSON
            'is_active'      => ['type'=>'TINYINT','default'=>1],
            'meta_title'     => ['type'=>'VARCHAR','constraint'=>191,'null'=>true],
            'meta_desc'      => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'created_at'     => ['type'=>'DATETIME','null'=>true],
            'updated_at'     => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('sku');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('name');
        $this->forge->addKey('size');
        $this->forge->addKey('price_per_day');
        $this->forge->createTable('products');

        // rentals (transaksi)
        $this->forge->addField([
            'id'            => ['type'=>'INT','auto_increment'=>true],
            'user_id'       => ['type'=>'INT'],
            'code'          => ['type'=>'VARCHAR','constraint'=>32], // INV...
            'status'        => ['type'=>'ENUM','constraint'=>['pending','aktif','batal','selesai'],'default'=>'pending'],
            'start_date'    => ['type'=>'DATE','null'=>true],
            'end_date'      => ['type'=>'DATE','null'=>true],
            'due_date'      => ['type'=>'DATE','null'=>true],
            'returned_at'   => ['type'=>'DATETIME','null'=>true],
            'queued_at'     => ['type'=>'DATETIME','null'=>true],
            'confirmed_at'  => ['type'=>'DATETIME','null'=>true],
            'canceled_at'   => ['type'=>'DATETIME','null'=>true],
            'notes'         => ['type'=>'TEXT','null'=>true],
            'wa_payload'    => ['type'=>'TEXT','null'=>true],
            'created_at'    => ['type'=>'DATETIME','null'=>true],
            'updated_at'    => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('status');
        $this->forge->addKey('queued_at');
        $this->forge->createTable('rentals');

        // rental_items
        $this->forge->addField([
            'id'                   => ['type'=>'INT','auto_increment'=>true],
            'rental_id'            => ['type'=>'INT'],
            'product_id'           => ['type'=>'INT'],
            'qty'                  => ['type'=>'INT','default'=>1],
            'daily_price_snapshot' => ['type'=>'INT','default'=>0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['rental_id','product_id']);
        $this->forge->createTable('rental_items');

        // fines
        $this->forge->addField([
            'id'         => ['type'=>'INT','auto_increment'=>true],
            'rental_id'  => ['type'=>'INT'],
            'type'       => ['type'=>'ENUM','constraint'=>['late','damage']],
            'amount'     => ['type'=>'INT','default'=>0],
            'note'       => ['type'=>'VARCHAR','constraint'=>191,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('rental_id');
        $this->forge->createTable('fines');

        // walkins
        $this->forge->addField([
            'id'           => ['type'=>'INT','auto_increment'=>true],
            'admin_id'     => ['type'=>'INT','null'=>true],
            'customer_name'=> ['type'=>'VARCHAR','constraint'=>191],
            'phone'        => ['type'=>'VARCHAR','constraint'=>20,'null'=>true],
            'note'         => ['type'=>'TEXT','null'=>true],
            'created_at'   => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('walkins');

        // carts
        $this->forge->addField([
            'id'         => ['type'=>'INT','auto_increment'=>true],
            'user_id'    => ['type'=>'INT'],
            'payload'    => ['type'=>'TEXT'], // JSON [{product_id, name, price, qty}]
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('carts');

        // password_resets (sederhana)
        $this->forge->addField([
            'id'        => ['type'=>'INT','auto_increment'=>true],
            'email'     => ['type'=>'VARCHAR','constraint'=>191],
            'token'     => ['type'=>'VARCHAR','constraint'=>128],
            'created_at'=> ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->addKey('token');
        $this->forge->createTable('password_resets');

        // Foreign keys (gunakan raw SQL agar ringkas)
        $db = \Config\Database::connect();
        $db->query('ALTER TABLE customers ADD CONSTRAINT fk_customers_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $db->query('ALTER TABLE products ADD CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT');
        $db->query('ALTER TABLE rentals ADD CONSTRAINT fk_rentals_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        $db->query('ALTER TABLE rental_items ADD CONSTRAINT fk_ri_rental FOREIGN KEY (rental_id) REFERENCES rentals(id) ON DELETE CASCADE');
        $db->query('ALTER TABLE rental_items ADD CONSTRAINT fk_ri_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT');
        $db->query('ALTER TABLE fines ADD CONSTRAINT fk_fines_rental FOREIGN KEY (rental_id) REFERENCES rentals(id) ON DELETE CASCADE');
        $db->query('ALTER TABLE walkins ADD CONSTRAINT fk_walkins_admin FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE SET NULL');
    }

    public function down()
    {
        $this->forge->dropTable('password_resets');
        $this->forge->dropTable('carts');
        $this->forge->dropTable('walkins');
        $this->forge->dropTable('fines');
        $this->forge->dropTable('rental_items');
        $this->forge->dropTable('rentals');
        $this->forge->dropTable('products');
        $this->forge->dropTable('categories');
        $this->forge->dropTable('customers');
        $this->forge->dropTable('users');
    }
}
