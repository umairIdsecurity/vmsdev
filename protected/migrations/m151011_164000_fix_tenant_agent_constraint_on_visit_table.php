<?php

class m151011_164000_fix_tenant_agent_constraint_on_visit_table extends CDbMigration
{
	public function safeUp()
	{
		//$transaction = $this->dbConnection->beginTransaction();
		try {
			$name = DatabaseIndexHelper::getForeignKeyName('visit', 'tenant_agent', 'user', 'id');

			if($name!=null) {
				$this->dropForeignKey($name, 'visit');
			}

			$name = DatabaseIndexHelper::getForeignKeyName('visitor','tenant_agent','user','id');
			if($name!=null) {
				$this->dropForeignKey($name, 'visitor');
			}

		//	$transaction->commit();

		} catch (CDbException $ex){
		//	$transaction->rollback();
		}

	}

	public function safeDown()
	{

	}

}