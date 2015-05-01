<?php

/**
 * This is the model class for table "workstation_card_type".
 *
 * The followings are the available columns in table 'workstation_card_type':
 * @property string $workstation
 * @property string $card_type
 * @property string $user
 *
 * The followings are the available model relations:
 * @property Workstation $workstation0
 * @property CardType $cardType
 * @property User $user0
 */
class WorkstationCardType extends CActiveRecord
{
	//public $workstation;
	//public $card_type;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'workstation_card_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workstation, card_type, user', 'required'),
			array('workstation, card_type, user', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('workstation, card_type, user', 'safe', 'on'=>'search'),
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
			//'workstation0' => array(self::BELONGS_TO, 'Workstation', 'workstation'),
			//'cardType' => array(self::BELONGS_TO, 'CardType', 'card_type'),
			//'user0' => array(self::BELONGS_TO, 'User', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'workstation' => 'Workstation',
			'card_type' => 'Card Type',
			'user' => 'User',
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

		$criteria->compare('workstation',$this->workstation,true);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('user',$this->user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WorkstationCardType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
