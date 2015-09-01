<?php

/**
 * This is the model class for table "helpdesk_group_user_role".
 *
 * The followings are the available columns in table 'helpdesk_group_user_role':
 * @property int $helpdesk_group
 * @property int $role
 *
 * The followings are the available model relations:
 * @property $helpdesk_group0
 * @property $role0
 */
class HelpdeskGroupUserRole extends CActiveRecord
{
    const PROFILE_TYPE_CORPORATE = 'CORPORATE';
    const PROFILE_TYPE_VIC       = 'VIC';
    const PROFILE_TYPE_ASIC      = 'ASIC';

    public static $AVMS_ROLES = array(
        11  => 'Issuing Body Administrator',
        13  => 'Agent Airport Administrator',
        12  => 'Airport Operator',
    );

    public static $CVMS_ROLES = array(
        1  => 'Administrator',
        6  => 'Agent Administrator',
        8  => 'Operator',
        9  => 'Host / Staff',
    );

    public static $AVMS_WEB_PREREGISTRATION_ROLES = array(
        self::PROFILE_TYPE_VIC          => 'VIC Holder',
        self::PROFILE_TYPE_ASIC         => 'ASIC Sponsor',
        self::PROFILE_TYPE_CORPORATE    => 'Company',
    );
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'helpdesk_group_user_role';
    }

    public function primaryKey(){
        return array('helpdesk_group', 'role');
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('helpdesk_group, role', 'required'),
            array('helpdesk_group, role', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'helpdesk_group0' => array(self::HAS_ONE, 'HelpDeskGroup', 'helpdesk_group'),
            'role0' => array(self::HAS_ONE, 'Roles', 'role'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'helpdesk_group' => 'Helpdesk Group',
            'role' => 'Role',
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
    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('helpdesk_group',$this->helpdesk_group,true);
        $criteria->compare('role',$this->role,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HelpdeskGroupUserRole the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}
