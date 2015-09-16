<?php

/**
 * This is the model class for table "helpdesk".
 *
 * The followings are the available columns in table 'helpdesk':
 * @property integer $id
 * @property string $name
 * @property string $location
 * @property string $contact_name
 * @property integer $contact_number
 * @property string $contact_email_address
 * @property integer $number_of_operators
 * @property integer $assign_kiosk
 * @property string $password
 * @property integer $created_by
 * @property string $helpdesk_group
 * @property string $helpdesk_group_agent
 * @property integer $is_deleted
 *
 * The followings are the available model relations:
 * @property UserHelpDesk[] $userHelpDesks
 * @property User $createdBy
 */
class HelpDesk extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'helpdesk';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question,answer', 'required','message' =>'Please complete {attribute}'),
            array('helpdesk_group_id','required','message' =>'Please complete {attribute}'),
            array('question, answer,helpdesk_group_id,created_by,order_by', 'length'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, question, answer, helpdesk_group_id, created_by, is_deleted,order_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'helpdeskGroup' => array(self::HAS_MANY, 'Helpdesk_group', 'helpdesk_group_id'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'question' => 'Help Desk Question',
            'answer' => 'Help Desk Answer',
			'order_by' => 'Sort Order',
            'created_by' => 'Created By',
            'helpdesk_group_id' => 'Help Desk Group',
            'is_deleted' => 'Is Deleted',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('question', $this->question, true);
        $criteria->compare('answer', $this->answer, true);
        $criteria->compare('helpdesk_group_id', $this->helpdesk_group_id, true);
        $criteria->compare('created_by', $this->created_by);
	$criteria->compare('order_by', $this->order_by, true);
        $criteria->compare('is_deleted', $this->is_deleted);
        
        $module = CHelper::get_allowed_module();        
        if( $module == "CVMS" )
           $criteria->addCondition ('helpdesk_group_id IN (4, 6)');
        if( $module == "AVMS" )
           $criteria->addCondition ('helpdesk_group_id IN (2, 5, 7)');
            
         $criteria->addCondition ('created_by = '.Yii::app()->user->id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ID DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HelpDesk the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getHelpDesks($userId, $helpdeskId) {

        $Criteria = new CDbCriteria();
        $Criteria->condition = "user = " . $userId . " and helpdesk=" . $helpdeskId . "";
        $userhelpdesks = UserHelpDesks::model()->findAll($Criteria);

        $userhelpdesks = array_filter($userhelpdesks);
        $helpdeskCount = count($userhelpdesks);

        if ($helpdeskCount != 0) {
            return "1";
        } else {
            return "0";
        }
    }
    
    public function beforeDelete() {
        //before delete check user helpdesk if has record
        $userHelpDesk = UserHelpDesks::model()->exists("helpdesk =".$this->id." ");
        $visit = Visit::model()->exists("helpdesk=".$this->id."");
        if ($userHelpDesk || $visit) {
            return false;
        } else {
            $this->is_deleted = 1;
            $this->save();
            echo "true";
            return false;
        }
    }

    /*public function beforeFind() {
        $criteria = new CDbCriteria;
        $criteria->condition = "t.is_deleted = 0";
        if (Yii::app()->user->role != Roles::ROLE_SUPERADMIN && isset(Yii::app()->user->helpdesk_group)) {
            $criteria->condition = "t.helpdesk_group ='" . Yii::app()->user->helpdesk_group . "' and t.is_deleted = 0";
        }
        $this->dbCriteria->mergeWith($criteria);
    }

    protected function afterValidate() {
       
    }*/

/**
     * retrieve all models for a particular group.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model of particular group
     */
    public function getHelpDeskByGroup($id) {
      $selectedHelpDesk = HelpDesk::model()->findAllByAttributes( array('helpdesk_group_id'=>$id),array('order' => 'order_by ASC'));
      return $selectedHelpDesk;
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

}
