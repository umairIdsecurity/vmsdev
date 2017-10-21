<?php

Yii::import('ext.validator.CustomContact');
Yii::import('ext.validator.PostalAddress');
Yii::import('ext.validator.fileUploadErrorValidator');
Yii::import('ext.validator.IdentificationCustom');

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
class RegistrationAsic extends CActiveRecord {

   
	public $postal_address;
	//public $country_id4;
    const PROFILE_TYPE_CORPORATE = 'CORPORATE';
    const PROFILE_TYPE_VIC = 'VIC';
    const PROFILE_TYPE_ASIC = 'ASIC';

    const AUSTRALIA_ID = 13;

    const DELTED = 1;
    const NOT_DELETED = 0;

    const ASIC_PENDING = 3;
    const ASIC_ISSUED = 4;
	public $check2;
	//public $upload_2_1;

    public static $VISITOR_CARD_TYPE_LIST = array(
        self::PROFILE_TYPE_CORPORATE => array(
        ),
        self::PROFILE_TYPE_VIC => array(
            1 => 'Card Status: Saved',
            2 => 'Card Status: VIC Holder',
            3 => 'Card Status: ASIC Pending',
            4 => 'Card Status: ASIC Issued',
            5 => 'Card Status: ASIC Denied',
        ),
        self::PROFILE_TYPE_ASIC => array(
            6 => 'Card Status: ASIC Issued',
            7 => 'Card Status: ASIC Applicant',
            5 => 'Card Status: ASIC Denied',
        ),
    );

    public static $PROFILE_TYPE_LIST = array(
        self::PROFILE_TYPE_CORPORATE => 'Corporate',
        self::PROFILE_TYPE_VIC => 'VIC',
        self::PROFILE_TYPE_ASIC => 'ASIC',
    );

    public static $IDENTIFICATION_TYPE_LIST_PRIMARY = array(
        'IMMIGRATION_CARD'		=> 'Immigration Card',
		'VISA'					=> 'Visa',
        'CITIZENSHIP_CERTIFICATE' => 'Citizenship Certificate',
        'BIRTH_CERTIFICATE'  => 'Birth Certificate',

    );
	 public static $IDENTIFICATION_TYPE_LIST_SECONDARY = array(
		'PASSPORT'        => 'Passport',
        'DRIVERS_LICENSE' => 'Driver Licence',
        'PROOF_OF_AGE'    => 'Proof of Age Card',
        'FIRE_ARMS_LICENCE'  => 'Fire Arms Licence',
        'WORKING_WITH_CHILDREN_CARD' => 'Working with Children Card',
        'APPROVED_MANAGER' => 'Approved Manager',
        'HIGH_RISK_WORK_LICENCE' => 'High Risk Work Licence',
        'SENIORS_CARD' => 'Seniors Card',
		'AUSTRALIAN_STUDENT_ID'=>'Student ID'
    );
	public static $IDENTIFICATION_TYPE_LIST_category = array(
        'Medicare_Card' => 'Medicare Card',
        'Marriage_Certificate'    => 'Marriage Certificate',
        'Payslips'  => 'Payslips',
		'ASIC'		=> 'Asic'
    );
	 public static $IDENTIFICATION_TYPE_LIST_TERTIARY = array(
        'Bank_STATEMENT' => 'Bank Statement',
        'Bills'    => 'Utility Bills',
        'ELECTORAL_ROLE_EXTRACT' => 'Electoral Role Extract',
    );
    public static $STREET_TYPES = array(
        'ALLY'     => 'ALLEY',
        'APP'      => 'APPROACH',
        'ARC'      => 'ARCADE',
        'AVE'      => 'AVENUE',
        'BLVD'     => 'BOULEVARD',
        'BROW'     => 'BROW',
        'BYPA'     => 'BYPASS',
        'CWAY'     => 'CAUSEWAY',
        'CCT'      => 'CIRCUIT',
        'CIRC'     => 'CIRCUS',
        'CL'       => 'CLOSE',
        'CPSE'     => 'COPSE',
        'CNR'      => 'CORNER',
        'CT'       => 'COURT',
        'CRES'     => 'CRESCENT',
        'CRS'      => 'CROSS',
        'DR'       => 'DRIVE',
        'END'      => 'END',
        'EESP'     => 'ESPLANAND',
        'FLAT'     => 'FLAT',
        'FWAY'     => 'FREEWAY',
        'FRNT'     => 'FRONTAGE',
        'GDNS'     => 'GARDENS',
        'GLD'      => 'GLADE',
        'GLEN'     => 'GLEN',
        'GRN'      => 'GREEN',
        'GR'       => 'GROVE',
        'HTS'      => 'HEIGHTS',
        'HWY'      => 'HIGHWAY',
        'LANE'     => 'LANE',
        'LINK'     => 'LINK',
        'LOOP'     => 'LOOP',
        'MALL'     => 'MALL',
        'MEWS'     => 'MEWS',
        'PCKT'     => 'PACKET',
        'PDE'      => 'PARADE',
        'PARK'     => 'PARK',
        'PKWY'     => 'PARKWAY',
        'PL'       => 'PLACE',
        'PROM'     => 'PROMENADE',
        'RES'      => 'RESERVE',
        'RDGE'     => 'RIDGE',
        'RISE'     => 'RISE',
        'RD'       => 'ROAD',
        'ROW'      => 'ROW',
        'SQ'       => 'SQUARE',
        'ST'       => 'STREET',
        'STRP'     => 'STRIP',
        'TARN'     => 'TARN',
        'TCE'      => 'TERRACE',
        'FARETFRE' => 'THOROUGH',
        'TRAC'     => 'TRACK',
        'TWAY'     => 'TRUNKWAY',
        'VIEW'     => 'VIEW',
        'VSTA'     => 'VISTA',
        'WALK'     => 'WALK',
        'WWAY'     => 'WALKWAY',
        'WAY'      => 'WAY',
        'YARD'     => 'YARD',
    );

