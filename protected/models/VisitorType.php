<?php

/**
 * This is the model class for table "visitor_type".
 *
 * The followings are the available columns in table 'visitor_type':
 * @property string $id
 * @property string $name
 * @property string $created_by
 * @property integer $is_default_value
 * @property string $module
 *
 * The followings are the available model relations:
 * @property Visitor[] $visitors
 * @property User $createdBy
 *
 *
 */
class VisitorType extends CActiveRecord {

    public $card_types = array();

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
            array('name', 'required'),
            array('name', 'length', 'max' => 25),
            array('created_by', 'length', 'max' => 20),
            array('module', 'length', 'max' => 4),
            array('is_default_value', 'length', 'max'=>1),  
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,is_deleted,tenant,tenant_agent,name,is_default_value,created_by', 'safe', 'on' => 'search'),
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
            'visitTypeCardType' => array(self::HAS_MANY,"VisitTypeCardType","visitor_type")
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
            'is_default_value' => 'Set Default',
            'module' => 'Module'
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
        $session = new CHttpSession;
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('is_default_value', $this->is_default_value, true);
        $criteria->compare('module', $this->module, true);

        if(isset($session['tenant']))
        {
            $criteria->addCondition("t.tenant =" . $session['tenant']);
        }

        // Allow Admin to View and Manage his own created Types
        //if( Yii::app()->user->role == Roles::ROLE_ADMIN )
        //    $criteria->addCondition("created_by =" . Yii::app()->user->id . "'");



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

        $criteria = new CDbCriteria;
        
        
        if (Yii::app()->controller->action->id != 'exportvisitorrecords' && Yii::app()->controller->action->id != 'evacuationReport' && Yii::app()->controller->action->id != 'visitorRegistrationHistory' && Yii::app()->controller->action->id != 'view') {
            $criteria->condition = "t.is_deleted = 0 AND t.id !=1";
        }

        if (Yii::app()->controller->action->id == 'visitorsByTypeReport' || Yii::app()->controller->action->id == 'visitorsByWorkstationReport') {
            $criteria->condition = "";
            $criteria->condition = "t.is_deleted=0";
        }
        

        if(isset(Yii::app()->user->role)) {
            if( Yii::app()->user->role != Roles::ROLE_SUPERADMIN ) {
                $criteria->condition = "t.is_deleted = 0 AND t.tenant = ".Yii::app()->user->tenant;
            }
        }

        $this->dbCriteria->mergeWith($criteria);

        return parent::beforeFind();

    }


    /**
     * @param $cardtype variable passed when log visit
     * @return null|string return list vistor type from cardtype
     */
    public function getFromCardType($cardtype)
    {
        $list = $this->getCardTypeVisitorTypes($cardtype);
        if($list) {

            return CJSON::encode($list);
        }
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
        //return true;
    }

    public function nullVisitorTypes(){
        return null;
    }

    public function getCardTypeVisitorTypes($card_type){
      
        $session = new CHttpSession;
        $criteria = new CDbCriteria;

        $criteria->addCondition("t.tenant=".$session['tenant']." AND t.is_deleted=0");

        //$criteria->addCondition("t.module='".CHelper::get_module_focus()."'");

        if($card_type > 4){
            $criteria->addCondition("t.module='AVMS'");
        }else{
            $criteria->addCondition("t.module='CVMS'");
        }
        
        if(isset($session['tenant_agent']))
            $criteria->addCondition("t.tenant_agent=".$session['tenant_agent']);

         $criteria->addCondition("visitor_type_card_type.is_deleted=0 AND visitor_type_card_type.card_type='".$card_type."'");

        $criteria->join = 'JOIN visitor_type_card_type'
                                        .' ON visitor_type_card_type.visitor_type = t.id';

        return VisitorType::model()->findAll($criteria);

    }

    public function getActiveCardTypes($visitor_type){

        $session = new CHttpSession;
        $criteria = new CDbCriteria;
        //$criteria->select = "card_type";
        $criteria->addCondition("t.visitor_type=" . $visitor_type."");
        
        //$criteria->addCondition("t.tenant=" . $session['tenant'] . " AND t.is_deleted=0");

        $criteria->addCondition("visitor_type.tenant=" . $session['tenant'] . " AND t.is_deleted=0");

        /*if (isset($session['tenant_agent']))
            $criteria->addCondition("t.tenant_agent=" . $session['tenant_agent']);*/

        $criteria->join = 'JOIN visitor_type '
            . 'ON visitor_type.id = t.visitor_type '
            . 'AND visitor_type.is_deleted=0 '
            . "AND visitor_type.module='" . CHelper::get_module_focus() . "'";

        return VisitorTypeCardType::model()->findAll($criteria);

    }
    public function getActiveCardTypeIds($visitor_type)
    {
        $result= array();
        if($visitor_type!='') {

            $types = $this->getActiveCardTypes($visitor_type);

            foreach ($types as $type => $value) {
                array_push($result, $value->card_type);
            }
        }
        return $result;
    }

    public function returnVisitorTypes($visitorTypeId = NULL,$condition= "1>0") {
        
        if( is_null($visitorTypeId) )
            $condition .=" And tenant = ".Yii::app ()->user->tenant;
        $visitorType = VisitorType::model()->findAll($condition);
        $VISITOR_TYPE_LIST = array();
        foreach ($visitorType as $key => $value) {
            $VISITOR_TYPE_LIST[$value['id']] =  $value['name'];
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

    public function returnVisitorType($visitorTypeId = NULL,$condition= "1>0") {
        
        if( is_null($visitorTypeId) )
            $condition .=" And tenant = ".Yii::app ()->user->tenant;
        $visitorType = VisitorType::model()->findAll($condition);
        $VISITOR_TYPE_LIST = array();
        foreach ($visitorType as $key => $value) {
            $VISITOR_TYPE_LIST[$value['id']] =  $value['name'];
        }

        if ($visitorTypeId == NULL) {
            $VISITOR_TYPE_LIST="";


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
