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
        <div class="col-xs-2 text-center"><a href="?p=function"><span class="glyphicon glyphicon-home"></span></a></div>
        <div class="col-xs-4 text-center"><a href="?p=history">Visit History</a></div>
        <div class="col-xs-6 text-center"><a href="?p=verify">Verifications</a></div>
    </div>
    <div class="title">
        <div class="text-center">Visitor Identification Cards (VIC)</div>
    </div>
</div>

<ul class="user-function">
    <li class="btn btn-lg btn-block"><a href="#">My profile</a></li>
    <li class="btn btn-lg btn-block"><a href="#">Preregister visit</a></li>
    <li class="btn btn-lg btn-block"><a href="#">Notifications</a></li>
    <?php
        if($account==='ASIC'){
            echo '<li class="btn btn-lg btn-block"><a href="#">ASIC sponsor verifications</a></li>';
        }
    ?>

</ul>
