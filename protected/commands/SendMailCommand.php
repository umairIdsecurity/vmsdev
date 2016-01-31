<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 3/12/2015
 * Time: 4:58 PM
 */
class SendMailCommand extends CConsoleCommand
{
    function actionIndex()
    {
//        $message            = new YiiMailMessage;
//        $message->subject    = 'My TestSubject';
//        $message->setBody("This is a test", 'text/html');
//        $message->addTo('geoff.stewart@idsecurity.com.au');
//        $message->from = 'vmsnotify@gmail.com';
//        Yii::app()->mail->send($message);

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: mail@identitysecurity.com.au\r\nReply-To: mail@identitysecurity.com.au";

        $content = "Reason: because<br><br>Message: because <br><br>~This message was sent via Visitor Management System~";

        EmailTransport::mail("geoffian@gmail.com","test",$content,$headers);

    }
}