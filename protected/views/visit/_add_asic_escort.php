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
        <tr class="asic-escort hidden">
            <td>
                <?php echo $form->textField($model, 'firstName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                <?php echo $form->textField($model, 'lastName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                <span class="required">*</span>
                <?php echo "<br>" . $form->error($model, 'firstName'); ?>
                <?php echo "" . $form->error($model, 'lastName'); ?>
            </td>
        </tr>
        <tr class="asic-escort hidden">
            <td>
                <?php echo $form->textField($model, 'asic_no', array('size' => 50, 'maxlength' => 50,'placeholder'=>'ASIC No')); ?>
                <?php echo $form->textField($model, 'expiry', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Expiry')); ?>
                <span class="required">*</span>
                <?php echo "<br>" . $form->error($model, 'asic_no'); ?>
                <?php echo "" . $form->error($model, 'expiry'); ?>
            </td>
        </tr>
        <tr class="asic-escort hidden">
            <td>
                <?php echo $form->textField($model, 'contact_no', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact No')); ?>
                <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email Address')); ?>
                <span class="required">*</span>
                <?php echo "<br>" . $form->error($model, 'contact_no'); ?>
                <?php echo "" . $form->error($model, 'email'); ?>
            </td>
        </tr>
    </table>

<?php $this->endWidget(); ?>
