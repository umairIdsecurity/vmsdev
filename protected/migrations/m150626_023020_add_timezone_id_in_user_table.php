<?php

class m150626_023020_add_timezone_id_in_user_table extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('user', 'timezone_id','bigint(20) NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'timezone_id');
    }
}