<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_whishlists_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
			'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'whish' => ['type' => 'VARCHAR', 'constraint' => 100],
			'description' => ['type' => 'TEXT', 'null' => true],
			'target' => ['type' => 'DATE', 'null' => true],
			'progress' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
			'is_private' => ['type' => 'BOOLEAN', 'default' => false],
			'is_completed' => ['type' => 'BOOLEAN', 'default' => false],
			'completed_at' => ['type' => 'DATE', 'null' => true],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->forge->addField("`updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");
		$this->forge->addField("`deleted_at` TIMESTAMP NULL DEFAULT NULL");

		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addPrimaryKey('id');
		$this->forge->addKey('whish');

		$this->forge->createTable('whishlists', true);
	}

	public function down()
	{
		$this->forge->dropTable('whishlists', true);
	}
}
