<?php

class m150604_083620_alter_compnay_contactnno extends CDbMigration {
	
    public function up() {
		$this->alterColumn('company', 'office_number', 'VARCHAR(20) NULL DEFAULT NULL');
		$this->alterColumn('company', 'mobile_number', 'VARCHAR(20) NULL DEFAULT NULL');
    }
}