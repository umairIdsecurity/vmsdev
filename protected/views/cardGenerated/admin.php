<?php
/* @var $this CardGeneratedController */
/* @var $model CardGenerated */

$this->breadcrumbs=array(
	'Card Generateds'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CardGenerated', 'url'=>array('index')),
	array('label'=>'Create CardGenerated', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#card-generated-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Card Generateds</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'card-generated-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'date_printed',
		'date_expiration',
		'card_image_generated_filename',
		'visitor_id',
		'created_by',
		/*
		'tenant',
		'tenant_agent',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
