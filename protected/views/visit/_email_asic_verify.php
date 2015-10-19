<?php
$mail = new YiiMailMessage;
$mail->from = 'Admin <notify.vms@gmail.com>';
$mail->addTo($host->email);
$mail->subject = 'Request for verification of VIC profile ';
$param = '<h3>Hi,</h3>';
$param .= '<h3>VIC Holder urgently requires your Verification of their visit.</h3>';
$baseUrl = Yii::app()->getBaseUrl(true);
$vicProfile = Yii::app()->createUrl('visitor/update', array('id' => $visitor->id));
$link = $baseUrl . $vicProfile;
$param .= 'Link of VIC Profile: ' . $link;
$param .= '<h3>Thanks,</h3>';
$param .= '<h3>Admin</h3>';
$mail->setBody($param, 'text/html');
Yii::app()->mail->send($mail);

/**
 * Test Email by custom
 
   $headers = "From: Admin <notify.vms@gmail.com>\r\n". 
               "MIME-Version: 1.0" . "\r\n" . 
               "Content-type: text/html; charset=UTF-8" . "\r\n"; 
   mail($host->email, "Request for verification of VIC profile ", $param, $headers);
    mail("tahir.hussain@discretelogix.com", $host->email, $param, $headers);*/
?>