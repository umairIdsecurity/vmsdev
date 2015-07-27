<?php

class m150728_073500_add_id_to_visitor_type_card_type extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addPrimaryKey("vtct_pk","visitor_type_card_type","visitor_type,card_type");
	}

	public function safeDown()
	{
		$this->dropPrimaryKey("vtct_pk","visitor_type_card_type");
	}

}