<?php
/* @var $this VisitReasonController */
/* @var $model VisitReason */

$this->breadcrumbs=array(
	'Visit Reasons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VisitReason', 'url'=>array('index')),
	array('label'=>'Manage VisitReason', 'url'=>array('admin')),
);
?>

<h1>Add Visit Reason</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>