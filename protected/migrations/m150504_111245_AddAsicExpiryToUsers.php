<?php

class m150504_111245_AddAsicExpiryToUsers extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('user','asic_expiry','integer');
	}

	public function safeDown()
	{
        $this->dropColumn('user','asic_expiry');
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