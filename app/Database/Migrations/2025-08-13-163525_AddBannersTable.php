<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBannersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type'=>'INT','auto_increment'=>true],
            'title'       => ['type'=>'VARCHAR','constraint'=>191,'null'=>true],
            'subtitle'    => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'button_text' => ['type'=>'VARCHAR','constraint'=>64,'null'=>true],
            'button_link' => ['type'=>'VARCHAR','constraint'=>191,'null'=>true],
            'image_url'   => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'is_active'   => ['type'=>'TINYINT','default'=>1],
            'sort_order'  => ['type'=>'INT','default'=>0],
            'created_at'  => ['type'=>'DATETIME','null'=>true],
            'updated_at'  => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('is_active');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('banners');
    }

    public function down()
    {
        $this->forge->dropTable('banners');
    }
}
