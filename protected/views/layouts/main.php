<?php echo Yii::app()->bootstrap->init();
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
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/match.js" ></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
                            array('label'=>'Administration', 'url'=>array('/user/admin'),'visible'=>!Yii::app()->user->isGuest,),
                            array('label'=>'Change Password', 'url'=>array('/password/update&id='.Yii::app()->user->getId()),'visible'=>!Yii::app()->user->isGuest,),
                            array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                            array('label'=>'Logout ', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest,'itemOptions'=>array('class'=>'logout')),
                            array('label'=>'Logged in as '.Yii::app()->user->name.' - '.User::model()->getUserRole($user_role).'','url'=>array('') ,'visible'=>!Yii::app()->user->isGuest)
                    ),
                  //  echo User::model()->getUserRole();
		)); ?>
            
	</div>
        <!-- mainmenu -->
      
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
