<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_whishlist_details_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => TRUE],
			'whishlist_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'detail' => ['type' => 'TEXT'],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->forge->addField("`updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP");
		
		$this->forge->addForeignKey('whishlist_id', 'whishlists', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addPrimaryKey('id');
		
		$this->forge->createTable('whishlist_details', true);
	}

	public function down()
	{
		$this->forge->dropTable('whishlist_details', true);
	}
}
