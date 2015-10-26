<?php

class m151011_143900_fix_tenant_agent_constraint_on_user_table extends CDbMigration
{
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('user','tenant_agent','user','id');
<<<<<<< HEAD
		if($name!=null){
			$this->dropForeignKey($name,'user');
		}

=======
		if($name!=null) {
			$this->dropForeignKey($name, 'user');
		}
>>>>>>> a76d7ed767c717fc46eeb41e49743b312e2466c1

	}

	public function safeDown()
	{

	}

}