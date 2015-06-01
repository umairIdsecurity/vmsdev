<?php

/**
 * This is the model class for table "user_type".
 *
 * The followings are the available columns in table 'user_type':
 * @property integer $id
 * @property string $name
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property User $createdBy
 */
class UserType extends CActiveRecord
{
        public static $USER_TYPE_LIST = array(
            1 => 'Internal',
            2 => 'External',
        );
        
        const USERTYPE_INTERNAL = 1;
        const USERTYPE_EXTERNAL = 2;
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_type';
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
			'users' => array(self::HAS_MANY, 'User', 'user_type'),
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
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
	 * @return UserType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function getUserType($user_type){

		$search_array = User::$USER_TYPE_LIST;
		if(isset(User::$USER_TYPE_LIST[$user_type])){
			return User::$USER_TYPE_LIST[$user_type];
		}
   }

	public function behaviors()
	{
		return array(

			'AuditTrailBehaviors'=>
				'application.components.behaviors.AuditTrailBehaviors',
		);
	}

}
