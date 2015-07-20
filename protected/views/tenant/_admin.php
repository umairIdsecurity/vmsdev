<?php
/* @var $this CompanyController */
/* @var $model Company */

?>

<h1>Tenant</h1>

<?php 
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'tenant-grid',
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
            'name' => 'name',
            'filter'=>CHtml::activeTextField($model, 'name', array('placeholder'=>'Tenant Name')),
            'value'=>'$data->id0->name',
        ),
        array(
            'name' => 'code',
            'filter'=>CHtml::activeTextField($model, 'code', array('placeholder'=>'Tenant Code')),
            'value'=>'$data->id0->code',
        ),
        array(
            'name' => 'name',
            'filter'=>CHtml::activeTextField($model, 'contact', array('placeholder'=>'Contact Number')),
            'value'=>'$data->id0->contact',
        ),
        array(
            'name' => 'name',
            'filter'=>CHtml::activeTextField($model, 'email_address', array('placeholder'=>'Email Address')),
            'value'=>'$data->id0->email_address',
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

                'delete' => array
                (
                    'label'=>'Delete',
                    'imageUrl' => false,
                    'visible' => '(($data->id)!= 1)',

                ),

            ),
        ),
    ),
));

?>
