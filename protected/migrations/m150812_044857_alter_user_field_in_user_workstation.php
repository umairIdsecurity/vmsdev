<?php

class m150812_044857_alter_user_field_in_user_workstation extends CDbMigration
{
	 
// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
			$fk = ForeignKeyHelper::getForeignKeyName('user_workstation','user','user','id');
			if($fk) {
				$this->dropForeignKey($fk, 'user_workstation');
			}
            $this->renameColumn("user_workstation", "user", "user_id");
            $this->addForeignKey("user_workstation_ibfk_3", "user_workstation", "user_id", "user", "id", null, null);
	}

	public function safeDown()
	{
	}
	 
}