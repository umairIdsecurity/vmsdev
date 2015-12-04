<?php

require_once('mandril/src/Mandrill.php');

class EmailTransport
{

    // function to adapt legacy mail function to YiiMail
    public static function mail($to,$subject,$body,$headers){

        // parse the headers
        $parts = EmailTransport::extractHeaders($headers);

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
            $mandrill = new Mandrill(Yii::app()->params['mandrillApiKey']);
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