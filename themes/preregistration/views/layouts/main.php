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

    <style type="text/css">
.top_nav
{
    float: right;
    /*margin-right: -27px !important;*/
    margin-top: -53px !important;
}
.top_nav ul
{
    list-style:none;
    float:right;
    margin: 0;
    padding: 0;
}
.top_nav ul li
{
    float:left;
    color:#000;
    font-size:14px;
    padding:0 3px;
}
.top_nav ul li:last-child
{
    border-right:none;
}

.top_nav ul li img
{
    float:left;
    width:14px;
}
.top_nav ul li a
{
    text-decoration:none;
    color:#000;
}
.top_nav ul li a:hover
{
    color:#9BD62C;
}

.top_nav .profile{
    padding: 0 ;
}


.open-folder a span{
    height: 38px;
    line-height: 38px;
    display: block;
    padding: 0 10px;
    color: #666666;
}
.glyphicons-folder-open:before {
    content: "\e118";
    font-size: 18px;
    vertical-align: sub;
}

.glyphicons-refresh:before {
    content: "\e031";
    font-size: 18px;
    vertical-align: sub;
}

.top_nav .profile a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-profile.png') no-repeat center center;
    text-indent: -9999px;
}

.top_nav .notifications a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-notifications.png') no-repeat center center;

}
.notifications .notification-count {
     padding:0px 6px;
     float:right;
     border:1px solid red;
     border-radius: 10px;
     background: red;
     font-size:10px;
     color:#fff !important;

}
.top_nav .support a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-support.png') no-repeat center center;
    text-indent: -9999px;
}



.top_nav .help a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-help.png') no-repeat center center;
    text-indent: -9999px;
}

.top_nav .logout a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-logout.png') no-repeat center center;
    text-indent: -9999px;
}

    </style>

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
                <!-- ******************************************************************** -->
                    <aside class="top_nav">
                        <ul id="icons">

                            <?php if(is_null(Yii::app()->user->id) || empty(Yii::app()->user->id)) {?>
                                <li class="group-2"><a style="text-decoration:underline; color:#428BCA;font-size:13px;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/login'); ?>">Login to AVMS</a></li>
                                <li class="group-2"><a style="text-decoration:underline; color:#428BCA;font-size:13px;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/registration'); ?>">Create Login</a></li>
                            <?php } ?> 


                            <?php if(!is_null(Yii::app()->user->id) && !empty(Yii::app()->user->id)) {?>
                                    
                                    <li class="profile">
                                        <a title="profile" href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . $session['id']); ?>">
                                            My Profile
                                        </a>
                                    </li>
                            

                                    <li class="notifications dropdown">
                                        <a title="notifications" href="<?php echo Yii::app()->createUrl('preregistration/notifications'); ?>" class="dropdown-toggle" data-toggle="dropdown"> 
                                            <?php $notifications = CHelper::get_unread_visitors_notifications();
                                               if($notifications) 
                                                  echo '  <div class="notification-count"> '. count($notifications).'</div>';
                                        ?></a>
                                    </li>

                                    
                                    <li class="help">
                                        <a title="help" href="<?php echo Yii::app()->createUrl('preregistration/helpdesk'); ?>">
                                            Help
                                        </a>
                                    </li>

                                    <li class="logout">
                                        <a title="logout" href="<?php echo Yii::app()->createUrl('preregistration/logout'); ?>">
                                            <span class="glyphicon glyphicon-log-out"></span>
                                        </a>
                                    </li>
                            
                            <?php
                                  }
                            ?>
                        </ul>
                            
                    </aside>
                <!-- ******************************************************************** -->
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

