
<?php
/* @var $this HelpDeskGroupController */
/* @var $model HelpDeskGroup */
function assignedHelpDeskGroups(){
    $data = CHtml::listData(HelpDeskGroup::model()->findAll(array('condition'=>'created_by='.Yii::app()->user->id, 'order' => 'order_by ASC')), 'id', 'name');
    $data=array(""=>'Help Desk Groups')+$data;
    return $data;
}
?>

<h1>Manage Help Desk Groups</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'helpdesk-group-grid',
    'dataProvider' => $model->search(),
    'enableSorting' => false,
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
	    array(
            'name' => 'helpdesk_group_id',
            'filter' => assignedHelpDeskGroups(),
            'type' => 'html',
            'value' => 'HelpDeskGroup::model()->getHelpDeskGroupName($data->helpdesk_group_id)',
            'htmlOptions'=>array('width'=>'200px')
        ),
        array(
            'name' => 'order_by',
			'filter'=>CHtml::activeTextField($model, 'order_by', array('placeholder'=>'Sort Order')),
			'htmlOptions'=>array('width'=>'50px')
        ),
		array(
            'name' => 'question',
            'filter'=>CHtml::activeTextField($model, 'question', array('placeholder'=>'Question')),
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
