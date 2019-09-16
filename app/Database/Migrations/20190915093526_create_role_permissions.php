<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_role_permissions_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'role_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'permission_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		
		$this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('permission_id', 'permissions', 'id', 'CASCADE', 'CASCADE');

		$this->forge->createTable('role_permissions', true);
	}

	public function down()
	{
		$this->forge->dropTable('role_permissions', true);
	}
}
