
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
            array('first_name, last_name, email, contact_number,tenant', 'required'),
            array('is_deleted', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, department, position, staff_id', 'length', 'max' => 50),
            array('contact_number, company, role, visitor_status, created_by, tenant, tenant_agent', 'length', 'max' => 20),
            // array('password', 'length', 'max' => 150),
            array('date_of_birth, notes,birthdayYear,birthdayMonth,birthdayDay', 'safe'),
            array('tenant, tenant_agent,company', 'default', 'setOnEmpty' => true, 'value' => null),
            array('repeatpassword,password', 'required', 'on' => 'insert'),
            array('password', 'compare', 'compareAttribute' => 'repeatpassword', 'on' => 'insert'),
            
            array('email', 'unique'),
            array('email', 'email'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_name, last_name, email, contact_number, date_of_birth, company, department, position, staff_id, notes, role, visitor_status, created_by, is_deleted, tenant, tenant_agent', 'safe', 'on' => 'search'),
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
            'position' => 'Position:',
            'staff_id' => 'Staff',
            'notes' => 'Notes',
            'password' => 'Password',
            'role' => 'Role',
            'visitor_status' => 'Visitor Status',
            'created_by' => 'Created By',
            'is_deleted' => 'Is Deleted',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
            'repeatpassword' => 'Repeat Password',
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
        $criteria->compare('notes', $this->notes, true);
        //$criteria->compare('password', $this->password, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('visitor_status', $this->visitor_status, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);

        if (Yii::app()->controller->id == 'visit') {
            $criteria->compare('CONCAT(first_name, \' \', last_name)', $this->first_name, true);
        } else {
            $criteria->compare('first_name', $this->first_name, true);
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

    public function behaviors() {
        return array(
            'softDelete' => array(
                'class' => 'ext.soft_delete.SoftDeleteBehavior'
            ),
        );
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

    public function findAllCompanyWithSameTenant($id) {
        $aArray = array();

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = '$id'";
        $company = Company::model()->findAll($Criteria);

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;
    }

    public function findAllCompanyWithSameTenantAndTenantAgent($id, $tenantagent) {
        $aArray = array();

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = '$id' and tenant_agent= '$tenantagent'";
        $company = Company::model()->findAll($Criteria);

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }
        return $aArray;
    }
    
    public function saveReason($visitor_id, $visit_reason_id) {

        $post = new VisitorVisitReason;
        $post->visitor = $visitor_id;
        $post->visit_reason = $visit_reason_id;
        $post->save();
    }
    
    public function checkIfEmailAddressIsTaken($email){
        $Criteria = new CDbCriteria();
        $Criteria->condition = "email = '" . $email . "' ";
        $visitorEmail = Visitor::model()->findAll($Criteria);

        $visitorEmail = array_filter($visitorEmail);
        $visitorEmailCount = count($visitorEmail);

        if ($visitorEmailCount == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function getIdOfUser($email){
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
    
    

}
