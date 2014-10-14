<?php
/* @var $this VisitorController */
/* @var $model Visitor */
?>

<h1>Manage Visitors</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'visitor-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'first_name',
        'last_name',
        array(
            'name' => 'role',
            'value' => 'User::model()->getUserRole($data->role)',
        ),
        array(
            'name' => 'visitor_type',
            'value' => 'VisitorType::model()->getVisitorType($data->visitor_type)',
            'filter' => VisitorType::$VISITOR_TYPE_LIST,
        ),
        'contact_number',
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
