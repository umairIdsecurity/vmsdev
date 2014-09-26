<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $id
 * @property string $name
 * @property string $trading_name
 * @property string $logo
 * @property string $contact
 * @property string $billing_address
 * @property string $email_address
 * @property integer $office_number
 * @property integer $mobile_number
 * @property string $website
 * @property integer $created_by_user
 * @property integer $created_by_visitor
 *
 * The followings are the available model relations:
 * @property User $createdByUser
 * @property User[] $users
 */
class Company extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('email_address', 'email'),
            array('website', 'url'),
            array('office_number, mobile_number, created_by_user, created_by_visitor', 'numerical', 'integerOnly' => true),
            array('name, trading_name, billing_address', 'length', 'max' => 150),
            array(' email_address, website', 'length', 'max' => 50),
            array('contact', 'length', 'max' => 100),
            array('tenant', 'length', 'max' => 100),
            array('logo,is_deleted', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, trading_name, logo,tenant, contact, billing_address, email_address, office_number, mobile_number, website, created_by_user, created_by_visitor', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'createdByUser' => array(self::BELONGS_TO, 'User', 'created_by_user'),
            'users' => array(self::HAS_MANY, 'User', 'company'),
            'photos' => array(self::HAS_MANY, 'Photo', 'logo'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Company Name',
            'trading_name' => 'Trading/Display Name',
            'logo' => 'Logo',
            'contact' => 'Company Contact Person',
            'billing_address' => 'Billing Address',
            'email_address' => 'Email Address',
            'office_number' => 'Office Number',
            'mobile_number' => 'Mobile Number',
            'website' => 'Website',
            'created_by_user' => 'Created By User',
            'created_by_visitor' => 'Created By Visitor',
            'tenant' => 'Tenant',
            'is_deleted' => 'Deleted',
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
        $criteria->compare('trading_name', $this->trading_name, true);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('contact', $this->contact, true);
        $criteria->compare('billing_address', $this->billing_address, true);
        $criteria->compare('email_address', $this->email_address, true);
        $criteria->compare('office_number', $this->office_number);
        $criteria->compare('mobile_number', $this->mobile_number);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('created_by_user', $this->created_by_user);
        $criteria->compare('created_by_visitor', $this->created_by_visitor);
        $criteria->compare('tenant', $this->tenant);
        $criteria->compare('is_deleted', $this->is_deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Company the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterSave() {
        /* if logged in is admin
         * set company tenant to tenant of admin
         */
        $session = new CHttpSession;
        if ($this->isNewRecord) {
            $lastInsertId = Yii::app()->db->getLastInsertID();
            //query if lastinsert record tenant=''
            $connection = Yii::app()->db;
            $command = $connection->createCommand('select id,tenant from company where id="' . $lastInsertId . '"');

            $row = $command->queryRow(); //executes the SQL statement and returns the first row of the result.
            foreach ($row as $key => $value) {
                $tenant = $row['tenant'];
                $companyId = $row['id'];
            }
            if ($tenant == '') {
                if ($session['role'] == Roles::ROLE_ADMIN) {
                    $command = $connection->createCommand('update company set tenant =' . $session['tenant'] . ' where id=' . $companyId . '');
                    $command->query();
                }
            }
        }
    }

    public function getCompanyLogo($id) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT photo.`relative_path` FROM company
                            LEFT JOIN photo ON photo.id = company.`logo`
                            where company.id="'.$id.'"');

        $row = $command->queryRow();
        return $row['relative_path'];
    }
    
    public function getCompanyName($id) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("SELECT name from company where id='".$id."'");

        $row = $command->queryRow();
        return $row['name'];
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
            if ($this->logo =='') {
                $this->logo = NULL;
            }
        }
    }

}
