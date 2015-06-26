<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/9/15
 * Time: 2:19 AM
 */

class PreregUserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user using the User data model.
     * @return boolean whether authentication succeeds.
     */

    public function authenticate() {
        $user = Registration::model()->find('LOWER(email)=?', array(strtolower($this->username)));
        if ($user === null) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } else if (!$user->validatePassword($this->password, $user->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->id;
            $this->setState('email', $user->email);
            $this->setState('role', $user->role);
            $this->setState('account', $user->profile_type);

            $this->errorCode = self::ERROR_NONE;
        }

        return $this->errorCode == self::ERROR_NONE;
    }


    public function getId()
    {
        return $this->_id;
    }

}