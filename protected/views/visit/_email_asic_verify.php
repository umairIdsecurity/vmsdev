<?php
//$mail = new YiiMailMessage;
//$mail->from = 'notify.vms@gmail.com';
//$mail->addTo($host->email);
//$mail->subject = 'Request for verification of VIC profile ';
$param = '<html><body><h4>Hi,</h4>';
$param .= '<h4>VIC Holder urgently requires your Verification of their visit.</h4>';
$baseUrl = Yii::app()->getBaseUrl(true);
$vicProfile = Yii::app()->createUrl('visitor/update', array('id' => $visitor->id));
$link = $baseUrl . $vicProfile;
$param .= 'Link of VIC Profile: ' . $link;
$param .= '<h4>Thanks,</h4>';
$param .= '<h4>Admin</h4></body></html>';
//$mail->setBody($param, 'text/html');
//Yii::app()->mail->send($mail);

//Email by custom

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: Admin <notify.vms@gmail.com>\r\n";

$to=$host->email;
$subject="Request for verification of VIC profile";

mail($to,$subject,$param,$headers);

//EmailTransport::mail($to, $subject, $param, $headers);

?>