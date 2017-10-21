<?php
/* @var $this ReasonsController */
/* @var $model Reasons */

$this->breadcrumbs=array(
	'Reasons'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Reasons', 'url'=>array('index')),
	array('label'=>'Create Reasons', 'url'=>array('create')),
	array('label'=>'Update Reasons', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Reasons', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Reasons', 'url'=>array('admin')),
);
?>

<h1>View Reasons #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'reason_name',
		'date_created',
	),
)); ?>
