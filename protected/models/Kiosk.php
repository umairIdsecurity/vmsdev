<?php

/**
 * This is the model class for table "kiosk".
 *
 * The followings are the available columns in table 'kiosk':
 * @property int $id
 * @property string $name
 * @property int $workstation
 * @property string $module
 * @property string $username
 * @property string $password
 * @property int $tenant
 * @property int $tenant_agent
 * @property int $created_by
 * @property int $is_deleted
 * @property int $enabled
 * @property string $atoken
 *
 * The followings are the available model relations:
 * @property Visitor[] $visitors
 */
class Kiosk extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kiosk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		# NOTE: you should only define rules for those attributes that
		# will receive user inputs.
		return array( 
			array('name, workstation, tenant, created_by', 'required'),			
			array('workstation, tenant, tenant_agent, created_by, is_deleted, enabled', 'numerical', 'integerOnly' => true),
			array('name, module, username, password', 'length', 'max' => 255),
			array('name, module, username, password, atoken', 'safe'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, created_by', 'safe', 'on' => 'search'),	);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		# NOTE: you may need to adjust the relation name and the related
		# class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Kiosk Name',
			'workstation' => 'Workstation',
			'module' => 'Module',
			'tenant' => 'Tenant',
			'tenant_agent' => 'Tenant Agent',			
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vehicle the static model class
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
