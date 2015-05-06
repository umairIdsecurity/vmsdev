<?php

class m150506_205300_tenant_and_tenant_contact extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $table = Yii::app()->db->schema->getTable('tenant');
        if(!isset($table)) {
            $this->execute("CREATE TABLE `tenant` (
                          `id` BIGINT(20) NOT NULL,
                          `created_by` BIGINT(20) NOT NULL,
                          PRIMARY KEY (`id`),
                          CONSTRAINT `fk_tenant_company1`
                            FOREIGN KEY (`id`)
                            REFERENCES `vms`.`company` (`id`)
                            ON DELETE NO ACTION
                            ON UPDATE NO ACTION)
                        ");
        }

        $table = Yii::app()->db->schema->getTable('tenant_contact');
        if(!isset($table)) {
            $this->execute("CREATE TABLE `vms`.`tenant_contact` (
                              `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
                              `tenant` BIGINT(20) NOT NULL,
                              `user` BIGINT(20) NOT NULL,
                              PRIMARY KEY (`id`),
                              INDEX `fk_tenant_contact_tenant1_idx` (`tenant` ASC),
                              CONSTRAINT `fk_tenant_contact_tenant1`
                                FOREIGN KEY (`tenant`)
                                REFERENCES `vms`.`tenant` (`id`)
                                ON DELETE NO ACTION
                                ON UPDATE NO ACTION)
                              ");
        }

	}

	public function safeDown()
	{
        $table = Yii::app()->db->schema->getTable('tenant');
        if(isset($table)) {
            $this->execute("DROP TABLE tenant");
        }

        $table = Yii::app()->db->schema->getTable('tenant_contact');
        if(isset($table)) {
            $this->execute("DROP TABLE tenant_contact");
        }
	}
}