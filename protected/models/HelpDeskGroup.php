<?php

/**
 * This is the model class for table "helpdesk_group".
 *
 * The followings are the available columns in table 'helpdesk_group':
 * @property string $id
 * @property string $name
 * @property string $created_by
 *
 * The followings are the available model relations:
 * @property Visitor[] $visitors
 * @property User $createdBy
 * @property HelpdeskGroupWebPreregistration $helpdeskGroupWebPreregistration
 * @property HelpdeskGroupUserRole $helpdeskGroupUserRole
 */
class HelpDeskGroup extends CActiveRecord {

    //public static $helpdesk_group_LIST = returnHelpDeskGroups();

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'helpdesk_group';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'length', 'max' => 25),
            array('name, is_default_value', 'required', 'message'=>'Please complete {attribute}'),
            array('created_by, order_by', 'length', 'max' => 20),
            array('is_default_value', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, is_deleted, name, created_by, order_by, is_default_value', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'helpdeskGroupWebPreregistration' => array(self::HAS_MANY,"HelpdeskGroupWebPreregistration", "helpdesk_group"),
            'helpdeskGroupUserRole' => array(self::HAS_MANY,"HelpdeskGroupUserRole", "helpdesk_group"),
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
			'order_by' => 'Sort Order',
            'is_deleted' => 'Is Deleted',
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
        $criteria->compare('order_by', $this->order_by, true);
		$criteria->compare('is_default_value', $this->is_default_value, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->addCondition ('created_by = '.Yii::app()->user->id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HelpDeskGroup the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeFind() {
        
    }

    public function beforeDelete() {
        $this->is_deleted = 1;
        $this->save();

        //prevent real deletion
        return false;
    }

    public function returnHelpDeskGroups($helpDeskGroupId = NULL) {
        $helpDeskGroup = HelpDeskGroup::model()->findAll('created_by = '.Yii::app()->user->id);
        $helpdesk_group_LIST = array();
        foreach ($helpDeskGroup as $key => $value) {
            $helpdesk_group_LIST[$value['id']] = $value['name'];
        }

        if ($helpDeskGroupId == NULL) {
            $helpdesk_group_LIST=array(""=>'Help Desk Group')+$helpdesk_group_LIST;
            return $helpdesk_group_LIST;
        } else {
            if ($helpDeskGroupId != 1) {
                return $helpdesk_group_LIST[$helpDeskGroupId];
            }
        }
    }
	
	 /**
     * Returns the all records 
      * @return HelpDeskGroup the static model class
     */
	public function getAllHelpDeskGroup() {
            
            $session = new CHttpSession;

           $role = $session['role'];
            $roles = HelpdeskGroupUserRole::model()->findAllByAttributes(array('role' => $role));
            $heldeskGroups = array();
            foreach ($roles as $role) {
                if (!in_array($role->helpdesk_group, $heldeskGroups))
                    array_push($heldeskGroups, $role->helpdesk_group);
            }

            if(isset($session['account']) && !empty($session['account'])) {
                $account = $session['account'];
                $preregistrations = HelpdeskGroupWebPreregistration::model()->findAllByAttributes(array('web_preregistration' => $account));
                foreach ($preregistrations as $preregistration) {
                    if (!in_array($preregistration->helpdesk_group, $heldeskGroups))
                        array_push($heldeskGroups, $preregistration->helpdesk_group);
                }
            }

            $criteria = new CDbCriteria();
            $criteria->order = 'order_by ASC';
            $criteria->addInCondition('id', $heldeskGroups);
            
            if(!empty($session['created_by'])){
                $criteria->addCondition ('created_by = '.$session['created_by']);
            }else{
                $criteria->addCondition ('created_by = '.Yii::app()->user->id);
            }
            

            $helpDeskGroup = $this->findAll($criteria);
            return $helpDeskGroup;
    }
	
	 /**
     * Returns the name of group.
     * @param int $id of the record you want to retrieve name.
     */
	public function getHelpDeskGroupName($id) {
       $helpDeskGroup = $this->findByPk($id);

		return $helpDeskGroup->name;
    }

    /**
     * Retrieves a list of roles id of current help desk group
     */
    public function getActiveRoleIds($id)
    {
        $result= array();
        $roles = HelpdeskGroupUserRole::model()->findAllByAttributes(array('helpdesk_group' => $id));
        foreach ($roles as $role) {
            array_push($result, $role->role);
        }
        return $result;
    }

    /**
     * Retrieves a list of web preregistration of current help desk group
     */
    public function getActiveWebPreregistrations($id)
    {
        $result= array();
        $preregistrations = HelpdeskGroupWebPreregistration::model()->findAllByAttributes(array('helpdesk_group' => $id));
        foreach ($preregistrations as $preregistration) {
            array_push($result, $preregistration->web_preregistration);
        }
        return $result;
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }
	

}
