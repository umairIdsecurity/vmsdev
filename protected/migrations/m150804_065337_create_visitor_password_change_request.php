<?php

class m150804_065337_create_visitor_password_change_request extends CDbMigration
{
	public function safeUp()
	{

		$this->createTable('visitor_password_change_request', array(
			'id' => 'pk',
			'visitor_id' => 'BIGINT NOT NULL',
			'hash' => 'VARCHAR(255) NOT NULL',
			'created_at' => 'DATETIME NOT NULL',
			'is_used' => 'BIT'
		));

		$this->addForeignKey('visitor_password_change_request_visitor_id', 'visitor_password_change_request', 'visitor_id', 'visitor', 'id');

	}

	public function safeDown()
	{
		$this->dropTable('visitor_password_change_request');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}