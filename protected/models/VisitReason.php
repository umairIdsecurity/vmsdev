<?php

/**
 * This is the model class for table "visit_reason".
 *
 * The followings are the available columns in table 'visit_reason':
 * @property string $id
 * @property string $reason
 * @property string $created_by
 * @property string $tenant
 * @property string $tenant_agent
 *
 * The followings are the available model relations:
 * @property User $tenantAgent
 * @property User $createdBy
 * @property User $tenant0
 */
class VisitReason extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'visit_reason';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, tenant, tenant_agent', 'length', 'max' => 20),
            array('reason', 'required'),
            array('reason', 'filter', 'filter' => 'trim'),
            array('reason', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,reason, created_by, tenant, tenant_agent,is_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tenantAgent' => array(self::BELONGS_TO, 'User', 'tenant_agent'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'tenant0' => array(self::BELONGS_TO, 'User', 'tenant'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'reason' => 'Reason',
            'created_by' => 'Created By',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
            'is_deleted' => 'Deleted',
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
        $criteria->compare('reason', $this->reason, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.ID DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VisitReason the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

//    public function behaviors() {
//        return array(
//            'softDelete' => array(
//                'class' => 'ext.soft_delete.SoftDeleteBehavior'
//            ),
//        );
//    }

    public function findAllReason() {

        $criteria = new CDbCriteria;
        $criteria->select = 'id,reason';

        return VisitReason::model()->findAll($criteria);
    }

    public function GetAllReason() {
        $aArray = array();
        $visitReason = VisitReason::model()->findAll();
        foreach ($visitReason as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['reason'],
            );
        }

        return $aArray;
    }

    public function isReasonUnique($reason) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "reason = '" . $reason . "' ";
        $visitorReason = VisitReason::model()->findAll($Criteria);

        $visitorReason = array_filter($visitorReason);
        $visitorReasonCount = count($visitorReason);

        if ($visitorReasonCount == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function beforeFind() {
        $session = new CHttpSession;
        $criteria = new CDbCriteria;
        $criteria->condition = "t.is_deleted = 0";
        $this->dbCriteria->mergeWith($criteria);
    }
    
    public function beforeDelete() {
        $this->is_deleted = 1;
        $this->save();

        //prevent real deletion
        return false;
    }

    

}
