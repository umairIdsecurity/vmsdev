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
    private $_identity;
    
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
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
            $this->_identity = new UserIdentity($this->username, $this->password);
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
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
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
            $date_db = $user->induction_expiry;
            $current_date=date("Y-m-d");
            $validateNotifiSend2Weeks = Notification::model()->with('user_notification')->find("user_id=".$user->id." and subject='Login Expire in 2 weeks'");
            $validateNotifiSend1Day = Notification::model()->with('user_notification')->find("user_id=".$user->id." and subject='Login Expire in 1 day'");
            if(empty($validateNotifiSend2Weeks)){
                //2 weeks or 14 days prior to expiry date from today date
                if (strtotime($date_db) <= strtotime($current_date) + 86400*14 && strtotime($date_db) > strtotime($current_date) + 86400*13) {
                    $model=new Notification;
                    $model->created_by = Yii::app()->user->tenant;
                    $model->date_created = date("Y-m-d");
                    $model->subject = "Login Expire in 2 weeks";
                    $model->message = "Your login will expire after two weeks from today.";
                    $model->role_id = $user->role;
                    $model->notification_type = "Login Notifcation";

                    if($model->save()){
                        $notify = new UserNotification;
                        $notify->user_id = $user->id;
                        $notify->notification_id = $model->id;
                        $notify->has_read = 0; //Not Yet
                        $notify->save();
                    }
                }
            }
            
            if(empty($validateNotifiSend1Day)){
                //1 day prior to expiry date from today date
                if (strtotime($date_db) <= strtotime($current_date) + 86400*1) {
                    $model=new Notification;
                    $model->created_by = Yii::app()->user->tenant;
                    $model->date_created = date("Y-m-d");
                    $model->notification_type = "Login Notifcation";
                    $model->message = "Your login will expire after 1 day from today.";
                    $model->role_id = $user->role;
                    $model->subject = "Login Expire in 1 day";

                    if($model->save()){
                        $notify = new UserNotification;
                        $notify->user_id = $user->id;
                        $notify->notification_id = $model->id;
                        $notify->has_read = 0; //Not Yet
                        $notify->save();
                    }
                }
            }    
           
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
