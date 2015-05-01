<?php

/**
 * This is the model class for table "user_workstations".
 *
 * The followings are the available columns in table 'user_workstations':
 * @property integer $id
 * @property integer $user
 * @property integer $workstation
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Workstations $workstation0
 * @property User $createdBy
 * @property User $user0
 */
class UserWorkstations extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_workstation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user, workstation', 'required'),
            array('user, workstation, created_by,is_primary', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user, workstation, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'workstation0' => array(self::BELONGS_TO, 'Workstations', 'workstation'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'user0' => array(self::BELONGS_TO, 'User', 'user'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user' => 'User',
            'workstation' => 'Workstation',
            'created_by' => 'Created By',
            'is_primary' => 'Is_Primary',
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
        $criteria->compare('user', $this->user);
        $criteria->compare('workstation', $this->workstation);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('is_primary', $this->is_primary);
        //$criteria->compare('created_by',$this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserWorkstations the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAllworkstations($userid) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "user = '$userid'";
        $userworkstations = UserWorkstations::model()->findAll($Criteria);

        if (count($userworkstations) != 0) {
            foreach ($userworkstations as $index => $value) {
                $Criteria = new CDbCriteria();
                $Criteria->condition = "id = '" . $value['workstation'] . "' and is_deleted=0";
                $workstation = Workstation::model()->findAll($Criteria);
                foreach ($workstation as $index => $value) {
                    echo $value['name'] . "<br>";
                }
            }
        } else {
            return $result = '-';
        }
    }

    public function getAllUserWorkstationsCanBeEditedBySuperAdmin($currentlyEditedUser, $currentSessionRole) {

        $user = User::model()->findByPk($currentlyEditedUser);
        $currentlyLoggedInUser = User::model()->findByPK(Yii::app()->user->id);
        switch ($currentSessionRole) {
            case Roles::ROLE_ADMIN:
                $queryCondition = "tenant='" . $currentlyLoggedInUser->tenant . "'";
                if ($user->role == Roles::ROLE_OPERATOR) {
                    $queryCondition = "tenant='" . $user->tenant . "' and tenant_agent IS NULL";
                } else {
                    $queryCondition = "tenant='" . $currentlyLoggedInUser->tenant . "'";
                }
                break;
            case Roles::ROLE_AGENT_ADMIN:
                $queryCondition = "tenant='" . $currentlyLoggedInUser->tenant . "' and tenant_agent ='" . $currentlyLoggedInUser->tenant_agent . "'";

                break;
            default:
                if ($user->role == Roles::ROLE_OPERATOR) {
                    $queryCondition = "tenant='" . $user->tenant . "' and tenant_agent IS NULL";
                } else {
                    $queryCondition = "tenant='" . $user->tenant . "' and tenant_agent ='" . $user->tenant_agent . "'";
                }
        }

        $Criteria = new CDbCriteria();
        $Criteria->condition = $queryCondition;
        $workstations = Workstation::model()->findAll($Criteria);

        return $workstations;
    }

    public function deleteAllUserWorkstationsWithSameUserId($userId) {

        UserWorkstations::model()->deleteAll(array(
            'condition' => "`user` = '$userId'",
        ));
    }

    public function checkIfWorkstationIsPrimaryOfUser($currentlyEditedUser, $workstationId) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "user = '$currentlyEditedUser' and workstation ='" . $workstationId . "'";
        $userworkstations = UserWorkstations::model()->findAll($Criteria);

        foreach ($userworkstations as $index => $value) {
            if ($value['is_primary'] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkIfWorkstationIsAssignedAsPrimary($workstationId) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "workstation ='" . $workstationId . "' and is_primary='1'";
        $userworkstations = UserWorkstations::model()->findAll($Criteria);

        if (count($userworkstations) != 0) {
            return true;
        } else {
            return false;
        }
    }

}
