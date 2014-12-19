<?php
/* @var $this VisitorTypeController */
/* @var $model VisitorType */

$this->breadcrumbs=array(
	'Visitor Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VisitorType', 'url'=>array('index')),
	array('label'=>'Manage VisitorType', 'url'=>array('admin')),
);
?>

<h1>Create Visitor Type</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>