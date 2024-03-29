<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_wishlist_categories_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'category_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'wishlist_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

		$this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('wishlist_id', 'wishlists', 'id', 'CASCADE', 'CASCADE');

		$this->forge->createTable('wishlist_categories', true);
	}

	public function down()
	{
		$this->forge->dropTable('wishlist_categories', true);
	}
}
