<?php
$session = new CHttpSession;
?>
<div class="modal hide fade" id="addCompanyContactModal" style="width: 700px;">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'add-company-contact-form',
        'htmlOptions' => array('style'=>'margin: 0px;'),
        'enableAjaxValidation'=>false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError){
                if (!hasError){ // no errors
                    sendCompanyContactForm();
                } else { // has error
                    return false;
                }
            }'
        ),

    )); ?>

    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <h3 id="myModalLabel">Add Company </h3>
    </div>
    <div id="addCompanyContactModalBody" class="modal-body form">
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <input type="hidden" value="<?php echo $tenant;?>" name="CompanyTenant"/>
        <input type="hidden" name="CompanySelectedId" value="" id="CompanySelectedId"/>
        <input type="hidden" name="typePostForm" value="company" id="typePostForm"/>
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="width:60px;" ><?php echo $form->labelEx($model,'companyName'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'companyName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Company Name', 'class' => 'ui-autocomplete-input company-autocomplete', 'autocomplete' => 'on')); ?>
                                <?php echo "<br>" . $form->error($model, 'companyName'); ?>
                            </td>
                        </tr>

                        <tr class="hidden">
                            <td ><?php echo $form->labelEx($model,'companyType'); ?></td>
                            <td>
                                <?php /*if (Yii::app()->controller->id == 'visitor' && in_array(Yii::app()->controller->action->id, array('addvisitor', 'create'))) {
                        echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type', 'disabled' => 'disabled', 'options' => array('3' => array('selected' => true))));
                    } elseif (Yii::app()->controller->id == 'visit' && in_array(Yii::app()->controller->action->id, array('detail'))) {
                        echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type', 'disabled' => 'disabled', 'options' => array('3' => array('selected' => true))));
                    } else {
                        echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type'));
                    }*/?>
                                <?php echo $form->dropDownList($model, 'companyType', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a company type', 'placeholder' => 'Company Type', 'disabled' => 'disabled', 'options' => array('3' => array('selected' => true)))); ?>
                                <?php echo "<br>" . $form->error($model, 'companyType');?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="" rowspan="" headers="">
                                <a style="margin-left: 25px;" class="btn btn-default" href="javascript:void(0)" role="button" id="showCompanyContactFields">+</a>
                            </td>
                            <td style="width:200px; padding-left: 9px;">
                                Add Company Contact
                            </td>

                        </tr>
                        <tr class="company_contact_field hidden">
                            <td ><?php echo $form->labelEx($model,'firstName'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'firstName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                                <?php echo "<br>" . $form->error($model, 'firstName'); ?>
                            </td>
                        </tr>
                        <tr class="company_contact_field hidden">
                            <td ><?php echo $form->labelEx($model,'lastName'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'lastName', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                                <?php echo "<br>" . $form->error($model, 'lastName'); ?>
                            </td>
                        </tr>

                        <tr class="company_contact_field hidden">
                            <td ><?php echo $form->labelEx($model,'email'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>
                                <?php echo "<br>" . $form->error($model, 'email'); ?>
                            </td>
                        </tr>

                        <tr class="company_contact_field hidden">
                            <td><?php echo $form->labelEx($model,'mobile'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'mobile', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Mobile Number')); ?>
                                <?php echo "<br>" . $form->error($model, 'mobile'); ?>
                            </td>
                        </tr>
                    </table><!-- Company infor -->
<!--                    <div class="password-border hidden" style="float: right; margin-right: 3px; margin-top: -187px; max-width:275px !important;">
                        <table style="float:left; width:300px;">
                            <tr>
                                <td><strong>Password Options</strong></td>
                            </tr>
                            <tr>
                                <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select One Option</td>
                            </tr>
                            <tr>

                                <td>
                                    <?php /*echo $form->radioButtonList($model, 'password_requirement',
                                        array(
                                            PasswordRequirement::PASSWORD_IS_NOT_REQUIRED => 'User does not require Password',
                                            PasswordRequirement::PASSWORD_IS_REQUIRED => 'User requires Password to Login',
                                        ), array('class' => 'password_requirement form-label', 'style' => 'float:left;margin-right:10px;', 'separator' => ''));*/
                                    ?>
                                    <?php //echo $form->error($model, 'password_requirement'); ?>
                                </td>
                            </tr>
                            <tr style="display:none;" class="user_requires_password">
                                <td>
                                    <table
                                        style="margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none;margin-left: 30px;">

                                        <tr>
                                            <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select Atleast
                                                One option
                                            </td>
                                        </tr>
                                        <tr id="third_option" class='hiddenElement'></tr>
                                        <tr>
                                            <td><input class="pass_option" id="pass_option_0" type="radio" name="Company[password_option]" value="1"/>&nbsp;Send
                                                User Invitation
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-bottom:10px">
                                                <input class="pass_option" id="pass_option_1" type="radio" name="Company[password_option]" value="2"/>
                                                &nbsp;Create Password
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <?php //echo $form->passwordField($model, 'user_password', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Password')); ?>
                                                <span class="required">*</span>
                                                <?php //echo "<br>" . $form->error($model, 'user_password'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php //echo $form->passwordField($model, 'user_repeatpassword', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Repeat Password')); ?>
                                                <span class="required">*</span>
                                                <?php //echo "<br>" . $form->error($model, 'user_repeatpassword'); ?>
                                                <?php //echo '<div id="AddCompanyContactForm_user_passwordmatch_em_" class="errorMessage" style="display:none"></div>'?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <?php //$background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                                <div class="row buttons" style="text-align:center;">
                                                    <input onclick="generatepassword();" class="complete btn btn-info" type="button" value="Autogenerate Password"
                                                           style="<?php //echo $background; ?>position: relative; width: 180px; overflow: hidden;cursor:pointer;font-size:14px;margin-right:8px;"/>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>  password-border -->
                </td>
            </tr>
        </table>


    </div>
    <div class="modal-footer">
        <button class="btn neutral" id="btnCloseModalAddCompanyContact" data-dismiss="modal" aria-hidden="true">Close</button>
        <button type="button" id="btnAddCompanyContact" class="btn complete">Save</button>
        <button type="submit" id="btnAddCompanyContactConfirm" class="hidden"></button>
    </div>
<?php $this->endWidget(); ?>
</div>

<?php
    //$companyList = CHtml::listData(Company::model()->findAll(), 'id', 'name');
    //All the companies list is displayed for any tenant --- CAVMS-826
    $companyList = CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']), 'id', 'name');
    $companyList = array_unique($companyList);
    $listsCom = implode('", "', $companyList);
?>

<script>
    function addCompanyContactForm(){
         
        return "#add-company-contact-form ";
    }
    $(function() {
        $(document).on('click', '#showCompanyContactFields', function(e) {
            $("tr.company_contact_field").toggleClass("hidden");
            $("#add-company-contact-form .password-border").toggleClass("hidden");

        });

        $(document).on('click', '#btnAddCompanyContact', function(e) {
            e.preventDefault();
            $(addCompanyContactForm() + "tr.company_contact_field").removeClass('hidden');
            //$(addCompanyContactForm() + '.password-border').removeClass('hidden');
            var inputs = $(addCompanyContactForm())
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

    $(function() {
        var availableTags = ["<?php echo $listsCom; ?>"];
        $(".company-autocomplete").autocomplete({
            source: availableTags,
            select: function(event, ui) {
                event.preventDefault();
                $(".company-autocomplete").val(ui.item.label);
                $('#typePostForm').val('contact');
            }
        });
        $(".ui-front").css("z-index", 1051);
    });

    $(document).ready(function(){
        $("#AddCompanyContactForm_companyName").keypress(function(){
            $('#typePostForm').val('company');
        })
    });

    function sendCompanyContactForm() {
        var currentController = "<?php echo Yii::app()->controller->id; ?>";
        var currentAction = "<?php echo Yii::app()->controller->action->id; ?>";
        if($("#AddCompanyContactForm_companyType").attr("disabled") == "disabled" && $("#AddCompanyContactForm_companyType").val() != ""){
            var formInfo = $("#add-company-contact-form").serialize()+ "&AddCompanyContactForm%5BcompanyType%5D=" + $("#AddCompanyContactForm_companyType").val();
        } else {
            var formInfo = $("#add-company-contact-form").serialize();
        }
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('company/addCompanyContact') ?>",
            dataType: "json",
            data: formInfo,

            success: function(data) {
                $("#addCompanyContactModal").modal("hide");
                if (data.type == "contact") {
                    //$("#visitorStaffRow").html(data.contactDropDown);
                     $("#Visitor_staff_id").append(data.contactDropDown).val(data.id);
                     $('#Visitor_staff_id').trigger('change');
                } else {
                    //update company dropdown:
                    if(currentController == "visit" && currentAction == "detail") {
                         $("#AddAsicEscort_company").prepend($("<option>", {value:data.id, text: data.name}));
                      //  $("#AddAsicEscort_company").select2("val", data.id); // deprecated
                         $("#AddAsicEscort_company").val(data.id);
                         $("#asicSponsorModal").modal("show");
                         $('#asicSponsorModal').trigger('change');
                    } else if (currentController == "visitor"){
                         $("#Visitor_company").prepend($("<option>", {value:data.id, text: data.name}));
                        // $("#Visitor_company").select2("val", data.id);
                         $("#Visitor_company").val(data.id);
                         $('#Visitor_company').trigger('change');
                         
                        $("#User_company").prepend($("<option>", {value:data.id, text: data.name}));
                        //$("#User_company").select2("val", data.id);
                        $("#User_company").val(data.id);
                        $('#User_company').trigger('change');
                    }
                }
                return false;
            }
        }).fail(function() {
            //window.location = '<?php echo Yii::app()->createUrl('site/login');?>';
        });
    }

</script>