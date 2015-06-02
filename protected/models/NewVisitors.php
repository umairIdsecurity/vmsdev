<?php

/**
 * This is the model class for table "visitor".
 *
 * The followings are the available columns in table 'visitor':
 * @property string $id
 * @property string $first_name
 * @property string $middle_name
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
 * @property string $vehicle
 * @property string $photo
 * @property string $created_by
 * @property integer $is_deleted
 * @property string $tenant
 * @property string $tenant_agent
 * @property string $visitor_card_status
 * @property string $visitor_workstation
 * @property string $profile_type
 * @property string $identification_type
 * @property integer $identification_country_issued
 * @property string $identification_document_no
 * @property string $identification_document_expiry
 * @property string $identification_alternate_document_name1
 * @property string $identification_alternate_document_no1
 * @property string $identification_alternate_document_expiry1
 * @property string $identification_alternate_document_name2
 * @property string $identification_alternate_document_no2
 * @property string $identification_alternate_document_expiry2
 * @property string $contact_unit
 * @property string $contact_street_no
 * @property string $contact_street_name
 * @property string $contact_street_type
 * @property string $contact_suburb
 * @property string $contact_state
 * @property integer $contact_country
 * @property string $asic_no
 * @property string $asic_expiry
 * @property integer $verifiable_signature
 * @property string $contact_postcode
 *
 * The followings are the available model relations:
 * @property CardGenerated[] $cardGenerateds
 * @property Country $contactCountry
 * @property Country $identificationCountryIssued
 * @property VisitorCardStatus $visitorCardStatus
 * @property VisitorType $visitorType
 * @property VisitorStatus $visitorStatus
 * @property User $createdBy
 * @property User $tenant0
 * @property User $tenantAgent
 * @property Roles $role0
 * @property Company $company0
 * @property Vehicle $vehicle0
 * @property Photo $photo0
 * @property Workstation $visitorWorkstation
 */
