<?php
/* @var $this WorkstationController */
/* @var $model Workstation */

$this->breadcrumbs=array(
	'Workstations'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Workstation', 'url'=>array('index')),
	array('label'=>'Create Workstation', 'url'=>array('create')),
	array('label'=>'Update Workstation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Workstation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Workstation', 'url'=>array('admin')),
);
?>

<h1>View Workstation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'location',
		'contact_name',
		'contact_number',
		'contact_email_address',
		'number_of_operators',
		'assign_kiosk',
		'password',
		'created_by',
		'tenant',
		'tenant_agent',
		'is_deleted',
	),
)); ?>
