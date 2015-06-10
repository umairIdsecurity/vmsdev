<?php

class m150604_083620_alter_tenant_add_is_deleted extends CDbMigration {
	
    public function up() {
		$this->addColumn('tenant', 'is_deleted', 'tinyint(1) DEFAULT 0');
    }
}