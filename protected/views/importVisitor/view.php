<?php
/* @var $this ImportVisitorController */
/* @var $model ImportVisitor */

$this->breadcrumbs=array(
	'Import Visitors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ImportVisitor', 'url'=>array('index')),
	array('label'=>'Create ImportVisitor', 'url'=>array('create')),
	array('label'=>'Update ImportVisitor', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ImportVisitor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ImportVisitor', 'url'=>array('admin')),
);
?>

<h1>View ImportVisitor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'email',
		'company',
		'check_in_date',
		'check_out_date',
		'card_code',
		'imported_by',
		'import_date',
	),
)); ?>
