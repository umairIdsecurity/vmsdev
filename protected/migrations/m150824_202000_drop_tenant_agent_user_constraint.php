<?php

class m150824_202000_drop_tenant_agent_user_constraint extends CDbMigration
{
	 

	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$fkName = ForeignKeyHelper::getForeignKeyName('user','tenant_agent','user','id');
		if(isset($fkName) && $fkName!='') {
			$this->dropForeignKey($fkName, 'user');
		}
		$this->execute('update "user" set tenant_agent = NULL where id = 1');
        $this->addForeignKey('user_tenant_agent_fk','user','tenant_agent','tenant_agent','id');

	}

	public function safeDown()
	{
        $this->addForeignKey('user_ibfk_7','user','tenant_agent','user','id');
        $this->dropForeignKey('user_tenant_agent_fk','user');
	}
	 
}