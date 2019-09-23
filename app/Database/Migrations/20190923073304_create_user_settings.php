<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_user_settings_table extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'setting_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'value' => ['type' => 'TEXT', 'null' => TRUE],
        ]);
        $this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('setting_id', 'settings', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('user_settings', true);
	}

	public function down()
	{
        $this->forge->dropTable('user_settings', true);
	}
}
