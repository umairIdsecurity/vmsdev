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
class User extends VmsActiveRecord
{       
    
    
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
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, contact_number, role, user_type', 'required'),
			array('contact_number, company, role, user_type, user_status, created_by', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, email, department, position, staff_id', 'length', 'max'=>50),
			array('photo', 'length', 'max'=>150),
			array('date_of_birth, notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, contact_number, date_of_birth, company, department, position, staff_id, notes, photo, role_id, user_type_id, user_status_id, created_by', 'safe', 'on'=>'search'),
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
			'workstation' => array(self::HAS_MANY, 'user_workstations', 'id'),
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
			'last_name' => 'Last Name',
			'email' => 'Email',
			'contact_number' => 'Contact Number',
			'date_of_birth' => 'Date Of Birth',
			'company' => 'Company',
			'department' => 'Department',
			'position' => 'Position',
			'staff_id' => 'Staff',
			'notes' => 'Notes',
			'photo' => 'Photo',
			'password' => 'Password',
			'role' => 'Role',
			'user_type' => 'User Type',
			'user_status' => 'User Status',
			'created_by' => 'Created By',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact_number',$this->contact_number);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('company',$this->company);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('staff_id',$this->staff_id,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('user_status',$this->user_status);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function afterValidate()
	{
            parent::afterValidate();
            if(!$this->hasErrors())
            { 
               //$this->password = $this->hashPassword($this->password); 
            }
	}

	public function hashPassword($password)
	{
            return CPasswordHelper::hashPassword($password);
	}
	
	public function validatePassword($password,$hash)
	{
            //return $this->hashPassword($password)===$this->password;
            //hash saved in database
            if (CPasswordHelper::verifyPassword($password, $hash)){
                return true;
            }
            else{
                return false;
            }
	}
        
        
        public function getUserRole($user_role){
            
            $search_array = User::$USER_ROLE_LIST;
            if(isset(User::$USER_ROLE_LIST[$user_role])){
                return User::$USER_ROLE_LIST[$user_role];
            }   
        }
        
        public function beforeSave() {
            //$this->password = $this->hashPassword($this->password);
            $this->date_of_birth=date('Y-m-d', strtotime($this->date_of_birth));
            return true;
        }
        
}
