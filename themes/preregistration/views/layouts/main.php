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
                    <?php
                    if(
                        Yii::app()->user->isGuest ||
                        Yii::app()->urlManager->parseUrl(Yii::app()->request) =='preregistration/login'
                      ) {
                        ?>
                        <li class="group-1"><a href="#"><span class="glyphicon glyphicon-log-in"></span></a></li>
                    <?php
                    }
                    else{
                        ?>
                        <li class="group-2"><a href="#"><span class="glyphicon glyphicon-user"></span></a></li>
                        <li class="group-2"><a href="#"><span class="glyphicon glyphicon-envelope"></span></a></li>
                        <li class="group-2"><a href="#"><span class="glyphicon glyphicon-question-sign"></span></a></li>
                        <li class="group-2"><a href="#"><span class="glyphicon glyphicon-log-out"></span></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php
        if(Yii::app()->user->isGuest){
        ?>
        <div class="header-bottom">
            <div class="container"></div>
        </div>
        <?php
        }
        ?>


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
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js"></script>
    </body>
</html>

