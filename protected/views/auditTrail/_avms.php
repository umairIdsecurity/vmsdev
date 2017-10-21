<?php
/* @var $this AuditTrailController */
/* @var $model AuditTrail */

?>
<h1>Audit Trails</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'audit-trail-grid',
	'dataProvider'=>$model->search(Yii::app()->user->tenant),
	'filter'=>$model,
	'enableSorting' => false,
	'hideHeader'=>true,
	'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
        if (data.indexOf('Visitor Management System  - Login') > -1) {
            window.location = '<?php echo Yii::app()->createUrl('site/login');?>';
        }
    }",
    'ajaxUpdateError' => "function(id, data) {window.location.replace('?r=site/login');}",

	'columns'=>array(
	
		array(
			'name' => 'user_id',
			'filter'=>CHtml::activeTextField($model, 'user_id', array('placeholder'=>'Name')),
			'value'=>'!empty(User::model()->findByPk($data->user_id)->first_name) ? User::model()->findByPk($data->user_id)->first_name." ".User::model()->findByPk($data->user_id)->last_name : Visitor::model()->findByPk($data->user_id)->first_name." ".Visitor::model()->findByPk($data->user_id)->last_name'
		),
		array(
			'name' => 'old_value',
			'filter'=>CHtml::activeTextField($model, 'old_value', array('placeholder'=>'Old Value')),
			'value'=>'!empty($data->old_value) ? $data->old_value : "N/A"'
		),

		array(
			'name' => 'new_value',
			'filter'=>CHtml::activeTextField($model, 'new_value', array('placeholder'=>'New Value')),
			'value'=>'!empty($data->new_value) ? $data->new_value : "N/A"'
		),
		array(
			'name' => 'action',
			'filter'=>CHtml::activeTextField($model, 'action', array('placeholder'=>'Action')),
		),
		array(
			'name' => 'model',
			'filter'=>CHtml::activeTextField($model, 'model', array('placeholder'=>'Function')),
		),
		

		array(
			'name' => 'field',
			'filter'=>CHtml::activeTextField($model, 'field', array('placeholder'=>'Field')),
		),
		array(
			'name' => 'creation_date',
			'filter'=>CHtml::activeTextField($model, 'creation_date', array('placeholder'=>'Creation Date')),
			'value'=>'date("d/m/Y H:i:s",strtotime($data->creation_date))'
		),

		array(
			'header' => 'Actions',
			'class' => 'CButtonColumn',
			'template' => '{view}',
			'buttons' => array(
				'view' => array(//the name {reply} must be same
					'label' => 'View', // text label of the button
					'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
					'options' => array(
			            'class'=> 'view complete',
			        ),
				),

			),
		),


	),
)); ?>
