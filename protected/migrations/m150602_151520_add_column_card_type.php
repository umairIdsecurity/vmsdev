<?php

class m150602_151520_add_column_card_type extends CDbMigration {

    public function up() {
        
            $this->addColumn('card_type', 'back_text', 'TEXT AFTER `module` ');
        
    }
}
