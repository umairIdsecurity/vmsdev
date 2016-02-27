<?php

class m151115_210501_fix_tenant_agent_constraint_on_visitor_table extends CDbMigration
{
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('visitor','tenant_agent','user','id');

		if($name!=null){
			$this->dropForeignKey($name,'visitor');
		}

	}

	public function safeDown()
	{

	}

}