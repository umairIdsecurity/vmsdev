<?php
/* @var $this ImportHostsController */
/* @var $model ImportHosts */

$this->breadcrumbs=array(
	'Import Hosts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ImportHosts', 'url'=>array('index')),
	array('label'=>'Create ImportHosts', 'url'=>array('create')),
	array('label'=>'Update ImportHosts', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ImportHosts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ImportHosts', 'url'=>array('admin')),
);
?>

<h1>View ImportHosts #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'email',
		'department',
		'staff_id',
		'contact_number',
		'company',
		'imported_by',
		'date_imported',
		'password',
		'role',
	),
)); ?>
