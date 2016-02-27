<?php
/* @var $this ImportVisitorController */
/* @var $model ImportVisitor */

$this->breadcrumbs=array(
	'Import Visitors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImportVisitor', 'url'=>array('index')),
	array('label'=>'Manage ImportVisitor', 'url'=>array('admin')),
);
?>

<h1>Create ImportVisitor</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>