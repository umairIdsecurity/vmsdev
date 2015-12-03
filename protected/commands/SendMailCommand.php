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
        $message            = new YiiMailMessage;
        $message->subject    = 'My TestSubject';
        $message->setBody("This is a test", 'text/html');
        $message->addTo('geoff.stewart@idsecurity.com.au');
        $message->from = 'vmsnotify@gmail.com';
        Yii::app()->mail->send($message);

    }
}