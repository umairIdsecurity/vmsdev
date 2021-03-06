<?php

/**
 * This is the model class for table "reasons".
 *
 * The followings are the available columns in table 'reasons':
 * @property integer $id
 * @property string $reason_name
 * @property string $date_created
 */
class Reasons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reasons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reason_name', 'required', 'message'=>'Please complete {attribute}'),
			array('reason_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, reason_name, date_created', 'safe', 'on'=>'search'),
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
			'reason_name' => 'Reason Name',
			'date_created' => 'Date Created',
			'Formatdate' => 'Date Created',
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
		$criteria->compare('reason_name',$this->reason_name,true);
		$criteria->compare('date_created',$this->date_created,true);
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
	 * @return Reasons the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	 /*
	 * this function is used to get label 
	 * in notifications creation dropdownlist
	 */
	public function getNameFuncForReasons()
	{
		return $this->reason_name;
	}

	public function getFormatdate()
	{
		if (date("Y-m-d", strtotime($this->date_created)) != "1970-01-01" && date("Y-m-d", strtotime($this->date_created)) != "1969-12-31")
			return date("d-m-Y", strtotime($this->date_created) );
		else
			return "";
	}

	public function behaviors() 
	{
		return array(
			'DateTimeZoneAndFormatBehavior' => 'application.components.DateTimeZoneAndFormatBehavior',
		);
	}
}
