<?php
$session = new CHttpSession;
Yii::app()->bootstrap->register();

$cs = Yii::app()->clientScript;

$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.uploadfile.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.form.js');


$userRole = $session['role'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sidebar.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/uploadfile.css" />
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/match.js" ></script>

        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/script-sidebar.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.uploadfile.min.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form.js" ></script>


        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">
            <div class="wrapper" >
                <div id="content" style="margin-left: -30px; width: 930px;border:1px solid white;">
                    <?php echo $content; ?>
                </div>
            </div>
            <div class="clear"></div>
           
        </div><!-- page -->

                    </body>
                    </html>
