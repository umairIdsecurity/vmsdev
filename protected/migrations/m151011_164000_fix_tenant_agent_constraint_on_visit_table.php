<?php

class m151011_164000_fix_tenant_agent_constraint_on_visit_table extends CDbMigration
{
	public function safeUp()
	{
<<<<<<< HEAD
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
=======
		$name = DatabaseIndexHelper::getForeignKeyName('visit', 'tenant_agent', 'user', 'id');
		if($name!=null) {
			$this->dropForeignKey($name, 'visit');
		}
		$name = DatabaseIndexHelper::getForeignKeyName('visitor','tenant_agent','user','id');
		if($name!=null) {
			$this->dropForeignKey($name, 'visitor');
		}

>>>>>>> a76d7ed767c717fc46eeb41e49743b312e2466c1


	}

	public function safeDown()
	{

	}

}