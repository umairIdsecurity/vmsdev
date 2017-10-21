<?php

Yii::import('ext.validator.AddressHistory');


/**
 * This is the model class for table "visitor".
 *
 * The followings are the available columns in table 'visitor':
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $contact_number
 * @property string $date_of_birth
 * @property string $company
 * @property string $department
 * @property string $position
 * @property string $staff_id
 * @property string $notes
 * @property string $password
 * @property string $role
 * @property string $visitor_type
 * @property string $visitor_status
 * @property string $created_by
 * @property integer $is_deleted
 * @property string $tenant
 * @property string $tenant_agent
 * @property integer $verifiable_signature
 *
 * The followings are the available model relations:
 * @property CardGenerated[] $cardGenerateds
 * @property Company $company0
 * @property VisitorType $visitorType
 * @property VisitorStatus $visitorStatus
 * @property User $createdBy
 * @property User $tenant0
 * @property User $tenantAgent
 * @property Roles $role0
 */
class AsicAddressHistory extends CActiveRecord {

   

    /**
     * @return string the associated database table name
     */
	// public $from_date_add;
    public function tableName() {
        return 'address_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

            array('street_number, street_type, street_name, postcode, state, country, suburb, from_date, to_date', 'ext.validator.AddressHistory' ),
			array('street_number, street_type, street_name, postcode, state, country, suburb, from_date, to_date','safe')
           /* array('email', 'unique', 'className' => 'Registration','attributeName' => 'email','message'=>'This Email is already in use'),
			array('suburb', 'required' ,'on' => 'preregistration', 'message'=>'Please enter {attribute}'),
            array('date_of_birth', 'required' ,'on' => 'preregistration', 'message'=>'Please update your {attribute}'),
			array('street_type', 'required' ,'on' => 'preregistration', 'message'=>'Please select Street type'),
            array('street_number', 'required' ,'on' => 'preregistration', 'message'=>'Please enter Street no.'),
            array('street_name', 'required' ,'on' => 'preregistration', 'message'=>'Please enter Street name'),
            array('postcode', 'required' ,'on' => 'preregistration', 'message'=>'Please enter Postcode'),
            array('date_of_birth', 'required' ,'on' => 'preregistrationPass', 'message'=>'Please enter {attribute}'),
			array('first_name, given_name2,given_name3, last_name, email, unit, street_number, street_name, suburb', 'length', 'max'=>50),
			//array('contact_number, created_by, tenant' 'length', 'max'=>20),
			array('street_type', 'length', 'max'=>8),
			array('state', 'length', 'max'=>50),
			array('postcode', 'length', 'max'=>10),*/
			
		);
	}


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                                        => 'ID',
            'asic_applicant_id'                         => 'Asic ID',
            'unit'		                                => 'Unit',
            'street_number'		                        => 'Street No',
            'street_name'                       		=> 'Street Name',
            'street_type'                       		=> 'Street Type',
            'suburb'                            		=> 'Suburb',
			'postcode'									=> 'Postcode',
            'state'                             		=> 'State',
			'city'										=> 'City',
            'country'                           		=> 'Country',
			'from_date'									=> 'Resident From Date',
			'to_date'									=> 'Resident To Date',
			
        );
    }


}
