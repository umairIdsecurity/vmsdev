<?php

/**
 * This is the model class for table "reset_history".
 *
 * The followings are the available columns in table 'reset_history':
 * @property integer $id
 * @property string $visitor_id
 * @property string $reset_time
 * @property string $reason
 */
class ResetHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reset_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('visitor_id, reset_time, reason', 'required'),
            array('lodgement_date', 'safe'),
			array('visitor_id', 'length', 'max'=>20),
			array('reason', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, visitor_id, reset_time, reason,lodgement_date', 'safe', 'on'=>'search'),
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
			'visitor_id' => 'Visitor',
			'reset_time' => 'Reset Time',
			'reason' => 'Reason',
            'lodgement_date' => 'Lodgement Date',
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
		$criteria->compare('visitor_id',$this->visitor_id,true);
		$criteria->compare('reset_time',$this->reset_time,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('lodgement_date',$this->lodgement_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ResetHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array(

			'AuditTrailBehaviors'=>
				'application.components.behaviors.AuditTrailBehaviors',
		);
	}

}
