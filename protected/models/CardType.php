<?php

/**
 * This is the model class for table "card_type".
 *
 * The followings are the available columns in table 'card_type':
 * @property string $id
 * @property string $name
 * @property string $max_time_validity
 * @property integer $max_entry_count_validity
 * @property string $card_background_image_path
 * @property string $created_by
 *
 * The followings are the available model relations:
 * @property Photo $cardBackgroundImagePath
 * @property User $createdBy
 */
class CardType extends CActiveRecord {

	const SAME_DAY_VISITOR   = 1;
	const MULTI_DAY_VISITOR  = 2;
	const MANUAL_VISITOR     = 3;
	const CONTRACTOR_VISITOR = 4;

	const VIC_CARD_SAMEDATE = 5;
	const VIC_CARD_24HOURS  = 6;
	const VIC_CARD_EXTENDED = 7; // EVIC card type
	const VIC_CARD_MULTIDAY = 8;
	const VIC_CARD_MANUAL   = 9;
	const TEMPORARY_ASIC   = 10; // ASIC Card Type (Generate New card type and replace card id with existing id)

	public static $CARD_TYPE_LIST = array(
		'' => 'Card Type',
		1  => 'Same Day Visitor',
		2  => 'Multi-Day Visitor',
		3  => 'Manual Visitor',
		4  => 'Contractor Visitor',
	);

	public static $CORPORATE_CARD_TYPES = array(
		1  => 'Same Day',
		2  => 'Multi-Day',
		3  => 'Manual',
		4  => 'Contractor',
	);

	public static $VIC_CARD_TYPES = array(
		5  => 'Same Day',
		6  => '24 Hour',
		7  => 'Extended',
		8  => 'Multi-Day',
		9  => 'Manual',
		10  => 'Temporary ASIC',
	);


	public static $CORPORATE_CARD_TYPE_LIST = [
		self::SAME_DAY_VISITOR,
		self::MULTI_DAY_VISITOR,
		self::MANUAL_VISITOR,
		self::CONTRACTOR_VISITOR,
	];

	public static $VIC_CARD_TYPE_LIST = [
		self::VIC_CARD_SAMEDATE,
		self::VIC_CARD_24HOURS,
		self::VIC_CARD_EXTENDED,
		self::VIC_CARD_MULTIDAY,
		self::VIC_CARD_MANUAL,
		self::TEMPORARY_ASIC,
	];

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'card_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('max_entry_count_validity', 'numerical', 'integerOnly' => true),
			array('name, max_time_validity', 'length', 'max' => 50),
			array('card_background_image_path, created_by , module', 'length', 'max' => 20),
			array('card_icon_type', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, max_time_validity,card_icon_type, max_entry_count_validity, card_background_image_path, created_by, module', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'cardBackgroundImagePath' => array(self::BELONGS_TO, 'Photo', 'card_background_image_path'),
			'createdBy'               => array(self::BELONGS_TO, 'User', 'created_by'),
			'cardModule'              => array(self::BELONGS_TO, 'Module', 'module'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'                         => 'ID',
			'name'                       => 'Name',
			'max_time_validity'          => 'Max Time Validity',
			'max_entry_count_validity'   => 'Max Entry Count Validity',
			'card_background_image_path' => 'Card Background Image Path',
			'card_icon_type'             => 'Card Icon',
			'created_by'                 => 'Created By',
			'module'                     => 'Module',
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('max_time_validity', $this->max_time_validity, true);
		$criteria->compare('max_entry_count_validity', $this->max_entry_count_validity);
		$criteria->compare('card_background_image_path', $this->card_background_image_path, true);
		$criteria->compare('card_icon_type', $this->card_icon_type, true);
		$criteria->compare('created_by', $this->created_by, true);
		$criteria->compare('module', $this->module, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CardType the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function behaviors() {
		return array(

			'AuditTrailBehaviors' =>
			'application.components.behaviors.AuditTrailBehaviors',
		);
	}

}
