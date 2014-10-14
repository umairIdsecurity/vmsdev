<?php
/* @var $this VisitorController */
/* @var $model Visitor */

$this->breadcrumbs=array(
	'Visitors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Visitor', 'url'=>array('index')),
	array('label'=>'Manage Visitor', 'url'=>array('admin')),
);
?>

<h1>Add Visitor</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>