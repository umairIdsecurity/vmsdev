<?php
/* @var $this VisitReasonController */
/* @var $model VisitReason */

$this->breadcrumbs=array(
	'Visit Reasons'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List VisitReason', 'url'=>array('index')),
	array('label'=>'Create VisitReason', 'url'=>array('create')),
	array('label'=>'Update VisitReason', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VisitReason', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VisitReason', 'url'=>array('admin')),
);
?>

<h1>View VisitReason #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'reason',
		'created_by',
		'tenant',
		'tenant_agent',
	),
)); ?>
