<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_settings_table extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'setting' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE],
            'type' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE],
            'default' => ['type' => 'TEXT', 'null' => TRUE],
            'description' => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => TRUE],
        ]);
        $this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('setting');
        $this->forge->createTable('settings', true);
	}

	public function down()
	{
        $this->forge->dropTable('settings', true);
	}
}
