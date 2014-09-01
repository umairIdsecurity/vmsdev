<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Set Access Rules',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Set Access Rules</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array (
                    'header'=>'User',
                    'value'=>'',
                ),
                array (
                    'name'=>'user_type',
                    'value' => '($data->user_type=="1")?"Internal":"External"',
                    'filter' => array('="1"' => Yii::t('app', 'Internal'), '="2"' => Yii::t('app', 'External')),
                ),
		'email',
		array(
                    'class'=>'CCheckBoxColumn',
                    'headerTemplate'=>'Workstation 1  {item}',
                    'selectableRows' => 2,),
		array(
                    'class'=>'CCheckBoxColumn',
                    'headerTemplate'=>'Workstation 2  {item}',
                    'selectableRows' => 2,),
		array(
                    'class'=>'CCheckBoxColumn',
                    'headerTemplate'=>'Workstation 3  {item}',
                    'selectableRows' => 2,),
               
                
	),
)); ?>

<table>
    <tr>
       <th></th>
    </tr> 
</table>