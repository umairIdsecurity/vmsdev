<?php

/**
 * This is the model class for table "induction_name".
 *
 * The followings are the available columns in table 'induction_name':
 * @property string $id
 * @property string $induction_name 
 */
class InductionTitle extends CActiveRecord {
	public $id;
	public $induction_name;  

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'induction_name';
    }
}
