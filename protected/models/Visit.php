<?php
ini_set('xdebug.max_nesting_level', 200);
Yii::import('ext.validator.DropDown');
/**
 * This is the model class for table "visit".
 *
 * The followings are the available columns in table 'visit':
 * @property string $id
 * @property string $card
 * @property string $visitor_type
 * @property int $visit_status
 * @property string $reason
 * @property string $visitor_status
 * @property string $host
 * @property string $patient
 * @property string $created_by
 * @property string $date_in
 * @property string $time_in
 * @property string $date_out
 * @property string $time_out
 * @property string $date_check_in
 * @property string $time_check_in
 * @property string $date_check_out
 * @property string $time_check_out
 * @property string $tenant
 * @property string $tenant_agent
 * @property integer $is_deleted
 *
 * The followings are the available model relations:
 * @property User $tenantAgent
 * @property CardGenerated $card0
 * @property VisitReason $reason0
 * @property VisitorType $visitorType
 * @property VisitorStatus $visitorStatus
 * @property User $host0
 * @property Patient $patient0
 * @property User $createdBy
 * @property User $tenant0
 */
class Visit extends CActiveRecord {

    public $time_in_minutes;
    public $time_in_hours;
    private $_visitor;
    private $_firstname;
    private $_lastname;
    private $_company;
    private $_contactnumber;
    private $_contactemail;
    private $_datecheckin1;
    private $_cardnumber;
    public $filterProperties;
    public $companycode;
    public $date_of_birth;
    public $contact_number;
    public $contact_street_no;
    public $contact_street_name;
    public $contact_street_type;
    public $contact_suburb;
    public $contact_postcode;
    public $email;
    public $identification_type;
    public $identification_document_no;
    public $identification_document_expiry;
    public $asic_no;
    public $asic_expiry;
    public $contact_state;
    public $_contactperson;
    public $_contactphone;
    public $_asicname;
    public $other_reason;

    public $visitClockTime = array(
                '5:00' => '5:00',
                '5:30' => '5:30',
                '6:00' => '6:00',
                '6:30' => '6:30',
                '7:00' => '7:00',
                '7:30' => '7:30',
                '8:00' => '8:00',
                '8:30' => '8:30',
                '9:00' => '9:00',
                '9:30' => '9:30',
                '10:00' => '10:00',
                '10:30' => '10:30',
                '11:00' => '11:00',
                '11:30' => '11:30',
                '12:00' => '12:00',
                '12:30' => '12:30',
                '01:00' => '01:00',
                '01:30' => '01:30',
                '02:00' => '02:00',
                '02:30' => '02:30',
                '03:00' => '03:00',
                '03:30' => '03:30',
                '04:00' => '04:00',
                '04:30' => '04:30'
            );

    public $ampm;
    public $oClock = array(
                'am' => 'AM',
                'pm' => 'PM'
            );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'visit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('is_deleted', 'numerical', 'integerOnly' => true),
            array('visitor', 'required', 'on' => 'api'),
            
            //array('other_reason', 'unique','className'=>'VisitReason','attributeName'=>'reason','message'=>"Reason must be unique"),
            
            array('visitor_type,reason','required','on' => 'preregistration','message'=>'Please select {attribute}'),
            
            

            array('reason,visitor,visitor_status,workstation', 'required', 'on' => 'webapp'),
            array('visitor,card, visitor_type, reason, visitor_status,host, patient, created_by, tenant, tenant_agent', 'length', 'max' => 20),
            array('date_in,date_out,time_in_hours,time_in_minutes,visit_status, time_in, time_out, date_check_in, time_check_in, date_check_out, time_check_out,card_type, finish_date, finish_time, card_returned_date, negate_reason, reset_id, card_option, police_report_number, card_lost_declaration_file, workstation , other_reason,asic_escort', 'safe'),
            array('patient, host,card,tenant,tenant_agent', 'default', 'setOnEmpty' => true, 'value' => null),
            array('filterProperties', 'length', 'max' => 70),

            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,datecheckin1,cardnumber,company,firstname,lastname,contactnumber,contactemail,contactperson,contactphone,visit_status,visitor ,card,workstation, visitor_type, reason, visitor_status, host, patient, created_by, date_in, time_in, date_out, time_out, date_check_in, time_check_in, date_check_out, time_check_out, tenant, tenant_agent, is_deleted, companycode, contact_street_no, contact_street_name, contact_street_type, contact_suburb, contact_postcode, identification_type, identification_document_no, identification_document_expiry,asicname, asic_no, asic_expiry, workstation, date_of_birth, finish_date, card_returned_date', 'safe', 'on' => 'search'),
            array('id,datecheckin1,cardnumber,company,firstname,lastname,contactnumber,contactemail,contactperson,contactphone,visit_status,visitor ,card,workstation, visitor_type, reason, visitor_status, host, patient, created_by, date_in, time_in, date_out, time_out, date_check_in, time_check_in, date_check_out, time_check_out, tenant, tenant_agent, is_deleted, companycode, contact_street_no, contact_street_name, contact_street_type, contact_suburb, contact_postcode, identification_type, identification_document_no, identification_document_expiry,asicname, asic_no, asic_expiry, workstation, date_of_birth, finish_date, card_returned_date', 'safe', 'on' => 'search_history'),
            array('card_lost_declaration_file', 'file', 'types' => 'pdf,doc,docx,jpg,jpeg,gif,png', 'allowEmpty' => true, 'maxSize' => 1024 * 1024 * 10, 'wrongType'=>'Please upload file with these extensions pdf, doc, docx, jpg, jpeg, gif, png.'),
            
        );
    }

    public function getVisitor() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_visitor;
        }
    }

    public function setVisitor($value) {
        // set private attribute for search
        $this->_visitor = $value;
    }

    public function getDatecheckin1() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_datecheckin1;
        }
    }
    
   /* 
    * Below is rule for check out time for all VIC visits:
        1. Manual: Midnight of check out date
        2. 24 hour: same time as check in time
        3. EVIC: Midnight of the check out date
        4. Multiday: Midnight of the check out date
        5. Same day: Midnight of the check out date
    * 
    */
     public function beforeSave() { 
       
         //if($this->visit_status == VisitStatus::ACTIVE)
         switch( $this->card_type) {
             case CardType::VIC_CARD_SAMEDATE:
             case CardType::SAME_DAY_VISITOR:    
                 $this->time_check_out = '23:59:59';
                 $this->finish_time = '23:59:59';
                 $this->date_check_out = $this->date_check_in;
                 break;
             
             case CardType::VIC_CARD_MULTIDAY: 
             case CardType::VIC_CARD_EXTENDED:             
             case CardType::MANUAL_VISITOR:
             case CardType::MULTI_DAY_VISITOR:
             case CardType::CONTRACTOR_VISITOR:    
                 $this->time_check_out = '23:59:59';
                 $this->finish_time = '23:59:59';
                 break;
             
              case CardType::VIC_CARD_MANUAL:
                 $this->time_check_out = '23:59:59';
                 $this->finish_time = '23:59:59';
                 if( (empty($this->date_check_out) || $this->date_check_out == "0000-00-00" ) && $this->date_check_in != "0000-00-00") {
                    $this->date_check_out = date("Y-m-d" , ((3600*24) + strtotime($this->date_check_in)) );
                  }
                  break;
              
             case CardType::VIC_CARD_24HOURS:
                 $this->time_check_out = $this->time_check_in;
                 $this->finish_time = $this->time_check_in;
                 if( (empty($this->date_check_out) || $this->date_check_out == "0000-00-00" ) && $this->date_check_in != "0000-00-00") {
                    $this->date_check_out = date("Y-m-d" , ((3600*24) + strtotime($this->date_check_in)) );
                  }
                 break;
             default :
                 break;
         }
          return parent::beforeSave();
     }

     /**
      * Set Auto Closed Visit expired if the checkout date passed.
      * For 24Hour, EVIC
      * Where Visit_status is Auto Closed and Checkout date is today or has passed. 
      * @param type $value
      */
     public function beforeFind() {
       
       $this->updateAll(array("visit_status" => VisitStatus::CLOSED), 
                   " (card_type = ".CardType::VIC_CARD_24HOURS." OR card_type = ".CardType::VIC_CARD_EXTENDED.")"
                 . " AND visit_status = ".VisitStatus::AUTOCLOSED. " AND date_check_out <= '".date("Y-m-d")."'"
               . " AND tenant = ".Yii::app()->user->tenant );
                     
         return parent::beforeFind();
     }
     
    public function setDatecheckin1($value) {
        // set private attribute for search
        $this->_datecheckin1 = $value;
    }

    public function getFirstname() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_firstname;
        }
    }

    public function setFirstname($value) {
        // set private attribute for search
        $this->_firstname = $value;
    }

    public function getCardNumber() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_cardnumber;
        }
    }

    public function setCardNumber($value) {
        // set private attribute for search
        $this->_cardnumber = $value;
    }

    public function getLastname() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_lastname;
        }
        // return $this->_lastname;
    }

    public function setLastname($value) {
        // set private attribute for search
        $this->_lastname = $value;
    }

    public function getCompany() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_company;
        }
    }

    public function setCompany($value) {
        // set private attribute for search
        $this->_company = $value;
    }

    public function getContactNumber() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_contactnumber;
        }

