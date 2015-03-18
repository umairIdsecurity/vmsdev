<?php

/**
 * This is the model class for table "card_generated".
 *
 * The followings are the available columns in table 'card_generated':
 * @property string $id
 * @property string $date_printed
 * @property string $date_expiration
 * @property string $card_image_generated_filename
 * @property string $visitor_id
 * @property string $created_by
 * @property string $tenant
 * @property string $tenant_agent
 *
 * The followings are the available model relations:
 * @property Visitor $visitor
 * @property Photo $cardImageGeneratedFilename
 * @property User $createdBy
 * @property User $tenant0
 * @property User $tenantAgent
 */
class CardGenerated extends CActiveRecord {

    public $max_card_count;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'card_generated';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('card_image_generated_filename, visitor_id, created_by, tenant, tenant_agent', 'length', 'max' => 20),
            array('company_code,card_count,print_count,card_status,date_printed,date_expiration', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,company_code,card_count,print_count, card_status,date_printed, date_expiration, card_image_generated_filename, visitor_id, created_by, tenant, tenant_agent', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'visitor' => array(self::BELONGS_TO, 'Visitor', 'visitor_id'),
            'cardImageGeneratedFilename' => array(self::BELONGS_TO, 'Photo', 'card_image_generated_filename'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'tenant0' => array(self::BELONGS_TO, 'User', 'tenant'),
            'tenantAgent' => array(self::BELONGS_TO, 'User', 'tenant_agent'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date_printed' => 'Date Printed',
            'date_expiration' => 'Date Expiration',
            'card_image_generated_filename' => 'Card Image Generated Filename',
            'visitor_id' => 'Visitor',
            'created_by' => 'Created By',
            'tenant' => 'Tenant',
            'tenant_agent' => 'Tenant Agent',
            'card_status' => 'Card Status',
            'company_code' => 'Company Code',
            'card_count' => 'Card Count',
            'print_count' => 'Print Count',
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
        $criteria->compare('date_printed', $this->date_printed, true);
        $criteria->compare('date_expiration', $this->date_expiration, true);
        $criteria->compare('card_image_generated_filename', $this->card_image_generated_filename, true);
        $criteria->compare('visitor_id', $this->visitor_id, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->compare('tenant', $this->tenant, true);
        $criteria->compare('tenant_agent', $this->tenant_agent, true);
        $criteria->compare('card_status', $this->card_status, true);
        $criteria->compare('company_code', $this->company_code, true);
        $criteria->compare('card_count', $this->card_count, true);
        $criteria->compare('print_count', $this->print_count, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CardGenerated the static model 
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCardCode($cardId, $visitId) {
        $session = new CHttpSession;
        $status = Visit::model()->findByPk($visitId)->visit_status;
        if ($cardId != '' && ($status == VisitStatus::ACTIVE || $status == VisitStatus::CLOSED)) {
            
            $tenant = User::model()->findByPk(Visit::model()->findByPk($visitId)->tenant);
            $tenantCompany = Company::model()->findByPk($tenant->company);
            $card_count = CardGenerated::model()->findByPk($cardId)->card_count;


            $inc = 6 - (strlen(($card_count)));
            $int_code = '';
            for ($x = 1; $x <= $inc; $x++) {

                $int_code .= "0";
            }

            return $tenantCompany->code . $int_code . ($card_count);
        } else {
            return "";
        }
    }

}
