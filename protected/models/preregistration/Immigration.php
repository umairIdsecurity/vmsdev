<?php

Yii::import('ext.validator.CustomContact');
Yii::import('ext.validator.PostalAddress');
Yii::import('ext.validator.ImmiInfo');



class Immigration extends CActiveRecord {

   public $is_postal;
	

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asic_immi';
    }

    /**
     * @return array validation rules for model attributes.
     */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		 if($this->scenario=='save')
		 {
			 return array(
			 array('is_citizen,travel_id,grant_number,arrival,arrival_date,flight_number,name_vessel,parent_family_name,parent_given_name','safe')
			 );
		 }
		 else
		 {
			 return array(

            array('is_citizen', 'required' , 'message'=>'Please select Yes or No'),
			array('travel_id,grant_number,arrival,arrival_date,flight_number,name_vessel,parent_family_name,parent_given_name','ext.validator.ImmiInfo','is_citizen'=>$this->is_citizen),
			
		);
		 }
		
		
		
	}


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                                        => 'ID',
			'asic_applicant_id'							=> 'Asic ID',
            'flight_number'                             => 'Flight Number',
            'name_vessel'                               => 'Vessel Name',
			'parent_given_name'							=> 'Given Names of Parent',
            'parent_family_name'                        => 'Last Name of Parent',
			'is_citizen'								=> 'Australian or New Zealand citizen',
			'travel_id'									=> 'Travel Document No.',
			'grant_number'								=> 'Visa Grant Number',
			'arrival'									=> 'Location of Arrival',
			'arrival_date'								=> 'Date of Arrival'

			);
    }


}
