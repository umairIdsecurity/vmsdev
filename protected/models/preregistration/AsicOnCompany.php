<?php
Yii::import('ext.validator.CompanyNumber');
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
 * @property integer $company_type
 *
 * The followings are the available model relations:
 * @property User $createdByUser
 * @property User[] $users
 */
class AsicOnCompany extends CActiveRecord {

    public $isTenant;
	public $userRole;
	public $user_first_name;
	public $user_last_name;
	public $user_email;
	public $user_contact_number;
    public $is_user_field;
    public $user_password;
    public $password_requirement;
    public $user_repeatpassword;
    public $password_option;
    public $company_type;
	public $contact;
	public $asiccheck;
	public $company_radio;
	public $authorised_file;
    protected $tenantQuery = "SELECT COUNT(c.id) FROM user u LEFT JOIN company c ON u.company=c.id WHERE u.id=c.tenant AND c.id !=1";

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
		if(Yii::app()->controller->action->id!='asicOperationalNeed' && Yii::app()->controller->action->id!='addCompanyContact')
		{
		return array(
	         array('name,office_number', 'required','message'=>'Please complete {attribute}'),
                 array("name", "check_unique_name", 'name'=>$this->name, 'except'=>array("company_contact_update","addCompany_log")),
                 array('user_first_name , user_last_name , user_email , user_contact_number', 'required' , 'on' => 'company_contact_update','message'=>'Please complete {attribute}'),      
                //array('user_first_name , user_last_name , user_email , user_contact_number', 'required' , 'on' => 'preregistration'),
                array('user_first_name','required','message'=>'Please complete First Name'),
                array('user_last_name','required','message'=>'Please complete Last Name'),
                array('user_email','required','message'=>'Please complete Email Address'),
                array('user_contact_number','required','message'=>'Please complete Contact Number'),
                 
                //array("email_address", "unique", 'except'=>array("company_contact_update"), 'message'=>"Email already exist."),
                array("user_email","unique_name",'user_email'=>$this->user_email),
                   
	            array('website', 'url'),
	           
	            array('name, trading_name, billing_address', 'length', 'max' => 150),
	            array('email_address, website', 'length', 'max' => 50),
	            array('contact', 'length', 'max' => 100),
	            array('tenant', 'length', 'max' => 100),
	            array('logo,is_deleted,company_laf_preferences ,is_user_field, company_type', 'safe'),

                    // Senario for Add Tenant
                  
                    
	            array('tenant, tenant_agent,logo,card_count', 'default', 'setOnEmpty' => true, 'value' => null),
	            // The following rule is used by search().
	            // @todo Please remove those attributes that should not be searched.
	            array('id,isTenant,card_count, name,code,company_laf_preferences, trading_name, logo,tenant, contact, billing_address, email_address, office_number, mobile_number, website, created_by_user, created_by_visitor', 'safe', 'on' => 'search'),
	        );
		}
		if (Yii::app()->controller->action->id=='asicOperationalNeed')
		{	return array(
	
			array('name,contact,company_radio,street_number,street_name,street_type,suburb,post_code,country,state', 'required','message'=>'Please complete {attribute}'),
			array('office_number','ext.validator.CompanyNumber'),
			array('authorised_file', 'ext.validator.fileUploadErrorValidator'),
			
			);
		}
		if(Yii::app()->controller->action->id=='addCompanyContact')
		{
			return array(
	         array('name', 'required','message'=>'Please complete {attribute}'),
                 //array("name", "check_unique_name", 'name'=>$this->name, 'except'=>array("company_contact_update","addCompany_log")),
                 //array('user_first_name , user_last_name , user_email , user_contact_number', 'required' , 'on' => 'company_contact_update','message'=>'Please complete {attribute}'),      
                //array('user_first_name , user_last_name , user_email , user_contact_number', 'required' , 'on' => 'preregistration'),
                array('user_first_name','required','message'=>'Please complete First Name'),
                array('user_last_name','required','message'=>'Please complete Last Name'),
                array('user_email','required','message'=>'Please complete Email Address'),
                array('user_contact_number','required','message'=>'Please complete Contact Number'),
                 
                //array("email_address", "unique", 'except'=>array("company_contact_update"), 'message'=>"Email already exist."),
                array("user_email","unique_name",'user_email'=>$this->user_email),
                   
	          //  array('website', 'url'),
	           
	            array('name, trading_name, billing_address', 'length', 'max' => 150),
	            array('email_address, website', 'length', 'max' => 50),
	            array('contact', 'length', 'max' => 100),
	            array('tenant', 'length', 'max' => 100),
	            array('logo,is_deleted,company_laf_preferences ,is_user_field, company_type', 'safe'),

                    // Senario for Add Tenant
                  
                    
	            array('tenant, tenant_agent,logo,card_count', 'default', 'setOnEmpty' => true, 'value' => null),
	            // The following rule is used by search().
	            // @todo Please remove those attributes that should not be searched.
	            array('id,isTenant,card_count, name,code,company_laf_preferences, trading_name, logo,tenant, contact, billing_address, email_address, office_number, mobile_number, website, created_by_user, created_by_visitor', 'safe', 'on' => 'search'),
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
            'tenant_agent' => array(self::HAS_MANY, 'TenantAgent', 'id'),
            'tenant' => array(self::HAS_ONE, 'Tenant', 'id'),
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
            'user_first_name' => 'User First Name',
            'user_last_name' => 'User Last Name',
            'user_email' => 'User Email',
            'user_contact_number' => 'User Contact Number',
            'company_type' => 'Company Type',
			'asiccheck' => 'Add Asic Sponsor As Company Contact'
        );
    }
    
