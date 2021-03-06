<?php

class m150423_072538_visitor_card_status extends CDbMigration
{
    public function up()
    {

        $table = Yii::app()->db->schema->getTable('visitor_card_status');

        if(!isset($table)) {

            $this->execute("

                  CREATE TABLE IF NOT EXISTS visitor_card_status (
                          id bigint(20) NOT NULL AUTO_INCREMENT,
                          name varchar(50) NOT NULL,
                          profile_type enum('VIC','ASIC') NOT NULL DEFAULT 'VIC',
                          PRIMARY KEY (id)
                          );

            ");

            $this->execute("

                INSERT IGNORE INTO visitor_card_status (id, name, profile_type) VALUES
                (1, 'Saved', 'VIC'),
                (2, 'VIC Holder', 'VIC'),
                (3, 'ASIC Pending', 'VIC'),
                (4, 'ASIC Issued', 'VIC'),
                (5, 'ASIC Denied', 'VIC');

            ");
        }

        $table = Yii::app()->db->schema->getTable('visitor');
        if(!isset($table->columns['profile_type'])){

            $this->execute("

                ALTER  TABLE visitor
                  ADD COLUMN profile_type enum('VIC','ASIC') NOT NULL DEFAULT 'VIC',
                  ADD COLUMN visitor_card_status bigint(20) DEFAULT NULL,
                  ADD COLUMN visitor_workstation bigint(20) DEFAULT NULL,
                  ADD KEY visitor_card_status (visitor_card_status),
                  ADD KEY visitor_workstation (visitor_workstation),
                  ADD CONSTRAINT visitor_card_status_fk FOREIGN KEY (visitor_card_status) REFERENCES visitor_card_status (id),
                  ADD CONSTRAINT visitor_workstation_fk FOREIGN KEY (visitor_workstation) REFERENCES workstation (id);

            ");

        }


    }



    public function down()
    {
        $this->execute("
            ALTER TABLE visitor
              DROP KEY visitor_card_status,
              DROP FOREIGN KEY visitor_card_status_fk,
              DROP FOREIGN KEY visitor_workstation_fk,
              DROP COLUMN profile_type,
              DROP COLUMN visitor_workstation,
              DROP COLUMN visitor_card_status;
        ");

        $this->execute("
            DROP TABLE IF EXISTS visitor_card_status;
        ");
    }
}