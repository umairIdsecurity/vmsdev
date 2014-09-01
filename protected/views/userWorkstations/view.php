<?php
/* @var $this UserWorkstationsController */
/* @var $model UserWorkstations */

$this->breadcrumbs=array(
	'User Workstations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserWorkstations', 'url'=>array('index')),
	array('label'=>'Create UserWorkstations', 'url'=>array('create')),
	array('label'=>'Update UserWorkstations', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserWorkstations', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserWorkstations', 'url'=>array('admin')),
);
?>

<h1>View UserWorkstations #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user',
		'workstation',
		'created_by',
	),
)); ?>
