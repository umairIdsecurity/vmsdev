<form></form>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id' => 'add-asic-escort-form',
    'htmlOptions' => array('style' => 'margin-left: 0px;'),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError){
                if (!hasError){ // no errors
                    $.ajax({
                        type: "POST",
                        url: "' . $this->createUrl('') . '",
                        dataType: "json",
                        data: $("#add-asic-escort-form").serialize(),
                        success: function(data) {
                            return false;
                        }
                    });
                } else { // has error
                    return false;
                }
            }'
    ),

)); ?>
    <table>
        <tr>
            <td class="asic-escort-field">
                <?php echo $form->textField($model, 'firstName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                <?php echo $form->textField($model, 'lastName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                <span class="required">*</span>
                <?php echo "<br>" . $form->error($model, 'firstName'); ?>
                <?php echo "" . $form->error($model, 'lastName'); ?>

                <?php echo "<br>" . $form->textField($model, 'asic_no', array('size' => 50, 'maxlength' => 50,'placeholder'=>'ASIC No')); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'expiry',
                    'options' => array(
                        'dateFormat' => 'dd-mm-yy',
                    ),
                    'htmlOptions' => array(
                        'maxlength' => '10',
                        'placeholder' => 'Expiry',
                        'style' => 'width: 205px;',
                    ),
                )); ?>
                <span class="required">*</span>
                <?php echo "<br>" . $form->error($model, 'asic_no'); ?>
                <?php echo "" . $form->error($model, 'expiry'); ?>

                <?php echo "<br>" . $form->textField($model, 'contact_no', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact No')); ?>
                <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email Address')); ?>
                <span class="required">*</span>
                <?php echo "<br>" . $form->error($model, 'contact_no'); ?>
                <?php echo "" . $form->error($model, 'email'); ?>
            </td>
    </table>

<?php $this->endWidget(); ?>


