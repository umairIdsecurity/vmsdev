<?php
/* @var $this AuditLogController */
/* @var $model AuditLog */

?>
<h1>Audit Log</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'audit-log-grid',
	'dataProvider'=>$model->search(),
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
	'columns'=>array(

		array(
			'name' => 'id',
			'filter'=>CHtml::activeTextField($model, 'id', array('placeholder'=>'ID')),
		),
		array(
			'name' => 'action_datetime_new',
			'filter'=>CHtml::activeTextField($model, 'action_datetime_new', array('placeholder'=>'Action Datetime')),
		),

		array(
			'name' => 'action',
			'filter'=>CHtml::activeTextField($model, 'action', array('placeholder'=>'Action')),
		),
		array(
			'name' => 'detail',
			'filter'=>CHtml::activeTextField($model, 'detail', array('placeholder'=>'Detail')),
		),
		array(
			'name' => 'user_email_address',
			'filter'=>CHtml::activeTextField($model, 'user_email_address', array('placeholder'=>'User Email Address')),
		),
		array(
			'name' => 'ip_address',
			'filter'=>CHtml::activeTextField($model, 'ip_address', array('placeholder'=>'Ip Address')),
		),

		array(
			'name' => 'tenant',
			'filter'=>CHtml::activeTextField($model, 'tenant', array('placeholder'=>'Tenant')),
		),
		array(
			'name' => 'tenant_agent',
			'filter'=>CHtml::activeTextField($model, 'tenant_agent', array('placeholder'=>'Tenant Agent')),
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
