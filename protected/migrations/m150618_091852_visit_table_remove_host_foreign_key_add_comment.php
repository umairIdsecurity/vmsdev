<?php

class m150618_091852_visit_table_remove_host_foreign_key_add_comment extends CDbMigration
{
    public function safeUp()
    {
        $this->dropForeignKey('visit_ibfk_6', 'visit');
    }

    public function safeDown()
    {
        $this->addForeignKey('visit_ibfk_6', 'visit', 'host', 'user', 'id');
    }
}