<?php

class m160107_061610_create_tenant_default_card_type_column extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('company','tenant_default_card_type','VARCHAR(30) DEFAULT NULL');
	}

	public function safeDown()
	{
		$this->dropColumn('company','tenant_default_card_type');
	}
	
}