class NewVisitors extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'visitor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, contact_number', 'required'),
			array('is_deleted, identification_country_issued, contact_country, verifiable_signature', 'numerical', 'integerOnly'=>true),
			array('first_name, middle_name, last_name, email, department, position, staff_id, identification_document_no, identification_alternate_document_name1, identification_alternate_document_no1, identification_alternate_document_name2, identification_alternate_document_no2, contact_unit, contact_street_no, contact_street_name, contact_suburb, asic_no', 'length', 'max'=>50),
			array('contact_number, company, role, visitor_type, visitor_status, vehicle, photo, created_by, tenant, tenant_agent, visitor_card_status, visitor_workstation', 'length', 'max'=>20),
			array('password', 'length', 'max'=>150),
			array('profile_type', 'length', 'max'=>9),
			array('identification_type', 'length', 'max'=>15),
			array('contact_street_type', 'length', 'max'=>8),
			array('contact_state', 'length', 'max'=>3),
			array('contact_postcode', 'length', 'max'=>10),
			array('date_of_birth, notes, identification_document_expiry, identification_alternate_document_expiry1, identification_alternate_document_expiry2, asic_expiry', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, middle_name, last_name, email, contact_number, date_of_birth, company, department, position, staff_id, notes, password, role, visitor_type, visitor_status, vehicle, photo, created_by, is_deleted, tenant, tenant_agent, visitor_card_status, visitor_workstation, profile_type, identification_type, identification_country_issued, identification_document_no, identification_document_expiry, identification_alternate_document_name1, identification_alternate_document_no1, identification_alternate_document_expiry1, identification_alternate_document_name2, identification_alternate_document_no2, identification_alternate_document_expiry2, contact_unit, contact_street_no, contact_street_name, contact_street_type, contact_suburb, contact_state, contact_country, asic_no, asic_expiry, verifiable_signature, contact_postcode', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cardGenerateds' => array(self::HAS_MANY, 'CardGenerated', 'visitor_id'),
			'contactCountry' => array(self::BELONGS_TO, 'Country', 'contact_country'),
			'identificationCountryIssued' => array(self::BELONGS_TO, 'Country', 'identification_country_issued'),
			'visitorCardStatus' => array(self::BELONGS_TO, 'VisitorCardStatus', 'visitor_card_status'),
			'visitorType' => array(self::BELONGS_TO, 'VisitorType', 'visitor_type'),
			'visitorStatus' => array(self::BELONGS_TO, 'VisitorStatus', 'visitor_status'),
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
			'tenant0' => array(self::BELONGS_TO, 'User', 'tenant'),
			'tenantAgent' => array(self::BELONGS_TO, 'User', 'tenant_agent'),
			'role0' => array(self::BELONGS_TO, 'Roles', 'role'),
			'company0' => array(self::BELONGS_TO, 'Company', 'company'),
			'vehicle0' => array(self::BELONGS_TO, 'Vehicle', 'vehicle'),
			'photo0' => array(self::BELONGS_TO, 'Photo', 'photo'),
			'visitorWorkstation' => array(self::BELONGS_TO, 'Workstation', 'visitor_workstation'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'contact_number' => 'Contact Number',
			'date_of_birth' => 'Date Of Birth',
			'company' => 'Company',
			'department' => 'Department',
			'position' => 'Position',
			'staff_id' => 'Staff',
			'notes' => 'Notes',
			'password' => 'Password',
			'role' => 'Role',
			'visitor_type' => 'Visitor Type',
			'visitor_status' => 'Visitor Status',
			'vehicle' => 'Vehicle',
			'photo' => 'Photo',
			'created_by' => 'Created By',
			'is_deleted' => 'Is Deleted',
			'tenant' => 'Tenant',
			'tenant_agent' => 'Tenant Agent',
			'visitor_card_status' => 'Visitor Card Status',
			'visitor_workstation' => 'Visitor Workstation',
			'profile_type' => 'Profile Type',
			'identification_type' => 'Identification Type',
			'identification_country_issued' => 'Identification Country Issued',
			'identification_document_no' => 'Identification Document No',
			'identification_document_expiry' => 'Identification Document Expiry',
			'identification_alternate_document_name1' => 'Identification Alternate Document Name1',
			'identification_alternate_document_no1' => 'Identification Alternate Document No1',
			'identification_alternate_document_expiry1' => 'Identification Alternate Document Expiry1',
			'identification_alternate_document_name2' => 'Identification Alternate Document Name2',
			'identification_alternate_document_no2' => 'Identification Alternate Document No2',
			'identification_alternate_document_expiry2' => 'Identification Alternate Document Expiry2',
			'contact_unit' => 'Contact Unit',
			'contact_street_no' => 'Contact Street No',
			'contact_street_name' => 'Contact Street Name',
			'contact_street_type' => 'Contact Street Type',
			'contact_suburb' => 'Contact Suburb',
			'contact_state' => 'Contact State',
			'contact_country' => 'Contact Country',
			'asic_no' => 'Asic No',
			'asic_expiry' => 'Asic Expiry',
			'verifiable_signature' => 'Verifiable Signature',
			'contact_postcode' => 'Contact Postcode',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact_number',$this->contact_number,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('staff_id',$this->staff_id,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('visitor_type',$this->visitor_type,true);
		$criteria->compare('visitor_status',$this->visitor_status,true);
		$criteria->compare('vehicle',$this->vehicle,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('tenant',$this->tenant,true);
		$criteria->compare('tenant_agent',$this->tenant_agent,true);
		$criteria->compare('visitor_card_status',$this->visitor_card_status,true);
		$criteria->compare('visitor_workstation',$this->visitor_workstation,true);
		$criteria->compare('profile_type',$this->profile_type,true);
		$criteria->compare('identification_type',$this->identification_type,true);
		$criteria->compare('identification_country_issued',$this->identification_country_issued);
		$criteria->compare('identification_document_no',$this->identification_document_no,true);
		$criteria->compare('identification_document_expiry',$this->identification_document_expiry,true);
		$criteria->compare('identification_alternate_document_name1',$this->identification_alternate_document_name1,true);
		$criteria->compare('identification_alternate_document_no1',$this->identification_alternate_document_no1,true);
		$criteria->compare('identification_alternate_document_expiry1',$this->identification_alternate_document_expiry1,true);
		$criteria->compare('identification_alternate_document_name2',$this->identification_alternate_document_name2,true);
		$criteria->compare('identification_alternate_document_no2',$this->identification_alternate_document_no2,true);
		$criteria->compare('identification_alternate_document_expiry2',$this->identification_alternate_document_expiry2,true);
		$criteria->compare('contact_unit',$this->contact_unit,true);
		$criteria->compare('contact_street_no',$this->contact_street_no,true);
		$criteria->compare('contact_street_name',$this->contact_street_name,true);
		$criteria->compare('contact_street_type',$this->contact_street_type,true);
		$criteria->compare('contact_suburb',$this->contact_suburb,true);
		$criteria->compare('contact_state',$this->contact_state,true);
		$criteria->compare('contact_country',$this->contact_country);
		$criteria->compare('asic_no',$this->asic_no,true);
		$criteria->compare('asic_expiry',$this->asic_expiry,true);
		$criteria->compare('verifiable_signature',$this->verifiable_signature);
		$criteria->compare('contact_postcode',$this->contact_postcode,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return newVisitors the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
