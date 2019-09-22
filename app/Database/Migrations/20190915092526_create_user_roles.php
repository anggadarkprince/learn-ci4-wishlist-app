<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_user_roles_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'role_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');

		$this->forge->createTable('user_roles', true);
	}

	public function down()
	{
		$this->forge->dropTable('user_roles', true);
	}
}
