<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */


$session = new CHttpSession;
$tenant = '';
$tenantAgent = '';
if (isset($_GET['tenant'])) {
    $tenant = $_GET['tenant'];
} elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
    $tenant = $session['tenant'];
}

if (isset($_GET['tenant_agent'])) {
    $tenantAgent = $_GET['tenant_agent'];
} elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
    $tenantAgent = $session['tenant_agent'];
}

$dataId = '';
if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'company-form',
        'htmlOptions' => array("name" => "registerform"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError) {
                if (!hasError) {
                    if($("#currentAction").val() == "create"){
                        if ($("#company-form .password_requirement").is(":checked")== false) {
                            $("#company-form #pass_error_").show();
                            return false;
                        } else {
                            if ($("#Company_password_requirement_1").is(":checked")) {
                                if($(createCompanyForm()+".pass_option").is(":checked") == false) {
                                    $(createCompanyForm()+".user_requires_password #pass_error_").show();
                                    return false;
                                } else {
                                    $(createCompanyForm()+".user_requires_password #pass_error_").hide();
                                    if($(createCompanyForm()+"#pass_option_1").is(":checked")) {
                                        var validatePass = validatePassword();
                                        if(validatePass == true) {
                                            var isMatch = isPasswordMatch();
                                            if(isMatch == true) {
                                                checkCompanyNameUnique();
                                            } else {
                                                return false;
                                            }
                                        } else {
                                            return false;
                                        }
                                    }else {
                                        checkCompanyNameUnique();
                                    }
                                }
                            } else {
                                checkCompanyNameUnique();
                            }
                        }
                    } else{
                        checkCompanyNameUnique();
                    }
                } else {
                    $(createCompanyForm()+".user_fields" ).show();
                    $(createCompanyForm()+".password-border").show();
                }
            }'
        ),
    ));
    ?>
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }

    if (isset($_GET['viewFrom'])) {
        $isViewedFromModal = $_GET['viewFrom'];
    } else {
        //echo $form->errorSummary($model);
    }
    ?>
    <!--<input type="hidden" id="user_role" name="user_role" value="<?php /*echo $session['role'];  */?>" />-->
    <?php if ($this->action->id != 'update') {
        ?>
        <input type="hidden" id="Company_tenant" name="Company[tenant]" value="<?php echo $tenant; ?>">
        <input type="hidden" id="Company_tenant_agent" name="Company[tenant_agent]" value="<?php echo $tenantAgent; ?>">

    <?php } else {
        ?>
        <input type="hidden" id="Company_tenant_" name="Company[tenant_]" value="<?php echo $model['tenant']; ?>">
        <input type="hidden" id="Company_tenant_agent_" name="Company[tenant_agent_]" value="<?php echo $model['tenant_agent']; ?>">

    <?php
    }
    ?>
    <table>
            <tr>
                <td>
                    <table>
                        <tr class="user_fields1">
                            <td style="width:160px;">&nbsp;</td>
                            <td style="width:240px;">
                                <?php
                                echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150, 'placeholder' => 'Company Name'));
                                echo '<span class="required"> *</span><br>';
                                echo $form->error($model, 'name');
                                echo '<div id="Company_name_unique_em_" class="errorMessage" style="display: none">Company name has already been taken</div>';
                               ?>
                            </td>
                            <td></td>
                        </tr>

                        <!--WangFu Modified-->
                        <?php if ($session['role'] != Roles::ROLE_ADMIN) { ?>
                            <tr class="user_fields1">
                                <td style="width:160px;">&nbsp;</td>
                                <td style="width:240px;">
                                    <?php
                                    echo $form->textField($model, 'code', array('size' => 3, 'maxlength' => 3, 'placeholder' => 'Company Code'));
                                    if (isset($_GET['viewFrom'])) {
                                        echo "<br>" . $form->error($model, 'code');
                                    }
                                    ?></td>
                                <td><?php
                                    if (!isset($_GET['viewFrom'])) {
                                        echo "<br>" . $form->error($model, 'code');
                                    }
                                    ?></td>

                            </tr>
                        <?php } ?>

                        <!-- <tr class="user_fields1">
            <td style="width:160px;">&nbsp;</td>
            <td style="width:240px;">
                <?php //echo $form->dropDownList($model, 'company_type', CHtml::listData(CompanyType::model()->findAll(), 'id', 'name'), array('prompt'=>'Select a company type', 'placeholder'=>'Company Type', 'style' => 'width: 228px')); ?>
                <?php //echo "<br>" . $form->error($model, 'company_type'); ?>
            </td>
        </tr> -->

                        <tr>
                            <td style="width:160px;">&nbsp;</td>
                            <td>
                                <a class="btn btn-default" href="#" role="button" id="addContact">+</a> Add Company Contact
                                <input type="hidden" id="is_user_field" name="is_user_field" value="<?php echo $session['is_field'];?>">
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_first_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'user_first_name'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'user_last_name'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'user_email'); ?>
                                <div id="Company_user_email_unique_em_" class="errorMessage" style="display: none">User email has already been taken</div>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_contact_number', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact Number')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'user_contact_number'); ?>
                            </td>
                        </tr>
                        <tr>
                        <td> &nbsp; </td>
                        <td colspan="2"><?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px;', 'class' => 'complete')); ?></td>
                        </tr>
                    </table><!--Company Contact field-->
                    <div class="password-border" style="float: right; margin-right: 147px; margin-top: -230px; max-width:275px !important;">
                        <table style="float:left; width:300px;">
                            <tr>
                                <td><strong>Password Options</strong></td>
                            </tr>
                            <tr>
                                <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select One Option</td>
                            </tr>
                            <tr>

                                <td>
                                    <?php echo $form->radioButtonList($model, 'password_requirement',
                                        array(
                                            PasswordRequirement::PASSWORD_IS_NOT_REQUIRED => 'User does not require Password',
                                            PasswordRequirement::PASSWORD_IS_REQUIRED => 'User requires Password to Login',
                                        ), array('class' => 'password_requirement form-label', 'style' => 'float:left;margin-right:10px;', 'separator' => ''));
                                    ?>
                                    <?php echo $form->error($model, 'password_requirement'); ?>
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
<!--                                                <input placeholder="Password" ng-model="user.passwords" data-ng-class="{-->
<!--                                                                       'ng-invalid':registerform['Company[user_repeatpassword]'].$error.match}"-->
<!--                                                       type="password" id="Company_user_password" name="Company[user_password]">-->
<!--                                                <span class="required">*</span>-->
                                                <?php echo $form->passwordField($model, 'user_password', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Password')); ?>
                                                <span class="required">*</span>
                                                <?php echo "<br>" . $form->error($model, 'user_password'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
<!--                                                <input placeholder="Repeat Password" ng-model="user.passwordConfirm" type="password"-->
<!--                                                       id="Company_user_repeatpassword" data-match="user.passwords"-->
<!--                                                       name="Company[user_repeatpassword]"/>-->
<!--                                                <span class="required">*</span>-->
<!---->
<!--                                                <div style='font-size:0.9em;color:red;position: static;'-->
<!--                                                     data-ng-show="registerform['Company[user_repeatpassword]'].$error.match">Password does-->
<!--                                                    not match with Repeat <br> Password.-->
<!--                                                </div>-->
<!--                                                --><?php //echo "<br>" . $form->error($model, 'user_repeatpassword'); ?>
                                                <?php echo $form->passwordField($model, 'user_repeatpassword', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Repeat Password')); ?>
                                                <span class="required">*</span>
                                                <?php echo "<br>" . $form->error($model, 'user_repeatpassword'); ?>
                                                <?php echo '<div id="Company_user_passwordmatch_em_" class="errorMessage" style="display:none"></div>'?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                                <div class="row buttons" style="text-align:center;">
                                                    <input onclick="generatepassword();" class="complete btn btn-info" type="button" value="Autogenerate Password"
                                                           style="<?php echo $background; ?>position: relative; padding: 3px 6px 5px; overflow: hidden;cursor:pointer;font-size:14px;margin-right:8px;"/>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>                                  
                                </td>                               
                            </tr>


                        </table>
                    </div> <!-- password-border -->               
                </td>
            </tr>
    </table>
    <!--Company Contact-->


    <div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
        margin-left:173px;
    <?php
    } else {
        echo "text-align: right;";
    }
    ?>">        
        <?php // echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px;', 'class' => 'complete')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>

        <?php
        } else {
        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
            ?>
<!--            <button class="yiiBtn neutral" id="modalBtn" style="padding:1.5px 6px;margin-top:-4.1px;height:30.1px;" data-target="#viewLicense" data-toggle="modal">View License Details</button>-->
        <?php } else { ?>
<!--        <button class="yiiBtn actionForward" style="padding:2px 6px;margin-top:-4.1px;height:30.1px;" type='button' onclick="gotoLicensePage()">License Details</button>-->
        <?php
            }
        }
        ?>
    </div>
 <?php
    if (isset($contacts) && !empty($contacts)) { ?>
    <div class="page-header">
      <h1>Organisation Contacts</h1>
    </div>
 <?php  
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'contacts-grid',
            'dataProvider' => new CArrayDataProvider($contacts),
            'enableSorting' => false,
            'afterAjaxUpdate' => "
            function(id, data) {
                $('th > .asc').append('<div></div>');
                $('th > .desc').append('<div></div>');
            }",
            'columns' => array(
                array(
                    'name' => 'User',
                    'value' => '$data->getFullName()',
                ),
                array(
                    'name' => 'email',
                    'header' => 'Email',
                ),
                array(
                    'name' => 'contact_number',
                    'header' => 'Number',
                ),
            ),
        ));
    }
    ?>

