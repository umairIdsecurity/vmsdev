<?php
/* @var $this UserWorkstationsController */
/* @var $model UserWorkstations */

$this->breadcrumbs=array(
	'User Workstations'=>array('index'),
	'Manage',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-workstations-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Workstations</h1>

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
	'id'=>'user-workstations-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array (
                    'header'=>'User',
                    'value'=>'',
                ),
		'user0.user_type',
                
                'user0.email',
		array(
                    'class'=>'CCheckBoxColumn',
                    'headerTemplate'=>'Workstation 1  {item}',
                    'selectableRows' => 2,
                    'checked'=>'($data->workstation==1)?(1):(0)',),
                array(
                    'class'=>'CCheckBoxColumn',
                    'headerTemplate'=>'Workstation 2  {item}',
                    'selectableRows' => 2,
                    'checked'=>'($data->workstation==2)?(1):(0)',),
		array(
                    'class'=>'CCheckBoxColumn',
                    'headerTemplate'=>'Workstation 3  {item}',
                    'selectableRows' => 2,),    
	),
)); ?>
