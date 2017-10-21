<?php

require_once('mandril/src/Mandrill.php');

class EmailTransport
{

    // function to adapt legacy mail function to YiiMail
    public static function mail($to,$subject,$body,$headers){
				
        // parse the headers
        $parts = EmailTransport::extractHeaders($headers);
		//$errors=$visitor->getErrors();
				
        // create a message
        $message = new YiiMailMessage;

        // set the subject
        $message->subject = $subject;

        // get the content type
        $contentType = 'text/html';
        if(isset($parts['Content-type'])){$contentType = $parts['Content-type'];}

        // set the body
        $message->setBody($body, $contentType);

        // send to
        $message->addTo($to);
		
        // set from
        if(isset($parts['From'])){$message->from = $parts['From'];}
		
        return Yii::app()->mail->send($message);

    }

    private static function extractHeaders($headers){
        $result = [];
        $rows = explode("\r\n",$headers);
        foreach($rows as $row){
            $parts = explode(":",$row);
            if(sizeof($parts)<2) continue;
            $result[trim($parts[0])] = trim($parts[1]);
        }
        return $result;
    }


    public function sendEmail($templateName, $templateParams, $to)
    {
        $templateParams = $this->_convertToMandrillFormat($templateParams);

        try {
            $mandrill = new Mandrill('qFr4QNc7JIypUf3ty8qqMw');
            $message = array(
                'subject' => '',
                'to' => $to,
                'merge_language' => 'handlebars',
                'global_merge_vars' => $templateParams,
            );

            $async = true;
            $ip_pool = 'Main Pool';

            $result = $mandrill->messages->sendTemplate(
                $templateName,
                $templateParams,
                $message, $async, $ip_pool
            );
		
        } catch(Mandrill_Error $e) {
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			//echo "<pre>";
		//print_r($templateParams);
		//echo "<pre>";
		Yii::app()->end();

//            throw $e;
        }
    }
	  public function sendEmailUser($templateName, $templateParams,$to,$subject)
    {
        $templateParams = $this->_convertToMandrillFormat($templateParams);
		
        try {
            $mandrill = new Mandrill('qFr4QNc7JIypUf3ty8qqMw');
            $message = array(
                'subject' => $subject,
                'to' => $to,
                'merge_language' => 'handlebars',
                'global_merge_vars' => $templateParams,
            );

            $async = true;
            $ip_pool = 'Main Pool';

            $result = $mandrill->messages->sendTemplate(
                $templateName,
                $templateParams,
                $message, $async, $ip_pool
            );
		

        } catch(Mandrill_Error $e) {
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			Yii::app()->end();
//            throw $e;
        }
    }
	public function sendEmailUserAttach($templateName, $templateParams,$to,$subject,$attachments)
    {
        $templateParams = $this->_convertToMandrillFormat($templateParams);
		
        try {
            $mandrill = new Mandrill('qFr4QNc7JIypUf3ty8qqMw');
            $message = array(
                'subject' => $subject,
                'to' => $to,
                'merge_language' => 'handlebars',
                'global_merge_vars' => $templateParams,
				'attachments'=>array($attachments)
            );

            $async = true;
            $ip_pool = 'Main Pool';

            $result = $mandrill->messages->sendTemplate(
                $templateName,
                $templateParams,
                $message, $async, $ip_pool
            );
		

        } catch(Mandrill_Error $e) {
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			Yii::app()->end();
//            throw $e;
        }
    }
    public function sendResetPasswordEmail($params, $toEmail, $toName)
    {
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );

       $this->sendEmail('resetpassword', $params, $to);
		
		
    }
 public function sendSetPasswordEmail($params, $toEmail, $toName,$subject)
    {
		
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );
		
       $this->sendEmailUser('setpassword', $params, $to, $subject);
		
		
    }
	 public function sendAppointment($params, $toEmail, $toName,$subject)
    {
		
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );
		
       $this->sendEmailUser('appointment', $params, $to, $subject);
		
		
    }
	 public function sendSubmitted($params, $toEmail, $toName,$subject,$attachments)
    {
		
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );
		
       $this->sendEmailUserAttach('AsicAppSubmit', $params, $to, $subject,$attachments);
		
		
    }
	 public function sendLodged($params, $toEmail, $toName,$subject)
    {
		
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );
		
       $this->sendEmailUser('lodgedasic', $params, $to, $subject);
		
		
    }
	
	 public function sendApproved($params, $toEmail, $toName,$subject)
    {
		
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );
		
       $this->sendEmailUser('approvedasic', $params, $to, $subject);
		
		
    }
	 public function sendReady($params, $toEmail, $toName,$subject)
    {
		
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );
		
       $this->sendEmailUser('readycollect', $params, $to, $subject);
		
		
    }
    public function sendResetPasswordConfirmationEmail($params, $toEmail, $toName)
    {
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );
		
        $this->sendEmail('reset-password-confirmation', $params, $to);
    }
	 public function sendRegistration($params, $toEmail, $toName,$subject)
    {
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );

        $this->sendEmailUser('user-registration', $params, $to,$subject);
    }
	 public function sendAsicNotification($params, $toEmail, $toName,$subject)
    {
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );

        $this->sendEmailUser('user-notification2', $params, $to,$subject);
    }
	 public function sendNotification($params, $toEmail, $toName,$subject)
    {
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );

        $this->sendEmailUser('user-notification', $params, $to,$subject);
    }
 public function sendRegistrationUser($params, $toEmail, $toName,$subject)
    {
        $to = array(
            array(
                'email' => $toEmail,
                'name' => $toName,
                'type' => 'to'
            ),
        );

        $this->sendEmailUser('user-registration2', $params, $to,$subject);
    }

    protected function _convertToMandrillFormat(array $parameters)
    {
        $result = array();

        foreach ($parameters as $name => $value) {

            $parameter = array(
                'name' => $name,
                'content' => $value,
            );

            $result[] = $parameter;
        }

        return $result;
    }
}