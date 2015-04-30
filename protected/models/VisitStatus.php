<?php

/**
 * This is the model class for table "visit_status".
 *
 * The followings are the available columns in table 'visit_status':
 * @property string $id
 * @property string $name
 * @property string $created_by
 *
 * The followings are the available model relations:
 * @property User $createdBy
 */
class VisitStatus extends CActiveRecord
{
    
    public static $VISIT_STATUS_LIST = array(
		""=> 'Status',
        1 => 'Active',
        2 => 'Preregistered',
        3 => 'Closed',
        4 => 'Expired',
        5 => 'Saved',
    );
    
    
    public static $VISIT_STATUS_DASHBOARD_FILTER = array(
		''=> 'Status',
        1 => 'Active',
        2 => 'Preregistered'
    );
    
    
    CONST ACTIVE = 1;
    CONST PREREGISTERED = 2;
    CONST CLOSED =3;
    CONST EXPIRED = 4;
    CONST SAVED = 5;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'visit_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>25),
			array('created_by', 'length', 'max'=>20),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisitStatus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
