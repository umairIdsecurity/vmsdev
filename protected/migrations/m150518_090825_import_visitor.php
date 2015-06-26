<?php

class m150518_090825_import_visitor extends CDbMigration
{
	public function safeUp()
	{
             $this->createTable('import_visitor', array(
            'id' => 'pk',
            'card_code' => 'string',     
            'first_name' => 'string NOT NULL',
            'last_name' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'company'=>'string NOT NULL',
            'check_in_date'=>'date',
            'check_out_date'=>'date',
            'imported_by'=>'integer',
            'import_date'=>'date',     
                 
        ));
	}

	public function safeDown()
	{
	  $this->execute("
            DROP TABLE IF EXISTS import_visitor;
            ");
	}

	 
}