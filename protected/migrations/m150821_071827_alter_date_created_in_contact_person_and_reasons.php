<?php

class m150821_071827_alter_date_created_in_contact_person_and_reasons extends CDbMigration
{
	public function safeUp()
	{
		$this->alterColumn("contact_person", "date_created", "date");
		$this->alterColumn("reasons", "date_created", "date");
	}

	public function safeDown()
	{
		$this->alterColumn("contact_person", "date_created", "timestamp");
		$this->alterColumn("reasons", "date_created", "timestamp");
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