<?php
/* @var $this UserWorkstationsController */
/* @var $model UserWorkstations */

$this->breadcrumbs=array(
	'User Workstations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserWorkstations', 'url'=>array('index')),
	array('label'=>'Manage UserWorkstations', 'url'=>array('admin')),
);
?>

<h1>Create UserWorkstations</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>