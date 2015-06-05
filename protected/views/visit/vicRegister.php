<style>
    .header-form {
        min-width: 70px !important;
    }
</style>

<?php

/* @var $this VisitController */
/* @var $model Visit */
?>

<h1>VIC Register</h1>

<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete')); ?>

<?php
$form=$this->beginWidget('CActiveForm', array(
    'id' => 'filterProperties',
    'action' => Yii::app()->createUrl($this->route),
    'enableAjaxValidation' => true,
    'method' => 'get',
    'htmlOptions' => array('style' => 'margin: 0px')
)); ?>

<div class="row" style="margin-left: 224px">
    <?php echo 'Search: '; ?>
    <?php echo $form->textField($model,'filterProperties',array('size'=>40,'maxlength'=>70)); ?>
    <?php echo CHtml::submitButton('Search', array('style' => 'margin-bottom: 10px')); ?>
    <?php echo '&nbsp|&nbsp&nbsp'; echo CHtml::link('Reset Filter', Yii::app()->createUrl($this->route)); ?>
</div>
<?php $this->endWidget();

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'vic-register',
    'dataProvider' => $model->search($merge),
    'enableSorting' => false,
    //'ajaxUpdate'=>true,
    'hideHeader'=>true,
    'filter' => $model,
    'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
    'columns' => array(
        array(
            'type' => 'raw',
            'value' => '"<a class=\'statusLink\' href=\'" . Yii::app()->createUrl("visitor/update&id=" . $data->id) . "\'>Edit</a>"',
        ),
        array(
            'name' => 'id',
            'filter'=>CHtml::activeTextField($model, 'id', array('placeholder'=>'Visitor ID', 'class' => 'header-form')),
        ),
        array(
            'name' => 'company0.code',
            'filter'=>CHtml::activeTextField($model, 'companycode', array('placeholder'=>'Company Code', 'class' => 'header-form')),
        ),
        array(
            'name' => 'first_name',
            'filter'=>CHtml::activeTextField($model, 'first_name', array('placeholder'=>'First Name', 'class' => 'header-form')),
        ),
        array(
            'name' => 'last_name',
            'filter'=>CHtml::activeTextField($model, 'last_name', array('placeholder'=>'Last Name', 'class' => 'header-form')),
        ),
        array(
            'name' => 'date_of_birth',
            'filter'=>CHtml::activeTextField($model, 'date_of_birth', array('placeholder'=>'DOB', 'class' => 'header-form')),
        ),
        array(
            'name' => 'contact_number',
            'filter'=>CHtml::activeTextField($model, 'contact_number', array('placeholder'=>'Mobile', 'class' => 'header-form')),
        ),
        array(
            'name' => 'contact_street_no',
            'filter'=>CHtml::activeTextField($model, 'contact_street_no', array('placeholder'=>'Street No', 'class' => 'header-form')),
        ),
        array(
            'name' => 'contact_street_name',
            'filter'=>CHtml::activeTextField($model, 'contact_street_name', array('placeholder'=>'Street', 'class' => 'header-form')),
        ),
        array(
            'name' => 'contact_street_type',
            'filter'=>CHtml::activeTextField($model, 'contact_street_type', array('placeholder'=>'Street Type', 'class' => 'header-form')),
        ),
        array(
            'name' => 'contact_suburb',
            'filter'=>CHtml::activeTextField($model, 'contact_suburb', array('placeholder'=>'Suburbe', 'class' => 'header-form')),
        ),
        array(
            'name' => 'contact_postcode',
            'filter'=>CHtml::activeTextField($model, 'contact_postcode', array('placeholder'=>'Postcode', 'class' => 'header-form')),
        ),
        array(
            'name' => 'company0.name',
            'filter'=>CHtml::activeTextField($model, 'company', array('placeholder'=>'Company Name', 'class' => 'header-form')),
        ),
        array(
            'name' => 'email',
            'filter'=>CHtml::activeTextField($model, 'email', array('placeholder'=>'Contact Email', 'class' => 'header-form')),
        ),
        array(
            'name' => 'identification_type',
            'filter'=>CHtml::activeTextField($model, 'identification_type', array('placeholder'=>'Document Type', 'class' => 'header-form')),
        ),
        array(
            'name' => 'identification_document_no',
            'filter'=>CHtml::activeTextField($model, 'identification_document_no', array('placeholder'=>'Number', 'class' => 'header-form')),
        ),
        array(
            'name' => 'identification_document_expiry',
            'filter'=>CHtml::activeTextField($model, 'identification_document_expiry', array('placeholder'=>'Expiry', 'class' => 'header-form')),
        ),
        array(
            'name' => 'asic_no',
            'filter'=>CHtml::activeTextField($model, 'asic_no', array('placeholder'=>'ASIC ID Number', 'class' => 'header-form')),
        ),
        array(
            'name' => 'asic_expiry',
            'filter'=>CHtml::activeTextField($model, 'asic_expiry', array('placeholder'=>'ASIC Expiry', 'class' => 'header-form')),
        ),
    ),
));

?>

<script>
    $(document).ready(function() {
        if ($("#totalRecordsCount").val() == 0) {
            $('#export-button').removeClass('greenBtn');
            $('#export-button').addClass('btn DeleteBtn actionForward');
            $("#export-button").attr('disabled', true);
        }

        $('#export-button').on('click', function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('vic-register', {
                success: function() {
                    $('#vic-register').removeClass('grid-view-loading');
                    window.location = '<?php echo $this->createUrl('exportFileVicRegister'); ?>';
                },
                data: $('#vic-register').serialize() + '&export=true'
            });
        }

    });
</script>