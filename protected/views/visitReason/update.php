<?php
/* @var $this VisitReasonController */
/* @var $model VisitReason */

$this->breadcrumbs=array(
	'Visit Reasons'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VisitReason', 'url'=>array('index')),
	array('label'=>'Create VisitReason', 'url'=>array('create')),
	array('label'=>'View VisitReason', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VisitReason', 'url'=>array('admin')),
);
?>

<h1>Update Visit Reason</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>