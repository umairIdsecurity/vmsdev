<?php

class m150520_091128_create_import_host extends CDbMigration
{
        // Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->createTable("import_hosts", array(
            'id' => 'pk',
            'first_name' => 'VARCHAR (50) NOT NULL',     
            'last_name' => 'VARCHAR (50) NOT NULL',
            'email' => 'VARCHAR (255) NOT NULL',
            'department' => 'VARCHAR (50) NOT NULL',
            'staff_id'=>'VARCHAR (50) NOT NULL',
            'contact_number'=>'VARCHAR (50) NOT NULL',
            'company'=>'VARCHAR (50) NOT NULL',
            'imported_by'=>'INTEGER',
            'date_imported'=>'DATE',
            'password'=>'VARCHAR (50) NOT NULL',
            'role'=>'INTEGER',
            'position'=>'VARCHAR (50)',
            'date_of_birth'=>'DATE',    
        ));
	}

	public function safeDown()
	{
            $this->dropTable("import_hosts");
	}
	 
}