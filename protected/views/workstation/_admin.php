<?php
/* @var $this WorkstationController */
/* @var $model Workstation */
?>

<h1>Manage Workstations</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'workstation-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        'location',
        'contact_name',
        'contact_number',
        'contact_email_address',
        /*
          'number_of_operators',
          'assign_kiosk',
          'password',
          'created_by',
          'tenant',
          'tenant_agent',
          'is_deleted',
         */
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
                    'visible' => 'UserWorkstations::model()->checkIfWorkstationIsAssignedAsPrimary($data->id)!= 1',
                ),
            ),
        ),
    ),
));
?>
