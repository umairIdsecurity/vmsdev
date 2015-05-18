<?php

/**
 * This is the model class for table "import_visitor".
 *
 * The followings are the available columns in table 'import_visitor':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $company
 * @property string $check_in_date
 * @property string $check_out_date
 * @property string $card_code
 * @property integer $imported_by
 * @property integer $import_date
 */
class ImportVisitor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'import_visitor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, company, check_in_date, check_out_date, imported_by, import_date', 'required'),
			array('first_name, last_name, email, company, card_code', 'length', 'max'=>255),
			array('check_in_date, check_out_date, card_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, card_code, first_name, last_name, email, company, check_in_date, check_out_date', 'safe', 'on'=>'search'),
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
//                    "visitor"=>array(self::BELONGS_TO, 'Visitor', 'email')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
                        'card_code' =>'Card Code',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'company' => 'Company',
			'check_in_date' => 'Check In Date',
			'check_out_date' => 'Check Out Date',
                        'imported_by'=>'Imported By',
                        'import_date'=>'Date imported',
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
               
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('check_in_date',$this->check_in_date,true);
		$criteria->compare('check_out_date',$this->check_out_date,true);
                $criteria->compare('imported_by',$this->imported_by,true);
                $criteria->compare('import_date',$this->import_date,true);
                
                $criteria->select = "t.*";
                $criteria->join = 'INNER JOIN visitor v on v.email = t.email';
                $criteria->addCondition('imported_by = '.Yii::app()->user->id);
                $criteria->group = 'v.email';
                
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImportVisitor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
       
}
