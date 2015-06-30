<?php

Yii::import('ext.validator.PasswordCustom');
Yii::import('ext.validator.PasswordRepeat');
Yii::import('ext.validator.PasswordRequirement');
Yii::import('ext.validator.PasswordOption');
Yii::import('ext.validator.VisitorPrimaryIdentification');
Yii::import('ext.validator.VisitorAlternateIdentification');
Yii::import('ext.validator.EmailCustom');
Yii::import('ext.validator.DropDown');

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
class Visitor extends CActiveRecord {

    public $birthdayMonth;
    public $birthdayYear;
    public $birthdayDay;
    public $repeatpassword;
    public $password_option;
    public $password_requirement;
    public $alternative_identification;
    public $companycode;

    const PROFILE_TYPE_CORPORATE = 'CORPORATE';
    const PROFILE_TYPE_VIC = 'VIC';
    const PROFILE_TYPE_ASIC = 'ASIC';

    const AUSTRALIA_ID = 13;
    
    const DELTED = 1;
    const NOT_DELETED = 0;

    const ASIC_PENDING = 3;
    const ASIC_ISSUED = 4;


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

    public static $IDENTIFICATION_TYPE_LIST = array(
        'PASSPORT'        => 'Passport',
        'DRIVERS_LICENSE' => 'Drivers License',
        'PROOF_OF_AGE'    => 'Proof of Age Card',
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
        return 'visitor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        $rules = array(
            array('first_name, last_name, email, contact_number', 'required'),
            array('tenant','required','message' =>'Please select a {attribute}'),
            array('is_deleted', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, department, position, staff_id', 'length', 'max' => 50),
            array('contact_number, company, role, visitor_status, created_by, tenant, tenant_agent', 'length', 'max' => 20),
            array(
                'date_of_birth,
                notes,
                birthdayYear,
                birthdayMonth,
                birthdayDay,
                vehicle,
                profile_type,
                middle_name,
                company,
                staff_id
                identification_type,
                identification_country_issued,
                identification_document_no,
                identification_document_expiry,
                asic_no,
                asic_expiry,
                identification_alternate_document_name1,
                identification_alternate_document_no1,
                identification_alternate_document_expiry1,
                identification_alternate_document_name2,
                identification_alternate_document_no2,
                identification_alternate_document_expiry2,
                contact_unit,
                contact_street_no,
                contact_street_name,
                contact_street_type,
                contact_suburb,
                contact_state,
                contact_postcode,
                contact_country,
                visitor_card_status,
                visitor_type,
                visitor_workstation,
                repeatpassword,
                password_option,
                password_requirement,
                alternative_identification,
                verifiable_signature,
                ',
                'safe'
            ),
            array('tenant, tenant_agent,company, visitor_type, visitor_workstation, photo,vehicle, visitor_card_status', 'default', 'setOnEmpty' => true, 'value' => null),
            array('password', 'PasswordCustom'),
            array('repeatpassword', 'PasswordRepeat'),

            //todo: check to enable again. why do we need this validation ?
            //array('password_requirement', 'PasswordRequirement'),
            //array('password_option', 'PasswordOption'),

            /// array('vehicle', 'length', 'min'=>6, 'max'=>6, 'tooShort'=>'Vehicle is too short (Should be in 6 characters)'),
            array('email', 'EmailCustom'),
            array('vehicle', 'match',
                'pattern' => '/^[A-Za-z0-9_]+$/u',
                'message' => 'Vehicle accepts alphanumeric characters only'
            ),
            array('vehicle', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_name, photo,last_name, email,companycode, vehicle,contact_number, date_of_birth, company, department, position, staff_id, notes, role, visitor_status, created_by, is_deleted, tenant, tenant_agent, profile_type', 'safe', 'on' => 'search'),
        );

        $rules[] = array(
            'identification_alternate_document_name1,
            identification_alternate_document_no1,
            identification_alternate_document_name2,
            identification_alternate_document_no2',
            'VisitorAlternateIdentification'
        );

        if (date('Y') - $this->birthdayYear > 18) {
            $rules[] = array(
                'identification_type,
                identification_country_issued,
                identification_document_no,
                identification_document_expiry',
                'VisitorPrimaryIdentification',
            );
        }


        if (Yii::app()->controller->id === 'visitor') {
            if (Yii::app()->controller->action->id == 'addvisitor') {
                $rules[] = array('company, visitor_workstation, visitor_card_status, visitor_type,contact_street_type,contact_state, contact_country, asic_expiry','DropDown');
            } elseif(Yii::app()->controller->action->id == 'create'){
                $rules[] = array('company','DropDown');
            }
        }

        if ($this->profile_type == self::PROFILE_TYPE_CORPORATE) {
            $rules[] = array(
                'company', 'required'
            );

        } else if ($this->profile_type == self::PROFILE_TYPE_VIC) {
                $rules[] = array(
                    'company,
                visitor_card_status,
                visitor_workstation,
                visitor_type,
                contact_street_no,
                contact_street_name,
                contact_street_type,
                contact_suburb,
                contact_state,
                contact_postcode,
                contact_country',
                    'required','except'=>'updateVic'
                );

        } else if ($this->profile_type == self::PROFILE_TYPE_ASIC) {
            $rules[] = array(
                'visitor_card_status, asic_no',
                'required'
            );
        }


        return $rules;
    }


    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cardGenerateds' => array(self::HAS_MANY, 'CardGenerated', 'visitor_id'),
            'company0' => array(self::BELONGS_TO, 'Company', 'company'),
            'visitorStatus' => array(self::BELONGS_TO, 'VisitorStatus', 'visitor_status'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'tenant0' => array(self::BELONGS_TO, 'User', 'tenant'),
            'tenantAgent' => array(self::BELONGS_TO, 'User', 'tenant_agent'),
            'role0' => array(self::BELONGS_TO, 'Roles', 'role'),
            'vehicle0' => array(self::BELONGS_TO, 'Vehicle', 'vehicle'),
            'photo0' => array(self::BELONGS_TO, 'Photo', 'photo'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                                        => 'ID',
            'visitor_workstation'                       => 'Workstation',
            'first_name'                                => 'First Name',
            'middle_name'                               => 'Middle Name',
            'last_name'                                 => 'Last Name',
            'email'                                     => 'Email Address',
            'contact_number'                            => 'Mobile Number',
            'date_of_birth'                             => 'Date Of Birth',
            'company'                                   => 'Company',
            'visit_count'                               => 'Total Visits',
            'department'                                => 'Department',
            'position'                                  => 'Position',
            'staff_id'                                  => 'Staff ID',
            'notes'                                     => 'Notes',
            'password'                                  => 'Password',
            'role'                                      => 'Role',
            'visitor_status'                            => 'Visitor Status',
            'created_by'                                => 'Created By',
            'is_deleted'                                => 'Is Deleted',
            'asic_expiry'                                => 'Asic Expiry',
            'tenant'                                    => 'Tenant',
            'tenant_agent'                              => 'Tenant Agent',
            'repeatpassword'                            => 'Repeat Password',
            'vehicle'                                   => 'Vehicle Registration Number',
            'photo'                                     => 'Photo',
            'identification_type'                       => 'Identification Type',
            'identification_country_issued'             => 'Country of Issued',
            'identification_document_no'                => 'Document No',
            'identification_document_expiry'            => 'Expiry',
            'identification_alternate_document_name1'   => 'Document Name',
            'identification_alternate_document_no1'     => 'Document No',
            'identification_alternate_document_expiry1' => 'Expiry',
            'identification_alternate_document_name2'   => 'Document Name',
            'identification_alternate_document_no2'     => 'Document No',
            'identification_alternate_document_expiry2' => 'Expiry',
            'visitor_card_status'                       => 'Card Status',
            'visitor_type'                              => 'Visitor Type',
            'contact_unit'                              => 'Unit',
            'contact_street_no'                         => 'Street No',
            'contact_street_name'                       => 'Street Name',
            'contact_street_type'                       => 'Street Type',
            'contact_suburb'                            => 'Suburb',
            'contact_state'                             => 'State',
            'contact_country'                           => 'Country',
            'verifiable_signature'                      => 'Verifiable Signature'
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
    public function search($merge = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array( 'company0' );

        $criteria->compare('t.id', $this->id, true);
        //$criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('contact_number', $this->contact_number, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('company0.name', $this->company, true);
        $criteria->compare('company0.code', $this->companycode, true);
        $criteria->compare('department', $this->department, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('photo', $this->photo, true);
        $criteria->compare('notes', $this->notes, true);
        //$criteria->compare('password', $this->password, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('visitor_status', $this->visitor_status, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('vehicle', $this->vehicle, true);
        $criteria->compare('profile_type', $this->profile_type, true);
        $criteria->compare('contact_street_no', $this->contact_street_no, true);
        $criteria->compare('contact_street_name', $this->contact_street_name, true);
        $criteria->compare('contact_street_type', $this->contact_street_type, true);
        $criteria->compare('contact_suburb', $this->contact_suburb, true);
        $criteria->compare('contact_postcode', $this->contact_postcode, true);
        $criteria->compare('identification_type', $this->identification_type, true);
        $criteria->compare('identification_document_no', $this->identification_document_no, true);
        $criteria->compare('identification_document_expiry', $this->identification_document_expiry, true);
        $criteria->compare('asic_no', $this->asic_no, true);
        $criteria->compare('asic_expiry', $this->asic_expiry, true);
        $criteria->compare('t.is_deleted', self::NOT_DELETED);

        if (Yii::app()->controller->id === 'visit') {
            $criteria->compare('CONCAT(first_name, \' \', last_name)', $this->first_name, true);
        } else {
            $criteria->compare('first_name', $this->first_name, true);
        }

        $user = User::model()->findByPK(Yii::app()->user->id);
        if($user->role != Roles::ROLE_SUPERADMIN){
            if(Yii::app()->controller->id === 'visit'){
                if(Yii::app()->controller->action->id !== 'vicTotalVisitCount' && Yii::app()->controller->action->id !== 'corporateTotalVisitCount'  ) {
                    $criteria->condition = "t.is_deleted = 0 and t.tenant = " . Yii::app()->user->tenant;
                }
            }
        }

        if ($merge !== null) {
            $criteria->mergeWith($merge);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder'=>'t.id DESC', #set default order by visitor.id desc
                'attributes'=>array(
                    'company.name'=>array(
                        'asc'=>'company.name',
                        'desc'=>'company.name DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Visitor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->email = trim($this->email);

        if(!$this->contact_country) {
            $this->contact_country = self::AUSTRALIA_ID;
        }
        
        if (!empty($this->date_of_birth)) $this->date_of_birth =  date('Y-m-d', strtotime($this->date_of_birth));
        if (!empty($this->asic_expiry)) $this->asic_expiry =  date('Y-m-d', strtotime($this->asic_expiry));
        if (!empty($this->identification_document_expiry)) $this->identification_document_expiry =  date('Y-m-d', strtotime($this->identification_document_expiry));

        if ($this->password_requirement == PasswordRequirement::PASSWORD_IS_NOT_REQUIRED) {
            $this->password = null;
        } else {
            $this->password = User::model()->hashPassword($this->password);
        }

        return parent::beforeSave();
    }


    public function beforeDelete() {
        $visitorExists = Visit::model()->exists('is_deleted = 0 and visitor =' . $this->id . ' and (visit_status=' . VisitStatus::PREREGISTERED . ' or visit_status=' . VisitStatus::ACTIVE . ')');
        $visitorExistsClosed = Visit::model()->exists('is_deleted = 0 and visitor =' . $this->id . ' and (visit_status=' . VisitStatus::CLOSED . ' or visit_status=' . VisitStatus::EXPIRED . ')');
        $visitorHasSavedVisitOnly = Visit::model()->exists("is_deleted = 0 and visitor =" . $this->id . " and visit_status='".VisitStatus::SAVED."'");

        if ($visitorExists) {
            return false;
        } elseif ($visitorExistsClosed) {
            return false;
        } elseif($visitorHasSavedVisitOnly){

            $this->is_deleted = 1;
            $this->save();
            echo "true";
            Visit::model()->updateCounters(array('is_deleted' => 1), 'visitor=:visitor', array(':visitor' => $this->id));
            return false;
        } else {
            $this->is_deleted = 1;
            $this->save();
            echo "true";
            return false;
        }
    }

    public function beforeFind() {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.is_deleted = 0';
        if (isset(yii::app()->user->role)) {
            if (Yii::app()->user->role != Roles::ROLE_SUPERADMIN) {
                $criteria->condition = "t.is_deleted = 0 and t.created_by = " . Yii::app()->user->tenant;
            }
        }
        $this->dbCriteria->mergeWith($criteria);

    }
    
    /**
     * Radio button auto Select on Edit/Update
     * 
     */
    public function afterFind() {
     
        if( is_null($this->password) ) { 
            $this->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;
        }
        else {
            $this->password_requirement = PasswordRequirement::PASSWORD_IS_REQUIRED;
            $this->password_option = 1;
            
        }
        
        
        parent::afterFind();
    }
    protected function afterValidate() {
        parent::afterValidate();
        if (!$this->hasErrors()) {
            if (Yii::app()->controller->action->id == 'create') {
                // $this->password = User::model()->hashPassword($this->password);
            }
            //disable if action is update
        }
    }
    
    public function behaviors() {
        return array(
            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
            'DateTimeZoneAndFormatBehavior' => 'application.components.DateTimeZoneAndFormatBehavior',
        );
    }


    public function findAllCompanyWithSameTenant() {
        $session = new CHttpSession;
        $aArray = array();
        $tenant = User::model()->findByPk($session['tenant']);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = '" . $session['tenant'] . "' and (id!=1 and id !='" . $tenant->company . "')";

        $company = Company::model()->findAll($Criteria);

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;
    }

    public function findAllCompanyByTenant($tenantId) {
        $tenant = User::model()->findByPk($tenantId);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = '".$tenantId."' and (id!=1 and id !='".$tenant->company."')";
        return Company::model()->findAll($Criteria);
    }

    public function findAllCompanyWithSameTenantAndTenantAgent($id, $tenantAgentId) {
        $aArray = array();
        $tenant = User::model()->findByPk($id);
        $tenantagent = User::model()->findByPk($tenantAgentId);
        $Criteria = new CDbCriteria();
        $Criteria->condition = "((tenant = '$id' and tenant_agent= '$tenantAgentId') || id ='".$tenant->company."') and id !='".$tenantagent->company."'";
        $company = Company::model()->findAll($Criteria);

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'tenant_agent' => $value['tenant_agent'],
            );
        }
        return $aArray;
    }

    public function saveReason($visitorId, $visitReasonId) {

        $post = new VisitorVisitReason;
        $post->visitor = $visitorId;
        $post->visit_reason = $visitReasonId;
        $post->save();
    }

    public function isEmailAddressTaken($email,$id = 0) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "email = '" . $email . "' ".($id?" AND id <> $id":"");
        $visitorEmail = Visitor::model()->findAll($Criteria);

        //$visitorEmail = array_filter($visitorEmail);
        $visitorEmailCount = count($visitorEmail);

        if ($visitorEmailCount == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkAsicStatusById($id=0) {
        $allow = 1;
        $visitor = Visitor::model()->findByPk($id);

        if($visitor){
            //If CardStatus is ASIC DENIED Return FALSE
            if($visitor->visitor_card_status == 5){
                $allow = 0;
            }
        }
        return $allow;
    }

    public function getIdOfUser($email) {
        $aArray = array();

        $Criteria = new CDbCriteria();
        $Criteria->condition = "email = '$email'";
        $visitorId = Visitor::model()->findAll($Criteria);

        foreach ($visitorId as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
            );
        }
        return $aArray;
    }

    public function getModelName()
    {
        return __CLASS__;
    }

    public function getCompany()
    {
        return Company::model()->findByPk($this->company);
    }

    public function getTotalVisit()
    {
        $totalVisit = 0;
        $activeVisits = $this->activeVisits;
        foreach($activeVisits as $visit) {
            $totalVisit += $visit->visitCounts;
        }
        if($totalVisit > 0 ) {
            return $totalVisit;
        } else {
            return "";
        }
    }

    public function getActiveVisits()
    {
        return Visit::model()->findAllByAttributes([
            'visitor' => $this->id,
            'reset_id'       => null,
            'negate_reason' => null
        ]);
    }

    public function getVisitorProfileIcon ()
    {
        switch ($this->profile_type) {
            case Visitor::PROFILE_TYPE_VIC :
                return '<img style="width: 25px" src="' . Yii::app()->controller->assetsBase . '/images/vic-visitor-icon.png"/>';
            case Visitor::PROFILE_TYPE_ASIC :
                return '<img style="width: 25px" src="' . Yii::app()->controller->assetsBase . '/images/asic-visitor-icon.png"/>';
            case Visitor::PROFILE_TYPE_CORPORATE :
                return '<img style="width: 25px" src="' . Yii::app()->controller->assetsBase . '/images/corporate-visitor-icon.png"/>';
        }

    }



    public function getFullName() {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function avms_visitor()
    {
        $condition = "profile_type = '". Visitor::PROFILE_TYPE_VIC ."' OR profile_type = '". Visitor::PROFILE_TYPE_ASIC ."'";
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $condition,
        ));
        return $this;
    }

    public function cvms_visitor()
    {
        $condition = "profile_type = '". Visitor::PROFILE_TYPE_CORPORATE ."'";
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $condition,
        ));
        return $this;
    }

}
