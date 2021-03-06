<?php

class m150820_092420_create_tenant_agent_table extends CDbMigration
{

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {

        $table = Yii::app()->db->schema->getTable('tenant_agent');
        if(!isset($table)) {
            $this->createTable('tenant_agent',array(
                'id'          => 'BIGINT NOT NULL',
                'user_id'     => 'BIGINT NULL',
                'tenant_id'   => 'BIGINT NOT NULL',
                'for_module'  => 'VARCHAR(20)',
                'tenant_id'   => 'BIGINT NOT NULL',
                'is_deleted'  => 'BIT',
                'created_by'  => 'BIGINT',
                'date_created'=> 'DATETIME'

            ));
            $this->addPrimaryKey("PK_tenant_agent",'tenant_agent','id');
            $this->addForeignKey('fk_tenant_agent_company1','tenant_agent','id','company','id');
            $this->addForeignKey('fk_tenant_agent_tenant1','tenant_agent','tenant_id','tenant','id');

//            $this->execute("CREATE TABLE tenant_agent (
//                           id BIGINT NOT NULL,
//                           user_id BIGINT,
//                           tenant_id BIGINT,
//                           for_module VARCHAR(20),
//                           is_deleted BIGINT,
//                           created_by BIGINT,
//                           date_created DATETIME,
//                           PRIMARY KEY (id, user_id, tenant_id),
//
//                            CONSTRAINT fk_tenant_agent_company1
//                            FOREIGN KEY (id)
//                            REFERENCES company (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
//
//                            CONSTRAINT fk_tenant_agent_tenant1
//                            FOREIGN KEY (tenant_id)
//                            REFERENCES tenant (id) ON DELETE NO ACTION ON UPDATE NO ACTION
//
//                           )
//                        ");
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