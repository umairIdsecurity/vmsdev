<?php
/* @var $this WorkstationController */
/* @var $model Workstation */

$this->breadcrumbs=array(
	'Workstations'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Workstation', 'url'=>array('index')),
	array('label'=>'Create Workstation', 'url'=>array('create')),
	array('label'=>'View Workstation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Workstation', 'url'=>array('admin')),
);
?>

<h1>Update Workstation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>