<?php $this->endWidget(); ?>
    

</div><!-- form -->
<input type="hidden" id="currentAction" value="<?php echo $this->action->id; ?>">
<input type="hidden" id="viewFrom" value="<?php
if (isset($_GET['viewFrom'])) {
    echo "1";
} else {
    echo "0";
}
?>"/>
<script>
    function createCompanyForm() {
        return "#company-form ";
    }
    function checkCompanyNameUnique() {

        if($("#currentAction").val() == "update"){
            if($('#Company_name').val() == "<?php echo $model->name?>"){
                var name = "";
            } else{
                var name = $('#Company_name').val();
            }
        } else {
            var name = $('#Company_name').val();
        }
        if($("#currentAction").val() == "create"){
            var tenant = $('#Company_tenant').val();
        } else{
            var tenant = $('#Company_tenant_').val();
        }
        $.ajax({
            type : "POST",
            url: "<?php echo $this->createUrl('company/checkNameUnique')?>",
            data: {name:name, tenant:tenant},
            success: function(data){
                if(data == 0) {
                    $('#Company_name_unique_em_').show();
                    return false;
                } else {
                    if($("#currentAction").val() == "create"){
                        checkUserEmailUnique();
                    } else{
                        sendCreateCompanyForm();
                    }
                }
            }
        });
    }

    function checkUserEmailUnique(){
        var email = $("#Company_user_email").val();
        var tenant = $('#Company_tenant').val();
        $.ajax({
            type : "POST",
            url: "<?php echo $this->createUrl('user/checkCompanyContactEmail')?>",
            data: {email:email, tenant:tenant},
            success: function(data){
                if(data == 1) {
                    $('#Company_user_email_unique_em_').show();
                    return false;
                } else {
                    $('#Company_user_email_unique_em_').hide();
                    sendCreateCompanyForm();
                }
            }
        });
    }

    function sendCreateCompanyForm() {
        var formInfo = $(createCompanyForm()).serialize();
        if($("#currentAction").val() == "create"){
            var url = "<?php echo $this->createUrl('company/create')?>";
        } else{
            var url = "<?php echo $this->createUrl('company/update&id='.$model->id)?>";
        }
        $.ajax({
            type: "POST",
            url:url ,
            data: formInfo,
            success: function(data){
                window.location = 'index.php?r=company/admin';
            }
        });
    }

    function closeParent() {
        window.parent.dismissModal();
    }

    function gotoLicensePage() {
        window.location = 'index.php?r=licenseDetails/update&id=1';
    }

    function cancel() {
        $('#Company_user_repeatpassword').val('');
        $('#Company_user_password').val('');
        $(createCompanyForm()+"#random_password").val('');
        $(createCompanyForm()+"#close_generate").click();
    }

    function copy_password() {
        if ($('#random_password').val() == '') {
            $('#error_msg').show();
        } else {
            $('#Company_user_password').val($('#random_password').val());
            $('#Company_user_repeatpassword').val($('#random_password').val());
            $("#close_generate").click();
        }
    }

    function validatePassword() {
        if($("#Company_user_password").val() == ""){
            $("#Company_user_password_em_").html("Password should be specified");
            $("#Company_user_password_em_").show();
            return false;
        } else if($("#Company_user_repeatpassword").val() == "") {
            $("#Company_user_repeatpassword_em_").html("Please confirm a password");
            $("#Company_user_repeatpassword_em_").show();
            return false;
        } else {
            return true;
        }
    }

    function isPasswordMatch() {
        if($(createCompanyForm()+"#pass_option_1").is(":checked")){
            if($("#Company_user_password").val() == $("#Company_user_repeatpassword").val()){
                $("#Company_user_passwordmatch_em_").hide();
                return true;
            } else {
                $("#Company_user_passwordmatch_em_").html("Passwords are not matched");
                $("#Company_user_passwordmatch_em_").show();
                return false;
            }
        }
    }

    function generatepassword() {
        $("#random_password").val('');
        $(createCompanyForm()+".pass_option").prop("checked", true);

        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 6; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        document.getElementById('random_password').value = text;
        $("#gen_pass").click();
    }

    $(document).ready(function() {
        $(createCompanyForm()+".pass_option").on("click",function(){
            $(createCompanyForm()+".user_requires_password #pass_error_").hide();
        });
        $("#Company_user_password").on("change",function(){
            isPasswordMatch();
           if($("#Company_user_password").val() == '') {
               $("#Company_user_password_em_").html("Password should be specified");
               $("#Company_user_password_em_").show();
           } else {
               $("#Company_user_password_em_").hide();
           }

        });

        $("#Company_user_repeatpassword").on("change",function(){
            isPasswordMatch();
           if($("#Company_user_repeatpassword").val() == '') {
               $("#Company_user_repeatpassword_em_").html("Please confirm a password");
               $("#Company_user_repeatpassword_em_").show();
           } else {
               $("Company_user_repeatpassword_em_").hide();
           }

        });

        var default_field = $("#is_user_field").attr('value');

        if(default_field == "") {
            $( ".user_fields" ).hide();
            $(createCompanyForm()+".password-border").hide();
        }
        else{
            $( ".user_fields" ).show();
            $(createCompanyForm()+".password-border").show();
        }

        $(createCompanyForm()+"#addContact").click(function(e) {
            e.preventDefault();

            var is_user_field = $("#is_user_field").attr('value');
            if(is_user_field==""){
                $('#is_user_field').val(1);
                $( createCompanyForm()+".user_fields" ).show();
                $(createCompanyForm()+".password-border").show();
            }
            else{
                $('#is_user_field').val("");
                $( createCompanyForm()+".user_fields" ).hide();
                $(createCompanyForm()+".password-border").hide();
            }

        });

        $(createCompanyForm()+'.password_requirement').click(function () {
            $(createCompanyForm()+".password-border #pass_error_").hide();
            if ($('#Company_password_requirement_1').is(':checked')) {
                $(createCompanyForm()+'.user_requires_password').css("display", "block");
                $(createCompanyForm()+'.pass_option').prop('checked', false);
                $('#Company_user_password').val('');
            }
            else {
                $(createCompanyForm()+'.user_requires_password').css("display", "none");
            }

        });

    });


