<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_users_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
			'name' => ['type' => 'VARCHAR', 'constraint' => 100],
			'username' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
			'email' => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
			'password' => ['type' => 'VARCHAR', 'constraint' => 200],
			'avatar' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
			'status' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'ACTIVATED'],
			'about' => ['type' => 'TEXT', 'null' => true],
			'last_logged_in' => ['type' => 'DATETIME', 'null' => true],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->forge->addField("`updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");
		$this->forge->addField("`deleted_at` TIMESTAMP NULL DEFAULT NULL");

		$this->forge->addPrimaryKey('id');
		$this->forge->addKey('name');

		$this->forge->createTable('users', true);
	}

	public function down()
	{
		$this->forge->dropTable('users', true);
	}
}
