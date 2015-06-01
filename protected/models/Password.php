<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property integer $contact_number
 * @property string $date_of_birth
 * @property integer $company
 * @property string $department
 * @property string $position
 * @property string $staff_id
 * @property string $notes
 * @property string $photo
 * @property string $password
 * @property integer $role
 * @property integer $user_type
 * @property integer $user_status
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 * @property Roles[] $roles
 * @property Password $createdBy
 * @property Password[] $users
 * @property Roles $role0
 * @property UserType $userType
 * @property UserStatus $userStatus
 * @property Company $company0
 * @property UserStatus[] $userStatuses
 * @property UserType[] $userTypes
 * @property Workstations[] $workstations
 */
class Password extends CActiveRecord {
    public $repeatpassword;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('password', 'length', 'max' => 150),
            array('password', 'required'),
            array('repeatpassword', 'required'),
            array('password', 'compare', 'compareAttribute' => 'repeatpassword'),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
        );
    }

    /**
     * @return array relational rules.
     */

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'password' => 'Password',
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
        $criteria->compare('password', $this->password, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Password the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->password = User::model()->hashPassword($this->password);
        return true;
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

}
