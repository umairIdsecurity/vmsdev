<?php

class m151011_153600_fix_tenant_agent_constraint_on_visit_reason_table extends CDbMigration
{
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('visit_reason','tenant_agent','user','id');
		$this->dropForeignKey($name,'visit_reason');




	}

	public function safeDown()
	{

	}

}