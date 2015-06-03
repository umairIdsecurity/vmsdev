
<?php
$session=new CHttpSession;
Yii::app()->bootstrap->register();
?>
<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/angular.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/match.js');

$userRole = $session['role'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/style.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::link(CHtml::image(Yii::app()->controller->assetsBase.'/images/ids-circle-logo.png')); ?></div>
	
	</div><!-- header -->

     

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
            Copyright &copy; <?php echo date('Y'); ?> by <a href="http://idsecurity.com.au">Identity Security Pty Ltd </a>©.<br/>
            All Rights Reserved.<br/>
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
