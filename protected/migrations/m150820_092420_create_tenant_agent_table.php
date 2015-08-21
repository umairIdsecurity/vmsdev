<?php

class m150820_092420_create_tenant_agent_table extends CDbMigration
{
	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
             
            $table = Yii::app()->db->schema->getTable('tenant_agent');
            if(!isset($table)) {
            $this->execute("CREATE TABLE tenant_agent (
                           id BIGINT(20) NOT NULL,
                           user_id BIGINT(20),
                           tenant_id BIGINT(20),
                           for_module VARCHAR(20),
                           is_deleted BIGINT(20),
                           created_by BIGINT(20),
                           date_created datetime NULL,
                           PRIMARY KEY (id, user_id, tenant_id),
                           
                            CONSTRAINT fk_tenant_agent_company1
                            FOREIGN KEY (id)
                            REFERENCES company (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
                                                       
                            CONSTRAINT fk_tenant_agent_tenant1
                            FOREIGN KEY (tenant_id)
                            REFERENCES tenant (id) ON DELETE NO ACTION ON UPDATE NO ACTION
                            
                           )
                        ");
            }
	}

	public function safeDown()
	{
            $table = Yii::app()->db->schema->getTable('tenant_agent');
            if(isset($table)) {
                $this->execute("DROP TABLE tenant_agent");
            }
	}
	 
}