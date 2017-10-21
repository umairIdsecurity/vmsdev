
<?php
$session = new CHttpSession;
?>

<div class="page-content">
    <h1 class="text-primary title">Your application has been saved</h1>


    <p>In order to complete your saved application please create visitor login from <a style="text-decoration:underline; color:#428BCA;font-size:13px;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/registration'); ?>">here</a>. Remember all the details e.g First name, Last name and Email address should be the same as provided in the saved application. If you have already created a login with the same details then please login<a style="text-decoration:underline; color:#428BCA;font-size:13px;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/login'); ?>"> here </a>. </p>

   

</div>