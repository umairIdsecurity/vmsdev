<?php

class m151115_202600_fix_tenant_agent_constraint_on_company_table extends CDbMigration
{
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('company','tenant_agent','user','id');

		if($name!=null){
			$this->dropForeignKey($name,'company');
		}

	}

	public function safeDown()
	{

	}

}