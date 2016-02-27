<?php

class m151009_042040_change_contact_support_person extends CDbMigration
{
	public function safeUp()
	{
		// add user_role and reason_id to contact_person
		if(!in_array('user_role',$this->dbConnection->getSchema()->getTable('contact_person')->columnNames)) {
			$this->addColumn("contact_person", "user_role", "TINYINT NULL");
		}
		if(!in_array('reason_id',$this->dbConnection->getSchema()->getTable('contact_person')->columnNames)) {
			$this->addColumn("contact_person", "reason_id", "BIGINT NULL");
		}

		// remove contact person message
		if(in_array('contact_person_message',$this->dbConnection->getSchema()->getTable('contact_person')->columnNames)) {
			$this->dropColumn("contact_person", "contact_person_message");
		}
		// add contact support table
		if(!in_array('contact_support',$this->dbConnection->getSchema()->tableNames)) {
			$this->createTable("contact_support", array(
				'id' => 'pk',
				'contact_person_id' => 'BIGINT NULL',
				'contact_reason_id' => 'BIGINT NULL',
				'user_id' => 'BIGINT NULL',
				'contact_message' => 'VARCHAR(100) NULL',
				'date_created' => 'DATETIME NOT NULL'
			));
		}
	}

	public function safeDown()
	{
		$this->dropColumn("contact_person", "user_role");
		$this->dropColumn("contact_person", "reason_id");
		$this->addColumn("contact_person", "contact_person_message", "VARCHAR(100) NULL");
		$this->dropTable("contact_support");
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