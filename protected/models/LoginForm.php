<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    public $tenant;
    private $_identity;

    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password, tenant', 'required','message'=>'Please enter {attribute}'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me next time',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password,$this->tenant);
            if (!$this->_identity->authenticate())
                $this->addError('password', 'Incorrect username or password.');
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password,$this->tenant);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            $session = new CHttpSession();
            $session['tenant'] = Yii::app()->user->tenant;

            $this->audit_log_login(); //logs the login of the user
            return true;
        } else
            return false;
    }

    public function audit_log_login(){
        $log = new AuditLog();
        $log->action_datetime_new = date('Y-m-d H:i:s');
        $log->action = "LOGIN TO SYSTEM";
        $log->detail = 'ID: ' . Yii::app()->user->id;
        $log->user_email_address = Yii::app()->user->email;
        $log->ip_address = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") ? $_SERVER['REMOTE_ADDR'] : "UNKNOWN";
        $log->tenant = Yii::app()->user->tenant;
        $log->tenant_agent = Yii::app()->user->tenant_agent;
        $log->save();
    }

    public function findWorkstations($id) {
        
        $Criteria = new CDbCriteria();
        $Criteria->condition = "user_id = '$id'";
        $userworkstations = UserWorkstations::model()->findAll($Criteria);

        $aArray = array();
        if (count($userworkstations) != 0) {
            foreach ($userworkstations as $index => $value) {

                $workstations = Workstation::model()->findByPk($value['workstation']);
                $aArray[] = array(
                    'id' => $workstations['id'],
                    'name' => $workstations['name'],
                );
            }
            return true;
        } else {
            return false;
        }
    }
	
	/*
	*AUTH: DX_TAHIR
	*@param session id after authentication and validation
	*return true or false based on inductions Set previously 
	*while adding ROLE_OPERATOR, ROLE_AIRPORT_OPERATOR and ROLE_AGENT_AIRPORT_ADMIN	
	*/
	public function checkInductions($id) {

            $user = User::model()->findByPk($id);

            $returnData=array("role"=>$user->role,"success"=>true,"inducComplete"=>true);
            
            if($user->is_required_induction == 1){
                if($user->is_completed_induction == 1){
                        if(strtotime($user->induction_expiry) >= strtotime(date("Y-m-d"))){
                            $returnData["success"]=true;
                            return $returnData;
                        }else{
                            $returnData["success"]=false;
                            return $returnData;
                        }
                }else{
                    $returnData["inducComplete"]=false;
                    return $returnData;
                }
            }else{
                $returnData["success"]=true;
                return $returnData;
            }
        }
}
