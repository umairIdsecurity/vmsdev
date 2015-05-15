
<?php
/* @var $this VisitorTypeController */
/* @var $model VisitorType */
?>

<h1>Manage Visitor Types</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visitor-type-grid-2',
    'dataProvider' => $model->search(),
    'enableSorting' => true,
    'hideHeader'=>false,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'name' => 'name',
            'filter'=>CHtml::activeTextField($model, 'name', array('placeholder'=>'Name')),
        ),
          array(
            'name' => 'is_default_value',
            'header'=> 'Default Value',
            'filter'=>array('1'=>'Default','0'=>'Not Default'),
            'value'=>'($data->is_default_value=="1")?("Default"):""',
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
