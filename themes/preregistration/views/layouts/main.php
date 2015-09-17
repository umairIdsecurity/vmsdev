<?php

$session = new CHttpSession;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="" />
    <meta name="description" content="description" />
    <meta name="keywords" content="keywords"/>
    <link rel="shortcut icon" href="<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-dashboard.png" type="image/x-icon"/>


    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/jquery.min.js" ></script>
    <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/jquery.form.js" ></script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/libs.js"></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body class="first-page">
        <div id="header" class="relative">
            <div class="container">
                <div class="logo">
                    <a href="./">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" alt="Pre registration"/>
                    </a>
                </div>
                <ul class="icons">
                    <?php if(is_null(Yii::app()->user->id) || empty(Yii::app()->user->id)) {?>
                            <li class="group-2"><a style="text-decoration:underline; color:#428BCA;font-size:13px;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/login'); ?>">Login to AVMS</a></li>
                            <li class="group-2"><a style="text-decoration:underline; color:#428BCA;font-size:13px;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/registration'); ?>">Create Login</a></li>
                    <?php } ?> 

                    <?php if(!is_null(Yii::app()->user->id) && !empty(Yii::app()->user->id)) {?>
                            <li class="group-2"><a href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . $session['id']); ?>"><span class="glyphicon glyphicon-user"></span></a></li>
                            
                            <!-- <li class="group-2"><a href="<?php //echo Yii::app()->createUrl('preregistration/notifications'); ?>"><span class="glyphicon glyphicon-envelope"></span></a></li> -->

                            <li class="notifications dropdown">
                                <a title="notifications" href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php $notifications = CHelper::get_unread_visitors_notifications();
                                       if($notifications) 
                                          echo '  <div class="notification-count"> '. count($notifications).'</div>';
                                ?></a>
                                <?php //echo $this->renderPartial("//preregistration/notification_menu", array('notifications'=>$notifications), false, false); ?>
                            </li>

                            <li class="group-2"><a href="<?php echo Yii::app()->createUrl('preregistration/helpdesk'); ?>"><span class="glyphicon glyphicon-question-sign"></span></a></li>
                            <li class="group-2"><a href="<?php echo Yii::app()->createUrl('preregistration/logout'); ?>"><span class="glyphicon glyphicon-log-out"></span></a></li>
                    <?php
                          }
                    ?>
                    
                </ul>
            </div>
        </div>
        
        <div class="header-bottom">
            <div class="container"></div>
        </div>
        
       
        <br>

        <div id="container">
            <div class="container">
                <div id="main">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>

        <div id="footer">
            <div class="container">

            </div>
        </div>

        <!-- for developer -->
        <!--<script src="<?php /*echo Yii::app()->theme->baseUrl; */?>/js/libs.js"></script>-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.download.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"></script>

        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js"></script>
    </body>
</html>

