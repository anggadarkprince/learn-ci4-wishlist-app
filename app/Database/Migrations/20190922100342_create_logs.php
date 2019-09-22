<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_logs_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
			'event_access' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE],
			'event_type' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE],
			'data' => ['type' => 'TEXT', 'null' => TRUE],
			'created_by' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'null' => TRUE],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('logs', true);
	}

	public function down()
	{
		$this->forge->dropTable('logs', true);
	}
}
