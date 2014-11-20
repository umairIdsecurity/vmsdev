<?php

/**
 * This is the model class for table "visit".
 *
 * The followings are the available columns in table 'visit':
 * @property string $id
 * @property string $card
 * @property string $visitor_type
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
            array('reason,visitor_type,visitor,visitor_status,workstation', 'required'),
            array('visitor,card, visitor_type, reason, visitor_status, host, patient, created_by, tenant, tenant_agent', 'length', 'max' => 20),
            array('time_in_hours,time_in_minutes,visit_status,date_in, time_in, date_out, time_out, date_check_in, time_check_in, date_check_out, time_check_out,card_type', 'safe'),
            array('patient, host,card,tenant,tenant_agent', 'default', 'setOnEmpty' => true, 'value' => null),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,firstname,lastname,contactnumber,contactemail,visit_status,visitor ,card,workstation, visitor_type, reason, visitor_status, host, patient, created_by, date_in, time_in, date_out, time_out, date_check_in, time_check_in, date_check_out, time_check_out, tenant, tenant_agent, is_deleted', 'safe', 'on' => 'search'),
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
            'date_in' => 'Date In',
            'time_in' => 'Time In',
            'date_out' => 'Date Out',
            'time_out' => 'Time Out',
            'date_check_in' => 'Date Check In',
            'time_check_in' => 'Time Check In',
            'date_check_out' => 'Date Check Out',
            'time_check_out' => 'Time Check Out',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
            'is_deleted' => 'Is Deleted',
            'visit_status' => 'Visit Status',
            'workstation' => 'Workstation',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = 'visitor0';
        $criteria->compare('CONCAT(visitor0.first_name, \' \', visitor0.last_name)', $this->visitor, true);
        $criteria->compare('visitor0.first_name', $this->firstname, true);
        $criteria->compare('visitor0.last_name', $this->lastname, true);
        $criteria->compare('visitor0.contact_number', $this->contactnumber, true);
        $criteria->compare('visitor0.email', $this->contactemail, true);

        $criteria->compare('id', $this->id, true);
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
        $criteria->compare('time_in', $this->time_in, true);
        $criteria->compare('date_out', $this->date_out, true);
        $criteria->compare('time_out', $this->time_out, true);
        $criteria->compare('date_check_in', $this->date_check_in, true);
        $criteria->compare('time_check_in', $this->time_check_in, true);
        $criteria->compare('date_check_out', $this->date_check_out, true);
        $criteria->compare('time_check_out', $this->time_check_out, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('t.is_deleted', $this->is_deleted);
        $criteria->compare('visit_status', $this->visit_status);
        $criteria->compare('workstation', $this->workstation);

        if (Yii::app()->user->role == Roles::ROLE_STAFFMEMBER && Yii::app()->controller->action->id != 'view') {
            $criteria->addCondition('host = ' . Yii::app()->user->id . ' and visit_status = ' . VisitStatus::PREREGISTERED);
        }
        $session = new CHttpSession;
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
                $criteria->addCondition('t.workstation ="' . $session['workstation'] . '"');
                break;
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.ID DESC',
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
                . "WHERE visit.is_deleted= 0 ")->queryAll();
        return $rawData;
    }

}
