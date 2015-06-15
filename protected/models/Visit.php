<?php
ini_set('xdebug.max_nesting_level', 200);
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
            array('reason,visitor_type,visitor,visitor_status,workstation', 'required', 'on' => 'webapp'),
            array('visitor,card, visitor_type, reason, visitor_status,host, patient, created_by, tenant, tenant_agent', 'length', 'max' => 20),
            array('date_in,date_out,time_in_hours,time_in_minutes,visit_status, time_in, time_out, date_check_in, time_check_in, date_check_out, time_check_out,card_type, finish_date, finish_time, card_returned_date, negate_reason, reset_id, card_option, police_report_number, card_lost_declaration_file, workstation', 'safe'),
            array('patient, host,card,tenant,tenant_agent', 'default', 'setOnEmpty' => true, 'value' => null),
            array('filterProperties', 'length', 'max' => 70),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,datecheckin1,cardnumber,company,firstname,lastname,contactnumber,contactemail,visit_status,visitor ,card,workstation, visitor_type, reason, visitor_status, host, patient, created_by, date_in, time_in, date_out, time_out, date_check_in, time_check_in, date_check_out, time_check_out, tenant, tenant_agent, is_deleted, companycode, contact_street_no, contact_street_name, contact_street_type, contact_suburb, contact_postcode, identification_type, identification_document_no, identification_document_expiry, asic_no, asic_expiry, workstation, date_of_birth, finish_date, card_returned_date', 'safe', 'on' => 'search'),
            array('id,datecheckin1,cardnumber,company,firstname,lastname,contactnumber,contactemail,visit_status,visitor ,card,workstation, visitor_type, reason, visitor_status, host, patient, created_by, date_in, time_in, date_out, time_out, date_check_in, time_check_in, date_check_out, time_check_out, tenant, tenant_agent, is_deleted, companycode, contact_street_no, contact_street_name, contact_street_type, contact_suburb, contact_postcode, identification_type, identification_document_no, identification_document_expiry, asic_no, asic_expiry, workstation, date_of_birth, finish_date, card_returned_date', 'safe', 'on' => 'search_history'),
            array('card_lost_declaration_file', 'file', 'types' => 'pdf,doc,docx,jpg,gif,png', 'allowEmpty' => true, 'maxSize' => 1024 * 1024 * 10),
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

        $criteria->with = array('card0', 'visitor0', 'company0', 'reason0', 'workstation0');
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
        $criteria->compare('DATE_FORMAT(visitor0.date_of_birth, "%d-%m-%Y")', $this->date_of_birth, true);
        $criteria->compare('visitor0.contact_street_no', $this->contact_street_no, true);
        $criteria->compare('visitor0.contact_street_name', $this->contact_street_name, true);
        $criteria->compare('visitor0.contact_street_type', $this->contact_street_type, true);
        $criteria->compare('visitor0.contact_suburb', $this->contact_suburb, true);
        $criteria->compare('visitor0.contact_postcode', $this->contact_postcode, true);
        $criteria->compare('visitor0.identification_type', $this->identification_type, true);
        $criteria->compare('visitor0.identification_document_no', $this->identification_document_no, true);
        $criteria->compare('DATE_FORMAT(visitor0.identification_document_expiry, "%d-%m-%Y")', $this->identification_document_expiry, true);
        $criteria->compare('visitor0.asic_no', $this->asic_no, true);
        $criteria->compare('DATE_FORMAT(visitor0.asic_expiry, "%d-%m-%Y")', $this->asic_expiry, true);
        $criteria->compare('finish_date', $this->finish_date, true);
        $criteria->compare('card_returned_date', $this->card_returned_date, true);

        if ($merge !== null) {
            $criteria->mergeWith($merge);
        }
        // $criteria->addCondition("t.date_check_out > DATE_ADD(now(),interval -2 day)");
        if ($this->filterProperties) {
            $criteria->addCondition("t.id LIKE CONCAT('%', :filterProperties , '%')
                OR card0.card_number LIKE CONCAT('%', :filterProperties , '%')
                OR company0.code LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.first_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.last_name LIKE CONCAT('%', :filterProperties , '%')
                OR DATE_FORMAT(visitor0.date_of_birth, '%d-%m-%Y') LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_number LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_suburb LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_state LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_postcode LIKE CONCAT('%', :filterProperties , '%')
                OR reason0.reason LIKE CONCAT('%', :filterProperties , '%')
                OR workstation0.name LIKE CONCAT('%', :filterProperties , '%')
                OR company0.name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.email LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_type LIKE CONCAT('%', :filterProperties , '%')
                OR finish_date LIKE CONCAT('%', :filterProperties , '%')
                OR card_returned_date LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_type LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_document_no LIKE CONCAT('%', :filterProperties , '%')
                OR DATE_FORMAT(visitor0.identification_document_expiry, '%d-%m-%Y') LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.asic_no LIKE CONCAT('%', :filterProperties , '%')
                OR DATE_FORMAT(visitor0.asic_expiry, '%d-%m-%Y') LIKE CONCAT('%', :filterProperties , '%')");
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
                $criteria->addCondition('t.id != ""');
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
                $text = "";
                foreach ($workstations as $key => $value) {
                    $text .="'" . $value['id'] . "',";
                }
                $workstations = "IN (" . rtrim($text, ',') . ")";

                $criteria->addCondition('t.workstation '.$workstations.'');
                break;
        }
        
        $criteria->addCondition('t.is_deleted = 0');
        
        /*
         * this condition is a hack to show only CORPORATE VISITOR in the listing report
         * 
         */
        if (Yii::app()->controller->action->id == 'visitorRegistrationHistory') {
            $criteria->addCondition('profile_type ="' . Visitor::PROFILE_TYPE_CORPORATE . '"');
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
                //'pagination'=>false,
        ));
    }

    public function search_history($merge = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('card0', 'visitor0', 'company0');
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
        $criteria->mergeWith($this->dateRangeSearchCriteria('date_check_in', $this->date_check_in));

        $criteria->compare('time_check_in', $this->time_check_in, true);
        // $criteria->compare('date_check_out', $this->date_check_out, true);
        $criteria->compare('time_check_out', $this->time_check_out, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('t.is_deleted', $this->is_deleted, "0");
        $criteria->compare('visit_status', $this->visit_status);
        $criteria->compare('workstation', $this->workstation);

        $criteria->compare('company0.code', $this->companycode, true);
        $criteria->compare('visitor0.date_of_birth', $this->date_of_birth, true);
        $criteria->compare('visitor0.contact_street_no', $this->contact_street_no, true);
        $criteria->compare('visitor0.contact_street_name', $this->contact_street_name, true);
        $criteria->compare('visitor0.contact_street_type', $this->contact_street_type, true);
        $criteria->compare('visitor0.contact_suburb', $this->contact_suburb, true);
        $criteria->compare('visitor0.contact_postcode', $this->contact_postcode, true);
        $criteria->compare('visitor0.identification_type', $this->identification_type, true);
        $criteria->compare('visitor0.identification_document_no', $this->identification_document_no, true);
        $criteria->compare('visitor0.identification_document_expiry', $this->identification_document_expiry, true);
        $criteria->compare('visitor0.asic_no', $this->asic_no, true);
        $criteria->compare('visitor0.asic_expiry', $this->asic_expiry, true);
        $criteria->compare('finish_date', $this->finish_date, true);
        $criteria->compare('card_returned_date', $this->card_returned_date, true);

        if ($merge !== null) {
            $criteria->mergeWith($merge);
        }
            $criteria->addCondition("str_to_date(t.date_check_out,'%d-%m-%Y') > DATE_ADD(now(),interval -2 day)");
        if ($this->filterProperties) {
            $criteria->addCondition("t.id LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.first_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.last_name LIKE CONCAT('%', :filterProperties , '%')
                OR company0.code LIKE CONCAT('%', :filterProperties , '%')
                OR company0.name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.date_of_birth LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_number LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_name LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_street_type LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_suburb LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.contact_postcode LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.email LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_type LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_document_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.identification_document_expiry LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.asic_no LIKE CONCAT('%', :filterProperties , '%')
                OR visitor0.asic_expiry LIKE CONCAT('%', :filterProperties , '%')");
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
                $criteria->addCondition('t.id != ""');
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
                $text = "";
                foreach ($workstations as $key => $value) {
                    $text .="'" . $value['id'] . "',";
                }
                $workstations = "IN (" . rtrim($text, ',') . ")";

                $criteria->addCondition('t.workstation ' . $workstations . '');
                break;
        }

        $criteria->addCondition('t.is_deleted = 0');

        /*
         * this condition is a hack to show only CORPORATE VISITOR in the listing report
         * 
         */
        if (Yii::app()->controller->action->id == 'visitorRegistrationHistory') {
            $criteria->addCondition('profile_type ="' . Visitor::PROFILE_TYPE_CORPORATE . '"');
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
                //'pagination'=>false,
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
                    LEFT JOIN card_generated ON card_generated.id = visit.`card` 
                    SET visit_status = '" . VisitStatus::CLOSED . "',card_status ='" . CardStatus::NOT_RETURNED . "'
                    WHERE 'd-m-Y' > date_out AND date_out != 'd-m-Y' AND visit_status = '" . VisitStatus::ACTIVE . "'
                    AND card_status ='" . CardStatus::ACTIVE . "' and card_type= '" . CardType::SAME_DAY_VISITOR . "'")->execute();
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
                    SET visit_status = '" . VisitStatus::CLOSED . "', card_option ='" . CardStatus::RETURNED . "', finish_date = CURDATE(), finish_time = CURTIME() WHERE 'd-m-Y' > date_check_out AND DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 28 DAY), '%d-%m-%Y %h:%i:%s') >= CONCAT(date_check_in, ' ', time_check_in) AND visit_status = '" . VisitStatus::ACTIVE . "' AND (card_type = '" . CardType::VIC_CARD_EXTENDED . "' OR card_type = '". CardType::VIC_CARD_MULTIDAY ."')")->execute();
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
                "UPDATE visit SET visit_status = '" . VisitStatus::CLOSED . "', card_option ='" . CardStatus::RETURNED . "', finish_date = CURDATE(), finish_time = CURTIME() WHERE 'd-m-Y' > date_check_out AND DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 24 HOUR), '%d-%m-%Y %h:%i:%s') >= CONCAT(date_check_in, ' ', time_check_in) AND visit_status = '" . VisitStatus::ACTIVE . "' AND card_type = '" . CardType::VIC_CARD_24HOURS . "'")->execute();
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
                "UPDATE visit SET visit_status = '" . VisitStatus::EXPIRED . "', card_option ='" . CardStatus::RETURNED . "', finish_date = CURDATE(), finish_time = CURTIME() WHERE DATE_FORMAT(NOW(), '%d-%m-%Y') > date_check_out AND CURTIME() >= time_check_out AND visit_status = '" . VisitStatus::ACTIVE . "' AND card_type = '" . CardType::VIC_CARD_SAMEDATE . "'")->execute();
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
                    LEFT JOIN card_generated ON card_generated.id = visit.`card` 
                    SET visit_status = '" . VisitStatus::EXPIRED . "',card_status ='" . CardStatus::NOT_RETURNED . "'
                    WHERE 'd-m-Y' > date_expiration AND visit_status = '" . VisitStatus::ACTIVE . "'
                    AND card_status ='" . CardStatus::ACTIVE . "' and card_type='" . CardType::MULTI_DAY_VISITOR . "'")->execute();
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
        $Criteria->condition = "visitor = '" . $visitorId . "' && visit_status='" . VisitStatus::SAVED . "'";
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
            $Criteria->condition = "visitor='" . $visitorId . "' && visit_status='" . $visitStatus . "'";
        } else {
            $Criteria->condition = "date_in = '" . $date_in . "' && visitor='" . $visitorId . "' && visit_status='" . $visitStatus . "'";
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

            $res_company = Yii::app()->db->createCommand("SELECT company.id AS company_id, company.name AS company_name FROM visit LEFT JOIN user ON user.id = visit.host LEFT JOIN company ON user.company = company.id WHERE company.is_deleted=0 AND visit.id= " . $visitId)->queryAll();
            if ($res_company) {
                $company = $res_company[0]['company_id'];
            } else {
                $company = 0;
            }


            $res_host = Yii::app()->db->createCommand("SELECT id FROM user WHERE user.is_deleted=0 AND user.company=" . $company)->queryAll();

            //var_dump($res_host);
            if ($res_host) {
                foreach ($res_host as $arr_val) {
                    $arr[] = $arr_val['id'];
                }

                $hosts = implode(",", $arr);
                $sql_company_visit_by_visitor = "SELECT COUNT(*) as cnt FROM visit"
                        . " WHERE visit.is_deleted=0 AND visit.visitor= " . $visitor
                        . " AND host IN (" . $hosts . ")";


                $companyVisitsByVisitor = Yii::app()->db->createCommand($sql_company_visit_by_visitor)->queryAll();

                $countData = array('allVisitsByVisitor' => $allVisitsByVisitor[0]['cnt'], 'companyVisitsByVisitor' => $companyVisitsByVisitor[0]['cnt'], 'companyName' => $res_company[0]['company_name']);

                return $countData;
            } else {
                return [];
            }


            //echo $hosts;echo "<br> ============ <br> ";
            //echo $company;echo "<br> ============ <br> ";
            //echo $visitor;echo "<br> ============ <br> ";	die();
        }
        return [];
    }

    public function getVisitCounts() {
        switch ($this->card_type) {
            case CardType::VIC_CARD_MANUAL:
                return (int)$this->countByAttributes(['visit_status' => VisitStatus::CLOSED, 'visitor' => $this->visitor]) + 1;
                break;
            case CardType::VIC_CARD_EXTENDED:
            case CardType::VIC_CARD_MULTIDAY:
                $dateIn = new DateTime($this->date_check_in);
                $dateNow = new DateTime(date('d-m-Y'));
                return (int)($dateNow->format('z') - $dateIn->format('z')) + 1;
                break;
            case CardType::VIC_CARD_SAMEDATE:
                $dateOut = new DateTime($this->date_check_out);
                $dateIn = new DateTime($this->date_check_in);
                return (int)($dateOut->format('z') - $dateIn->format('z')) + 1;
                break;
            case CardType::VIC_CARD_24HOURS:
                return (int)$this->countByAttributes(['visit_status' => VisitStatus::CLOSED, 'visitor' => $this->visitor]) + 1;
                break;
        }
    }

    public function getRemainingDays() {
        switch ($this->card_type) {
            case CardType::VIC_CARD_MANUAL:
                return 28 - (int)$this->visitCounts;
                break;
            case CardType::VIC_CARD_EXTENDED:
            case CardType::VIC_CARD_MULTIDAY:
                $dateNow = new DateTime(date('d-m-Y'));
                $dateOut = new DateTime($this->date_check_out);
                return (int)($dateOut->format('z') - $dateNow->format('z'));
                break;
            case CardType::VIC_CARD_SAMEDATE:
                if (date('d-m-Y') == $this->date_check_in) {
                    return 28 - (int)$this->countByAttributes(['visit_status' => VisitStatus::CLOSED, 'visitor' => $this->visitor]);
                }
                return 28;
                break;
            case CardType::VIC_CARD_24HOURS:
                return 28 - (int)$this->visitCounts;
                break;
        }
        
    }

    /**
     * Change date formate to Australian after fetech
     * 
     */
    public function afterFind() {

        $this->date_check_in = (string) date("d-m-Y", strtotime($this->date_check_in));
        $this->date_check_out = (string) date("d-m-Y", strtotime($this->date_check_out));
        return parent::afterFind();
    }

    /**
     * If visit is preregistered and date of entry passes 48 hours after proposed visit date 
     * the record is archived from Dashboard and Visit History 
     * 
     */
    public function archivePregisteredOldVisits() {
        // Find and Update Status
        $crieteria = 'visit_status = 2 AND ( date_check_in <= "' . date("Y-m-d", strtotime('-2 days')) . '"  OR date_check_in <= "' . date("d-m-Y", strtotime('-2 days')) . '")';
        $preRegistered = $this->findAll($crieteria);

        if ($preRegistered)
            foreach ($preRegistered as $key => $visit) {
                $this->updateByPk($visit->id, array('is_deleted' => '1'));
            }

        return;
    }

}
