<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_whishlist_participants_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
			'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'is_confirmed' => ['type' => 'BOOLEAN', 'default' => false],
			'comfirmed_at' => ['type' => 'DATE', 'null' => true],
			'description' => ['type' => 'TEXT', 'null' => true],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		
		$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addPrimaryKey('id');

		$this->forge->createTable('whishlist_participants', true);
	}

	public function down()
	{
		$this->forge->dropTable('whishlist_participants', true);
	}
}
