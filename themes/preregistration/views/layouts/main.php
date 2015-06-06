<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-title" content="" />
        <meta name="description" content="description" />
        <meta name="keywords" content="keywords"/>
        <title>Preregistration</title>
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" rel="stylesheet">
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/modernizr.js"></script>
    </head>
    <body class="first-page logout-page login-page">
        <div id="header" class="relative">
            <div class="container">
                <div class="logo">
                    <a href="./">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" alt="Pre registration"/>
                    </a>
                </div>
                <ul class="icons">
                    <li class="group-1"><a href="<?php echo Yii::app()->theme->baseUrl; ?>/user.php"><span class="glyphicon glyphicon-log-in"></span></a></li>
                    <li class="group-2"><a href="<?php echo Yii::app()->theme->baseUrl; ?>/user.php?p=function"><span class="glyphicon glyphicon-user"></span></a></li>
                    <li class="group-2"><a href="#"><span class="glyphicon glyphicon-envelope"></span></a></li>
                    <li class="group-2"><a href="#"><span class="glyphicon glyphicon-question-sign"></span></a></li>
                    <li class="group-2"><a href="#"><span class="glyphicon glyphicon-log-out"></span></a></li>
                </ul>
            </div>
        </div>
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
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/libs.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.download.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"></script>
    </body>
</html>

