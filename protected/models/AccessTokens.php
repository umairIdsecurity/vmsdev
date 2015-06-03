<?php

/**
 * This is the model class for table "access_tokens".
 *
 * The followings are the available columns in table 'access_tokens':
 * @property integer $ID
 * @property integer $USER_ID
 * @property string $ACCESS_TOKEN
 * @property integer $EXPIRY
 * @property integer $CLIENT_ID
 * @property string $CREATED
 * @property string $MODIFIED
 */
class AccessTokens extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'access_tokens';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('USER_ID, ACCESS_TOKEN, EXPIRY, CLIENT_ID, CREATED, MODIFIED', 'required'),
			array('USER_ID, EXPIRY, CLIENT_ID', 'numerical', 'integerOnly'=>true),
			array('ACCESS_TOKEN', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, USER_ID, ACCESS_TOKEN, EXPIRY, CLIENT_ID, CREATED, MODIFIED', 'safe', 'on'=>'search'),
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
			'ID' => 'ID',
			'USER_ID' => 'User',
			'ACCESS_TOKEN' => 'Access Token',
			'EXPIRY' => 'Expiry',
			'CLIENT_ID' => 'Client',
			'CREATED' => 'Created',
			'MODIFIED' => 'Modified',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('USER_ID',$this->USER_ID);
		$criteria->compare('ACCESS_TOKEN',$this->ACCESS_TOKEN,true);
		$criteria->compare('EXPIRY',$this->EXPIRY);
		$criteria->compare('CLIENT_ID',$this->CLIENT_ID);
		$criteria->compare('CREATED',$this->CREATED,true);
		$criteria->compare('MODIFIED',$this->MODIFIED,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AccessTokens the static model class
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
