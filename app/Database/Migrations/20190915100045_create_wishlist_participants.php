<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_wishlist_participants_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
			'wishlist_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'is_confirmed' => ['type' => 'BOOLEAN', 'default' => false],
			'confirmed_at' => ['type' => 'DATE', 'null' => true],
			'description' => ['type' => 'TEXT', 'null' => true],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('wishlist_id', 'wishlists', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addPrimaryKey('id');

		$this->forge->createTable('wishlist_participants', true);
	}

	public function down()
	{
		$this->forge->dropTable('wishlist_participants', true);
	}
}
