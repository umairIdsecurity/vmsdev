<?php

/**
 * This is the model class for table "tenant".
 *
 * The followings are the available columns in table 'tenant':
 * @property string $id
 * @property string $created_by
 * @property int $is_deleted
 *
 * The followings are the available model relations:
 * @property Company $id0
 * @property TenantContact[] $tenantContacts
 */
class Tenant extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $name;
    public $code;
    public $contact;
    public $email_address;
    public $is_deleted;
   
      
	public function tableName()
	{
		return 'tenant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, created_by', 'required', 'message'=>'Please complete {attribute}'),
			array('id, created_by', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, created_by,name,code,contact,email_address,is_deleted', 'safe', 'on'=>'search'),
			array('id, created_by,name,code,contact,email_address,is_deleted', 'safe', 'on'=>'tenant_contact'),
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
			'id0' => array(self::BELONGS_TO, 'Company', 'id'),
			'tenantContacts' => array(self::HAS_MANY, 'TenantContact', 'tenant'),
			'user0'=> array(self::MANY_MANY, 'User', 'tenant_contact(tenant, user)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'created_by' => 'Created By',
			'is_deleted' => 'Is deleted',        
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

		$criteria->with = array('id0', 'user0');

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.created_by',$this->created_by,true);
		$criteria->compare('t.is_deleted',0);
		$criteria->compare('id0.name',$this->name,true);
		$criteria->compare('id0.code',$this->code,true);
		$criteria->compare('id0.contact',$this->contact,true);
		$criteria->compare('id0.email_address',$this->email_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tenant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
