<?php
/* @var $this UserLafPreferencesController */
/* @var $model UserLafPreferences */

$this->breadcrumbs=array(
	'User Laf Preferences'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserLafPreferences', 'url'=>array('index')),
	array('label'=>'Create UserLafPreferences', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-laf-preferences-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Laf Preferences</h1>

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
	'id'=>'user-laf-preferences-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'logo',
		'action_forward_bg_color',
		'action_forward_hover_color',
		'action_forward_font_color',
		'complete_bg_color',
		/*
		'complete_hover_color',
		'complete_font_color',
		'neutral_bg_color',
		'neutral_hover_color',
		'neutral_font_color',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
