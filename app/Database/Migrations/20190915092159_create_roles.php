<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_roles_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
			'role' => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
			'description' => ['type' => 'TEXT', 'null' => true]
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->forge->addField("`updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");
		$this->forge->addField("`deleted_at` TIMESTAMP NULL DEFAULT NULL");

		$this->forge->addPrimaryKey('id');
		
		$this->forge->createTable('roles', true);
	}

	public function down()
	{
		$this->forge->dropTable('roles', true);
	}
}
