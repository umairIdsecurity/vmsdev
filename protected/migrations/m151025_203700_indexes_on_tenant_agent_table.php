<?php

class m151025_203700_indexes_on_tenant_agent_table extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$name = DatabaseIndexHelper::getForeignKeyName('tenant_agent', 'user_id', 'user', 'id');
		if($name!=null) {
			$this->dropForeignKey($name, 'tenant_agent');
		}
        $name = DatabaseIndexHelper::getForeignKeyName('tenant_agent', 'id', 'company', 'id');
        if($name!=null) {
            $this->dropForeignKey($name, 'tenant_agent');
        }
        $name = DatabaseIndexHelper::getForeignKeyName('tenant_agent', 'tenant_id', 'tenant', 'id');
        if($name!=null) {
            $this->dropForeignKey($name, 'tenant_agent');
        }
        $name = DatabaseIndexHelper::getForeignKeyName('tenant_agent_contact', 'tenant_agent_id', 'tenant_agent', 'id');
        if($name!=null) {
            $this->dropForeignKey($name, 'tenant_agent_contact');
        }
        $name = DatabaseIndexHelper::getForeignKeyName('user', 'tenant_agent', 'tenant_agent', 'id');
        if($name!=null) {
            $this->dropForeignKey($name, 'user');
        }

        $this->alterColumn('tenant_agent','user_id','BIGINT NULL');

        $this->alterColumn('tenant_agent','id','BIGINT NOT NULL');
		$this->dropPrimaryKey('PRIMARY','tenant_agent');
        $this->addPrimaryKey('PRIMARY','tenant_agent','id');

        $this->addForeignKey('fk_tenant_agent_tenant','tenant_agent','tenant_id','tenant','id');
        //$this->addForeignKey('fk_tenant_agent_company_id','tenant_agent','id','customer','id');
        $this->addForeignKey('fk_tenant_agent_contact_id','tenant_agent_contact', 'tenant_agent_id', 'tenant_agent', 'id');
        $this->addForeignKey('user_tenant_agent_fk','user', 'tenant_agent', 'tenant_agent', 'id');

    }

	public function safeDown()
	{
	}
	
}