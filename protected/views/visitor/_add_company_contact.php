<div class="modal hide fade" id="addCompanyContactModal" style="width: 520px;">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'add-company-contact-form',
        'htmlOptions' => array('style'=>'margin: 0px;'),
        'enableAjaxValidation'=>false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError){
                if (!hasError){ // no errors
                    $.ajax({
                        type: "POST",
                        url: "' . $this->createUrl('company/addCompanyContact') .'",
                        dataType: "json",
                        data: $("#add-company-contact-form").serialize(),
                        success: function(data) {
                            $("#addCompanyContactModal").modal("hide");

                            //update company dropdown:
                            $("#Visitor_company").append($("<option>", {value:data.id, text: data.name}));
                            $("#Visitor_company").select2("val", data.id);

                            $("#visitorStaffRow").html(data.contactDropDown);

                            return false;
                        }
                    });
                } else { // has error
                    return false;
                }
            }'
        ),

    )); ?>

    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <h3 id="myModalLabel">Add Company</h3>
    </div>
    <div id="addCompanyContactModalBody" class="modal-body form">
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <input type="hidden" value="<?php echo $tenant;?>" name="CompanyTenant"/>
        <input type="hidden" name="CompanySelectedId" value="" id="CompanySelectedId"/>

        <table>
            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model,'companyName'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'companyName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Company Name')); ?>
                    <?php echo "<br>" . $form->error($model, 'companyName'); ?>
                </td>
            </tr>
            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model,'firstName'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'firstName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                    <?php echo "<br>" . $form->error($model, 'firstName'); ?>
                </td>
            </tr>
            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model,'lastName'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'lastName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                    <?php echo "<br>" . $form->error($model, 'lastName'); ?>
                </td>
            </tr>

            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model,'email'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>
                    <?php echo "<br>" . $form->error($model, 'email'); ?>
                </td>
            </tr>

            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model,'mobile'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'mobile', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Mobile Number')); ?>
                    <?php echo "<br>" . $form->error($model, 'mobile'); ?>
                </td>
            </tr>
        </table>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Save</button>
    </div>
<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $('#addCompanyContactModal').on('hidden', function () {
        $("#add-company-contact-form").find("input[type=text]").val("");
    })
    $('#addCompanyContactModal').on('show', function () {
        if ($('#CompanySelectedId').val() == "") {
            $('#AddCompanyContactForm_companyName').removeProp('disabled');
        }
    })
</script>