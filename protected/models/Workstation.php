<?php

/**
 * This is the model class for table "workstation".
 *
 * The followings are the available columns in table 'workstation':
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
 * @property string $tenant
 * @property string $tenant_agent
 * @property integer $is_deleted
 *
 * The followings are the available model relations:
 * @property UserWorkstation[] $userWorkstations
 * @property User $createdBy
 */
class Workstation extends CActiveRecord {

    public $card_type;

    public $moduleCorporate;

    public $moduleVic;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'workstation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('tenant','required','message' =>'Please select a {attribute}'),
            array('contact_number, card_type,moduleCorporate, moduleVic', 'safe'),
            array('contact_email_address', 'email'),
            array('number_of_operators, assign_kiosk', 'numerical', 'integerOnly' => true),
            array('name, contact_name,tenant,tenant_agent,created_by', 'length', 'max' => 50),
            array('location', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, location, contact_name, contact_number, contact_email_address, number_of_operators, assign_kiosk, created_by, tenant, tenant_agent, is_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userWorkstations' => array(self::HAS_MANY, 'UserWorkstation', 'workstation'),
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
            'location' => 'Location',
            'contact_name' => 'Contact Person Name',
            'contact_number' => 'Contact No.',
            'contact_email_address' => 'Contact Email Address',
            'number_of_operators' => 'Number Of Operators',
            'assign_kiosk' => 'Assign Kiosk',
            'created_by' => 'Created By',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('location', $this->location, true);
        $criteria->compare('moduleCorporate', $this->moduleCorporate, true);
        $criteria->compare('moduleVic', $this->moduleVic, true);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('contact_number', $this->contact_number);
        $criteria->compare('contact_email_address', $this->contact_email_address, true);
        $criteria->compare('number_of_operators', $this->number_of_operators);
        $criteria->compare('assign_kiosk', $this->assign_kiosk);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('is_deleted', $this->is_deleted);
        $user = User::model()->findByPK(Yii::app()->user->id);
        if ($user->role == Roles::ROLE_ADMIN) {

            $criteria->compare('tenant', $user->tenant);
        } else if ($user->role == Roles::ROLE_AGENT_ADMIN) {

            $criteria->compare('tenant', $user->tenant);
            $criteria->compare('tenant_agent', $user->tenant_agent);
        }
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
     * @return Workstation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getWorkstations($userId, $workstationId) {

        $Criteria = new CDbCriteria();
        $Criteria->condition = "user = '" . $userId . "' and workstation='" . $workstationId . "'";
        $userworkstations = UserWorkstations::model()->findAll($Criteria);

        $userworkstations = array_filter($userworkstations);
        $workstationCount = count($userworkstations);

        if ($workstationCount != 0) {
            return "1";
        } else {
            return "0";
        }
    }
    
    public function beforeDelete() {
        //before delete check user workstation if has record
        $userWorkstation = UserWorkstations::model()->exists('workstation ="'.$this->id.'" ');
        $visit = Visit::model()->exists('workstation="'.$this->id.'"');
        if ($userWorkstation || $visit) {
            return false;
        } else {
            $this->is_deleted = 1;
            $this->save();
            echo "true";
            return false;
        }
    }

    public function beforeFind() {
        $criteria = new CDbCriteria;
        $criteria->condition = "t.is_deleted = 0";
        if (Yii::app()->user->role != Roles::ROLE_SUPERADMIN) {
            $criteria->condition = "t.tenant ='" . Yii::app()->user->tenant . "' and t.is_deleted = 0";
        }
        $this->dbCriteria->mergeWith($criteria);
    }

    protected function afterValidate() {
        parent::afterValidate();
        if (!$this->hasErrors()) {
            if (Yii::app()->controller->action->id == 'create') {
                $this->password = User::model()->hashPassword($this->password);
            }
            //disable if action is update 
        }
    }

    public function getWorkstationName($id) {
        $workstations = Workstation::model()->findByPk($id);
        return $workstations->name;
    }

    public function findWorkstationAvailableForUser($userId) {

        $Criteria = new CDbCriteria();
        $Criteria->condition = "user = '$userId'";
        $userworkstations = UserWorkstations::model()->findAll($Criteria);

        $aArray = array();
        if (count($userworkstations) != 0) {
            foreach ($userworkstations as $index => $value) {

                $workstations = Workstation::model()->findByPk($value['workstation']);
                $aArray[] = array(
                    'id' => $workstations['id'],
                    'name' => $workstations['name'],
                );
            }
            return $aArray;
        } else {
            return false;
        }
    }


    /**
     * Return all corporate card types
     *
     * This function receives the param workstation_id and then find all
     * card type which are under corporate modules. Each card type is checked
     * whether is it associated with workstation or not. All the card types
     * will be displayed as checkbox. Only associated card type with workstation
     * will be assigned as checked in the among all the card types in corporate
     * module.
     *
     *
     * @param string $workstation_id
     *
     * @return string $cardArr
     *
     * */
    public function getCorporateCardType($workstation_id){

        $cards = CardType::model()->findAllByAttributes(
            array('module'=>1)
        );

        $cardArr = "";
        foreach($cards as $card){

            $ws_card = WorkstationCardType::model()->findByPk(
                array(
                    'workstation' => $workstation_id,
                    'card_type' => $card->id
                )
            );

            if(!empty($ws_card)){
                $cardArr .= CHtml::checkBox($card->id,true,array("value"=>$card->id , "class"=>"card_type_corporate"));
            }
            else{
                $cardArr .= CHtml::checkBox($card->id,false,array("value"=>$card->id , "class"=>"card_type_corporate"));
            }

        }

        return $cardArr;

    }

    public function getCorporateVic($workstation_id){

        $cards = CardType::model()->findAllByAttributes(
            array('module'=>2)
        );

        $cardArr = "";
        foreach($cards as $card){

            $ws_card = WorkstationCardType::model()->findByPk(
                array(
                    'workstation' => $workstation_id,
                    'card_type' => $card->id
                )
            );

            if(!empty($ws_card)){
                $cardArr .= CHtml::checkBox($card->id,true,array("value"=>$card->id , "class"=>"card_type_vic"));
            }
            else{
                $cardArr .= CHtml::checkBox($card->id,false,array("value"=>$card->id , "class"=>"card_type_vic"));
            }

        }

        return $cardArr;


    }




}
