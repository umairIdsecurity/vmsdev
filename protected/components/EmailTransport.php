<?php

require_once('mandril/src/Mandrill.php');

class EmailTransport
{

    // function to adapt legacy mail function to YiiMail
    public static function mail($to,$subject,$body,$headers){

        // parse the headers
        $parts = EmailTransport::extractHeaders($headers);



        $message            = new YiiMailMessage;
        $message->subject   = $subject;
        $message->setBody($body, 'text/html');
        $message->addTo('geoff.stewart@idsecurity.com.au');

        // set from
        $message->from = 'vmsnotify@gmail.com';
        if(isset($parts['from'])){$message->from = $parts['from'];}

        Yii::app()->mail->send($message);

    }

    private static function extractHeaders($headers){
        $result = [];
        $rows = explode("\r\n",$headers);
        foreach($rows as $row){
            $parts = explode(":",$row);
            $result[trim($parts[0])] = trim($parts[1]);
        }
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