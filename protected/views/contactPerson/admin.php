<?php
/* @var $this ContactPersonController */
/* @var $model ContactPerson */

$this->breadcrumbs=array(
	'Contact People'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ContactPerson', 'url'=>array('index')),
	array('label'=>'Create ContactPerson', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#contact-person-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Contact Person</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contact-person-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'contact_person_name',
		'contact_person_email',
		array(
            'name'=>'Formatdate',
            'filter'=>false,
        ),
		array(
                    'header' => 'Actions',
                    'class' => 'CButtonColumn',
                    'template' => '{update} {delete}',
                    'buttons' => array(
                        'update' => array(//the name {reply} must be same
                            'label' => 'Edit', // text label of the button
                            'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                        ),
                        'delete' => array(//the name {reply} must be same
                            'label' => 'Delete', // text label of the button
                            'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels

                        ),
                    ),
                ),
	),
)); ?>
