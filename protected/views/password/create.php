<?php
/* @var $this PasswordController */
/* @var $model Password */

$this->breadcrumbs=array(
	'Passwords'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Password', 'url'=>array('index')),
	array('label'=>'Manage Password', 'url'=>array('admin')),
);
?>

<h1>Create Password</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>