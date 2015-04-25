<?php

class m150424_181334_issue_171_addUserPhoto extends CDbMigration
{
	public function up()
	{
		
		  // Fetch the table schema
		  $table = 'user';
		  $column = 'photo';
		  $type='BIGINT( 20 )';
		  $table_to_check = Yii::app()->db->schema->getTable($table);
		  if ( ! isset( $table_to_check->columns[$column] )) {
			$this->addColumn($table, $column, $type);
		  }
		
	}

	public function down()
	{
		 $table = 'user';
		  $column = 'photo';
		$this->dropColumn($table, $column);
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}