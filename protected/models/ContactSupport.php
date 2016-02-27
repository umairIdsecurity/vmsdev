<?php

/**
 * This is the model class for table "contact_support".
 *
 * The followings are the available columns in table 'contact_support':
 * @property integer $id
 * @property integer $contact_person_id
 * @property integer $contact_reason_id
 * @property integer $user_id
 * @property string $contact_message
 * @property string $date_created
 */
class ContactSupport extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contact_support';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('contact_person_id, contact_reason_id, user_id', 'required','message' =>'Please complete {attribute}'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, contact_person_id, contact_reason_id, user_id, contact_message, date_created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contact_person_id' => 'Contact Person',
			'contact_reason_id' => 'Contact Reason',
			'user_id' => 'User',
			'contact_message' => 'Contact Message',
			'date_created' => 'Date Created',
		);
	}

	/**
	* Change date Formate 
	*/
	protected function afterFind ()
	{
		// convert to display format
		$this->date_created = date("d-m-Y", strtotime($this->date_created));
		parent::afterFind();
	}

	public function behaviors() 
	{
		return array(
			'DateTimeZoneAndFormatBehavior' => 'application.components.DateTimeZoneAndFormatBehavior',
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
		$criteria->compare('contact_person_id',$this->contact_person_id,true);
		$criteria->compare('contact_reason_id',$this->contact_reason_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('contact_message',$this->contact_message,true);
		$criteria->compare('date_created',$this->date_created,true);
		//Show only same tenant related persons. 
		if(Yii::app()->user->role != Roles::ROLE_SUPERADMIN)
			$criteria->condition = "t.tenant = " . Yii::app()->user->tenant;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactPerson the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
