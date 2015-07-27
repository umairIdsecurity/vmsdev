<?php

class m150725_233300_add_visitor_type_card_is_deleted extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn("visitor_type_card_type","is_deleted","BIT DEFAULT 0");

	}

	public function safeDown()
	{
		$this->dropColumn("visitor_type_card_type","is_deleted");

	}

}