<?php

class m150821_114547_create_tenant_agent_contact extends CDbMigration
{
	 

	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $table = Yii::app()->db->schema->getTable('tenant_agent_contact');
            if(!isset($table)) {

                $this->createTable('tenant_agent_contact', array(
                    'id' => 'pk',
                    'user_id' => 'BIGINT NULL',
                    'tenant_id' => 'BIGINT NOT NULL',
                    'tenant_agent_id' => 'BIGINT NOT NULL',
                ));
                $this->addForeignKey('fk_tenant_agent_contact_id',
                                    'tenant_agent_contact','tenant_agent_id',
                                    'tenant_agent','id');
                $this->addForeignKey('fk_tenant_agent_contact_tenant1',
                                    'tenant_agent_contact','tenant_id',
                                    'tenant','id');

//            $this->execute("CREATE TABLE tenant_agent_contact (
//                           id BIGINT AUTO_INCREMENT NOT NULL,
//                           user_id BIGINT NULL,
//                           tenant_id BIGINT NULL,
//                           tenant_agent_id BIGINT NULL,
//                           PRIMARY KEY (id),
//
//                            CONSTRAINT fk_tenant_agent_contact_id
//                            FOREIGN KEY (tenant_agent_id)
//                            REFERENCES tenant_agent (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
//
//                            CONSTRAINT fk_tenant_agent_contact_tenant1
//                            FOREIGN KEY (tenant_id)
//                            REFERENCES tenant (id) ON DELETE NO ACTION ON UPDATE NO ACTION
//
//                           )
//                        ");
            }
	}

	public function safeDown()
	{
            $table = Yii::app()->db->schema->getTable('tenant_agent_contact');
            if(isset($table)) {
                $this->execute("DROP TABLE tenant_agent_contact");
            }
	}
	 
}