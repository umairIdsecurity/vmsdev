pen the template in the editor.
-->
<?php
$message = new YiiMailMessage;
$message->view = 'registrationFollowup';
 
//userModel is passed to the view
$message->setBody(array('userModel'=>$userModel), 'text/html');
 
 
$message->addTo($userModel->email);
$message->from = Yii::app()->params['adminEmail'];
Yii::app()->mail->send($message);
