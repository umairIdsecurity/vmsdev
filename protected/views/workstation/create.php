<?php
/* @var $this WorkstationController */
/* @var $model Workstation */

$this->breadcrumbs=array(
	'Workstations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Workstation', 'url'=>array('index')),
	array('label'=>'Manage Workstation', 'url'=>array('admin')),
);
?>

<h1>Create Workstation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>