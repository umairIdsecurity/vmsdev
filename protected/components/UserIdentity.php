<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;

    public function authenticate() {
        
        $user = User::model()->find('LOWER(email)=?', array(strtolower($this->username)));
        
        if ($user === null) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } else if (!$user->validatePassword($this->password, $user->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->id;
            $this->setState('email', $user->email);
            $this->setState('role', $user->role);
            $this->setState('tenant', ( !is_null($user->tenant) )?$user->tenant:$user->id );
            $this->setState('allowed_module', ( !is_null($user->allowed_module)) ?$user->allowed_module:''  );
             
            if ($user->tenant_agent == '') {
                $this->setState('tenant_agent', '');
            } else {
                $this->setState('tenant_agent', $user->tenant_agent);
            }
            $session = new CHttpSession;
            $session->open();
            $session['id'] = $user->id;
            $session['role'] = $user->role;
            $session['company'] = $user->company;
            
            $session['tenant'] = $user->tenant;
            
            $session['tenant_agent'] = $user->tenant_agent;
            
            // Subscription Modules Allowed to view by a Tenant
            if( !is_null($user->allowed_module) )
                $session['module_allowed_to_view'] = USER::$allowed_module[$user->allowed_module];
            
            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }
 
}
