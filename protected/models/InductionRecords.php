<?php

/**
 * This is the model class for table "induction_records".
 *
 * The followings are the available columns in table 'induction_records':
 * @property string $id
 * @property string $is_required_induction
 * @property string $is_completed_induction
 * @property string $induction_expiry
 * @property string $visitor_id
 * @property string $induction_id
 */
class InductionRecords extends CActiveRecord {
	//public $id;
	//public $is_required_induction;
    //public $is_completed_induction;
   
   /*public static $induction_expiry = array(
        1  => '$induction_expiry_1', 
         2  => '$induction_expiry_2', 
    );*/
	//public $visitor_id;
	//public $induction_id;
	

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'induction_records';
    }
	
	/**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'is_required_induction' => 'Required',
            'is_completed_induction' => 'Completed',
			'visitor_id' => 'Visitor ID',
            'induction_id' => 'Induction ID',
        );
    }
	/**
     * @return array relational rules for model attributes.
	 * Defing rules for those attributes that will receive user inputs
     */
	/*public function rules() {
		
		return array(
			array('required', 'required', 'message'=>'Please complete {attribute}'),
			array('name', 'required', 'message' => 'Country\'s name can not be blank.'),
			array('code', 'match', 'pattern' => '/^[A-z]{2}/', 'message' => 'Incorrect type (2 letters are allowed).'),
			array('name', 'match', 'pattern' => '/^[A-z ]*$/', 'message' => 'Incorrect type (only letters with/without spaces are allowed).'),
			array('name', 'unique'),
			array('code', 'unique'),
			array("id, code, name", 'safe'),
		);
	}*/
	
	/**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CardType the static model class
     */
    /*public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }*/

    public static $cardNumber = 0000001; 
}
