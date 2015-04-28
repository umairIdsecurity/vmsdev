<?php

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
    const PROFILE_TYPE_VIC = 'VIC';
    const PROFILE_TYPE_ASIC = 'ASIC';

    public static $VISITOR_CARD_TYPE_LIST = array(
        self::PROFILE_TYPE_VIC => array(
            1 => 'Saved',
            2 => 'VIC holder',
            3 => 'ASIC Pending',
            4 => 'ASIC Issued',
            5 => 'ASIC Denied',
        ),
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
        return array(
            array('first_name, last_name, email, contact_number,company, visitor_card_status', 'required'),
            array('tenant','required','message' =>'Please select a {attribute}'),
            array('is_deleted', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, department, position, staff_id', 'length', 'max' => 50),
            array('contact_number, company, role, visitor_status, created_by, tenant, tenant_agent', 'length', 'max' => 20),
            array('date_of_birth, notes,birthdayYear,birthdayMonth,birthdayDay,vehicle', 'safe'),
            array('tenant, tenant_agent,company, photo,vehicle, visitor_card_status, visitor_workstation', 'default', 'setOnEmpty' => true, 'value' => null),
            array('repeatpassword,password', 'required','on'=>'insert'),
            array('password', 'compare', 'compareAttribute' => 'repeatpassword', 'on' => 'insert'),
           // array('vehicle', 'length', 'min'=>6, 'max'=>6, 'tooShort'=>'Vehicle is too short (Should be in 6 characters)'), 
            array('email', 'email'),
            array('vehicle', 'match',
                'pattern' => '/^[A-Za-z0-9_]+$/u',
                'message' => 'Vehicle accepts alphanumeric characters only'
            ),
            array('vehicle', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_name, photo,last_name, email, vehicle,contact_number, date_of_birth, company, department, position, staff_id, notes, role, visitor_status, created_by, is_deleted, tenant, tenant_agent', 'safe', 'on' => 'search'),
        );
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
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'contact_number' => 'Mobile Number',
            'date_of_birth' => 'Date Of Birth',
            'company' => 'Company',
            'department' => 'Department',
            'position' => 'Position',
            'staff_id' => 'Staff ID',
            'notes' => 'Notes',
            'password' => 'Password',
            'role' => 'Role',
            'visitor_status' => 'Visitor Status',
            'created_by' => 'Created By',
            'is_deleted' => 'Is Deleted',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
            'repeatpassword' => 'Repeat Password',
            'vehicle' => 'Vehicle Registration Number',
            'photo' => 'Photo',
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

        $criteria->compare('id', $this->id, true);
        // $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('contact_number', $this->contact_number, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('department', $this->department, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('photo', $this->photo, true);
        $criteria->compare('notes', $this->notes, true);
        //$criteria->compare('password', $this->password, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('visitor_status', $this->visitor_status, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('vehicle', $this->vehicle, true);
        
        
        
        if (Yii::app()->controller->id == 'visit') {
            $criteria->compare('CONCAT(first_name, \' \', last_name)', $this->first_name, true);
        } else {
            $criteria->compare('first_name', $this->first_name, true);
        }
        
        $user = User::model()->findByPK(Yii::app()->user->id);
        if($user->role != Roles::ROLE_SUPERADMIN){
            
        } 
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ID DESC',
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

      return parent::beforeSave();
   }

   
    public function beforeDelete() {
        $visitorExists = Visit::model()->exists('is_deleted = 0 and visitor =' . $this->id . ' and (visit_status=' . VisitStatus::PREREGISTERED . ' or visit_status=' . VisitStatus::ACTIVE . ')');
        $visitorExistsClosed = Visit::model()->exists('is_deleted = 0 and visitor =' . $this->id . ' and (visit_status=' . VisitStatus::CLOSED . ' or visit_status=' . VisitStatus::EXPIRED . ')');
        $visitorHasSavedVisitOnly = Visit::model()->exists('is_deleted = 0 and visitor =' . $this->id . ' and visit_status="'.VisitStatus::SAVED.'"');
        
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
        if (Yii::app()->user->role != Roles::ROLE_SUPERADMIN) {
            $criteria->condition = 't.is_deleted = 0 and t.tenant ="' . Yii::app()->user->tenant . '"';
        }
        $this->dbCriteria->mergeWith($criteria);
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

    public function findAllCompanyWithSameTenant($tenantId) {
        $session = new CHttpSession;
        $aArray = array();
        $tenant = User::model()->findByPk($tenantId);
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'tenant = "'.$tenantId.'" and (id!=1 and id !="'.$tenant->company.'")';
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
        $Criteria->condition = 'tenant = "'.$tenantId.'" and (id!=1 and id !="'.$tenant->company.'")';
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

    public function isEmailAddressTaken($email) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "email = '" . $email . "' ";
        $visitorEmail = Visitor::model()->findAll($Criteria);

        //$visitorEmail = array_filter($visitorEmail);
        $visitorEmailCount = count($visitorEmail);

        if ($visitorEmailCount == 0) {
            return false;
        } else {
            return true;
        }
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
}
