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

                    var currentController = "'.Yii::app()->controller->id.'";
                    var currentAction = "'.Yii::app()->controller->action->id.'";
                    if($("#AddCompanyContactForm_companyType").attr("disabled") == "disabled" && $("#AddCompanyContactForm_companyType").val() != ""){
                        var formInfo = $("#add-company-contact-form").serialize()+ "&AddCompanyContactForm%5BcompanyType%5D=" + $("#AddCompanyContactForm_companyType").val();
                    } else {
                        var formInfo = $("#add-company-contact-form").serialize();
                    }
                    $.ajax({
                        type: "POST",
                        url: "' . $this->createUrl('company/addCompanyContact') .'",
                        dataType: "json",
                        data: formInfo,

                        success: function(data) {
                            $("#addCompanyContactModal").modal("hide");
                            if (data.type == "contact") {
                                //$("#visitorStaffRow").html(data.contactDropDown);
                                $("#Visitor_staff_id").append(data.contactDropDown).val(data.id);
                            } else {
                                //update company dropdown:
                                if(currentController == "visit" && currentAction == "detail") {
                                    $("#AddAsicEscort_company").prepend($("<option>", {value:data.id, text: data.name}));
                                    $("#AddAsicEscort_company").select2("val", data.id);
                                    $("#asicSponsorModal").modal("show");
                                } else if (currentController == "visitor"){
                                    $("#Visitor_company").prepend($("<option>", {value:data.id, text: data.name}));
                                    $("#Visitor_company").select2("val", data.id);
                                }
                            }
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
        <input type="hidden" name="typePostForm" value="company" id="typePostForm"/>

        <table>
            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model,'companyName'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'companyName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Company Name')); ?>
                    <?php echo "<br>" . $form->error($model, 'companyName'); ?>
                </td>
            </tr>
            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model,'companyType'); ?></td>
                <td>
                    <?php if (Yii::app()->controller->id == 'visitor' && in_array(Yii::app()->controller->action->id, array('addvisitor', 'create'))) {
                        echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type', 'disabled' => 'disabled', 'options' => array('3' => array('selected' => true))));
                    } elseif (Yii::app()->controller->id == 'visit' && in_array(Yii::app()->controller->action->id, array('detail'))) {
                        echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type', 'disabled' => 'disabled', 'options' => array('3' => array('selected' => true))));
                    } else {
                        echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type'));
                    }?>
                    <?php echo "<br>" . $form->error($model, 'companyType');?>
                </td>
            </tr>
            <tr>
                <td style="width:200px; padding-left: 9px;">
                    <a class="btn btn-default" href="javascript:void(0)" role="button" id="showCompanyContactFields">+</a> Add Company Contact
                </td>
                <td colspan="" rowspan="" headers="">&nbsp;</td>
            </tr>
            <tr class="company_contact_field hidden">
                <td style="width:160px;"><?php echo $form->labelEx($model,'firstName'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'firstName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                    <?php echo "<br>" . $form->error($model, 'firstName'); ?>
                </td>
            </tr>
            <tr class="company_contact_field hidden">
                <td style="width:160px;"><?php echo $form->labelEx($model,'lastName'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'lastName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                    <?php echo "<br>" . $form->error($model, 'lastName'); ?>
                </td>
            </tr>

            <tr class="company_contact_field hidden">
                <td style="width:160px;"><?php echo $form->labelEx($model,'email'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>
                    <?php echo "<br>" . $form->error($model, 'email'); ?>
                </td>
            </tr>

            <tr class="company_contact_field hidden">
                <td style="width:160px;"><?php echo $form->labelEx($model,'mobile'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'mobile', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Mobile Number')); ?>
                    <?php echo "<br>" . $form->error($model, 'mobile'); ?>
                </td>
            </tr>
        </table>

    </div>
    <div class="modal-footer">
        <button class="btn" id="btnCloseModalAddCompanyContact" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="button" id="btnAddCompanyContact" class="btn btn-primary">Save</button>
        <button type="submit" id="btnAddCompanyContactConfirm" class="hidden"></button>
    </div>
<?php $this->endWidget(); ?>
</div>
<script>
    $(function() {
        $(document).on('click', '#showCompanyContactFields', function(e) {
            $("tr.company_contact_field").toggleClass("hidden");
        });

        $(document).on('click', '#btnAddCompanyContact', function(e) {
            e.preventDefault();
            $("tr.company_contact_field").removeClass('hidden');
            var inputs = $('#add-company-contact-form')
                .not('input[type="hidden"]')
                .find('input[type="text"]');
            var flag = true;

            $.each(inputs, function(i, input) {
                if (input == '') {
                    flag = false;
                    return;
                }
            });
            
            if (flag == true) {
                $('#btnAddCompanyContactConfirm').click();
            }
        });
    });
</script>