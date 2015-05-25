<?php

/**
 * This is the model class for table "roles".
 *
 * The followings are the available columns in table 'roles':
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 * @property User[] $users
 */
class Roles extends CActiveRecord
{
        const ROLE_SUPERADMIN = 5;
        const ROLE_ADMIN = 1;
        const ROLE_AGENT_ADMIN = 6;
        const ROLE_AGENT_OPERATOR = 7;
        const ROLE_OPERATOR = 8;
        const ROLE_STAFFMEMBER = 9;
        const ROLE_VISITOR = 10;

        const ROLE_ISSUING_BODY_ADMIN = 11;     // Same As Administrator with Access to VIC Issuing Module Functionality
        const ROLE_AIRPORT_OPERATOR = 12;       // Same Access Rights as Administrator with view of VIC Issuing Module Functionality
        CONST ROLE_AGENT_AIRPORT_ADMIN = 13;    //Same Access as CVMS Agent with Access to VIC Issuing Module
        CONST ROLE_AGENT_AIRPORT_OPERATOR = 14; //Same Access to CVMS Agent
        
        // Roles label to show on Add/Edit User page
        public static $labels =array(
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_AGENT_ADMIN => 'Agent Administrator',
            self::ROLE_OPERATOR => 'Operator',
            self::ROLE_STAFFMEMBER => 'Host',
            self::ROLE_ISSUING_BODY_ADMIN => 'Issuing Body Admin',
            self::ROLE_AIRPORT_OPERATOR => 'Airport Operator',
            self::ROLE_AGENT_AIRPORT_ADMIN => 'Agent Airport Admin',
            self::ROLE_AGENT_OPERATOR => 'Agent Operator',
            self::ROLE_VISITOR => 'Visitor',
            self::ROLE_AGENT_AIRPORT_OPERATOR => 'Agent Airport Operator', 
            
            );

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'roles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('created_by', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, created_by', 'safe', 'on'=>'search'),
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
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
			'users' => array(self::HAS_MANY, 'User', 'role'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Roles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public static function get_avms_roles()
    {
        return array(
            self::ROLE_SUPERADMIN,
            self::ROLE_ISSUING_BODY_ADMIN,
            self::ROLE_AIRPORT_OPERATOR,
            self::ROLE_AGENT_AIRPORT_ADMIN,
            self::ROLE_AGENT_AIRPORT_OPERATOR
        );
    }

    public static function get_cvms_roles()
    {
        return array(
            self::ROLE_SUPERADMIN,
            self::ROLE_ADMIN,
            self::ROLE_AGENT_ADMIN,
            self::ROLE_AGENT_OPERATOR,
            self::ROLE_OPERATOR,
            self::ROLE_STAFFMEMBER,
            self::ROLE_VISITOR,
        );
    }


    public static function get_admin_allowed_roles($should_filter)
    {
        if($should_filter)
        {
            if(CHelper::is_avms_users_requested()){
                return array(
                    self::ROLE_ISSUING_BODY_ADMIN,
                    self::ROLE_AGENT_AIRPORT_ADMIN,
                    self::ROLE_AIRPORT_OPERATOR,
                    //self::ROLE_AGENT_AIRPORT_OPERATOR
                );
            }else{
                return array(
                    self::ROLE_ADMIN,
                    self::ROLE_AGENT_ADMIN,
                    self::ROLE_AGENT_OPERATOR,
                    self::ROLE_OPERATOR,
                    self::ROLE_STAFFMEMBER,
                    self::ROLE_VISITOR
                );
            }
        }else{
            return array(
                self::ROLE_ADMIN,
                self::ROLE_AGENT_ADMIN,
                self::ROLE_AGENT_OPERATOR,
                self::ROLE_OPERATOR,
                self::ROLE_STAFFMEMBER,
                self::ROLE_VISITOR,

                self::ROLE_ISSUING_BODY_ADMIN,
                self::ROLE_AGENT_AIRPORT_ADMIN,
                self::ROLE_AIRPORT_OPERATOR,
                //self::ROLE_AGENT_AIRPORT_OPERATOR
            );
        }
    }

    public static function get_agent_admin_allowed_roles($should_filter){
        if($should_filter)
        {
            if(CHelper::is_avms_users_requested()){
                return array(

                    self::ROLE_AGENT_AIRPORT_ADMIN,
                    self::ROLE_AGENT_AIRPORT_OPERATOR,

                    self::ROLE_STAFFMEMBER,
                    self::ROLE_VISITOR
                );
            }else{
                return array(
                    self::ROLE_AGENT_ADMIN,
                    self::ROLE_AGENT_OPERATOR
                );
            }
        }else{
            return array(
                self::ROLE_AGENT_ADMIN,
                self::ROLE_AGENT_OPERATOR,
                self::ROLE_STAFFMEMBER,
                self::ROLE_VISITOR,

                self::ROLE_AGENT_AIRPORT_ADMIN,
                self::ROLE_AGENT_AIRPORT_OPERATOR
            );
        }
    }

    /*public static function get_agent_operator_allowed_roles($should_filter){
        if($should_filter){

        } else {

        }
    }

    public static function get_operator_allowed_roles($should_filter){
        if($should_filter){

        } else {

        }
    }*/




}