    public static $AUSTRALIAN_STATES = array(
        'ACT' => 'Australian Capital Territory',
        'NSW' => 'New South Wales',
        'NT'  => 'Northern Territory',
        'Qld' => 'Queensland',
        'SA'  => 'South Australia',
        'Tas' => 'Tasmania',
        'Vic' => 'Victoria',
        'WA'  => 'Western Australia',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asic_applicant';
    }

    /**
     * @return array validation rules for model attributes.
     */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		if(Yii::app()->controller->action->id!='identificationAsicOnline' && $this->scenario!='save')
		{
		return array(

            array('first_name,last_name, email, date_of_birth, birth_state, birth_city,street_name,street_number,postcode,from_date,suburb', 'required' , 'message'=>'Please enter {attribute}','except'=>'session'),
			array('gender,birth_country,citizenship,preferred_contact,street_type,state,country,is_postal', 'required' , 'message'=>'Please select {attribute}','except'=>'session'),
			
			array('mobile_phone','ext.validator.CustomContact','home_phone'=>$this->home_phone,'work_phone'=>$this->work_phone,'except'=>'session'),
			array('name_change_file,op_need_document', 'ext.validator.fileUploadErrorValidator'),	
			array('postal_street_number,postal_street_name,postal_street_type,postal_suburb,postal_country,postal_state,postal_postcode','ext.validator.PostalAddress','is_postal'=>$this->is_postal,'except'=>'session'),
			array('given_name2 , given_name3 , home_phone , mobile_phone , work_phone , condition_of_use , aus_check , application_type , unit , city , created_on , employment_status , company_id , upload_1 , upload_2 , upload_3 , operational_need , tenant , postal_unit , postal_street_number , postal_street_name , postal_street_type , postal_suburb , postal_postcode , postal_city , postal_state , postal_country,changed_last_name1,changed_given_name1,changed_given_name2,changed_given_name3,name_type1,changed_last_name2,changed_given_name1_1,changed_given_name2_1,changed_given_name3_1,name_type2,acc_name,acc_bsb,acc_number,name_change_file,op_need_document,primary_id,primary_id_no, country_id1,secondary_id,secondary_id_no,secondary_id_expiry,country_id2,country_id3,tertiary_id2,country_id4,tertiary_id1,tertiary_id1_no,tertiary_id2_no,tertiary_id2_expiry,tertiary_id1_expiry,','safe' ),
			

				
		);
		}
		if(Yii::app()->controller->action->id!='identificationAsicOnline' && $this->scenario=='save')
		{
		return array(

            array('first_name,last_name, email, date_of_birth', 'required' , 'message'=>'Please enter {attribute}','except'=>'session'),
			
			array('given_name2 , given_name3 , home_phone , mobile_phone , work_phone , condition_of_use , aus_check , application_type , unit , city , created_on , employment_status , company_id , upload_1 , upload_2 , upload_3 , operational_need , tenant , postal_unit , postal_street_number , postal_street_name , postal_street_type , postal_suburb , postal_postcode , postal_city , postal_state , postal_country,changed_last_name1,changed_given_name1,changed_given_name2,changed_given_name3,name_type1,changed_last_name2,changed_given_name1_1,changed_given_name2_1,changed_given_name3_1,name_type2,acc_name,acc_bsb,acc_number,name_change_file,op_need_document,primary_id,primary_id_no, country_id1,secondary_id,secondary_id_no,secondary_id_expiry,country_id2,country_id3,tertiary_id2,country_id4,tertiary_id1,tertiary_id1_no,tertiary_id2_no,tertiary_id2_expiry,tertiary_id1_expiry,birth_state, birth_city,street_name,street_number,postcode,from_date,suburb,gender,birth_country,citizenship,preferred_contact,street_type,state,country,is_postal','safe' ),
			

				
		);
		}
		if(Yii::app()->controller->action->id=='identificationAsicOnline')
		{
			
			return array(	
			array('primary_id,primary_id_no, country_id1,secondary_id,secondary_id_no,secondary_id_expiry,country_id2,country_id3,tertiary_id2', 'required' , 'message'=>'Please enter {attribute}','except'=>'save'),
			array('country_id4,tertiary_id1','ext.validator.IdentificationCustom','except'=>'save'),
			array('given_name2 , given_name3 , home_phone , mobile_phone , work_phone , condition_of_use , aus_check , application_type , unit , city , created_on , employment_status , company_id , upload_1 , upload_2 , upload_3 , operational_need , tenant , postal_unit , postal_street_number , postal_street_name , postal_street_type , postal_suburb , postal_postcode , postal_city , postal_state , postal_country,upload_4,tertiary_id1_no,tertiary_id2_no,tertiary_id1_expiry,country_id1,country_id2,country_id3,country_id4','safe' ),
			array('upload_1,upload_2,upload_4,upload_3', 'ext.validator.fileUploadErrorValidator'),	
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
            'first_name'                                => 'First Name',
            'given_name2'                               => 'Middle Name',
			'given_name3'								=> 'Given Name',
            'last_name'                                 => 'Last Name',
            'email'                                     => 'Email Address',
			'gender'									=> 'Gender',
            'mobile_phone'	                            => 'Mobile',
			'home_phone'								=> 'Home',
			'work_phone'								=> 'Work',
			'preferred_contact'							=> 'Preferred Contact',
            'date_of_birth'                             => 'Date Of Birth',
			'birth_country'								=> 'Country of Birth',
			'birth_state'								=> 'State of Birth',
			'birth_city'								=> 'City of Birth',
			'citizenship'								=> 'Country of Citizenship',
            'tenant'                                    => 'Tenant',
            'unit'		                                => 'Unit',
            'street_number'		                        => 'Street No',
            'street_name'                       		=> 'Street Name',
            'street_type'                       		=> 'Street Type',
            'suburb'                            		=> 'Suburb',
            'state'                             		=> 'State',
			'city'										=> 'City',
            'country'                           		=> 'Country',
			'is_postal'									=> 'postal address',
			'postal_unit'		                        => 'Postal Unit',
            'postal_street_number'		                => 'Street No',
            'postal_street_name'                       	=> 'Street Name',
            'postal_street_type'                       	=> 'Street Type',
            'postal_suburb'                            	=> 'Suburb',
			'postal_postcode'							=> 'Postcode',
			'postal_city'								=> 'City',
            'postal_state'                             	=> 'State',
            'postal_country'                           	=> 'Country',
			'from_date'									=> 'Resident From Date',
			'primary_id'								=> 'Category A Identification',
			'secondary_id'								=> 'Category B Identification',
			'tertiary_id1'								=> 'Tertiary ID 1',
			'tertiary_id2'								=> 'Category C',
			'tertiary_id1_expiry'						=> 'Expiry date (if applicable)',
			'tertiary_id2_expiry'						=> 'Category C Expiry (if applicable)',
			'appointment_1'								=>'Appointment 1',
			'appointment_2'								=>'Appoinment 2',
			'time_1'									=>'Time 1',
			'time_2'									=>'Time 2',
			'primary_id_no'								=>'Category A Number',
			'secondary_id_no'							=>'Category B Number',
			'tertiary_id2_no'							=>'Category C Number',
			'primary_id_expiry'							=>'Category A Expiry (if applicable)',
			'secondary_id_expiry'						=>'Category B Expiry',
        );
    }

public function listApplicants()
{
	$criteria = new CDbCriteria();
	$criteria->condition = "is_logged is null";
	return $this->findAll($criteria);
	/*echo "<pre>";
	print_r($this->findAll($criteria));
	echo "</pre>";
	Yii::app()->end();*/
}
public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;
		$criteria->compare("first_name", $this->first_name, true);
		$criteria->compare("last_name", $this->last_name, true);
		
		//$date = str_replace('/', '-', );
		
		$criteria->compare("date_of_birth",$this->date_of_birth, true);
		$criteria->compare("email",$this->email, true);
		$criteria->compare("application_type",$this->application_type, true);
		$criteria->compare("company_id",$this->company_id, true);
		$criteria->compare("created_on",$this->created_on, true);
		$criteria->compare("tenant",Yii::app()->user->tenant, true);
		if(Yii::app()->controller->action->id=='listApplicants')
		{
		 $criteria->addCondition("is_logged IS NULL OR is_logged=''");
		}
		if(Yii::app()->controller->action->id=='lodgedApplicants')
		{
		 $criteria->addCondition("is_logged='1' AND (is_approved IS NULL OR is_approved='')");
		}
		if(Yii::app()->controller->action->id=='approvedApplicants')
		{
		 $criteria->addCondition("is_logged='1' AND is_approved='1'");
		}
		if(Yii::app()->controller->action->id=='deniedApplicants')
		{
		 $criteria->addCondition("is_logged='1' AND is_eligible='0'");
		}
		return new CActiveDataProvider($this, array(	
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 10,
			),
		));
	}

}
