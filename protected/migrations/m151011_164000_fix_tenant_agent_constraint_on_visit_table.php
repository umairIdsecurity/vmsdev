<?php

class m151011_164000_fix_tenant_agent_constraint_on_visit_table extends CDbMigration
{
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('visit', 'tenant_agent', 'user', 'id');
		if($name!=null) {
			$this->dropForeignKey($name, 'visit');
		}
		$name = DatabaseIndexHelper::getForeignKeyName('visit', 'tenant_agent', 'user', 'id');
		if($name!=null) {
			$this->dropForeignKey($name, 'visit');
		}

	}

	public function safeDown()
	{

	}

}