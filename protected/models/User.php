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
        return array(
            array('first_name, last_name, email, contact_number, role, user_type,is_deleted,password,company', 'required'),
            array('company, role, user_type, user_status, created_by', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, email, department, position, staff_id', 'length', 'max' => 50),
            array('date_of_birth, notes,tenant,tenant_agent', 'safe'),
            array('email', 'unique'),
            array('email', 'email'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_name, last_name,email,is_deleted ,contact_number, date_of_birth, company, department, position, staff_id, notes, role_id, user_type_id, user_status_id, created_by', 'safe', 'on' => 'search'),
        );
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
            'email' => 'Email',
            'contact_number' => 'Contact Number',
            'date_of_birth' => 'Date Of Birth',
            'company' => 'Company Name',
            'department' => 'Department',
            'position' => 'Position',
            'staff_id' => 'Staff',
            'notes' => 'Notes',
            'password' => 'Password',
            'role' => 'Role',
            'user_type' => 'User Type',
            'user_status' => 'User Status',
            'created_by' => 'Created By',
            'is_deleted' => 'Deleted',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
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
        $session = new CHttpSession;
        $criteria = new CDbCriteria;
        $criteria->order = 'first_name ASC';
        $criteria->compare('id', $this->id);
      //  $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('contact_number', $this->contact_number);
        $criteria->compare('date_of_birth', $this->date_of_birth, true);
        $criteria->compare('company', $this->company);
        $criteria->compare('department', $this->department, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('staff_id', $this->staff_id, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('user_type', $this->user_type);
        $criteria->compare('user_status', $this->user_status);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('tenant', $this->tenant);
        $criteria->compare('tenant_agent', $this->tenant_agent);

        if (Yii::app()->controller->action->id == 'systemaccessrules') {
            $criteria->compare('CONCAT(first_name, \' \', last_name)', $this->first_name, true);
        } else {
            $criteria->compare('first_name', $this->first_name, true);
        }

        $queryCondition = 'company = "' . $session['company'] . '" or created_by="' . $session['id'] . '"';
        switch ($session['role']) {
            case Roles::ROLE_ADMIN:
                //$rolein = '(7,8)'; uncomment for if action id is systemaccessrule
                if (Yii::app()->controller->action->id == 'systemaccessrules') {
                    $rolein = '(7,8)';
                } else {
                    $rolein = '(1,6,7,8,9,10)';
                }
                $queryCondition = 'tenant = "' . $session['tenant'] . '"';
                break;
            case Roles::ROLE_AGENT_ADMIN:
                if (Yii::app()->controller->action->id == 'systemaccessrules') {
                    $rolein = '(7)';
                }else {
                    $rolein = '(6,7,8,9,10)';
                }
                
                $queryCondition = 'tenant_agent="' . $session['tenant_agent'] . '"';
                break;
            default:
                if (Yii::app()->controller->action->id == 'systemaccessrules') {
                    $rolein = '(8,7)';
                }else {
                    $rolein = '(1,5,6,7,8,9,10)';
                }
                
                $queryCondition = 'is_deleted=0';
                break;
        }
        $criteria->addCondition('role in ' . $rolein . ' and (' . $queryCondition . ')');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            
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

    protected function afterValidate() {
        parent::afterValidate();
        if (!$this->hasErrors()) {
            if (Yii::app()->controller->action->id == 'create'  ) {
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
        $session = new CHttpSession;

        $connection = Yii::app()->db;
        $sql = "select company from user where id='" . $id . "'";
        $command = $connection->createCommand($sql);
        $row = $command->queryRow();
        foreach ($row as $key => $val) {
            $session['company'] = $val;
        }
        return $session['company'];
    }

    public function beforeSave() {
        $session = new CHttpSession;
        // $this->password = $this->hashPassword($this->password);
        $this->date_of_birth = date('Y-m-d', strtotime($this->date_of_birth));
        if (null !== Yii::app()->user) {
            $id = Yii::app()->user->id;
        } else {
            $id = 16;
        }

        if ($this->isNewRecord) {
            $this->created_by = $id;
        } else {

            if ($session['role'] == 5) {
                $lastInsertId = Yii::app()->db->getLastInsertID();
                $connection = Yii::app()->db;
                $command = $connection->createCommand('SELECT user.id as id,user.role as role,user.company as user_company,company.name, 
                company.tenant AS company_tenant, company.`tenant_agent` AS company_tenant_agent
                FROM `user` 
                LEFT JOIN company ON company.id=user.`company`
                WHERE user.id="' . $this->id . '"');
                $row = $command->queryRow();
                foreach ($row as $key => $value) {
                    $userid = $row['id'];
                    $role = $row['role'];
                    $user_company = $row['user_company'];
                    $company_tenant = $row['company_tenant'];
                    $company_tenant_agent = $row['company_tenant_agent'];
                }

                if ($role == Roles::ROLE_ADMIN) {
                    if ($userid == $company_tenant) {
                        $command = $connection->createCommand('update company set tenant =NULL where id ="' . $user_company . '" ');
                        $command->query();
                }
                }
            }
        }
        return true;
    }

    protected function afterSave() {
        /** set tenant id if superadmin and user created is admin.. tenant id = admin_id 
         * set tenant_agent if superadmin and user created is agentadmin.. tenant id = admin_id ,tenant_agent
         * if not superadmin inherit tenant id from currently logged in user
         * if superadmin and user created != admin .. tenant id = choose admin_id
         * if agent admin logged in , all created 
         * * */
        $session = new CHttpSession;
        if ($this->isNewRecord) {
            $lastInsertId = Yii::app()->db->getLastInsertID();
            //query if lastinsert record tenant=''
            $connection = Yii::app()->db;
            $command = $connection->createCommand('SELECT user.tenant,user.tenant_agent,user.role as role,user.company as user_company,company.name, 
            company.tenant AS company_tenant, company.`tenant_agent` AS company_tenant_agent
            FROM USER 
            LEFT JOIN company ON company.id=user.`company`
            WHERE user.id="' . $lastInsertId . '"');

            $row = $command->queryRow(); //executes the SQL statement and returns the first row of the result.
            foreach ($row as $key => $value) {
                $tenant = $row['tenant'];
                $tenant_agent = $row['tenant_agent'];
                $role = $row['role'];
                $user_company = $row['user_company'];
                $company_tenant = $row['company_tenant'];
                $company_tenant_agent = $row['company_tenant_agent'];
            }

            if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                if ($this->isNewRecord) {
                    $tenant_id = $lastInsertId;
                    if ($role == Roles::ROLE_ADMIN) {
                        if ($tenant == '') {
                            if ($company_tenant == '') {
                                $this->tenant = $tenant_id;
                                $command = $connection->createCommand('update company set tenant= "' . $tenant_id . '" where id="' . $user_company . '"');
                                $row = $command->query();
                                $this->isNewRecord = false;
                                $this->saveAttributes(array('tenant'));
                            } else {
                                $this->tenant = $company_tenant;
                                $this->isNewRecord = false;
                                $this->saveAttributes(array('tenant'));
                            }
                        }
                    } else if ($role == Roles::ROLE_AGENT_ADMIN) {
                        if ($tenant_agent == '') {
                            if ($company_tenant_agent == '') {
                                $this->tenant_agent = $lastInsertId;
                                $command = $connection->createCommand('update company set tenant_agent="' . $tenant_id . '" where id="' . $user_company . '"');
                                $row = $command->query();
                            } else {
                                $this->tenant_agent = $company_tenant_agent;
                            }
                            if ($company_tenant == '') {
                                $command = $connection->createCommand('update company set tenant="' . $tenant . '" where id="' . $user_company . '"');
                                $row = $command->query();
                            }
                            $this->isNewRecord = false;
                            $this->saveAttributes(array('tenant_agent'));
                        }
                    } elseif ($role == Roles::ROLE_STAFFMEMBER) {
                        if ($this->isNewRecord) {
                            if ($tenant_agent != '') {
                                $this->tenant = '';

                                $this->isNewRecord = false;
                                $this->saveAttributes(array('tenant'));
                            }
                        }
                    }
                }
            } else {
                if ($this->isNewRecord) {
                    $tenant_id = $lastInsertId;
                    if ($tenant == '') { //meaning if no administrator saved
                        if ($role == Roles::ROLE_ADMIN) {
                            if ($company_tenant == '') {
                                $this->tenant = $tenant_id;
                                $command = $connection->createCommand('update company set tenant= "' . $tenant_id . '" where id="' . $user_company . '"');
                                $row = $command->query();
                                $this->isNewRecord = false;
                                $this->saveAttributes(array('tenant'));
                            } else {
                                $this->tenant = $company_tenant;
                                $this->isNewRecord = false;
                                $this->saveAttributes(array('tenant'));
                            }
                        } else if ($role == Roles::ROLE_AGENT_ADMIN) {
                            if ($company_tenant_agent == '') {
                                $this->tenant_agent = $tenant_id;
                                $command = $connection->createCommand('update company set tenant_agent= "' . $tenant_id . '" where id="' . $user_company . '"');
                                $row = $command->query();
                            } else {
                                $this->tenant_agent = $company_tenant_agent;
                            }
                            //check if company tenant blank ->company tenant = admin id

                            if ($company_tenant == '') {
                                $command = $connection->createCommand('update company set tenant= "' . $session['id'] . '" where id="' . $user_company . '"');
                                $row = $command->query();
                                $this->tenant = $session['id'];
                            } else {
                                $this->tenant = $company_tenant;
                            }

                            $this->isNewRecord = false;
                            $this->saveAttributes(array('tenant_agent', 'tenant'));
                        } else if ($role == Roles::ROLE_AGENT_OPERATOR) {
                            $this->tenant_agent = $session['tenant_agent'];
                            $this->tenant = $session['tenant'];
                            $this->isNewRecord = false;
                            $this->saveAttributes(array('tenant_agent', 'tenant'));
                        } else if ($session['role'] == Roles::ROLE_AGENT_ADMIN) {
                            if ($role == Roles::ROLE_STAFFMEMBER) {
                                $this->tenant_agent = $session['tenant_agent'];
                                $this->isNewRecord = false;
                                $this->saveAttributes(array('tenant_agent'));
                            }
                        } else {
                            $this->tenant = $session['tenant'];
                            $this->isNewRecord = false;
                            $this->saveAttributes(array('tenant'));
                        }
                    }
                }
            }
        } else {
            $connection = Yii::app()->db;
            $command = $connection->createCommand('SELECT user.id as id,user.role as role,user.company as user_company,company.name, 
                company.tenant AS company_tenant, company.`tenant_agent` AS company_tenant_agent
                FROM `user` 
                LEFT JOIN company ON company.id=user.`company`
                WHERE user.id="' . $this->id . '"');
            $row = $command->queryRow();
            foreach ($row as $key => $value) {
                $userid = $row['id'];
                $role = $row['role'];
                $user_company = $row['user_company'];
                $company_tenant = $row['company_tenant'];
                $company_tenant_agent = $row['company_tenant_agent'];
            }
            if ($role == Roles::ROLE_ADMIN) {
                if ($company_tenant == '') {
                    $command = $connection->createCommand('update company set tenant =' . $userid . ' where id ="' . $user_company . '" ');
                    $command->query();
                    
                    $command2 = $connection->createCommand('update user set tenant =' . $userid . ' where id ="' . $userid . '" ');
                    $command2->query();
                } else {
                    $command = $connection->createCommand('update user set tenant =' . $company_tenant . ' where id ="' . $userid . '" ');
                    $command->query();
                }
            }
        }
    }

    public function behaviors() {
        return array(
            'softDelete' => array(
                'class' => 'ext.soft_delete.SoftDeleteBehavior'
            ),
        );
    }

}
