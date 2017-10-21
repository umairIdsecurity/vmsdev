<?php

Yii::import('ext.validator.AsicInfoRed');
Yii::import('ext.validator.AsicInfoGrey');
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
class AsicInfo extends CActiveRecord {

   
	public $postal_address;
   

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asic_application_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
	/*	if(Yii::app()->controller->action->id!='identificationAsicOnline')
		{
		return array(

            array('first_name,last_name, email, date_of_birth, birth_state, birth_city,street_name,street_number,postcode,from_date,suburb', 'required' , 'message'=>'Please enter {attribute}','except'=>'session'),
			array('gender,birth_country,citizenship,preferred_contact,street_type,state,country,is_postal', 'required' , 'message'=>'Please select {attribute}','except'=>'session'),
			
			array('mobile_phone','ext.validator.CustomContact','home_phone'=>$this->home_phone,'work_phone'=>$this->work_phone,'except'=>'session'),
			
			array('postal_street_number,postal_street_name,postal_street_type,postal_suburb,postal_country,postal_state,postal_postcode','ext.validator.PostalAddress','is_postal'=>$this->is_postal,'except'=>'session'),
			array('given_name2 , given_name3 , home_phone , mobile_phone , work_phone , condition_of_use , aus_check , application_type , unit , city , created_on , employment_status , company_id , upload_1 , upload_2 , upload_3 , operational_need , tenant , postal_unit , postal_street_number , postal_street_name , postal_street_type , postal_suburb , postal_postcode , postal_city , postal_state , postal_country','safe' ),
				
		);
		}
		if(Yii::app()->controller->action->id=='identificationAsicOnline')
		{
			
			return array(	
			array('primary_id,primary_id_no, country_id1, primary_id_expiry', 'required' , 'message'=>'Please enter {attribute}'),
			array('secondary_id,secondary_id_no,secondary_id_expiry,tertiary_id1,tertiary_id2','ext.validator.IdentificationCustom'),
			array('given_name2 , given_name3 , home_phone , mobile_phone , work_phone , condition_of_use , aus_check , application_type , unit , city , created_on , employment_status , company_id , upload_1 , upload_2 , upload_3 , operational_need , tenant , postal_unit , postal_street_number , postal_street_name , postal_street_type , postal_suburb , postal_postcode , postal_city , postal_state , postal_country','safe' ),
			array('upload_1,upload_2,upload_2_1,upload_3', 'ext.validator.fileUploadErrorValidator'),	
			);
		}*/
		return array(
				 array('asic_type,access', 'required' , 'message'=>'Please select one of {attribute}'),
		 array('security_detail,door_detail', 'required','message'=>'Please write {attribute}'),
		 array('frequency_red', 'ext.validator.AsicInfoRed'),
		 array('frequency_grey','ext.validator.AsicInfoGrey'),
		 array('previous_card , previous_issuing_body , other_info , asic_type , access , previous_expiry , frequency_red , frequency_grey , security_detail , door_detail','safe'),
		);
		
		
	}


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                                        => 'ID',
            'previous_card'                             => 'Current Or Former ASIC Number',
            'previous_issuing_body'                     => 'Previous Isssuing Body Airport',
			'other_info'								=> 'Other Info',
            'asic_type'                                 => 'ASIC Type',
            'access'                                    => 'Access Areas',
			'frequency_red'								=> 'Frequency of Access',
			'frequency_grey'							=> 'Frequency of Access',
            'previous_expiry'	                        => 'Previous ASIC Expiry',
			'security_detail'							=> 'Reason for access to Security Areas',
			'door_detail'								=> 'Door Access Required',
			
        );
    }


}
