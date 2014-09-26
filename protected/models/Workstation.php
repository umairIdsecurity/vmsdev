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
            array('name,tenant', 'required'),
            array('contact_number', 'safe'),
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
            'contact_number' => 'Contact Number',
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
        $session = new CHttpSession;
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('location', $this->location, true);
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
        if ($session['role'] == Roles::ROLE_ADMIN) {

            $criteria->compare('tenant', $session['tenant']);
        } else if ($session['role'] == Roles::ROLE_AGENT_ADMIN) {

            $criteria->compare('tenant', $session['tenant']);
            $criteria->compare('tenant_agent', $session['tenant_agent']);
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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

    public function getWorkstations($userid, $workstationid) {

        $connection = Yii::app()->db;
        $sql = "select * from user_workstation where user='" . $userid . "' and workstation='" . $workstationid . "'";
        $command = $connection->createCommand($sql);
        $row = $command->queryRow();

        if (is_array($row)) {
            $res = array();
            foreach ($row as $key => $val) {
                $res[] = array('label' => $key, 'value' => $val);
            }
            $res = array_filter($res);

            if (!empty($res)) {

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function behaviors() {
        return array(
            'softDelete' => array(
                'class' => 'ext.soft_delete.SoftDeleteBehavior'
            ),
        );
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
        $connection = Yii::app()->db;
        $command = $connection->createCommand("SELECT name from workstation where id=$id");

        $row = $command->queryRow();
        return $row['name'];
    }

}
