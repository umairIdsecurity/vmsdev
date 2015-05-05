<?php

/**
 * This is the model class for table "visitor_type".
 *
 * The followings are the available columns in table 'visitor_type':
 * @property string $id
 * @property string $name
 * @property string $created_by
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
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, is_deleted,tenant,tenant_agent,name, created_by', 'safe', 'on' => 'search'),
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
        if(Yii::app()->controller->action->id != 'exportvisitorrecords' && Yii::app()->controller->action->id != 'evacuationReport' && Yii::app()->controller->action->id != 'visitorRegistrationHistory'){
            $criteria->condition = "t.is_deleted = 0 && t.id !=1";
        }
        $this->dbCriteria->mergeWith($criteria);
    }

    public function beforeDelete() {
        $this->is_deleted = 1;
        $this->save();

        //prevent real deletion
        return false;
    }

    public function returnVisitorTypes($visitorTypeId = NULL) {
        $visitorType = VisitorType::model()->findAll();
        $VISITOR_TYPE_LIST = array();
        foreach ($visitorType as $key => $value) {
            $VISITOR_TYPE_LIST[$value['id']] = $value['name'];
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

}
