<?php

class m150710_095702_add_module_allowed_field_in_user extends CDbMigration
{
       // Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->addColumn('user', 'allowed_module', 'INTEGER');
	}

	public function safeDown()
	{
             $this->dropColumn('user', 'allowed_module');
	}
	 
}