</script>

<!-- <div class="modal hide fade" id="viewLicense" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody" style="padding:20px;">
        <?php
        echo LicenseDetails::model()->getLicenseDetails();
        ?>
    </div>

</div> -->
<div class="modal hide fade" id="viewLicense" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal">×</a>
        <br>
        </div>
      <div style="padding:20px;" id="modalBody">
        <?php
        echo LicenseDetails::model()->getLicenseDetails();
        ?>
      </div>
    </div>
  </div>
</div>
<div class="modal hide fade" id="generate_password" style="width: 410px">
    <div style="border:5px solid #BEBEBE; width:405px">
        <div class="modal-header"
             style=" border:none !important; height: 60px !important;padding: 0px !important;width: 405px !important;">
            <div style="background-color:#E8E8E8; padding-top:2px; width:405px; height:56px;">
                <a data-dismiss="modal" class="close" id="close_generate">×</a>

                <h1 style="color: #000;font-size: 15px;font-weight: bold;margin-left: 9px;padding-top: 0px !important;">
                    Autogenerated Password
                </h1>

            </div>

            <br>
        </div>
        <div id="modalBody_gen">

            <table>

                <div id="error_msg" style='font-size: 0.9em;color: #FF0000;padding-left: 11px; display:none'>Please
                    Generate Password
                </div>

                <tr>
                    <td colspan="2" style="padding-left:10px">Your randomly generated password is :</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:55px; padding-top:24px;"><input readonly="readonly" type="text" placeholder="Random Password" value="" id="random_password"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="padding-left:10px; font:italic">Note:Please copy and save this password
                        somewhere safe.
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 11px;padding-top: 26px !important; width:50%"><input onclick="copy_password();" style="border-radius: 4px; height: 35px; " type="button" value="Use Password"/></td>
                    <td style="padding-right:10px;padding-top: 25px;"><input onclick="cancel();" style="border-radius: 4px; height: 35px;" type="button" value="Cancel"/></td>
                </tr>

            </table>


        </div>
        <a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none"
           class="btn btn-primary">Click me</a>
    </div>
</div>

