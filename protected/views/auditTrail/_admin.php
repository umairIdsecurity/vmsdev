<?php
/* @var $this AuditTrailController */
/* @var $model AuditTrail */

?>
<h1>Audit Trails</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'audit-trail-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'enableSorting' => false,
	'hideHeader'=>true,
	'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
	'columns'=>array(

		array(
			'name' => 'user_id',
			'filter'=>CHtml::activeTextField($model, 'user_id', array('placeholder'=>'User Id')),
		),
		array(
			'name' => 'old_value',
			'filter'=>CHtml::activeTextField($model, 'old_value', array('placeholder'=>'Old Value')),
		),

		array(
			'name' => 'new_value',
			'filter'=>CHtml::activeTextField($model, 'new_value', array('placeholder'=>'New Value')),
		),
		array(
			'name' => 'action',
			'filter'=>CHtml::activeTextField($model, 'action', array('placeholder'=>'Action')),
		),
		array(
			'name' => 'model',
			'filter'=>CHtml::activeTextField($model, 'model', array('placeholder'=>'Model')),
		),
		array(
			'name' => 'model_id',
			'filter'=>CHtml::activeTextField($model, 'model_id', array('placeholder'=>'Model Id')),
		),

		array(
			'name' => 'field',
			'filter'=>CHtml::activeTextField($model, 'field', array('placeholder'=>'Field')),
		),
		array(
			'name' => 'creation_date',
			'filter'=>CHtml::activeTextField($model, 'creation_date', array('placeholder'=>'Creation Date')),
		),

		array(
			'header' => 'Actions',
			'class' => 'CButtonColumn',
			'template' => '{view}',
			'buttons' => array(
				'view' => array(//the name {reply} must be same
					'label' => 'View', // text label of the button
					'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
				),

			),
		),


	),
)); ?>
