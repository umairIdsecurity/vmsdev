<?php

class m150715_081616_change_mobile_number_datatype_in_company_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn('company', 'mobile_number', 'varchar(50) NULL');
	}

	public function safeDown()
	{
		$this->alterColumn('company', 'mobile_number', 'INT(20) NULL');
	}
}