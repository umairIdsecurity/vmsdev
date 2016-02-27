<?php

class m150626_022554_add_column_access_token extends CDbMigration {
    public function safeUp() {
        $this->addColumn('access_tokens', 'USER_TYPE', 'INTEGER AFTER MODIFIED ');
    }

    public function safeDown() {
        $this->dropColumn('access_tokens', 'USER_TYPE');
    }
}

?>