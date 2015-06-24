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

    public $isTenant;
	public $userRole;
	public $user_first_name;
	public $user_last_name;
	public $user_email;
	public $user_contact_number;
    public $is_user_field;


    protected $tenantQuery = "SELECT COUNT(c.id)
FROM user u
LEFT JOIN company c ON u.company=c.id
WHERE u.id=c.tenant AND c.id !=1";

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'company';
    }

    public function getIsTenant() {
        // return private attribute on search
        if ($this->scenario == 'search') {
            return $this->_isTenant;
        }
    }

    public function setIsTenant($value) {
        // set private attribute for search
        $this->_isTenant = $value;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
		echo $this->userRole;
		if($this->userRole == 1){
			return array(
	            array('name', 'required'),
	            array('user_first_name , user_last_name , user_email , user_contact_number', 'required' , 'on' => 'company_contact'),
				array('name , code , email_address , mobile_number', 'required' , 'on' => 'updatetenant'),
                array('mobile_number', 'numerical', 'integerOnly' => true, 'on' => 'updatetenant'),
                array('code', 'match',
                    'pattern' => '/^[a-zA-Z\s]+$/',
                    'message' => 'Code can only contain letters' ,'on' => 'updatetenant'),
	            array('code', 'length', 'min' => 3, 'max' => 3, 'tooShort' => 'Code is too short (Should be in 3 characters)'),
	            array('email_address', 'email'),
	            array('website', 'url'),
	            array('office_number, mobile_number, created_by_user, created_by_visitor', 'numerical', 'integerOnly' => true),
	            array('name, trading_name, billing_address', 'length', 'max' => 150),
	            array('email_address, website', 'length', 'max' => 50),
	            array('contact', 'length', 'max' => 100),
	            array('tenant', 'length', 'max' => 100),
	            array('logo,is_deleted,company_laf_preferences ,is_user_field', 'safe'),
	            array('tenant, tenant_agent,logo,card_count', 'default', 'setOnEmpty' => true, 'value' => null),
	            // The following rule is used by search().
	            // @todo Please remove those attributes that should not be searched.
	            array('id,isTenant,card_count, name,code,company_laf_preferences, trading_name, logo,tenant, contact, billing_address, email_address, office_number, mobile_number, website, created_by_user, created_by_visitor', 'safe', 'on' => 'search'),
	        );
		}
		else{
			return array(
                //array('code', 'safe' , 'on' => 'visit_reason'),
	            array('name', 'required'),

                array('code', 'required', 'except' => 'preregistration'),

                //array('user_first_name , user_last_name , user_email , user_contact_number', 'required' , 'on' => 'company_contact'),
	//            array('code', 'unique'),
	//            array('code', 'unique', 'criteria' => array(
	//                    'condition' => 'tenant=:tenant',
	//                    'params' => array(
	//                        ':tenant' => Yii::app()->user->tenant
	//                    )
	//                )),
	
				array(' email_address , mobile_number', 'required' , 'on' => 'updatetenant'),
                array('mobile_number', 'numerical', 'integerOnly' => true, 'on' => 'updatetenant'),
				
	            array('code', 'length', 'min' => 3, 'max' => 3, 'tooShort' => 'Code is too short (Should be in 3 characters)'),
	            array('code', 'match',
	                'pattern' => '/^[a-zA-Z\s]+$/',
	                'message' => 'Code can only contain letters'),
	            array('email_address', 'email'),
	            array('website', 'url'),
	            array('office_number, mobile_number, created_by_user, created_by_visitor', 'numerical', 'integerOnly' => true),
	            array('name, trading_name, billing_address', 'length', 'max' => 150),
	            array('email_address, website', 'length', 'max' => 50),
	            array('contact', 'length', 'max' => 100),
	            array('tenant', 'length', 'max' => 100),
	            array('logo,is_deleted,company_laf_preferences', 'safe'),
	            array('tenant, tenant_agent,logo,card_count', 'default', 'setOnEmpty' => true, 'value' => null),
	            // The following rule is used by search().
	            // @todo Please remove those attributes that should not be searched.
	            array('id, isTenant,card_count, name,code,company_laf_preferences, trading_name, logo,tenant, contact, billing_address, email_address, office_number, mobile_number, website, created_by_user, created_by_visitor', 'safe', 'on' => 'search'),
	        );
		}
        
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
            'contacts' => array(self::HAS_MANY, 'Contact', 'company_id'),
            'ph' => array(self::BELONGS_TO, 'Photo', 'logo'),
            'companyPreference' => array(self::BELONGS_TO,'CompanyLafPreferences','company_laf_preferences'),
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
            'tenant_agent' => 'Tenant Agent',
            'is_deleted' => 'Deleted',
            'code' => 'Company Code',
            'card_count' => 'Card Count',
            'company_laf_preferences' => 'Look and Feel Preferences',
            'user_first_name' => 'First Name',
            'user_last_name' => 'Last Name',
            'user_email' => 'Email',
            'user_contact_number' => 'Contact Number'
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
        $post_count_sql = "( " . $this->tenantQuery . " AND c.id=t.id)";

        // select
        $criteria->select = array(
            '*',
            $post_count_sql . " as isTenant",
        );

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
        $criteria->compare('tenant_agent', $this->tenant_agent);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('code', $this->code);
        $criteria->compare('company_laf_preferences', $this->company_laf_preferences);
        $criteria->compare('card_count', $this->card_count);
        $criteria->compare($post_count_sql, $this->isTenant);

        $data = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'ID DESC',
            ),
        ));
        $data->setTotalItemCount(count($this->findAll($criteria)));

        return $data;
    }

    public function isTenant()
    {
        if (!$this->isNewRecord) {
            $sql = $this->tenantQuery . " AND c.id = " . $this->id;
        } else {
            $sql = $this->tenantQuery;
        }
        $result = $this->getCommandBuilder()->createSqlCommand($sql)->queryScalar();
        return (bool) $result;
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

    public function getCompanyLogo($companyId) {

        $company = Company::model()->findByPK($companyId);
        if ($company->logo != '') {
            $photo = Photo::model()->findByPK($company->logo);

            return $photo->relative_path;
        }
    }

    public function getPhotoRelativePath($photoId) {
        if ($photoId != '') {
            $photo = Photo::model()->findByPK($photoId);
            return $photo->relative_path;
        }
    }

    public function getCompanyName($companyId) {
        if ($companyId != '') {
            $company = Company::model()->findByPK($companyId);
            return $company->name;
        }
    }

    public function behaviors() {
        return array(
            'softDelete' => array(
                'class' => 'ext.soft_delete.SoftDeleteBehavior'
            ),

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

    protected function afterValidate() {
        parent::afterValidate();
        if (!$this->hasErrors()) {
            if ($this->logo == '') {
                $this->logo = NULL;
            }
        }
    }

    public function isUserAllowedToViewCompany($companyId, $user) {

        $Criteria = new CDbCriteria();
        $Criteria->condition = "company = '" . $companyId . "' and id='" . $user->id . "'";
        $users = User::model()->findAll($Criteria);

        //$users = array_filter($users);
        if (empty($users)) {
            return false;
        } else {
            return true;
        }
    }

    public function isCompanyUniqueWithinTheTenant($companyName, $tenant) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "name = '" . $companyName . "' and tenant='" . $tenant . "'";
        $company = Company::model()->findAll($Criteria);

        $company = array_filter($company);
        return count($company);
    }

    public function isCompanyCodeUniqueWithinTheTenant($companyCode, $tenant) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "code = '" . $companyCode . "' and tenant='" . $tenant . "'";
        $company = Company::model()->findAll($Criteria);

        $company = array_filter($company);
        return count($company);
    }
	
	public function isWithoutCompanyCodeUniqueWithinTheTenant($tenant) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant='" . $tenant . "'";
        $company = Company::model()->findAll($Criteria);

        $company = array_filter($company);
        return count($company);
    }

	
    public function findAllCompany() {
        $aArray = array();
        if (Yii::app()->user->role != Roles::ROLE_SUPERADMIN) {
            $company = Yii::app()->db->createCommand()
                    ->selectdistinct('*')
                    ->from('company')
                    ->where("id != 1 and tenant='" . Yii::app()->user->tenant . "'")
                    ->queryAll();
        } else {
            $company = Yii::app()->db->createCommand()
                    ->selectdistinct('*')
                    ->from('company')
                    ->where('id != 1')
                    ->queryAll();
        }

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;
    }

    public function findAllCompanyWithSameTenant($tenant) {
        $aArray = array();

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = '".$tenant."'";
        $company = Company::model()->findAll($Criteria);

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;
    }


}
