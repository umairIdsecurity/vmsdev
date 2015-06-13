
<h1>Manage Notifications</h1>
 
<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'notification-grid',
	'dataProvider'=>$model->indexSearch(),
	'filter'=>$model,
	'columns'=>array(
		/* 'id', */
		'subject',
		/* 'message', */
                'date_created',
                'notification_type',
		/*'created_by',
		 
		'role_id',
		 'notification_type',
		*/
             array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'template' => '{view} {delete}',
                'deleteButtonUrl' => 'Yii::app()->createUrl("notifications/indexDelete", array("id"=>$data->id))',
                'buttons' => array(                  
                    'view' => array(//the name {reply} must be same
                        'label' => 'view', // text label of the button
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
