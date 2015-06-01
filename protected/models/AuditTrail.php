<?php

/**
 * This is the model class for table "AuditTrail".
 *
 * The followings are the available columns in table 'AuditTrail':
 * @property string $id
 * @property string $description
 * @property string $old_values
 * @property string $new_values
 * @property string $action
 * @property string $model
 * @property string $model_id
 * @property string $field
 * @property string $creation_date
 * @property string $userid
 */
class AuditTrail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'audit_trail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creation_date', 'required'),
			array('description, old_value, new_value', 'length', 'max'=>255),
			array('action', 'length', 'max'=>20),
			array('model, field, user_id', 'length', 'max'=>45),
			array('model_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, description, old_value, new_value, action, model, model_id, field, creation_date, user_id', 'safe', 'on'=>'search'),
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
			'description' => 'Description',
			'old_value' => 'Old Value',
			'new_value' => 'New Value',
			'action' => 'Action',
			'model' => 'Model',
			'model_id' => 'Model',
			'field' => 'Field',
			'creation_date' => 'Creation Date',
			'user_id' => 'User Id',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('old_value',$this->old_value,true);
		$criteria->compare('new_value',$this->new_value,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('model_id',$this->model_id,true);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuditTrail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
