<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_user_tokens_table extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'unsigned' => TRUE, 'constraint' => 11, 'auto_increment' => TRUE],
			'email' => ['type' => 'VARCHAR', 'constraint' => '50'],
			'token' => ['type' => 'VARCHAR', 'constraint' => '200'],
			'type' => ['type' => 'ENUM("REGISTRATION", "PASSWORD", "REMEMBER", "OTP", "AUTHORIZATION")', 'default' => 'REGISTRATION'],
			'max_activation' => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE],
			'expired_at' => ['type' => 'DATETIME', 'null' => TRUE],
		]);
		$this->forge->addField("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");

		$this->forge->addForeignKey('email', 'users', 'email', 'CASCADE', 'CASCADE');
		$this->forge->addPrimaryKey('id');
		$this->forge->addKey('token');

		$this->forge->createTable('user_tokens', true);
	}

	public function down()
	{
		$this->forge->dropTable('user_tokens', true);
	}
}
