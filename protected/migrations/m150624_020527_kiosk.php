<?php

class m150624_020527_kiosk extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('cvms_kiosk', array(
            'id' => 'pk',
            'workstation' => 'BIGINT NOT NULL',
            'module' => 'VARCHAR(30) NOT NULL',
            'username' => 'VARCHAR(20) NOT NULL',
            'password' => 'VARCHAR(30) NOT NULL',
            'tenant'=>'BIGINT NOT NULL',
            'tenant_agent'=>'BIGINT NOT NULL',
            'created_by' =>'BIGINT NOT NULL',
            'is_deleted'=>'BIT NOT NULL',
            'enabled'=>'BIT NOT NULL',
        ));
    }

    public function safeDown()
    {
        $this->execute("
            DROP TABLE IF EXISTS cvms_kiosk;
            ");
    }


}