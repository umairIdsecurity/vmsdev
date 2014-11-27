<?php
/* @var $this CardTypeController */
/* @var $model CardType */

$this->breadcrumbs=array(
	'Card Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CardType', 'url'=>array('index')),
	array('label'=>'Create CardType', 'url'=>array('create')),
	array('label'=>'Update CardType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CardType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CardType', 'url'=>array('admin')),
);
?>

<h1>View CardType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'max_day_validity',
		'max_time_validity',
		'max_entry_count_validity',
		'card_icon_type',
		'card_background_image_path',
		'created_by',
	),
)); ?>
