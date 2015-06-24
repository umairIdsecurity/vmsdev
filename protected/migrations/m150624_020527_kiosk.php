<?php

class m150624_020527_kiosk extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('cvms_kiosk', array(
            'id' => 'pk',
            'workstation' => 'INTEGER (11) NOT NULL',
            'module' => 'VARCHAR (255) NOT NULL',
            'username' => 'VARCHAR (255) NOT NULL',
            'password' => 'VARCHAR (255) NOT NULL',
            'tenant'=>'INTEGER (11) NOT NULL',
            'tenant_agent'=>'INTEGER (11) NOT NULL',
            'created_by' =>'INTEGER (11) NOT NULL',
            'is_deleted'=>'TINYINT (1) NOT NULL',
            'enabled'=>'TINYINT (1) NOT NULL',
        ));
    }

    public function safeDown()
    {
        $this->execute("
            DROP TABLE IF EXISTS cvms_kiosk;
            ");
    }


}