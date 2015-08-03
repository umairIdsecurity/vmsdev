<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/26/15
 * Time: 9:28 AM
 */

if(Yii::app()->user->hasState('account')){
    $account=Yii::app()->user->getState('account');
}

?>

<div id="menu">
    <div class="row items">
        <div class="col-xs-2 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
        <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/visitHistory'); ?>">Visit History</a></div>
        <div class="col-xs-6 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/verify'); ?>">Verifications</a></div>
    </div>
    <div class="title">
        <div class="text-center">Visitor Identification Cards (VIC)</div>
    </div>
</div>

<ul class="user-function">
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/profile'); ?>">My profile</a></li>
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/preregisterVIC'); ?>">Preregister for a VIC</a></li>
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/notifications'); ?>">Notifications</a></li>
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/renewApplyAsic'); ?>">Apply for or Renew an ASIC</a></li>
    <li class="btn btn-lg btn-block"><a href="<?php echo Yii::app()->createUrl('preregistration/applicationStatus'); ?>">ASIC Application Status</a></li>
    <?php
        if($account==='ASIC'){
            echo '<li class="btn btn-lg btn-block"><a href="#">ASIC sponsor verifications</a></li>';
        }
    ?>

</ul>
