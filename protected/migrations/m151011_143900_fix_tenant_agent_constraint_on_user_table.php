<?php

class m151011_143900_fix_tenant_agent_constraint_on_user_table extends CDbMigration
{
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('user','tenant_agent','user','id');

		if($name!=null){
			$this->dropForeignKey($name,'user');
		}

	}

	public function safeDown()
	{

	}

}