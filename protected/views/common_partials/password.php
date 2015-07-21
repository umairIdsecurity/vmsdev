<?php

$company               = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}
?>
<div class="password-border">
<table class="no-margin-bottom">
    <tr>
        <td><strong>Password Options</strong></td>
    </tr>
    <tr>
        <td>
        <table style="margin-top:10px !important; width:273px; border-left-style:none; border-top-style:none">
                <tr>
                    <td>
                        <?php
                        if (!isset($model->password_requirement)) {
                            $model->password_requirement = PasswordRequirement::PASSWORD_IS_NOT_REQUIRED;
                        }

                        echo $form->radioButtonList($model, 'password_requirement',
                            array(
                                PasswordRequirement::PASSWORD_IS_NOT_REQUIRED => 'User does not require Password',
                                PasswordRequirement::PASSWORD_IS_REQUIRED     => 'User requires Password to Login',
                            ), array('class' => 'password_requirement form-label', 'separator' => ''));
                        ?>
                        <?php echo $form->error($model, 'password_requirement'); ?>
                    </td>
                </tr>
                <tr class="user_requires_password" style="display:none;">
                    <td >
                        <table style="margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none;margin-left:30px;">
                            <tr>
                                <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select
                                    Atleast One option
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $form->radioButtonList($model, 'password_option',
                                        array(
                                            PasswordOption::SEND_INVITATION => 'Send User Invitation',
                                            PasswordOption::CREATE_PASSWORD => 'Create Password',
                                        ), array('class' => 'password_option form-label', 'separator' => ''));
                                    ?>
                                    <?php echo $form->error($model, 'password_option'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table id="passwordInputsTable" style="margin-top:10px">
                                        <tr>
                                            <td>
                                                <!--<input placeholder="Password" type="password" class="original-password" id="Visitor_password_input">-->
                                                <?php echo $form->passwordField($model,'password',array("class"=>"original-password","id"=>"Visitor_password_input","placeholder"=>"Password"));?>
                                                <span class="required">*</span>
                                                <?php echo "<br>" . $form->error($model, 'password'); ?>
                                                <div class="errorMessage visitor_password" style="display:none"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <!--<input placeholder="Repeat Password" type="password" id="Visitor_repeatpassword_input" />-->
                                                <?php echo $form->passwordField($model,'repeatpassword',array("id"=>"Visitor_repeatpassword_input","placeholder"=>"Repeat Password"));?>
                                                <span class="required">*</span>
                                                <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                                                <div class="errorMessage visitor_password_repeat" style="display:none"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <div class="row buttons" style="text-align:center;">
                                                	<?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                                    <input onclick="generatepassword();" class="complete btn btn-info" type="button" value="Autogenerate Password"
                                                    	style="<?php echo $background; ?>position: relative; width: 180px; overflow: hidden;cursor:pointer;font-size:14px;margin-right:8px;"/>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                           
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div> <!-- password-border -->
<script>

    $(document).ready(function () {
        $(parentElement() + "#passwordInputsTable").detach().insertAfter($( parentElement() + ".password_option:eq(1)").next());

		/***********************hide password section if not required************************/
	    $(parentElement() + '.password_requirement').click(function() {
		     if($(parentElement() + '#Visitor_password_requirement_1').is(':checked'))
			 {
                 $(parentElement() + '#Visitor_password_input').val('');
                 $(parentElement() + '#Visitor_repeatpassword_input').val('');
				 $(parentElement() + '.user_requires_password').css("display","block");
				 $(parentElement() + '.password_option').prop('checked', false);
			 }
				else
			 {
				 $(parentElement() + '.user_requires_password').css("display","none");
			 }

         });
    });

    function parentElement() {

        var parentElement = '';
        if("<?php echo $this->action->id?>" == "create") {
            if($('#step2Tab').css('display') == 'block'){
                parentElement = "#step2Tab ";
            } else if ($('#step3Tab').css('display') == 'block') {
                parentElement = "#step3Tab ";
            }
        }
        return parentElement;
    }

    function validatePassword() {
        if ($(parentElement() + "#Visitor_password_input").val() == "") {
            $(parentElement() + "#Visitor_password_em_").html("Password cannot be blank");
            $(parentElement() + "#Visitor_password_em_").show();
            return false;
        } else if ($(parentElement() + "#Visitor_repeatpassword_input").val() == "") {
            $(parentElement() + "#Visitor_password_em_").hide();
            $(parentElement() + "#Visitor_repeatpassword_em_").html("Reapeat password cannot be blank");
            $(parentElement() + "#Visitor_repeatpassword_em_").show();
            return false;
        } else {
            $(parentElement() + "#Visitor_password_em_").hide();
            $(parentElement() + "#Visitor_repeatpassword_em_").hide();
            return true;
        }
    }

    function isPasswordMatch() {
        if($(parentElement() + "#Visitor_password_option_1").is(":checked")){
            if($(parentElement() + "#Visitor_password_input").val() == $(parentElement() +"#Visitor_repeatpassword_input").val()){
                $(parentElement() + "#Visitor_repeatpassword_em_").hide();
                return true;
            } else {
                $(parentElement() + "#Visitor_repeatpassword_em_").html("Password is not match");
                $(parentElement() + "#Visitor_repeatpassword_em_").show();
                return false;
            }
        }
    }

    $(parentElement() + "#Visitor_password_input").on("change",function(){
        $(parentElement() + "#Visitor_password_em_").hide();
        if($(parentElement() + "#Visitor_password_input").val() == '') {
            $(parentElement() + "#Visitor_password_em_").html("Password cannot be blank");
            $(parentElement() + "#Visitor_password_em_").show();
        } else {
            $(parentElement() + "#Visitor_password_em_").hide();
        }

    });

    $(parentElement() + "#Visitor_repeatpassword_input").on("change",function(){
        $(parentElement() + "Visitor_repeatpassword_em_").hide();
        if($(parentElement() + "#Visitor_repeatpassword").val() == '') {
            $(parentElement() + "#Visitor_repeatpassword_em_").html("Password cannot be blank");
            $(parentElement() + "#Visitor_repeatpassword_em_").show();
        } else {
            $(parentElement() + "Visitor_repeatpassword_em_").hide();
        }

    });

    function cancel() {
        $(parentElement() + '#Visitor_repeatpassword').val('');
        $(parentElement() + '#Visitor_password').val('');
        $(parentElement() + "#random_password").val('');
        $(parentElement() + "#close_generate").click();
    }

    function copy_password() {
        if ($(parentElement() + '#random_password').val() == '') {
            $(parentElement() + '#error_msg').show();
        } else {
            var random_password = $(parentElement() + '#random_password').val();
            $(parentElement() + 'input[name="Visitor[password]"]').val(random_password);
            $(parentElement() + 'input[name="Visitor[repeatpassword]"]').val(random_password);
            $(parentElement() + "#close_generate").click();
        }
    }

    function generatepassword() {
        $(parentElement() + "#random_password").val('');
        $(parentElement() + "#pass_option").prop("checked", true);

        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 6; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        $(parentElement() + ' #random_password').val(text);
        $(parentElement() + "#generate_password").modal('show');
    }

</script>

<div class="modal hide fade" id="generate_password" style="width: 410px">
    <div style="border:5px solid #BEBEBE; width:405px">
        <div class="modal-header"
             style=" border:none !important; height: 60px !important;padding: 0px !important;width: 405px !important;">
            <div style="background-color:#E8E8E8; padding-top:2px; width:405px; height:56px;">
                <a data-dismiss="modal" class="close" id="close_generate">×</a>

                <h1 style="color: #000;font-size: 15px;font-weight: bold;margin-left: 9px;padding-top: 0px !important;">
                    Autogenerated Password</h1>
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
                    <td colspan="2" style="padding-left:55px; padding-top:24px;"><input readonly="readonly" type="text"
                                                                                        placeholder="Random Password"
                                                                                        value="" id="random_password"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:10px; font:italic">Note:Please copy and save this password
                        somewhere safe.
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 11px;padding-top: 26px !important; width:50%"><input
                            onclick="copy_password();" style="border-radius: 4px; height: 35px; " type="button"
                            value="Use Password"/></td>
                    <td style="padding-right:10px;padding-top: 25px;"><input onclick="cancel();"
                                                                             style="border-radius: 4px; height: 35px;"
                                                                             type="button" value="Cancel"/></td>
                </tr>
            </table>
        </div>
        <a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none"
           class="btn btn-primary">Click me</a>
    </div>
</div>