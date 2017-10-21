<?php

class m151115_223100_fix_tenant_agent_constraint_on_card_generated_table extends CDbMigration
{
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('card_generated','tenant_agent','user','id');

		if($name!=null){
			$this->dropForeignKey($name,'card_generated');
		}

	}

	public function safeDown()
	{

	}

}