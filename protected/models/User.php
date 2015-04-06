<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property integer $contact_number
 * @property string $date_of_birth
 * @property integer $company_id
 * @property string $department
 * @property string $position
 * @property string $staff_id
 * @property string $notes
 * @property string $photo
 * @property string $password
 * @property integer $role_id
 * @property integer $user_type_id
 * @property integer $user_status_id
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 * @property Company[] $companies1
 * @property Roles[] $roles
 * @property User $createdBy
 * @property User[] $users
 * @property Roles $role
 * @property UserType $userType
 * @property UserStatus $userStatus
 * @property Company $company
 * @property UserStatus[] $userStatuses
 * @property UserType[] $userTypes
 */
class User extends VmsActiveRecord {

    public $assignedWorkstations;
    public $repeatpassword;
    public $birthdayMonth;
    public $birthdayYear;
    public $birthdayDay;
    private $_companyname;
    public static $USER_ROLE_LIST = array(
        5 => 'Super Administrator',
        1 => 'Administrator',
        6 => 'Agent Administrator',
        7 => 'Agent Operator',
        8 => 'Operator',
        9 => 'Staff Member',
        10 => 'Visitor',
    );
    public static $USER_TYPE_LIST = array(
        1 => 'Internal',
        2 => 'External',
    );
    public static $USER_STATUS_LIST = array(
        1 => 'Open',
        2 => 'Access Denied',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        if (Yii::app()->controller->action->id == 'update' || Yii::app()->controller->action->id == 'profile') {
            return array(
                array('first_name, last_name, email, contact_number, user_type,is_deleted', 'required'),
                array('company, role, user_type, user_status, created_by', 'numerical', 'integerOnly' => true),
                array('first_name, last_name, email, department, position, staff_id', 'length', 'max' => 50),
                array('date_of_birth, notes,tenant,tenant_agent,birthdayYear,birthdayMonth,password,birthdayDay', 'safe'),
                array('email', 'filter', 'filter' => 'trim'),
                array('email', 'email'),
                array('role,company', 'required', 'message' => 'Please select a {attribute}'),
                array('tenant, tenant_agent', 'default', 'setOnEmpty' => true, 'value' => null),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array('id, companyname,first_name, last_name,email,is_deleted ,contact_number, date_of_birth, company, department, position, staff_id, notes, role_id, user_type_id, user_status_id, created_by', 'safe', 'on' => 'search'),
            );
        } else {
            return array(
                array('first_name, last_name, email, contact_number, user_type,is_deleted,password', 'required'),
                array('company, role, user_type, user_status, created_by', 'numerical', 'integerOnly' => true),
                array('first_name, last_name, email, department, position, staff_id', 'length', 'max' => 50),
                array('date_of_birth, notes,tenant,tenant_agent,birthdayYear,birthdayMonth,birthdayDay', 'safe'),
                array('email', 'filter', 'filter' => 'trim'),
                array('email', 'email'),
                array('role,company', 'required', 'message' => 'Please select a {attribute}'),
                array('tenant, tenant_agent', 'default', 'setOnEmpty' => true, 'value' => null),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
                array('id, first_name, companyname,last_name,email,is_deleted,assignedWorkstations,contact_number, date_of_birth, company, department, position, staff_id, notes, role_id, user_type_id, user_status_id, created_by', 'safe', 'on' => 'search'),
            );
        }
    }

