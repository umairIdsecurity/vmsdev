<?php

/**
 * This is the model class for table "notifications".
 *
 * The followings are the available columns in table 'notifications':
 * @property integer $id
 * @property string $subject
 * @property string $message
 * @property integer $created_by
 * @property string $date_created
 * @property integer $role_id
 * @property string $notification_type
 */
class Notification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, message', 'required', 'message' =>'Please complete {attribute}'),
			array('created_by, role_id', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>250),
			array('notification_type', 'length', 'max'=>100),
			array('date_created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, subject, message, created_by, date_created, role_id, notification_type', 'safe', 'on'=>'search'),
                        array('id, subject, message, created_by, date_created, role_id, notification_type', 'safe', 'on'=>'indexSearch'),
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
                    'user_notification'=>array(self::HAS_MANY, "UserNotification", "notification_id"),
                    'role'=>array(self::BELONGS_TO, "Roles", "role_id"),
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject' => 'Subject',
			'message' => 'Message',
			'created_by' => 'Created By',
			'date_created' => 'Date Created',
			'role_id' => 'Group to Send',
			'notification_type' => 'Notification Type',
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
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('date_created',$this->date_created,true);	
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('notification_type',$this->notification_type,true);
                
                if( Roles::ROLE_SUPERADMIN != Yii::app()->user->role)
                {
                     $criteria->condition = "created_by = ".Yii::app()->user->id;
                }
        
        $criteria->order = 't.id DESC';        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        /**
	 * this function together with usernotification fetch his only results(notifications)
	 */
	public function indexSearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('date_created',$this->date_created,true);	
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('notification_type',$this->notification_type,true);
                
                $criteria->with = array('user_notification' );
                $criteria->together = true;
                $criteria->condition = "user_notification.user_id=:user_id";
                $criteria->params = array(':user_id' => Yii::app()->user->id);
                $criteria->order = 't.id DESC';        
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function afterFind() {
		$this->date_created = date("d-m-Y", strtotime($this->date_created) );
		parent::afterFind();
	}

	public function beforeSave() {
	   $this->date_created = date("Y-m-d", strtotime($this->date_created));
	   return parent::beforeSave();

	}

	public function behaviors()
	{
		return array(

			'AuditTrailBehaviors'=>
				'application.components.behaviors.AuditTrailBehaviors',
                        'DateTimeZoneAndFormatBehavior' => 'application.components.DateTimeZoneAndFormatBehavior',
       
		);
	}

}
