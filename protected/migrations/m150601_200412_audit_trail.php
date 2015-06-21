<?php

class m150601_200412_audit_trail extends CDbMigration
{
	public function safeUp()
	{
		$table = Yii::app()->db->schema->getTable('audit_trail');
		if(!isset($table)){

			$this->execute("CREATE TABLE IF NOT EXISTS audit_trail (
                            id bigint(20) NOT NULL AUTO_INCREMENT,
                            description varchar(255) NULL,
                            old_value varchar(255) NULL,
                            new_value varchar(255) NULL,
                            action varchar(20) NULL,
                            model varchar(45) NULL,
                            model_id bigint(20) NULL,
                            field varchar(45) NULL,
                            creation_date DATETIME NOT NULL,
                            user_id varchar(45) NULL,
                            PRIMARY KEY (id)                             )
            ");

		}
	}

	public function safeDown()
	{
        $table = Yii::app()->db->schema->getTable('audit_trail');
        if(isset($table)) {

            $this->execute("DELETE FROM audit_trail ");

            $this->execute("DROP TABLE audit_trail ");

        }

	}


}