    public function getCompanyname() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_companyname;
        }
    }

    public function setCompanyname($value) {
        // set private attribute for search
        $this->_companyname = $value;
    }

    /* set empty fields to null */

    function empty2null($value) {
        return $value === '' ? null : $value;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'companies1' => array(self::HAS_MANY, 'Company', 'created_by_user'),
            'roles' => array(self::HAS_MANY, 'Roles', 'created_by'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'users' => array(self::HAS_MANY, 'User', 'created_by'),
            'role' => array(self::BELONGS_TO, 'Roles', 'role'),
            'userType' => array(self::BELONGS_TO, 'UserType', 'user_type'),
            'userStatus' => array(self::BELONGS_TO, 'UserStatus', 'user_status'),
            'company' => array(self::BELONGS_TO, 'Company', 'company'),
            'userStatuses' => array(self::HAS_MANY, 'UserStatus', 'created_by'),
            'userTypes' => array(self::HAS_MANY, 'UserType', 'created_by'),
            'workstation' => array(self::HAS_MANY, 'user_workstation', 'id'),
            'userWorkstation1' => array(self::MANY_MANY, 'Workstation', 'user_workstation(user, workstation)'),
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
            'contact_number' => 'Contact No.',
            'date_of_birth' => 'Date Of Birth',
            'company' => 'Company Name',
            'department' => 'Department',
            'position' => 'Position',
            'staff_id' => 'Staff ID',
            'notes' => 'Notes',
            'password' => 'Password',
            'role' => 'Role',
            'user_type' => 'User Type',
            'user_status' => 'User Status',
            'created_by' => 'Created By',
            'is_deleted' => 'Deleted',
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
        $criteria->compare('t.id', $this->id);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('t.contact_number', $this->contact_number, true);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('company', $this->company);
        $criteria->compare('company.name', $this->companyname, true);
        $criteria->compare('department', $this->department, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('user_type', $this->user_type);
        $criteria->compare('user_status', $this->user_status);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('t.is_deleted', $this->is_deleted);
        $criteria->compare('t.tenant', $this->tenant);
        $criteria->compare('t.tenant_agent', $this->tenant_agent);

        $criteria->compare('workstation', $this->assignedWorkstations);
        $criteria->with = array('userWorkstation1', 'company');
        $criteria->together = true;

        $user = User::model()->findByPK(Yii::app()->user->id);

        if (Yii::app()->controller->action->id == 'systemaccessrules') {
            $criteria->compare('CONCAT(first_name, \' \', last_name)', $this->first_name, true);
        } else {
            $criteria->compare('first_name', $this->first_name, true);
        }

        $queryCondition = 'company = "' . $user->company . '" or created_by="' . $user->id . '"';
        switch ($user->role) {
            case Roles::ROLE_ADMIN:
                if (Yii::app()->controller->action->id == 'systemaccessrules') {
                    $rolein = '(' . Roles::ROLE_AGENT_OPERATOR . ',' . Roles::ROLE_OPERATOR . ')';
                } else {
                    $rolein = '(' . Roles::ROLE_ADMIN . ',' . Roles::ROLE_AGENT_ADMIN . ',' . Roles::ROLE_AGENT_OPERATOR . ',' . Roles::ROLE_OPERATOR . ',' . Roles::ROLE_VISITOR . ',' . Roles::ROLE_STAFFMEMBER . ')';
                }
                $queryCondition = 't.tenant = "' . $user->tenant . '"';
                break;
            case Roles::ROLE_AGENT_ADMIN:
                if (Yii::app()->controller->action->id == 'systemaccessrules') {
                    $rolein = '(' . Roles::ROLE_AGENT_OPERATOR . ')';
                } else {
                    $rolein = '(' . Roles::ROLE_AGENT_ADMIN . ',' . Roles::ROLE_AGENT_OPERATOR . ',' . Roles::ROLE_STAFFMEMBER . ',' . Roles::ROLE_VISITOR . ')';
                }

                $queryCondition = 't.tenant_agent="' . $user->tenant_agent . '"';
                break;
            default:
                if (Yii::app()->controller->action->id == 'systemaccessrules') {
                    $rolein = '(' . Roles::ROLE_AGENT_OPERATOR . ',' . Roles::ROLE_OPERATOR . ')';
                } else {
                    $rolein = '(' . Roles::ROLE_SUPERADMIN . ',' . Roles::ROLE_ADMIN . ',' . Roles::ROLE_AGENT_ADMIN . ',' . Roles::ROLE_AGENT_OPERATOR . ',' . Roles::ROLE_OPERATOR . ',' . Roles::ROLE_VISITOR . ',' . Roles::ROLE_STAFFMEMBER . ')';
                }

                $queryCondition = 't.is_deleted=0';
                break;
        }
        if (Yii::app()->controller->id == 'user' && Yii::app()->controller->action->id == 'admin') {
            $criteria->addCondition('t.id !="' . $user->id . '" and role in ' . $rolein . ' and (' . $queryCondition . ')');
        } else {
            $criteria->addCondition('role in ' . $rolein . ' and (' . $queryCondition . ')');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.ID DESC',
                'attributes' => array(
                    'companyname' => array(
                        'asc' => 'company.name',
                        'desc' => 'company.name DESC',
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
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->email = trim($this->email);

        return parent::beforeSave();
    }

    public function beforeDelete() {
        $visitExists = Visit::model()->exists('is_deleted = 0 and host ="' . $this->id . '"');
        $isTenant = Company::model()->exists('is_deleted = 0 and tenant ="' . $this->id . '"');
        $userWorkstation = UserWorkstations::model()->exists('user = "' . $this->id . '"');
        $visitorExists = Visitor::model()->exists('tenant = "' . $this->id . '" and is_deleted=0');
        $isTenantAgent = Company::model()->exists('tenant_agent = "' . $this->id . '" and is_deleted=0');
        if ($visitExists || $isTenant || $userWorkstation || $visitorExists || $isTenantAgent) {
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
        $criteria->condition = "t.is_deleted = 0";

        $this->dbCriteria->mergeWith($criteria);
    }

    protected function afterValidate() {
        parent::afterValidate();
        if (!$this->hasErrors()) {
            if (Yii::app()->controller->action->id == 'create' && $this->password != '(NULL)') {
                $this->password = $this->hashPassword($this->password);
            }
            //disable if action is update 
        }
    }

    public function hashPassword($password) {
        return CPasswordHelper::hashPassword($password);
    }

    public function validatePassword($password, $hash) {
        //return $this->hashPassword($password)===$this->password;
        //hash saved in database
        if (CPasswordHelper::verifyPassword($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserRole($user_role) {

        $search_array = User::$USER_ROLE_LIST;
        if (isset(User::$USER_ROLE_LIST[$user_role])) {
            return User::$USER_ROLE_LIST[$user_role];
        }
    }

    public function getCompany($id) {
        $connection = Yii::app()->db;
        $sql = "select company from user where id='" . $id . "'";
        $command = $connection->createCommand($sql);
        $row = $command->queryRow();
        foreach ($row as $key => $val) {
            $company = $val;
        }
        return $company;
    }

    public function getFullName($id) {
        $user = User::model()->findByPK($id);
        $name = $user->first_name . ' ' . $user->last_name;
        return $name;
    }

    public function findAllCompanyTenant() {
        return Yii::app()->db->createCommand()
                        ->select('c.id as id, c.name as name,c.tenant')
                        ->from('user u')
                        ->join('company c', 'u.company=c.id')
                        ->where('u.id=c.tenant and c.id !=1 and u.is_deleted = 0')
                        ->queryAll();
    }

    public function findAllAdmin() {

        $criteria = new CDbCriteria;
        $criteria->select = 'id,tenant,first_name,last_name';
        $criteria->addCondition('role = 1');

        return User::model()->findAll($criteria);
    }

    public function findAllAgentAdmin() {
        $criteria = new CDbCriteria;
        $criteria->select = 'id,tenant,first_name,last_name';
        $criteria->addCondition('role ="' . Roles::ROLE_AGENT_ADMIN . '"');

        return User::model()->findAll($criteria);
    }

    public function isTenantOrTenantAgentOfUserViewed($currentlyEditedUserId, $user) {

        $connection = Yii::app()->db;
        $ownerCondition = "where id ='" . $currentlyEditedUserId . "'";

        if ($user->role == Roles::ROLE_ADMIN) {
            $ownerCondition = "WHERE tenant = '" . $user->tenant . "' ";
        } else if ($user->role == Roles::ROLE_AGENT_ADMIN) {
            $ownerCondition = "WHERE `tenant_agent`='" . $user->tenant_agent . "'";
        }
        $ownerQuery = "select * FROM `user`
                            " . $ownerCondition . " and id ='" . $currentlyEditedUserId . "' 
                            ";
        $command = $connection->createCommand($ownerQuery);
        $row = $command->query();
        if ($row->rowCount !== 0) {
            return true;
        } else {
            return false;
        }
    }

    public function saveWorkstation($userId, $workstationId, $currentUserId) {

        $post = new UserWorkstations;
        $post->user = $userId;
        $post->workstation = $workstationId;
        $post->created_by = $currentUserId;
        $post->is_primary = '1';
        $post->save();
    }

    public function findAllTenantAgent($tenantId) {
        //select all companies of tenant agents with same tenant
        $tenantId = trim($tenantId);
        $aArray = array();
        $company = Yii::app()->db->createCommand()
                ->selectdistinct(' c.id as id, c.name as name,c.tenant,c.tenant_agent')
                ->from('user u')
                ->join('company c', 'u.company=c.id')
                ->where('u.is_deleted = 0 and u.tenant="' . $tenantId . '" and u.role =' . Roles::ROLE_AGENT_ADMIN)
                ->queryAll();

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'tenant' => $value['tenant'],
                'tenant_agent' => $value['tenant_agent'],
            );
        }

        return $aArray;
    }

    public function findCompanyDetailsOfUser($userId) {
        $aArray = array();
        //find all company with same tenant except users company
        $user = User::model()->findByPk($userId);

        $Criteria = new CDbCriteria();

        $Criteria->condition = "tenant ='" . $userId . "' and id !=1 and id != " . $user->company;


        $companyList = Company::model()->findAll($Criteria);

        foreach ($companyList as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'tenant' => $value['tenant'],
            );
        }

        return $aArray;
    }

    public function findWorkstationsWithSameTenant($tenantId) {
        $aArray = array();

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = '$tenantId' and (tenant_agent IS NULL or tenant_agent = 0 or tenant_agent = '') ";
        $workstation = Workstation::model()->findAll($Criteria);

        foreach ($workstation as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;
    }

    public function findWorkstationsWithSameTenantAndTenantAgent($tenantAgentId, $tenantId) {
        $aArray = array();

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = '" . $tenantId . "' and tenant_agent='" . $tenantAgentId . "'";
        $workstation = Workstation::model()->findAll($Criteria);
        foreach ($workstation as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;
    }

    protected function afterFind() {
        $date_of_birth = $this->date_of_birth;
        $this->birthdayDay = date('d', strtotime($date_of_birth));
        $this->birthdayMonth = date('n', strtotime($date_of_birth));
        $this->birthdayYear = date('o', strtotime($date_of_birth));
        return parent::afterFind();
    }

    public function isEmailAddressUnique($email, $tenantId) {
        $Criteria = new CDbCriteria();
        $session = new CHttpSession;
        if ($tenantId != '') {
            if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                $Criteria->condition = 'email = "' . $email . '" and tenant = "' . $tenantId . '" and is_deleted!=1';
            } else {
                $Criteria->condition = 'email = "' . $email . '" and tenant = "' . $session['tenant'] . '" and is_deleted!=1';
            }
        } else { //if position is admin compare to email only
            $Criteria->condition = 'email = "' . $email . '" and is_deleted!=1';
        }


        $userEmail = User::model()->findAll($Criteria);

        $userEmails = array_filter($userEmail);
        $userEmailCount = count($userEmails);

        if ($userEmailCount == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getIdOfUser($email) {
        $aArray = array();

        $Criteria = new CDbCriteria();
        $Criteria->condition = "email = '$email'";
        $userId = User::model()->findAll($Criteria);

        foreach ($userId as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
            );
        }
        return $aArray;
    }

    public function findCompanyOfTenant($tenantId, $tenantAgentId) {
        $aArray = array();
        if ($tenantAgentId != '') {
            $user = User::model()->findByPk($tenantAgentId);
        } else {
            $user = User::model()->findByPk($tenantId);
        }
        $Criteria = new CDbCriteria();
        $Criteria->condition = "id = '$user->company'";
        $company = Company::model()->findAll($Criteria);

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }
        return $aArray;
    }

    public function restorePassword($email)
    {
        if($user = $this->findByAttributes(array('email' => $email))){
            return PasswordChangeRequest::model()->generateResetLink($user);
        } else {
            return "Email address does not exist in system.";
        }
    }
}
