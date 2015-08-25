<?php
/* @var $this CompanyController */
/* @var $model Company */

?>

<h1>Tenant <?php echo $module; ?> Agents</h1>

<?php 
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div><br>";
    }
?>
 

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'tenant-grid',
    'dataProvider' => $model->search(),
     
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        
         array(
            'name' => 'tenant_name',
            'filter'=>CHtml::activeTextField($model, 'tenant_name', array('placeholder'=>'Tenant')),
            'value'=>'$data->getTenantName($data->tenant_id)',
        ),
        
        array(
            'name' => 'tenant_agent_name',
            'filter'=>CHtml::activeTextField($model, 'tenant_agent_name', array('placeholder'=>'Tenant Agent')),
            'value'=>'$data->id0->name',
        ),
        
         array(
            'name' => 'email_address',
            'filter'=>CHtml::activeTextField($model, 'email_address', array('placeholder'=>'Contact Email')),
            'value'=>'$data->id0->email_address',
        ),
        
        array(
            'name' => 'agent_contact',
            'filter'=>CHtml::activeTextField($model, 'agent_contact', array('placeholder'=>'Contact Number')),
            'value'=>'$data->id0->mobile_number',
        ),
        
         array(
            'name' => 'for_module',
            'filter'=>CHtml::activeTextField($model, 'for_module', array('placeholder'=>'Module')),
            'value'=>'$data->for_module',
        ),
    
        
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
            'buttons' => array(
                'update' => array(//the name {reply} must be same
                    'label' => 'Edit', // text label of the button
                    'imageUrl' => false, // image URL of the button. If not set or false, a text link is used, The image must be 16X16 pixels
                     'visible' => '(Yii::app()->user->role == Roles::ROLE_SUPERADMIN)',
                    'url'=>'Yii::app()->createUrl("tenantAgent/update", array("id"=>$data->id))'
                    ),

                'delete' => array
                (
                    'label'=>'Delete',
                    'imageUrl' => false,
                    'visible' => '(Yii::app()->user->role == Roles::ROLE_SUPERADMIN)',
                    'url'=>'Yii::app()->createUrl("tenantAgent/delete", array("id"=>$data->id))'

                ),

            ),
        ),
    ),
));

?>
