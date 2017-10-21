<?php

class m150504_111234_AddAsicNoToUsers extends CDbMigration
{
	public function safeUp()
	{
        $this->addColumn('user','asic_no','integer');
	}

	public function safeDown()
	{
		$this->dropColumn('user','asic_no');
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