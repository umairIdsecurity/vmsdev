<?php

/**
 * This is the model class for table "visitor_password_change_request".
 *
 * @author Yuri Vodolazsky
 */
class PreregPasswordChangeRequest extends CActiveRecord
{
    const IS_USED_YES = 'YES';
    const IS_USED_NO = 'NO';

    const ALLOWED_GENERATION_INTERVAL = 24; // in hours
    const NUMBER_OF_ATTEMPTS = 3; // during allowed generation interval

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'visitor_password_change_request';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PasswordChangeRequest the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Generate reset password record
     *
     * @param visitor $visitor
     * @return string
     * @throws Exception
     * @throws Mandrill_Error
     */
    public function generateResetLink(Registration $visitor)
    {
        $generatedRequestsCount = $this->count($this->getAlreadyGeneratedUnexpiredUnusedCriteria($visitor));

        if ($generatedRequestsCount >= self::NUMBER_OF_ATTEMPTS) {
            return "You have exceeded the maximum number of password recovery attempts";
        }

        $now = new DateTime;

        $request = new self();
        $request->visitor_id = $visitor->id;
        $request->hash = $this->getHash($visitor);
        $request->created_at = $now->format('Y-m-d H:i:s');
		if(isset(Yii::app()->user->tenant))
		{
		$airport = Company::model()->findByPk(Yii::app()->user->tenant);
		$airportName = (isset($airport->name) && ($airport->name!="")) ? $airport->name:"Airport";
		}
		else
		{
			$airportName="Airport";
		}
        $result = $request->save();
	
        if (!$result) {
        return "Service is temporary unavailable, please try again later";
		 }
		
        $templateParams = array(
            'email' => $visitor->email,
            'resetLink' => 'vmsprdev-win.identitysecurity.info/index.php/preregistration/reset/hash/' . $request->hash,
			'Airport'=>$airportName,
			'name'=>  ucfirst($visitor->first_name) . ' ' . ucfirst($visitor->last_name),
        );
		$subject='Invitation to Create Password for'.' '.$airportName.' '.'Aviation Visitor Management System';
        //TODO: Change to YiiMail
        $emailTransport = new EmailTransport();
        $emailTransport->sendSetPasswordEmail($templateParams, $visitor->email, $visitor->first_name . ' ' . $visitor->last_name,$subject);
    }

    /**
     * @param visitor $visitor
     * @return string
     */
    public function getHash(Registration $visitor)
    {
        return md5(time() . $visitor->id . $visitor->email . 'Some salt 9ht3ldjnhuy)jnt47thlJ&');
    }

    /**
     * @param visitor $visitor
     * @return CDbCriteria
     */
    public function getAlreadyGeneratedUnexpiredUnusedCriteria(Registration $visitor)
    {
        $date = $this->getStartOfExpiredPeriod();

        $criteria = new CDbCriteria();
        $criteria->condition = "visitor_id = :visitorId and is_used = :isUsed and created_at >= :createdAt";
        $criteria->params = array(
            'visitorId' => $visitor->id,
            'isUsed' => self::IS_USED_NO,
            'createdAt' => $date,
        );

        return $criteria;
    }

    /**
     * Rest password by hash generated early
     *
     * @return string
     */
    public function checkPasswordRequestByHash()
    {
        if ($this->isExpired()>60) {
            return "Your reset password link is already expired. Please generate it again.";
        }

        if ($this->isUsed()) {
            return "Your reset password link is already used. Please generate it again.";
        }
    }

    public function isExpired()
    {
      
		$now=new DateTime();
        $expiredDate = strtotime($now->format('Y-m-d H:i:s'));
        $requestDate = strtotime($this->created_at);
		$diff=round(abs($expiredDate - $requestDate)/60,0);
		return $diff;	  
	}

    public function isUsed()
    {
        return $this->is_used == self::IS_USED_YES;
    }

    /**
     * @param bool $asString
     * @return string
     */
    public function getStartOfExpiredPeriod($asString = true)
    {
        $date = new DateTime();
        $date->modify('- ' . self::ALLOWED_GENERATION_INTERVAL . 'hours');
        return $asString ? $date->format('Y-m-d H:i:s') : $date;
    }

    public function markAsUsed(Registration $visitor)
    {
        $this->is_used = self::IS_USED_YES;
        $this->save(false, 'is_used');

        /*$to = $visitor->email;
        $loggedUserEmail = "admin@identitysecurity.com";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ".$loggedUserEmail."\r\nReply-To: ".$loggedUserEmail;
        $subject="Reset password confirmation";
        $body = "<html><body>Hi,<br><br>".
                "Your password was reset using the email address ".$visitor->email.".<br>";
                "If you did this, you can safely disregard this email.";
                "If you didn't do this, please contact our technical support.";
        $body .="<br><br>"."Thanks,"."<br>Admin</body></html>";
        EmailTransport::mail($to, $subject, $body, $headers);*/
		

        $templateParams = array(
            'email' => $visitor->email,
        );
		


        $emailTransport = new EmailTransport();
        $emailTransport->sendResetPasswordConfirmationEmail(
            $templateParams, $visitor->email, $visitor->first_name . ' ' . $visitor->last_name
        );
    }

    public function behaviors()
    {
        return array(
            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

}
