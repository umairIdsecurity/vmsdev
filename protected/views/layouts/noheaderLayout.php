<?php Yii::app()->bootstrap->register(); ?>
<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/angular.min.js');
//$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/match.js');
$session=new CHttpSession;
            $user_role = $session['role'];
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
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo" style="padding:10px 100px;"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/ids-logo.png')); ?></div>
	
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
