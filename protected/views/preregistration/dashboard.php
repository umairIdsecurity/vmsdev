<?php

$session = new CHttpSession;
$account='';
if(Yii::app()->user->hasState('account')){
    $account=Yii::app()->user->getState('account');
}

?>

<div id="menu">
    <div class="row items">
        <div class="col-xs-2 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
        <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/visitHistory'); ?>">Visit History</a></div>
        <div class="col-xs-6 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/verify'); ?>">ASIC Sponsor Verifications</a></div>
    </div>
    <div class="title">
        <div class="text-center">Aviation Visitor Management</div>
    </div>
</div>

<ul class="user-function">

    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . $session['id']); ?>">My profile</a></li>
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/preregisterVIC'); ?>">Preregister for a VIC</a></li>
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/notifications'); ?>">Notifications</a></li>
    
    <?php if($account==='CORPORATE'): ?>
        <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/addCompanyContact'); ?>">Add Company Contact</a></li>
    <?php endif; ?>
    
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/renewApplyAsic'); ?>">Apply for or Renew an ASIC</a></li>
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/applicationStatus'); ?>">ASIC Application Status</a></li>
    <?php
        /*if($account==='ASIC'){
            echo '<li class="btn btn-lg btn-block"><a href="#">ASIC sponsor verifications</a></li>';
        }*/
    ?>

</ul>
