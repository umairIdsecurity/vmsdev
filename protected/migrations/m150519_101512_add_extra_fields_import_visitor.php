<?php

class m150519_101512_add_extra_fields_import_visitor extends CDbMigration
{
 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
             $this->addColumn('import_visitor','check_in_time','varchar(20)');
             $this->addColumn('import_visitor','check_out_time','varchar(20)');
             $this->addColumn('import_visitor','position','varchar(30)');
             $this->addColumn('import_visitor','date_printed','date');
             $this->addColumn('import_visitor','date_expiration','date');
             $this->addColumn('import_visitor','vehicle','varchar(50)');
             $this->addColumn('import_visitor','contact_number','varchar(40)');
               
	}

	public function safeDown()
	{
             $this->dropColumn('import_visitor','check_in_time');
             $this->dropColumn('import_visitor','check_out_time');
             $this->dropColumn('import_visitor','position');
             $this->dropColumn('import_visitor','date_printed');
             $this->dropColumn('import_visitor','date_expiration');
             $this->dropColumn('import_visitor','vehicle');
             $this->dropColumn('import_visitor','contact_number');
	}
	 
}