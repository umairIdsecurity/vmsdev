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

<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete'));?>

<?php
$form = $this->beginWidget('CActiveForm', array(
	'id'                   => 'filterProperties',
	'action'               => Yii::app()->createUrl($this->route),
	'enableAjaxValidation' => true,
	'method'               => 'get',
	'htmlOptions'          => array('style' => 'margin: 0px'),
));?>

<div class="row" style="margin-left: 224px">
    <?php echo 'Search: ';?>
    <?php echo $form->textField($model, 'filterProperties', array('size' => 40, 'maxlength' => 70));?>
    <?php echo CHtml::submitButton('Search', array('style' => 'margin-bottom: 10px'));?>
    <?php echo '&nbsp|&nbsp&nbsp';
echo CHtml::link('Reset Filter', Yii::app()->createUrl($this->route));?>
</div>
<?php $this->endWidget();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'              => 'vic-register',
	'dataProvider'    => $model->search($merge),
	'enableSorting'   => false,
	//'ajaxUpdate'=>true,
	'hideHeader'      => true,
	'filter'          => $model,
	'afterAjaxUpdate' => "
    function(id, data) {
        $('th > .asc').append('<div></div>');
        $('th > .desc').append('<div></div>');
    }",
	'columns'         => array(
		array(
			'type'  => 'raw',
			'value' => '"<a class=\'statusLink\' href=\'" . Yii::app()->createUrl("visit/detail&id=" . $data->id) . "\'>Edit</a>"',
		),
		array(
			'name'   => 'id',
			'filter' => CHtml::activeTextField($model, 'id', array('placeholder' => 'ID', 'class' => 'header-form')),
		),
		array(
			'name'   => 'cardnumber',
			'value'  => 'isset($data->card0->card_number) ? $data->card0->card_number : ""',
			'filter' => CHtml::activeTextField($model, 'cardnumber', array('placeholder' => 'Card Number', 'class' => 'header-form')),
		),
		array(
			'name'   => 'companycode',
			'value'  => 'isset($data->company0->code) ? $data->company0->code : ""',
			'filter' => CHtml::activeTextField($model, 'companycode', array('placeholder' => 'Tenant Code', 'class' => 'header-form')),
		),
		array(
			'name'   => 'firstname',
			'value'  => '$data->visitor0->first_name',
			'filter' => CHtml::activeTextField($model, 'firstname', array('placeholder' => 'First Name', 'class' => 'header-form')),
		),
		array(
			'name'   => 'lastname',
			'value'  => '$data->visitor0->last_name',
			'filter' => CHtml::activeTextField($model, 'lastname', array('placeholder' => 'Last Name', 'class' => 'header-form')),
		),
		array(
			'name'   => 'date_of_birth',
			'value'  => 'date("d-m-Y", strtotime($data->visitor0->date_of_birth))',
			'filter' => CHtml::activeTextField($model, 'date_of_birth', array('placeholder' => 'DOB', 'class' => 'header-form')),
		),
        array(
            'name'   => 'contactnumber',
            'value'  => '$data->visitor0->contact_number',
            'filter' => CHtml::activeTextField($model, 'contactnumber', array('placeholder' => 'Mobile', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contact_street_no',
            'value'  => '$data->visitor0->contact_street_no',
            'filter' => CHtml::activeTextField($model, 'contact_street_no', array('placeholder' => 'Street No', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contact_street_name',
            'value'  => '$data->visitor0->contact_street_name',
            'filter' => CHtml::activeTextField($model, 'contact_street_name', array('placeholder' => 'Street', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contact_street_type',
            'value'  => '$data->visitor0->contact_street_type',
            'filter' => CHtml::activeTextField($model, 'contact_street_type', array('placeholder' => 'Street Type', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contact_suburb',
            'value'  => '$data->visitor0->contact_suburb',
            'filter' => CHtml::activeTextField($model, 'contact_suburb', array('placeholder' => 'Suburbe', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contact_state',
            'value'  => '$data->visitor0->contact_state',
            'filter' => CHtml::activeTextField($model, 'contact_state', array('placeholder' => 'State', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contact_postcode',
            'value'  => '$data->visitor0->contact_postcode',
            'filter' => CHtml::activeTextField($model, 'contact_postcode', array('placeholder' => 'Postcode', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'company0.name',
            'value'  => 'isset($data->company0->name) ? $data->company0->name : ""',
            'filter' => CHtml::activeTextField($model, 'company', array('placeholder' => 'Company Name', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contactperson',
            'value'  => 'isset($data->company0->contact) ? $data->company0->contact : ""',
            'filter' => CHtml::activeTextField($model, 'contactperson', array('placeholder' => 'Contact Person', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contactphone',
            'value'  => 'isset($data->visitor0->staff_id) ? User::model()->findByPk($data->visitor0->staff_id)->contact_number : ""',
            'filter' => CHtml::activeTextField($model, 'contactphone', array('placeholder' => 'Contact Phone', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'contactemail',
            'value'  => 'isset($data->company0->email_address) ? $data->company0->email_address : ""',
            'filter' => CHtml::activeTextField($model, 'contactemail', array('placeholder' => 'Contact Email', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'finish_date',
            'filter' => CHtml::activeTextField($model, 'finish_date', array('placeholder' => 'Date of Issue', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'identification_type',
            'value'  => '$data->visitor0->identification_type',
            'filter' => CHtml::activeTextField($model, 'identification_type', array('placeholder' => 'Document Type', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'identification_document_no',
            'value'  => '$data->visitor0->identification_document_no',
            'filter' => CHtml::activeTextField($model, 'identification_document_no', array('placeholder' => 'Number', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'identification_document_expiry',
            'value'  => 'date("d-m-Y", strtotime($data->visitor0->identification_document_expiry))',
            'filter' => CHtml::activeTextField($model, 'identification_document_expiry', array('placeholder' => 'Expiry', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'asicname',
            'value'  => 'isset($data->getHost()->fullName) ? $data->getHost()->fullName : ""',
            'filter' => CHtml::activeTextField($model, 'asicname', array('placeholder' => 'ASIC Name', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'asic_no',
            'value'  => '$data->visitor0->asic_no',
            'filter' => CHtml::activeTextField($model, 'asic_no', array('placeholder' => 'ASIC ID Number', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'asic_expiry',
            'value'  => '$data->visitor0->asic_expiry ? date("d-m-Y", strtotime($data->visitor0->asic_expiry)): $data->visitor0->asic_expiry',
            'filter' => CHtml::activeTextField($model, 'asic_expiry', array('placeholder' => 'ASIC Expiry', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'workstation',
            'value'  => 'isset(Workstation::model()->findByPk($data->workstation)->name) ? Workstation::model()->findByPk($data->workstation)->name : ""',
            'filter' => CHtml::activeTextField($model, 'workstation', array('placeholder' => 'Workstation', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'card_returned_date',
            'filter' => CHtml::activeTextField($model, 'card_returned_date', array('placeholder' => 'Date Card Returned/Lost', 'class' => 'header-form')),
        ),
        array(
            'name'   => 'police_report_number',
            'value'  => '$data->police_report_number',
            'filter' => CHtml::activeTextField($model, 'police_report_number', array('placeholder' => 'Police Report Number', 'class' => 'header-form')),
        ),
        array(
            'type'   => 'raw',
            'name'   => 'card_lost_declaration_file',
            'value'  => '
                !empty($data->card_lost_declaration_file) ? CHtml::link("Download", $data->card_lost_declaration_file, ["style" => "text-align:center;"]) : "";
            ',
            'filter' => CHtml::activeTextField($model, 'card_lost_declaration_file', array('placeholder' => 'Police Report or Declaration', 'class' => 'header-form')),
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
                    window.location = '<?php echo $this->createUrl('exportFileVicRegister');?>';
                },
                data: $('#vic-register').serialize() + '&export=true'
            });
        }

    });
</script>