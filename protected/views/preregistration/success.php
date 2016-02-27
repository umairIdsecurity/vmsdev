
<?php
$session = new CHttpSession;
?>

<div class="page-content">
    <h1 class="text-primary title">Create Login</h1>


    <p>You have successfully pre registered your visit <?php echo (isset($session['date_of_visit']) && $session['date_of_visit'] != "") ? "for ".date("d-m-Y",strtotime($session['date_of_visit'])) : "" ?></p>

    <p>Click here to <a style="text-decoration:underline; color:#428BCA;font-size:13px;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/registration'); ?>">Create Login</a> for your next visit.</p>

</div>
