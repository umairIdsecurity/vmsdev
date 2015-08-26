<?php

/**
 * This is the model class for table "helpdesk_group_web_preregistration".
 *
 * The followings are the available columns in table 'helpdesk_group_web_preregistration':
 * @property int $helpdesk_group
 * @property string $web_preregistration
 *
 * The followings are the available model relations:
 * @property $helpdesk_group0
 */
class HelpdeskGroupWebPreregistration extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'helpdesk_group_web_preregistration';
    }

    public function primaryKey(){
        return 'helpdesk_group';
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('helpdesk_group', 'required'),
            array('web_preregistration', 'length', 'max' => 20),
            array('helpdesk_group, web_preregistration', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'helpdesk_group' => 'Helpdesk Group',
            'web_preregistration' => 'AVMS Web Preregistration',
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
        $criteria->compare('web_preregistration',$this->web_preregistration,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HelpdeskGroupWebPreregistration the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}
