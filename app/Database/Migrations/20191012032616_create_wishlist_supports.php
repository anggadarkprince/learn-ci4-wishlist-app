<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_wishlist_supports extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
            'wishlist_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('wishlist_id', 'wishlists', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('wishlist_supports', true);
	}

	public function down()
	{
        $this->forge->dropTable('wishlist_supports', true);
	}
}
