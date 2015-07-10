<?php

/**
 * This is the model class for table "visitor_type".
 *
 * The followings are the available columns in table 'visitor_type':
 * @property string $id
 * @property string $name
 * @property string $created_by
 * @property integer $is_default_value
 *
 * The followings are the available model relations:
 * @property Visitor[] $visitors
 * @property User $createdBy
 */
class VisitorType extends CActiveRecord {

    //public static $VISITOR_TYPE_LIST = returnVisitorTypes();

    const PATIENT_VISITOR = 1;
    const CORPORATE_VISITOR = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'visitor_type';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'length', 'max' => 25),
            array('name', 'required'),          
            array('created_by', 'length', 'max' => 20),
            array('is_default_value', 'length', 'max'=>1),  
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, is_deleted,tenant,tenant_agent,name , is_default_value, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'visitors' => array(self::HAS_MANY, 'Visitor', 'visitor_type'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'visits'=>array(self::HAS_MANY, 'Visit', 'visitor_type'),
            'visitsCount' => array(self::STAT, 'Visit', 'visitor_type'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'created_by' => 'Created By',
            'is_deleted' => 'Is Deleted',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
            'is_default_value' => 'Set Default'
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
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('is_default_value', $this->is_default_value, true);
        // Allow Admin to View and Manage his own created Types
        if( Yii::app()->user->role == Roles::ROLE_ADMIN )
            $criteria->addCondition("created_by ='" . Yii::app()->user->id . "'");
        
        $data =  new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));

        $data->setTotalItemCount(count($data->getData()));
        $data->pagination->setItemCount(count($data->getData()));

        return $data;

    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VisitorType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeFind() {
        $session = new CHttpSession;
        $criteria = new CDbCriteria;
        if (Yii::app()->controller->action->id != 'exportvisitorrecords' && Yii::app()->controller->action->id != 'evacuationReport' && Yii::app()->controller->action->id != 'visitorRegistrationHistory' && Yii::app()->controller->action->id != 'view' && Yii::app()->controller->action->id != 'index' && Yii::app()->controller->action->id != 'getFromCardType') {
            $criteria->condition = "t.is_deleted = 0 AND t.id !=1";
        }


        if (Yii::app()->controller->action->id == 'index') {
            if(Yii::app()->request->getParam('vms') == 'cvms')
                $criteria->condition = " t.name not like 'Vic%'";
            else $criteria->condition = " t.name like 'Vic%'";
        }

        if (Yii::app()->controller->action->id == 'visitorsByTypeReport' || Yii::app()->controller->action->id == 'visitorsByWorkstationReport') {
            $criteria->condition = "";
            $criteria->condition = "t.is_deleted=0";
        }
        
        $this->dbCriteria->mergeWith($criteria);
    }


    /**
     * @param $cardtype variable passed when log visit
     * @return null|string return list vistor type from cardtype
     */
    public function getFromCardType($cardtype)
    {
        $criteria = new CDbCriteria;
        if (Yii::app()->user->role == Roles::ROLE_ADMIN)
            $criteria->addCondition("created_by ='" . Yii::app()->user->id . "'");

        if (in_array($cardtype, CardType::$CORPORATE_CARD_TYPE_LIST)) {
            $criteria->condition = " t.name not like 'Vic%'";
        } elseif (in_array($cardtype, CardType::$VIC_CARD_TYPE_LIST)) {
            $criteria->condition = " t.name  like 'Vic%'";
        }
        $list = $this->model()->findAll($criteria);
        if ($list) return CJSON::encode($list);
        return null;
    }

    /**
     * Before Save change a few things.
     * 
     * @return control
     */
    public function beforeSave() {
        
        // Only one value can be set default for a specific tenant ID
        if( isset($this->is_default_value) && $this->is_default_value ) {
            $this->updateAll(array("is_default_value"=>0), "tenant = '".$this->tenant."'" );
        }
       
        return parent::beforeSave();
    }

    public function beforeDelete() {
        $this->is_deleted = 1;
        $this->save();

        //prevent real deletion
        return false;
    }

    public function returnVisitorTypes($visitorTypeId = NULL,$condition= "1>0") {
        $visitorType = VisitorType::model()->findAll($condition);
        $VISITOR_TYPE_LIST = array();
        foreach ($visitorType as $key => $value) {
            $VISITOR_TYPE_LIST[$value['id']] = 'Visitor Type: ' . $value['name'];
        }

        if ($visitorTypeId == NULL) {
            $VISITOR_TYPE_LIST=array(""=>'Select Visitor Type')+$VISITOR_TYPE_LIST;
            return $VISITOR_TYPE_LIST;
        } else {
            if ($visitorTypeId != 1) {
                return $VISITOR_TYPE_LIST[$visitorTypeId];
            }
        }
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

}
