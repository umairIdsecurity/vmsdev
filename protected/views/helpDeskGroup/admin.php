
<?php
/* @var $this HelpDeskGroupController */
/* @var $model HelpDeskGroup */
?>

<h1>Manage Help Desk Groups</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'helpdesk-group-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
		array(
            'name' => 'order_by',
			'filter'=>CHtml::activeTextField($model, 'order_by'),
			'htmlOptions'=>array('width'=>'50px')
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
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
));
?>
