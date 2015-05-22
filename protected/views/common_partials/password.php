<?php

$company               = Company::model()->findByPk($session['company']);
$companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);

?>
<div class="password-border">
<table>
    <tr>
        <td><strong>Password Options</strong></td>
    </tr>
    <tr>
        <td>
        <table style="margin-top:18px !important; width:273px; border-left-style:none; border-top-style:none">
                <tr>
                    <td>
                        <?php echo $form->radioButtonList($model, 'password_requirement',
                            array(
                                PasswordRequirement::PASSWORD_IS_NOT_REQUIRED => 'User does not require Password',
                                PasswordRequirement::PASSWORD_IS_REQUIRED     => 'User requires Password to Login',
                            ), array('class' => 'password_requirement form-label'));
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
                                        ), array('class' => 'password_option form-label'));
                                    ?>
                                    <?php echo $form->error($model, 'password_option'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table id="passwordInputsTable">
                                        <tr>
                                            <td>
                                                <input placeholder="Password" type="password" class="original-password"
                                                       id="Visitor_password" name="Visitor[password]">
                                                <span class="required">*</span>
                                                <?php echo "<br>" . $form->error($model, 'password'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input placeholder="Repeat Password" type="password"
                                                       id="Visitor_repeatpassword" name="Visitor[repeatpassword]"/>
                                                <span class="required">*</span>
                                                <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <div class="row buttons" style="text-align:center;">
                                                    <input onclick="generatepassword();" class="complete btn btn-info"
                                                           type="button" value="Autogenerate Password"
                                                           style="background:<?php echo $companyLafPreferences->neutral_bg_color; ?> !important;position: relative; width: 180px; overflow: hidden;cursor:pointer;font-size:14px;margin-right:8px;"/>
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

<div class="register-a-visitor-buttons-div" style="  width: 300px;  float: right;">
                                        <input type="submit" value="Save" name="yt0" id="submitFormVisitor"
                                               class="complete" style="margin-top: 15px;"/>
                                    </div>
<script>

    $(document).ready(function () {

        $("#passwordInputsTable").detach().insertAfter($(".password_option:eq(1)").next());
		
		/***********************hide password section if not required************************/	
	    $('.password_requirement').click(function() { 
		     if($('#Visitor_password_requirement_1').is(':checked'))
			 {
				$('.user_requires_password').css("display","block");
				$('.password_option').prop('checked', false);
			 }
				else
			 {
				$('.user_requires_password').css("display","none");
			 }
			   
         });		


    });

    function cancel() {
        $('#Visitor_repeatpassword').val('');
        $('#Visitor_password').val('');
        $("#random_password").val('');
        $("#close_generate").click();
    }

    function copy_password() {
        if ($('#random_password').val() == '') {
            $('#error_msg').show();
        } else {

            $('#Visitor_password').val($('#random_password').val());
            $('#Visitor_repeatpassword').val($('#random_password').val());
            $("#close_generate").click();
        }
    }

    function generatepassword() {

        $("#random_password").val('');
        $("#pass_option").prop("checked", true);

        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 6; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        document.getElementById('random_password').value = text;
        $("#gen_pass").click();
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