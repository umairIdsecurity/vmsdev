<?php

class m150515_055942_add_default_value_to_visitor_type_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->addColumn('visitor_type','is_default_value','integer DEFAULT 0');
	}

	public function safeDown()
	{
            $this->dropColumn('visitor_type','is_default_value');
	}
	 
}