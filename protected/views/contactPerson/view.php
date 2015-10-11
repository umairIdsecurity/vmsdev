<?php
/* @var $this ContactPersonController */
/* @var $model ContactPerson */

$this->breadcrumbs=array(
	'Contact People'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ContactPerson', 'url'=>array('index')),
	array('label'=>'Create ContactPerson', 'url'=>array('create')),
	array('label'=>'Update ContactPerson', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ContactPerson', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContactPerson', 'url'=>array('admin')),
);
?>

<h1>View Contact Person #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'contact_person_name',
		'contact_person_email',
		//'contact_person_message',
		'user_role',
		'reason_id',
		'date_created',
	),
)); ?>
