<?php
/* @var $this VisitController */
/* @var $model Visit */

$this->breadcrumbs=array(
	'Visits'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Visit', 'url'=>array('index')),
	array('label'=>'Create Visit', 'url'=>array('create')),
	array('label'=>'Update Visit', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Visit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Visit', 'url'=>array('admin')),
);
?>

<h1>View Visit #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'card',
		'visitor_type',
		'reason',
		'visitor_status',
		'host',
		'patient',
		'created_by',
		'date_in',
		'time_in',
		'date_out',
		'time_out',
		'date_check_in',
		'time_check_in',
		'date_check_out',
		'time_check_out',
		'tenant',
		'tenant_agent',
		'is_deleted',
	),
)); ?>
