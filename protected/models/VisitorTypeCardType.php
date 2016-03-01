<?php

/**
 * This is the model class for table "tenant_contact".
 *
 * The followings are the available columns in table 'tenant_contact':
 * @property int $visit_type
 * @property int $card_type
 * @property int $tenant
 * @property int $tenant_agent
 *
 * The followings are the available model relations:
 * @property $visit_type0
 * @property $card_type0
 * @property $tenant0
 */
class VisitorTypeCardType extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'visitor_type_card_type';
    }

    public function primaryKey(){
        return array('visitor_type', 'card_type');
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('visitor_type, card_type', 'required', 'message'=>'Please complete {attribute}'),
            array('visitor_type, card_type, tenant', 'safe', 'on'=>'search'),
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
            'card_type0' => array(self::HAS_ONE, 'CardType', 'card_type'),
            'visitor_type0'=> array(self::HAS_ONE, 'VisitorType', 'visitor_type'),
            'tenant0'=> array(self::HAS_ONE, 'Tenant', 'tenant'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'visitor_type' => 'Visitor Type',
            'card_type' => 'Card Type',
            'tenant' => 'Tenant',
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
        $criteria->compare('visitor_type',$this->visit_type,true);
        $criteria->compare('card_type',$this->card_type,true);
        $criteria->compare('tenant',$this->tenant,true);
        $criteria->compare('tenant_agent',$this->tenant_agent,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TenantContact the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function beforeDelete() {
        $this->is_deleted = 1;
        $this->save();

        //prevent real deletion
        return false;
        //return true;
    }

}