//        if (isset($this->_contactnumber) && is_object($this->contactnumber)) {
//            return $this->user->lastname;
//        }
    }

    public function setContactNumber($value) {
        // set private attribute for search
        $this->_contactnumber = $value;
    }

    public function getContactEmail() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_contactemail;
        }
    }

    public function setContactEmail($value) {
        // set private attribute for search
        $this->_contactemail = $value;
    }

    public function getContactPerson() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_contactperson;
        }
    }

    public function setContactPerson($value) {
        // set private attribute for search
        $this->_contactperson = $value;
    }
    public function getContactPhone() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_contactphone;
        }
    }

    public function setContactPhone($value) {
        // set private attribute for search
        $this->_contactphone = $value;
    }
    public function getAsicName() {

        if ($this->scenario == 'search') {
            return $this->_asicname;
        }
    }

    public function setAsicName($value) {
        // set private attribute for search
        $this->_asicname = $value;
    }

    public function getHost() {
        // return private attribute on search
        if($this->card_type < 5) {
            $visitHost = User::model()->findByPk($this->host);
        } else {
            $visitHost = Visitor::model()->findByPk($this->host);
        }

        return $visitHost;

    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tenantAgent' => array(self::BELONGS_TO, 'User', 'tenant_agent'),
            'visitor0' => array(self::BELONGS_TO, 'Visitor', 'visitor'),
            'card0' => array(self::BELONGS_TO, 'CardGenerated', 'card'),
            'reason0' => array(self::BELONGS_TO, 'VisitReason', 'reason'),
            'visitorType' => array(self::BELONGS_TO, 'VisitorType', 'visitor_type'),
            'visitorStatus' => array(self::BELONGS_TO, 'VisitorStatus', 'visitor_status'),
            'host0' => array(self::BELONGS_TO, 'User', 'host'),
            'visitor1' => array(self::BELONGS_TO, 'Visitor', 'host'),
            'patient0' => array(self::BELONGS_TO, 'Patient', 'patient'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'tenant0' => array(self::BELONGS_TO, 'User', 'tenant'),
            'workstation0' => array(self::BELONGS_TO, 'Workstation', 'workstation'),
            // 'company0' => array(self::BELONGS_TO, 'Company', 'visitor0->company'),
            'company0' => array(
                self::BELONGS_TO, 'Company', array('company' => 'id'), 'through' => 'visitor0'
            ),
            'visitStatus' => array(self::BELONGS_TO, 'VisitStatus', 'visit_status'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'visitor' => 'Visitor',
            'card' => 'Card Generated',
            'card_type' => 'Card Type',
            'visitor_type' => 'Visitor Type',
            'reason' => 'Reason',
            'visitor_status' => 'Visitor Status',
            'host' => 'Host',
            'patient' => 'Patient',
            'created_by' => 'Created By',
            'date_in' => 'Proposed Check In Date',
            'time_in' => 'Proposed Check In Time',
            'date_out' => 'Proposed Check Out Date',
            'time_out' => 'Proposed Time Out',
            'date_check_in' => 'Check In Date',
            'time_check_in' => 'Check In Time',
            'date_check_out' => 'Check Out Date',
            'time_check_out' => 'Check Out Time',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
            'is_deleted' => 'Is Deleted',
            'visit_status' => 'Visit Status',
            'workstation' => 'Workstation',
            'firstname' => 'First Name',
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
        $criteria->with = array('card0','host0', 'visitor0', 'company0', 'reason0', 'workstation0','visitor1');
        //$criteria->with .= 'visitor0';
        $criteria->compare("CONCAT(visitor0.first_name, ' ', visitor0.last_name)", $this->visitor, true);
        $criteria->compare('visitor0.first_name', $this->firstname, true);
        $criteria->compare('visitor0.last_name', $this->lastname, true);
        $criteria->compare('visitor0.contact_number', $this->contactnumber, true);
        $criteria->compare('visitor0.email', $this->contactemail, true);
        $criteria->compare('date_check_in', $this->datecheckin1, true);
        $criteria->compare('company0.name', $this->company, true);
        $criteria->compare('card0.card_number', $this->cardnumber, true);

        $criteria->compare('t.id', $this->id, true);
        //  $criteria->compare('visitor', $this->visitor, true);
        $criteria->compare('card', $this->card, true);
        $criteria->compare('card_type', $this->card_type, true);
        $criteria->compare('t.visitor_type', $this->visitor_type, true);
        $criteria->compare('reason0.reason', $this->reason, true);
        $criteria->compare('t.visitor_status', $this->visitor_status, true);
        $criteria->compare('host', $this->host, true);
        $criteria->compare('patient', $this->patient, true);
        $criteria->compare('created_by', $this->created_by, true);

        $criteria->compare('date_in', $this->date_in, true);
        //$criteria->compare("DATE_FORMAT(date_in,'%Y-%m-%d')",$this->date_in);

        $criteria->compare('time_in', $this->time_in, true);
        $criteria->compare('date_out', $this->date_out, true);
        $criteria->compare('time_out', $this->time_out, true);

        // $criteria->compare('date_check_in', $this->date_check_in, true);
        $criteria->mergeWith($this->dateRangeSearchCriteria('date_check_in', $this->date_check_in));

        $criteria->compare('time_check_in', $this->time_check_in, true);
        // $criteria->compare('date_check_out', $this->date_check_out, true);
        $criteria->compare('time_check_out', $this->time_check_out, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('t.is_deleted', $this->is_deleted, "0");
        $criteria->compare('visit_status', $this->visit_status);
        $criteria->compare('workstation0.name', $this->workstation);

        $criteria->compare('company0.code', $this->companycode, true);
        $criteria->compare('company0.contact', $this->_contactperson, true);
        $criteria->compare('company0.email_address', $this->_contactemail, true);
        $criteria->compare('company0.mobile_number', $this->_contactphone, true);
        //$criteria->compare('DATE_FORMAT(visitor0.date_of_birth, "%Y-%m-%d")', $this->date_of_birth, true);
        $criteria->compare('visitor0.date_of_birth', $this->date_of_birth, true);

        $criteria->compare('visitor0.contact_street_no', $this->contact_street_no, true);
        $criteria->compare('visitor0.contact_street_name', $this->contact_street_name, true);
        $criteria->compare('visitor0.contact_street_type', $this->contact_street_type, true);
        $criteria->compare('visitor0.contact_suburb', $this->contact_suburb, true);
        $criteria->compare('visitor0.contact_postcode', $this->contact_postcode, true);
        $criteria->compare('visitor0.identification_type', $this->identification_type, true);
        $criteria->compare('visitor0.identification_document_no', $this->identification_document_no, true);
        //$criteria->compare('DATE_FORMAT(visitor0.identification_document_expiry, "%Y-%m-%d")', $this->identification_document_expiry, true);
        $criteria->compare('visitor0.identification_document_expiry', $this->identification_document_expiry, true);
        switch($this->card_type){
            case CardType::SAME_DAY_VISITOR:
            case CardType::MULTI_DAY_VISITOR:
            case CardType::MANUAL_VISITOR:
            case CardType::CONTRACTOR_VISITOR:
                $criteria->compare("CONCAT(host0.first_name,' ',host0.last_name)",$this->_asicname,true);
                break;
            default:
                $criteria->compare("CONCAT(visitor1.first_name,' ',visitor1.last_name)",$this->_asicname,true);
                break;
        }
        $criteria->compare('visitor0.asic_no', $this->asic_no, true);
        #$criteria->compare('DATE_FORMAT(visitor0.asic_expiry, "%Y-%m-%d")', $this->asic_expiry, true);
        $criteria->compare('visitor0.asic_expiry', $this->asic_expiry, true);

        $criteria->compare('finish_date', $this->finish_date, true);
        $criteria->compare('card_returned_date', $this->card_returned_date, true);

        if ($merge !== null) {
            $criteria->mergeWith($merge);
        }
        // $criteria->addCondition("t.date_check_out > DATE_ADD(now(),interval -2 day)");
        if ($this->filterProperties) {
            $query = "t.id LIKE CONCAT('%', :filterProperties , '%')
                OR card0.card_number LIKE CONCAT('%', :filterProperties , '%')
                OR company0.code LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.first_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.last_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.date_of_birth LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_number LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_suburb LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_state LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_postcode LIKE CONCAT('%', :filterProperties , '%')
                OR reason0.reason LIKE CONCAT('%', :filterProperties , '%')
                OR workstation0.name LIKE CONCAT('%', :filterProperties , '%')
                OR company0.name LIKE CONCAT('%', :filterProperties , '%')
                OR company0.contact LIKE CONCAT('%', :filterProperties , '%')
                OR company0.mobile_number LIKE CONCAT('%', :filterProperties , '%')
                OR company0.email_address LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_type LIKE CONCAT('%', :filterProperties , '%')
                OR finish_date LIKE CONCAT('%', :filterProperties , '%')
                OR card_returned_date LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_type LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_document_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_document_expiry LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.asic_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.asic_expiry LIKE CONCAT('%', :filterProperties , '%')";

            switch($this->card_type){
                case CardType::SAME_DAY_VISITOR:
                case CardType::MULTI_DAY_VISITOR:
                case CardType::MANUAL_VISITOR:
                case CardType::CONTRACTOR_VISITOR:
                    $query .= "OR host0.first_name LIKE CONCAT('%', :filterProperties , '%')
                    OR host0.last_name LIKE CONCAT('%', :filterProperties , '%')";
                    break;
                default:
                    $query .= "OR visitor1.first_name LIKE CONCAT('%', :filterProperties , '%')
                    OR visitor1.last_name LIKE CONCAT('%', :filterProperties , '%')";
                    break;
            }
            $criteria->addCondition($query);
            $criteria->params = array(':filterProperties' => $this->filterProperties);
        }

        if (Yii::app()->user->role == Roles::ROLE_STAFFMEMBER && Yii::app()->controller->action->id != 'view' && Yii::app()->controller->action->id != 'evacuationReport') {
            $criteria->addCondition('host = ' . Yii::app()->user->id . ' and visit_status = ' . VisitStatus::PREREGISTERED);
        }

        switch (Yii::app()->user->role) {
            case Roles::ROLE_STAFFMEMBER:
                $criteria->addCondition("host = " . Yii::app()->user->id);
                break;

            case Roles::ROLE_SUPERADMIN:
                $criteria->addCondition("t.id != ''");
                break;

            case Roles::ROLE_ADMIN:
                $criteria->addCondition('t.tenant = ' . Yii::app()->user->tenant);
                break;

            case Roles::ROLE_AGENT_ADMIN:
                $criteria->addCondition('t.tenant = ' . Yii::app()->user->tenant . ' and t.tenant_agent = ' . Yii::app()->user->tenant_agent);
                break;

            case Roles::ROLE_OPERATOR:
            case Roles::ROLE_AGENT_OPERATOR:
                $workstations = Workstation::model()->findWorkstationAvailableForUser(Yii::app()->user->id);
                if (!empty($workstations)) {
                    $text = "";
                    foreach ($workstations as $key => $value) {
                        $text .= "" . $value['id'] . ",";
                    }
                    $workstations = "IN (" . rtrim($text, ',') . ")";

                    $criteria->addCondition('t.workstation '.$workstations.'');
                }
                break;
        }

        $criteria->addCondition('t.is_deleted = 0');

        /*
         * this condition is a hack to show only CORPORATE VISITOR in the listing report
         *
         */
        if (Yii::app()->controller->action->id == 'visitorRegistrationHistory') {
            $criteria->addCondition("visitor0.profile_type = '" . Visitor::PROFILE_TYPE_CORPORATE . "'");
        }

        if (Yii::app()->controller->action->id == 'admindashboard') {
            Yii::app()->user->setState('pageSize', (int) '5');
        } else {
            Yii::app()->user->setState('pageSize', (int) '');
        }

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.ID DESC',
                'attributes' => array(
                    'firstname' => array(
                        'asc' => 'visitor0.first_name',
                        'desc' => 'visitor0.first_name DESC',
                    ),
                    'lastname' => array(
                        'asc' => 'visitor0.last_name',
                        'desc' => 'visitor0.last_name DESC',
                    ),
                    'contactnumber' => array(
                        'asc' => 'visitor0.contact_number',
                        'desc' => 'visitor0.contact_number DESC',
                    ),
                    'contactemail' => array(
                        'asc' => 'visitor0.email',
                        'desc' => 'visitor0.email DESC',
                    ),
                    'cardnumber' => array(
                        'asc' => 'card0.card_number',
                        'desc' => 'card0.card_number DESC',
                    ),
                    'company' => array(
                        'asc' => 'company0.name',
                        'desc' => 'company0.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function search_history($merge = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('card0','host0', 'visitor0', 'company0','visitor1');
        //$criteria->with .= 'visitor0';
        $criteria->compare('CONCAT(visitor0.first_name, \' \', visitor0.last_name)', $this->visitor, true);
        $criteria->compare('visitor0.first_name', $this->firstname, true);
        $criteria->compare('visitor0.last_name', $this->lastname, true);
        $criteria->compare('visitor0.contact_number', $this->contactnumber, true);
        $criteria->compare('visitor0.email', $this->contactemail, true);
        $criteria->compare('date_check_in', $this->datecheckin1, true);
        $criteria->compare('company0.name', $this->company, true);
        $criteria->compare('card0.card_number', $this->cardnumber, true);

        $criteria->compare('t.id', $this->id, true);
        //  $criteria->compare('visitor', $this->visitor, true);
        $criteria->compare('card', $this->card, true);
        $criteria->compare('card_type', $this->card_type, true);
        $criteria->compare('t.visitor_type', $this->visitor_type, true);
        $criteria->compare('reason', $this->reason, true);
        $criteria->compare('t.visitor_status', $this->visitor_status, true);
        $criteria->compare('host', $this->host, true);
        $criteria->compare('patient', $this->patient, true);
        $criteria->compare('created_by', $this->created_by, true);

        $criteria->compare('date_in', $this->date_in, true);
        //$criteria->compare("DATE_FORMAT(date_in,'%Y-%m-%d')",$this->date_in);

        $criteria->compare('time_in', $this->time_in, true);
        $criteria->compare('date_out', $this->date_out, true);
        $criteria->compare('time_out', $this->time_out, true);

        // $criteria->compare('date_check_in', $this->date_check_in, true);
        $criteria->mergeWith($this->dateRangeSearchCriteria('DATE_FORMAT(date_check_in, "%d-%m-%Y")', $this->date_check_in));
        $criteria->mergeWith($this->dateRangeSearchCriteria('DATE_FORMAT(date_check_out, "%d-%m-%Y")', $this->date_check_out));

        $criteria->compare('time_check_in', $this->time_check_in, true);
        // $criteria->compare('date_check_out', $this->date_check_out, true);
        $criteria->compare('time_check_out', $this->time_check_out, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('t.is_deleted', $this->is_deleted, "0");
        $criteria->compare('visit_status', $this->visit_status);
        $criteria->compare('workstation', $this->workstation);

        $criteria->compare('company0.code', $this->companycode, true);
        $criteria->compare('company0.contact', $this->_contactperson, true);
        $criteria->compare('company0.email_address', $this->_contactemail, true);
        $criteria->compare('company0.mobile_number', $this->_contactphone, true);
        $criteria->compare('visitor0.date_of_birth', $this->date_of_birth, true);
        $criteria->compare('visitor0.contact_street_no', $this->contact_street_no, true);
        $criteria->compare('visitor0.contact_street_name', $this->contact_street_name, true);
        $criteria->compare('visitor0.contact_street_type', $this->contact_street_type, true);
        $criteria->compare('visitor0.contact_suburb', $this->contact_suburb, true);
        $criteria->compare('visitor0.contact_postcode', $this->contact_postcode, true);
        $criteria->compare('visitor0.identification_type', $this->identification_type, true);
        $criteria->compare('visitor0.identification_document_no', $this->identification_document_no, true);
        $criteria->compare('visitor0.identification_document_expiry', $this->identification_document_expiry, true);
        switch($this->card_type){
            case CardType::SAME_DAY_VISITOR:
            case CardType::MULTI_DAY_VISITOR:
            case CardType::MANUAL_VISITOR:
            case CardType::CONTRACTOR_VISITOR:
                $criteria->compare('CONCAT(host0.first_name,\' \',host0.last_name)',$this->_asicname,true);
                break;
            default:
                $criteria->compare('CONCAT(visitor1.first_name,\' \',visitor1.last_name)',$this->_asicname,true);
                break;
        }
        $criteria->compare('visitor0.asic_no', $this->asic_no, true);
        $criteria->compare('visitor0.asic_expiry', $this->asic_expiry, true);
        $criteria->compare('finish_date', $this->finish_date, true);
        $criteria->compare('card_returned_date', $this->card_returned_date, true);

        if ($merge !== null) {
            $criteria->mergeWith($merge);
        }

        if ($this->date_check_out) {
            if (Yii::app()->params['dbDriver'] == 'mssql') {
                $criteria->addCondition("CONVERT(date, t.date_check_out, 102) > DATEADD(day, -2, GETDATE())");
            } else {
                $criteria->addCondition("str_to_date(t.date_check_out,'%Y-%m-%d') > DATE_ADD(now(),interval -2 day)");
            }
        }

        if ($this->filterProperties) {
            $query = "t.id LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.first_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.last_name LIKE CONCAT('%', :filterProperties , '%')
                OR company0.code LIKE CONCAT('%', :filterProperties , '%')
                OR company0.name LIKE CONCAT('%', :filterProperties , '%')
                OR company0.contact LIKE CONCAT('%', :filterProperties , '%')
                OR company0.mobile_number LIKE CONCAT('%', :filterProperties , '%')
                OR company0.email_address LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.date_of_birth LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_number LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_type LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_suburb LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_postcode LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_type LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_document_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_document_expiry LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.asic_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.asic_expiry LIKE CONCAT('%', :filterProperties , '%')";
            switch($this->card_type){
                case CardType::SAME_DAY_VISITOR:
                case CardType::MULTI_DAY_VISITOR:
                case CardType::MANUAL_VISITOR:
                case CardType::CONTRACTOR_VISITOR:
                    $query .= "OR host0.first_name LIKE CONCAT('%', :filterProperties , '%')
                    OR host0.last_name LIKE CONCAT('%', :filterProperties , '%')";
                    break;
                default:
                    $query .= "OR visitor1.first_name LIKE CONCAT('%', :filterProperties , '%')
                    OR visitor1.last_name LIKE CONCAT('%', :filterProperties , '%')";
                    break;
            }
            $criteria->addCondition($query);
            $criteria->params = array(':filterProperties' => $this->filterProperties);
        }

        if (Yii::app()->user->role == Roles::ROLE_STAFFMEMBER && Yii::app()->controller->action->id != 'view' && Yii::app()->controller->action->id != 'evacuationReport') {
            $criteria->addCondition('host = ' . Yii::app()->user->id . ' and visit_status = ' . VisitStatus::PREREGISTERED);
        }

        switch (Yii::app()->user->role) {
            case Roles::ROLE_STAFFMEMBER:
                $criteria->addCondition('host = ' . Yii::app()->user->id);
                break;

            case Roles::ROLE_SUPERADMIN:
                $criteria->addCondition("t.id != ''");
                break;

            case Roles::ROLE_ADMIN:
                $criteria->addCondition('t.tenant = ' . Yii::app()->user->tenant);
                break;

            case Roles::ROLE_AGENT_ADMIN:
                $criteria->addCondition('t.tenant = ' . Yii::app()->user->tenant . ' and t.tenant_agent = ' . Yii::app()->user->tenant_agent);
                break;

            case Roles::ROLE_OPERATOR:
            case Roles::ROLE_AGENT_OPERATOR:
                $workstations = Workstation::model()->findWorkstationAvailableForUser(Yii::app()->user->id);
                if (!empty($workstations)) {
                    $text = "";
                    foreach ($workstations as $key => $value) {
                        $text .="" . $value['id'] . ",";
                    }
                    $workstations = "IN (" . rtrim($text, ',') . ")";

                    $criteria->addCondition('t.workstation ' . $workstations . '');
                }
                break;
        }

        $criteria->addCondition('t.is_deleted = 0');

        /*
         * this condition is a hack to show only CORPORATE VISITOR in the listing report
         * 
         */
        if (Yii::app()->controller->action->id == 'visitorRegistrationHistory') {
            $criteria->addCondition("visitor0.profile_type ='" . Visitor::PROFILE_TYPE_CORPORATE . "'");
        }

        if (Yii::app()->controller->action->id == 'view' && (!empty($this->date_check_in) || !empty($this->date_check_out))) {
            $criteria->addCondition("visit_status =" . VisitStatus::ACTIVE . "");
        }
        
        if (Yii::app()->controller->action->id == 'admindashboard') {
            Yii::app()->user->setState('pageSize', (int) '5');
        } else {
            Yii::app()->user->setState('pageSize', (int) '');
        }

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.ID DESC',
                'attributes' => array(
                    'firstname' => array(
                        'asc' => 'visitor0.first_name',
                        'desc' => 'visitor0.first_name DESC',
                    ),
                    'lastname' => array(
                        'asc' => 'visitor0.last_name',
                        'desc' => 'visitor0.last_name DESC',
                    ),
                    'contactnumber' => array(
                        'asc' => 'visitor0.contact_number',
                        'desc' => 'visitor0.contact_number DESC',
                    ),
                    'contactemail' => array(
                        'asc' => 'visitor0.email',
                        'desc' => 'visitor0.email DESC',
                    ),
                    'cardnumber' => array(
                        'asc' => 'card0.card_number',
                        'desc' => 'card0.card_number DESC',
                    ),
                    'company' => array(
                        'asc' => 'company0.name',
                        'desc' => 'company0.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Visit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'softDelete' => array(
                'class' => 'ext.soft_delete.SoftDeleteBehavior'
            ),
            'dateRangeSearch' => array(
                'class' => 'application.components.behaviors.EDateRangeSearchBehavior',
            ),
            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
            'DateTimeZoneAndFormatBehavior' => 'application.components.DateTimeZoneAndFormatBehavior',
        );
    }

    public function exportVisitorRecords() {
        $rawData = Yii::app()->db->createCommand("SELECT "
                        . "visit.card,visitor.first_name, visitor.last_name,visit_status.name as visitStatus,visitor_status.name as visitorStatus,"
                        . "visitor.email,visitor.contact_number,visitor_type.name as visitorType,company.name as CompanyName,visit.date_in, "
                        . "visit.time_in "
                        . "FROM visit "
                        . "LEFT JOIN visitor ON visitor.id = visit.visitor "
                        . "LEFT JOIN company ON visitor.company = company.id "
                        . "LEFT JOIN visit_status ON visit.visit_status = visit_status.id "
                        . "LEFT JOIN visitor_type ON visit.visitor_type = visitor_type.id "
                        . "LEFT JOIN visitor_status ON visitor.visitor_status = visitor_status.id "
                        . "WHERE visit.is_deleted= 0")->queryAll();
        return $rawData;
    }

    public function updateVisitsToClose() {
        /* update visit status to close and card status to not return if
         * current date is greater than date out and if visit status is still active
         * and card status is still active and card type is same day visitor  
         */
        try {
            $commandUpdateCard = "";

            $command = Yii::app()->db->createCommand("UPDATE visit
                    LEFT JOIN card_generated ON card_generated.id = visit.card
                    SET visit_status = " . VisitStatus::CLOSED . ",card_status =" . CardStatus::NOT_RETURNED . "
                    WHERE CURRENT_DATE > date_out AND visit_status = " . VisitStatus::ACTIVE . "
                    AND card_status = " . CardStatus::ACTIVE . " and card_type= " . CardType::SAME_DAY_VISITOR . "")->execute();
            echo "Affected Rows : " . $command . "<br>";
            if ($command > 0) {
                echo "Update visit to close status successful.";
            } else {
                echo "No record to update.";
            }

            return true;
        } catch (Exception $ex) {
            echo 'Query failed', $ex->getMessage();
            return false;
        }
    }

    /* EVIC card type is issued Strictly for 28 days
     * update visit status to close and card status to return if
     * current date is greater than date check out and if visit status is still active
     * and card status is still active
     */
    public function updateMultiDayVisitsToClose() {
        try {
            $commandUpdateCard = "";

            $command = Yii::app()->db->createCommand("UPDATE visit
                    SET visit_status = " . VisitStatus::EXPIRED
                        . ", card_option =" . CardStatus::RETURNED
                        . ", finish_date = CURRENT_DATE, finish_time = CURRENT_TIME
                    WHERE CURRENT_DATE > date_check_out
                    AND visit_status = " . VisitStatus::ACTIVE . "
                    AND (card_type = " . CardType::VIC_CARD_EXTENDED . "
                    OR card_type = ". CardType::VIC_CARD_MULTIDAY .")")->execute();

            echo "Affected Rows : " . $command . "\n";
            if ($command > 0) {
                echo "Success: Update VIC Extended and Multiday visits to close status successful. \n";
            } else {
                echo "Success: No record to update. \n";
            }

            return true;
        } catch (Exception $ex) {
            echo 'Error: Query failed', $ex->getMessage() . '\n';
            return false;
        }
    }

    /* update visit status to expired and card status to not returned if
     * current date is greater than date expiration and visit status is still active
     * and card status is still active and if card type is same day visitor
     */
    public function updateOneDayVisitsToClose() {
        try {
            $command = Yii::app()->db->createCommand(
                "UPDATE visit SET visit_status = " . VisitStatus::CLOSED
                    . ", card_option =" . CardStatus::RETURNED
                    . ", finish_date = CURRENT_DATE, finish_time = CURRENT_TIME
                    WHERE CURRENT_DATE > date_check_out
                    AND CURRENT_TIME > time_check_out
                    AND visit_status = " . VisitStatus::ACTIVE . "
                    AND card_type = " . CardType::VIC_CARD_24HOURS . "")->execute();

            echo "Affected Rows : " . $command . "\n";
            if ($command > 0) {
                echo "Success: Update VIC 24 and Manual visits to close status successful. \n";
            } else {
                echo "Success: No record to update. \n";
            }

            return true;
        } catch (Exception $ex) {
            echo 'Error: Query failed', $ex->getMessage() . '\n';
            return false;
        }
    }

    public function updateSameDayVisitsToExpired() {
        try {
            $command = Yii::app()->db->createCommand(
                "UPDATE visit SET visit_status = " . VisitStatus::EXPIRED
                    . ", card_option =" . CardStatus::RETURNED
                    . ", finish_date = CURRENT_DATE , finish_time = CURRENT_TIME
                    WHERE CURRENT_DATE >= date_check_out
                    AND CURRENT_TIME > time_check_out
                    AND visit_status = " . VisitStatus::ACTIVE . "
                    AND card_type = " . CardType::VIC_CARD_SAMEDATE . "")->execute();

            echo "Affected Rows : " . $command . "\n";
            if ($command > 0) {
                echo "Success: Update VIC Sameday visits to expired status successful. \n";
            } else {
                echo "Success: No record to update. \n";
            }

            return true;
        } catch (Exception $ex) {
            echo 'Error: Query failed', $ex->getMessage() . '\n';
            return false;
        }
    }

    public function updateVisitsToExpired() {
        /* update visit status to expired and card status to not returned if
         * current date is greater than date expiration and visit status is still active
         * and card status is still active and if card type is multi day visitor
         */
        try {

            $command = Yii::app()->db->createCommand("UPDATE visit
                    LEFT JOIN card_generated ON card_generated.id = visit.card 
                    SET visit_status = " . VisitStatus::EXPIRED . ",card_status =" . CardStatus::NOT_RETURNED . "
                    WHERE CURRENT_DATE > date_expiration AND visit_status = " . VisitStatus::ACTIVE . "
                    AND card_status =" . CardStatus::ACTIVE . " and card_type=" . CardType::MULTI_DAY_VISITOR . "")->execute();

            echo "Affected Rows : " . $command . "<br>";
            if ($command > 0) {
                echo "Update visit to expired status successful.";
            } else {
                echo "No record to update.";
            }

            return true;
        } catch (Exception $ex) {
            echo 'Query failed', $ex->getMessage();
            return false;
        }
    }

    public function isVisitorHasCurrentSavedVisit($visitorId) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "visitor = " . $visitorId . " AND visit_status = " . VisitStatus::SAVED;
        $visit = Visit::model()->findAll($Criteria);

        $visitCount = count($visit);

        if ($visitCount == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function isDateConflictingWithAnotherVisit($date_in, $date_out, $visitorId, $visitStatus) {
        $Criteria = new CDbCriteria();
        if ($visitStatus == VisitStatus::ACTIVE) {
            $Criteria->condition = "visitor = " . $visitorId . " AND visit_status = " . $visitStatus;
        } else {
            $Criteria->condition = "date_in = '" . $date_in . "' AND visitor = " . $visitorId . " AND visit_status = " . $visitStatus;
        }
        $visit = Visit::model()->findAll($Criteria);

        $visitCount = count($visit);

        if ($visitCount == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getVisitCount($visitId) {

        $allVisitsByVisitor = Yii::app()->db->createCommand("SELECT COUNT(*) as cnt "
                        . "FROM visit "
                        . "WHERE visit.visitor= (SELECT visitor FROM visit "
                        . "WHERE visit.id= " . $visitId . ")")->queryAll();

        $res_visitor = Yii::app()->db->createCommand("SELECT visitor FROM visit WHERE visit.id= " . $visitId)->queryAll();
        if ($res_visitor) {
            $visitor = $res_visitor[0]['visitor'];
            $userTbl = Yii::app()->params['userTbl'];
//            $res_company = Yii::app()->db->createCommand("SELECT company.id AS company_id, company.name AS company_name
//                                                        FROM visit
//                                                        LEFT JOIN $userTbl ON $userTbl.id = visit.host
//                                                        LEFT JOIN company ON $userTbl.company = company.id
//                                                        WHERE company.is_deleted = 0
//                                                        AND visit.id = " . $visitId)->queryAll();
            $res_company = Visit::model()->with("company0", "host0", "visitor0")->find("t.id = ".$visitId);
            
            if ($res_company) {
                $company = $res_company["company0"]['id'];  
            } else {
                $company = 0;
            }


//            $res_host = Yii::app()->db->createCommand("SELECT id
//                                                        FROM $userTbl
//                                                        WHERE $userTbl.is_deleted=0
//                                                        AND $userTbl.company=" . $company)->queryAll();
            
            $res_host = User::model()->findAll();

            if ($res_host) {
                foreach ($res_host as $arr_val) {
                    $arr[] = $arr_val['id'];
                }

                $hosts = implode(",", $arr);
                $sql_company_visit_by_visitor = "SELECT COUNT(*) as cnt
                        FROM visit
                        WHERE visit.is_deleted = 0 AND visit.visitor= " . $visitor. "
                        AND host IN (" . $hosts . ")";


                $companyVisitsByVisitor = Yii::app()->db->createCommand($sql_company_visit_by_visitor)->queryAll();

                $countData = array('allVisitsByVisitor' => $allVisitsByVisitor[0]['cnt'],
                                    'companyVisitsByVisitor' => $companyVisitsByVisitor[0]['cnt'],
                                    'companyName' => $res_company["company0"]['name']);

                return $countData;
            } else {
                return [];
            }


        }
        return [];
    }

    public function getVisitCounts() {
        $dateIn   = new DateTime($this->date_check_in);
        $dateOut  = new DateTime($this->date_check_out);
        $dateNow  = new DateTime(date('Y-m-d'));
        $criteria = new CDbCriteria;

        //$criteria->addCondition("(visit_status = " . VisitStatus::AUTOCLOSED . " OR visit_status = " . VisitStatus::CLOSED . ") AND visitor = " . $this->visitor);
        $oldVisitsCount = $this->getOldVisitsCountForThisYear($this->id, $this->visitor);
         if($this->visit_status == VisitStatus::PREREGISTERED)
            return $oldVisitsCount;
         
        switch ($this->card_type) {
            case CardType::VIC_CARD_MANUAL:
            
                 $isExpired = $dateNow->diff($dateOut)->format("%r%a");
                if( $isExpired < 0 ) 
                     $totalCount = $dateOut->diff($dateIn)->days + 1;
                else
                     $totalCount = $dateIn->diff($dateNow)->days + 1;
                 return $totalCount + $oldVisitsCount;
                break;
            
            case CardType::VIC_CARD_SAMEDATE:
                if (in_array($this->visit_status, [VisitStatus::CLOSED, VisitStatus::AUTOCLOSED, VisitStatus::EXPIRED])) {
                   // return 1;
                    
                }
                 $isExpired = $dateNow->diff($dateOut)->format("%r%a");
                if( $isExpired < 0 ) 
                     $totalCount = $dateOut->diff($dateIn)->days + 1;
                else
                     $totalCount = $dateIn->diff($dateNow)->days + 1;
                
                 return $totalCount + $oldVisitsCount;
                 
             case CardType::VIC_CARD_24HOURS:
                //return (int)$this->count($criteria);
                $isExpired = $dateNow->diff($dateOut)->format("%r%a");
                if( $isExpired < 0 ) 
                     $totalCount = $dateOut->diff($dateIn)->days;
                else
                     $totalCount = $dateIn->diff($dateNow)->days + 1;
                 return $totalCount + $oldVisitsCount;
                 
                break;

            case CardType::VIC_CARD_MULTIDAY:
                $isExpired = $dateNow->diff($dateOut)->format("%r%a");
                if( $isExpired < 0 ) 
                     $totalCount = $dateOut->diff($dateIn)->days + 1;
                else
                     $totalCount = $dateIn->diff($dateNow)->days + 1;
                
                 // Add Old visits
                if ($oldVisitsCount > 0) {
                    $totalCount += $oldVisitsCount;
                }
                               
                return $totalCount;
                break;
                
            case CardType::VIC_CARD_EXTENDED:
                switch ($this->visit_status) {
                    case VisitStatus::AUTOCLOSED:
                        $totalCount =  $dateOut->diff($dateIn)->days + 1;
                        break;
                    default:
                    
                       if ($dateOut->diff($dateNow)->format("%r%a") > 0)  
                           $totalCount =  $dateIn->diff($dateOut)->days + 1;  
                        if( $dateOut->diff($dateNow)->format("%r%a") <=  0)
                            $totalCount =  $dateIn->diff($dateNow)->days + 1;                 
                        break;
                }
                 // Add Old visits
                if ($oldVisitsCount > 0) {
                    $totalCount += $oldVisitsCount;
                }
                return $totalCount;
                break;
        }
    }

    public function getRemainingDays() {
        $dateNow = new DateTime(date('Y-m-d'));
        $dateOut = new DateTime($this->date_check_out);
        $dateIn  = new DateTime($this->date_check_in);

        if ($this->visit_status == VisitStatus::SAVED) {
            return 28;
        }
        
        switch ($this->card_type) {
            case CardType::VIC_CARD_MANUAL:
            case CardType::VIC_CARD_24HOURS:
            case CardType::VIC_CARD_SAMEDATE:
                return 28 - (int)$this->visitCounts;
                break;
            case CardType::VIC_CARD_MULTIDAY:
                 return 28 - (int)$this->visitCounts;
                break;
            case CardType::VIC_CARD_EXTENDED:
                return 28 - (int)$this->visitCounts;
//                $totalDays = $dateOut->diff($dateIn)->days + 1;
//                switch ($this->visit_status) {
//                    case VisitStatus::AUTOCLOSED:
//                        return $dateOut->diff($dateNow)->days + 1;
//                        break;
//                    default:
//                        if ($dateNow->diff($dateOut)->format("%r%a") <= 0) {
//                            return $dateOut->diff($dateIn)->days + 1;
//                        }
//                        return $totalDays - $this->visitCounts;
//                        break;
//                }
                break;
        }
        
    }

    /**
     * This method counts a visitors all visits in the current calender year.
     * Visit counts depends upon the days between the dateIN and DateOut.  
     * @param int $current_visit_id
     * @param int $visitor_id
     * @return int
     */
    public function getOldVisitsCountForThisYear($current_visit_id, $visitor_id) {
        $criteria = new CDbCriteria;
        $criteria->addCondition(" ( id != ".$current_visit_id." ) AND "
                . "tenant = ".Yii::app()->user->tenant." AND (visit_status != ".VisitStatus::SAVED." && visit_status != ".VisitStatus::PREREGISTERED."  ) AND visitor = " . $this->visitor);
        $visits = $this->findAll($criteria);
       if( $visits ) {
           $visitCount  = 0;
           foreach( $visits as $key => $v ) {
               $dateIn  = new DateTime($v["date_check_in"]);
               $dateOut = new DateTime($v["date_check_out"]);
               $dateNow = new DateTime("NOW");
               
               // For the current Year Only
               if( $dateNow->format("Y") == $dateIn->format("Y") )
                  $visitCount += $dateIn->diff($dateOut)->days + 1;
           }
           return $visitCount;
           
       } else
       {
           return 0;
       }
       
    } 
    /**
     * Set Expire Or Close all visits that should be expired today under a tenant
     * * Set status as Closed of the VIC 24Hours visit only if date/time checkout reached current date/time.
     *   Below is the flow for the all VIC visit cards:
        * 24 hour* – Saved, Preregister, Active, Auto Closed (Operator can Preregister for future dates)
        * Same day* - Saved, Preregister, Active, Expired, Closed
        * Extended* - Saved, Preregister, Active, Auto Closed (Operator can Preregister for future dates) / Expired, Closed
        * Multiday *- Saved, Preregister, Active, Expired, Closed
        * Manual *- Saved, Preregister, Active, Closed 
     * 
     */
    public function setExpireOrClosedVisits( $tenant_Id, $visit_id = "" ) {
        //Get All Active Visits of a Tenant
        $criteria = new CDbCriteria;
        $criteria->addCondition("tenant = ".$tenant_Id ." AND visit_status = ".VisitStatus::ACTIVE);
        if( !empty( $visit_id) )
            $criteria->addCondition("id = ".$visit_id);
        $visits = $this->findAll($criteria);
        $session = new CHttpSession;
        $timezone = $session["timezone"]; 
        //Has Active visits?? Then
        if( $visits )
        foreach( $visits as $key => $visit ) {
        
        // Set closed visit if time-checkout reached current time.   
         $dateIn  = new DateTime($visit["date_check_in"]);
         $dateOut = new DateTime($visit["date_check_out"]);
         $dateNow = new DateTime("NOW", new DateTimeZone($timezone));
         $isExpired = $dateOut->diff($dateNow)->format("%r%a");
         if( $isExpired > 0 )  { //   expired or will expire today 
              
             $status = "";
            //VIC 24Hours visit will be Closed and Manual visit will be Closed manaually, Other visits will be Expired.
            if( $visit->card_type == CardType::VIC_CARD_24HOURS ) {
                $status = VisitStatus::CLOSED;
            } else if( $visit->card_type != CardType::VIC_CARD_24HOURS 
                    && $visit->card_type != CardType::VIC_CARD_MANUAL 
                    && $visit->card_type != CardType::MANUAL_VISITOR ) {
                $status = VisitStatus::EXPIRED;
            } 
             //Get current time to compare with current visit time
             $current = new DateTime('NOW', new DateTimeZone($timezone));
             $current_hour = $current->format("H");
             $current_minutes = $current->format("i"); 
             
            // Visit Time
             $time_checkout = $visit->time_check_out != "00:00:00"? $visit->time_check_out: $visit->finish_time;      
             $checkoutdatetime = $visit->date_check_out." ".$time_checkout;
             $checkout = new DateTime($checkoutdatetime);
             $checkout->setTimezone(new DateTimeZone($timezone));
             //compare Time hours and minutes
             if(  $current_hour > $checkout->format("H") || $isExpired > 0
                     || ( $current_hour == $checkout->format("H") && $current_minutes >= $checkout->format("i")) ) {
                     //Update
                     if( !empty($status) )
                        $this->updateByPk($visit->id, array("visit_status" => $status));     
             }
           }
        }
    }
    
    /**
        * Set Expire Or Close all visits that should be expired
     * * Set status as Closed of the VIC 24Hours visit only if date/time checkout reached current date/time.
     * @return type
     */
    public function afterFind() {
        
         $session = new CHttpSession;
         $timezone = $session["timezone"]; 
         
        // Set closed visit if time-checkout reached current time.   
         $dateIn  = new DateTime($this->date_check_in);
         $dateOut = new DateTime($this->date_check_out);
         $dateNow = new DateTime("NOW" , new DateTimeZone($timezone)); 
         $isExpired = $dateOut->diff($dateNow)->format("%r%a");
         
        if( $isExpired > 0 && $this->visit_status == VisitStatus::ACTIVE ) {
            
            $status = "";
            /* 
             * VIC 24Hours visit will be Closed and Manual visit will be Closed manaually, Other visits will be Expired.
             * Also instead of 'Expired' will have 'Closed' status for Auto Closed EVIC & 24 hour when the check out date exceeds current date. *
            */
            if( ($this->card_type == CardType::VIC_CARD_24HOURS || $this->card_type == CardType::VIC_CARD_EXTENDED) && 
                    $this->visit_status == VisitStatus::AUTOCLOSED ) {
                $status = VisitStatus::CLOSED;
            } else if( $this->card_type != CardType::VIC_CARD_24HOURS 
                    && $this->card_type != CardType::VIC_CARD_MANUAL 
                    && $this->card_type != CardType::MANUAL_VISITOR ) {
                $status = VisitStatus::EXPIRED;
            }  
             //Get current time to compare with current visit time
             $current = new DateTime('NOW', new DateTimeZone($timezone));
             $current_hour = $current->format("H");
             $current_minutes = $current->format("i"); 
             
            // Visit Time
             $time_checkout = $this->time_check_out != "00:00:00"? $this->time_check_out: $this->finish_time;      
             $checkoutdatetime = $this->date_check_out." ".$time_checkout;
             $checkout = new DateTime($checkoutdatetime);
             $checkout->setTimezone(new DateTimeZone($timezone));
            //compare Time hours and minutes
             if(  $current_hour > $checkout->format("H")  || ( $isExpired > 0 ) 
                     || ( $current_hour == $checkout->format("H") && $current_minutes >= $checkout->format("i")) ) {
                     //Update
                     if( !empty($status) )
                     $this->updateByPk($this->id, array("visit_status" => $status));                   
             }
        } 
         
        return parent::afterFind();
    }

    
    /**
     * If visit is preregistered and date of entry passes 48 hours after proposed visit date 
     * the record is archived from Dashboard and Visit History 
     * 
     */
    public function archivePregisteredOldVisits() {
        // Find and Update Status
       /* $crieteria = "visit_status = 2 AND ( date_check_in <= '" . date('Y-m-d', strtotime("-2 days")) . "')";
        $preRegistered = $this->findAll($crieteria);

        if ($preRegistered)
            foreach ($preRegistered as $key => $visit) {
                $this->updateByPk($visit->id, array('is_deleted' => '1'));
            }

        return;*/
    }

    /**
     * get Asic Sponsor
     * @return bool|CActiveRecord
     */
    public function getAsicSponsor ()
    {
        if ($this->card_type > CardType::CONTRACTOR_VISITOR) {
            return Visitor::model()->findByPk($this->host);
        }

        return false;
    }

    public function getAsicEscort()
    {
        return Visitor::model()->findByPk($this->asic_escort);
    }


    public function getVisitorProfile()
    {
    	$visitor = Visitor::model()->findByPk($this->visitor);
    	 
    	return $visitor;
    }
}
