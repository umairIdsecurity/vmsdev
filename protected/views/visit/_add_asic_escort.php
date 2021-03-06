<?php $form=$this->beginWidget('CActiveForm', array(
    'id' => 'add-asic-escort-form',
    'htmlOptions' => array('style' => 'margin-left: 0px;'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError){
                if (!hasError){ // no errors
                } else { // has error
                    return false;
                }
            }'
    ),

)); ?>
<style type="text/css">
    .addcompanymenu{   background-position-x: 3px !important;background-position-y: 5px !important;}
</style>
    <table>
        <tr>
            <td class="asic-escort-field">
                <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                <span class="required">*</span>
                <?php echo  "<br>" .$form->error($model, 'first_name'); ?>

            </td>
            <td class="asic-escort-field">
                <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                <span class="required">*</span>
                <?php echo "<br>" .$form->error($model, 'last_name'); ?>
            </td>
        </tr>
        <tr>
            <td class="asic-escort-field">
                <?php echo $form->textField($model, 'asic_no', array('size' => 50, 'maxlength' => 50,'placeholder'=>'ASIC No')); ?>
                <span class="required">*</span>
                <?php echo "<br>" .$form->error($model, 'asic_no'); ?>
            </td>
            <td class="asic-escort-field">
                <?php $this->widget('EDatePicker', array(
                    'model' => $model,
                    'attribute' => 'asic_expiry',
                    'mode' => 'asic_expiry',
                )); ?>
                <span class="required">*</span>
                <?php echo "<br>" .$form->error($model, 'asic_expiry'); ?>
            </td>
        </tr>
        <tr>
            <td class="asic-escort-field">
                <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact No')); ?>
                <span class="required">*</span>
                <?php echo "<br>" .$form->error($model, 'contact_number'); ?>
            </td>
            <td class="asic-escort-field">
                <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email Address')); ?>
                <span class="required">*</span>
                <?php echo "<br>" .$form->error($model, 'email'); ?>
                <div id="AddAsicEscort_email_unique_em_" class="errorMessage" style="display: none;">Email is existed.</div>
            </td>
        </tr>
        <tr>
            <td class="asic-escort-field">
                <?php
                $this->widget('application.extensions.select2.Select2', array(
                    'model' => $model,
                    'attribute' => 'company',
                    'items' => CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']),
                        'id', 'name'),
                    'selectedItems' => array(), // Items to be selected as default
                    'placeHolder' => 'Please select a company'
                ));
                ?>
                <span class="required">*</span>
                <?php echo "<br>" .$form->error($model, 'company', array("style" => "margin-top:0px")); ?>
                <div>
                    <a style="margin-top: 15px; margin-right: 5px; width: 95px; height: 21px; text-align: center;" href="#addCompanyContactModal" role="button" data-toggle="modal" id="addCompanyLink">Add Company</a>
                </div>

            </td>
            <td><td>
    </table>

<?php $this->endWidget(); ?>


