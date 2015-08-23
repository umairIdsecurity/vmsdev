<?php

/**
 * This is the model class for table "tenant_agent".
 *
 * The followings are the available columns in table 'tenant_agent':
 * @property string $id
 * @property string $user_id
 * @property string $tenant_id
 * @property string $for_module
 * @property string $is_deleted
 * @property string $created_by
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Company $id0
 * @property User $user
 * @property Tenant $tenant
 */
class TenantAgent extends CActiveRecord
{
    public $tenant_name;
    public $tenant_agent_name;
    public $agent_contact;
    public $email_address;
    public $is_deleted;
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tenant_agent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, user_id, tenant_id, for_module', 'required'),
			array('id, user_id, tenant_id, for_module, is_deleted, created_by', 'length', 'max'=>20),
			array('date_created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tenant_name, tenant_agent_name, agent_contact, email_address, id, user_id, tenant_id, for_module, is_deleted, created_by, date_created', 'safe', 'on'=>'search'),
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
			'id0' => array(self::BELONGS_TO, 'Company', 'id'),
			'user0' => array(self::BELONGS_TO, 'User', 'user_id'),
			'tenant0' => array(self::BELONGS_TO, 'Tenant', 'tenant_id'),
			'agent_contact' => array(self::HAS_MANY, 'TenantAgentContact', 'tenant_agent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'tenant_id' => 'Tenant',
			'for_module' => 'For Module',
			'is_deleted' => 'Is Deleted',
			'created_by' => 'Created By',
			'date_created' => 'Date Created',
                        'tenant_name' => 'Tenant',
                        'tenant_agent_name' => 'Tenant Agent',
                        'agent_contact' => 'Agent Contact',
                        'email_address' => 'Agent Contact Email',
                        'for_module' => 'Module',
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
               
                $criteria->with = array("id0", "user0", "tenant0");
                $criteria->compare('t.id',$this->id, true);
				$criteria->compare('t.created_by',$this->created_by,true);
                $criteria->compare('t.is_deleted',0);              
                $criteria->compare('id0.name', $this->tenant_name, true);
                $criteria->compare('id0.name', $this->tenant_agent_name, true);
                $criteria->compare('id0.email_address', $this->email_address, true);
                $criteria->compare('id0.mobile_number', $this->agent_contact, true);
                $criteria->compare('t.for_module', $this->for_module, true);
                
                if(Yii::app()->controller->action->id == "avmsagents")
                   $criteria->addCondition ("t.for_module = 'avms'");
                 else if(Yii::app()->controller->action->id == "cvmsagents")
                   $criteria->addCondition ("t.for_module = 'cvms'");
                 
                  if(Yii::app()->user->role != Roles::ROLE_SUPERADMIN)
                    $criteria->addCondition("t.tenant_id = ".Yii::app()->user->tenant);
                   
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'defaultOrder' => 't.id DESC',
                        ),
                    'pagination' => array(
                    'pageSize' => 20
                ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TenantAgent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeFind() {
            $criteria = new CDbCriteria;
            $criteria->addCondition("t.is_deleted = 0");
            if(Yii::app()->user->role != Roles::ROLE_SUPERADMIN)
                $criteria->addCondition("t.tenant_id = ".Yii::app()->user->tenant);
            
            return parent::beforeFind();
        }
        
       public function getTenantName($tenant_id) {
           
           $tenant = Company::model()->find(" id = ".$tenant_id);
           return $tenant->name;
       }
 
}