    //** Company name should be unique
    public function check_unique_name($attribute, $params) {
        $session = new CHttpSession();
        $tenant = (isset($session['tenant']) && $session['tenant'] != "") ? $session['tenant'] : "NULL";
        $model = Company::model()->find("id = '".$this->name."' AND tenant = ".$tenant." AND company_type=3");
        if( $model )
            $this->addError($attribute, 'Company name '.$this->name.' has already been taken.');
    }
	public function unique_name($attribute, $params) {
        $session = new CHttpSession();
        $tenant = (isset($session['tenant']) && $session['tenant'] != "") ? $session['tenant'] : "NULL";
        $model = User::model()->find("company = '".$this->name."' AND tenant = ".$tenant." AND email='".$this->user_email."'");
        if( $model )
            $this->addError($attribute, 'The user email '.$this->user_email.' has already been taken.');
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
//        $post_count_sql = "( " . $this->tenantQuery . " AND c.id=t.id)";
//
//        // select
//        $criteria->select = array(
//            '*',
//            $post_count_sql . " as isTenant",
//        );

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
        $criteria->compare('t.is_deleted', $this->is_deleted);
        $criteria->compare('code', $this->code);
        $criteria->compare('company_laf_preferences', $this->company_laf_preferences);
        $criteria->compare('card_count', $this->card_count);
        $criteria->compare('company_type', $this->company_type);

        if($_SESSION['role'] != Roles::ROLE_SUPERADMIN) {
            $criteria->compare('tenant', $_SESSION["tenant"]);
        }
        //$criteria->compare($post_count_sql, $this->isTenant);

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

            //return $photo->relative_path;
            return $photo->db_image;
        }
    }

    public function getPhotoRelativePath($photoId) {
        if ($photoId != '') {
            $photo = Photo::model()->findByPK($photoId);
            //return $photo->relative_path;
            return $photo->db_image;
        }
    }

    public function getCompanyName($companyId) {
        if ($companyId != '') {
            $this->detachBehavior('softDelete');
            $company = $this->findByAttributes(['is_deleted' => 0, 'id' => $companyId]);
            if ($company) {
                return $company->name;
            } else {
                return '-';
            }
        }
    }

    public function behaviors() {
        return array(
            'softDelete' => array(
                'class' => 'ext.soft_delete.SoftDeleteBehavior'
            ),

            'AuditTrailBehaviors' => 'application.components.behaviors.AuditTrailBehaviors',
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
        $Criteria->condition = "company = " . $companyId . " and id=" . $user->id . "";
        $users = User::model()->findAll($Criteria);

        //$users = array_filter($users);
        if (empty($users)) {
            return false;
        } else {
            return true;
        }
    }

    public function isUserAllowedToViewTenant($tenantId, $user) {

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = " . $tenantId . " and id=" . $user->id . "";
        $users = User::model()->findAll($Criteria);

        if (empty($users)) {
            return false;
        } else {
            if(Yii::app()->controller->id == "tenant" && Yii::app()->controller->action->id=="edit")
            {
                $tenant = Tenant::model()->with("user0")->find("t.id = ".$tenantId . " AND user0.id = ".$user->id);
                // $tenant = User::model()->with("tenant0")->find("t.id = ".$user->id . " AND tenant0.id = ".$tenantId);
                if (empty($tenant)) {
                    return false;
                } else {
                    return true;
                }
            }
            return true;
        }
    }

       public function isCompanyUniqueWithinTheTenant($companyName, $tenant) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "name = '" . $companyName . "' and tenant=" . $tenant . " AND company_type=3";
        $company = Company::model()->findAll($Criteria);

        $company = array_filter($company);
        return count($company);
    }

    public function isCompanyCodeUniqueWithinTheTenant($companyCode, $tenant) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "code = '" . $companyCode . "' and tenant=" . $tenant . "  AND company_type=3";
        $company = Company::model()->findAll($Criteria);

        $company = array_filter($company);
        return count($company);
    }

	public function isWithoutCompanyCodeUniqueWithinTheTenant($tenant) {
        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant=" . $tenant . "  AND company_type=3";
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
                    ->where("id != 1 and tenant=" . Yii::app()->user->tenant . " AND is_deleted = 0 AND id != ".Yii::app()->user->tenant )
                    ->queryAll();
        } else {
            $company = Yii::app()->db->createCommand()
                    ->selectdistinct('*')
                    ->from('company')
                    ->where('id != 1 AND is_deleted = 0')
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

    public function findAllTenantCompanies(){
        $aArray = array();
        if (Yii::app()->user->role != Roles::ROLE_SUPERADMIN) {
            $company = Yii::app()->db->createCommand()
                ->selectdistinct('*')
                ->from('company')
                ->where("id != 1 and (id=".Yii::app()->user->tenant." or tenant=" . Yii::app()->user->tenant . ") AND is_deleted = 0 " )
                ->queryAll();
        } else {
            $company = Yii::app()->db->createCommand()
                ->selectdistinct('*')
                ->from('company')
                ->where('id != 1 AND is_deleted = 0')
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
        $session = new CHttpSession;

        $Criteria = new CDbCriteria();
        $Criteria->condition = "tenant = " . $session['id'] . "";
        $company = Company::model()->findAll($Criteria);

        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;
    }

    public function findAllTenantAgents()
    {
        $company = Yii::app()->db->createCommand()
            ->selectdistinct('id,name,tenant')
            ->from('company')
            ->where("id != 1 and company_type = 2 AND is_deleted = 0")
            ->queryAll();
    }

    public function findAllTenants()
    {
        $aArray = array();

        $company = Yii::app()->db->createCommand()
            ->selectdistinct('*')
            ->from('company')
            ->where("id != 1 and company_type = 1 AND is_deleted = 0")
            ->order("name")
            ->queryAll();


        foreach ($company as $index => $value) {
            $aArray[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
            );
        }

        return $aArray;

    }

    public function findAtLeast1Tenant(){

        $aArray = array();

        $company = Yii::app()->db->createCommand()
            ->selectdistinct('*')
            ->from('company')
            ->where("id != 1 and company_type = 1 AND is_deleted = 0")
            ->order("name")
            ->queryAll();

        if($company == null || sizeof($company)==0){
            $company = Yii::app()->db->createCommand()
                ->selectdistinct('*')
                ->from('company')
                ->where("company_type = 1 AND is_deleted = 0")
                ->order("name")
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

    public static function findAllTenantsAndImages(){

        $aArray = array();

        $tenants = Yii::app()->db->createCommand()
            ->selectdistinct('company.id as id, company.name as name, db_image,filename')
            ->from('company')
            ->leftjoin('photo','company.logo = photo.id')
            ->where("company.id != 1 and company.company_type = 1 AND company.is_deleted = 0")
            ->order("company.name")
            ->queryAll();

      foreach($tenants as &$tenant){
          $tenant['db_image'] = "data:image/".pathinfo($tenant['filename'], PATHINFO_EXTENSION).";base64,".$tenant['db_image'];
      }
      return $tenants;
    }

    public function findTenantIdByCode($code){
        $company = Company::model()->find("code='$code' and company_type=1 and is_deleted=0");
        return isset($company['id'])?$company['id']:null;
    }

    public function getCurrentTenantName(){
        $session = new CHttpSession();
        if(isset($session['tenant'])){
            $company = Company::model()->find("id=".$session['tenant']." and company_type=1 and is_deleted=0");
            return isset($company['name'])?$company['name']:null;
        }
        return "The Airport";
    }

    public function getCurrentTenantImageSource(){

        $session = new CHttpSession();

        $tenant = Yii::app()->db->createCommand()
            ->selectdistinct('filename, db_image')
            ->from('company')
            ->leftjoin('photo','company.logo = photo.id')
            ->where("company.id = ".$session['tenant']." and company.company_type = 1 AND company.is_deleted = 0")
            ->queryAll();

        return "data:image/".pathinfo($tenant[0]['filename'], PATHINFO_EXTENSION).";base64,".$tenant[0]['db_image'];

    }


    public function getModelName()
    {
        return __CLASS__;
    }


}
