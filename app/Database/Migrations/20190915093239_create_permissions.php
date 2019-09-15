<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_permissions_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
			'permission' => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
			'description' => ['type' => 'TEXT', 'null' => true]
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

		$this->forge->addPrimaryKey('id');
		
		$this->forge->createTable('permissions', true);
	}

	public function down()
	{
		$this->forge->dropTable('permissions', true);
	}
}
