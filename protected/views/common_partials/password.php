<?php

$company = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}
?>
<div class="password-border" style="margin-top:10px;">
    <table>
        <tbody >
        <tr>
            <td><strong>Password Options</strong></td>
        </tr>
        <tr>
            <td>
                <table style=" !important; width:253px; border-left-style:none; border-top-style:none">
                    <tr>
                        <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select Atleast One option</td>
                    </tr>



                    <tr id="third_option" class='hiddenElement'>

                    </tr>

                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'password_option'); ?>
                            <input type="radio" value="1" class="pass_option" id="radio1" name="radiobtn" onclick="call_radio1();" />
                            &nbsp;Create Password
                        </td>

                        <?php echo "<br>". $form->error($model,'password_option'); ?>
                    </tr>
                    <tr>

                        <td>
                            <input placeholder="Password" ng-model="user.passwords" data-ng-class="{
                                                                   'ng-invalid':registerform['Visitor[repeatpassword]'].$error.match}"
                                   type="password" id="Visitor_password" name="Visitor[password]">
                            <span class="required">*</span>
                            <?php  echo $form->error($model,'password'); ?>

                        </td>
                    </tr>

                    <tr >
                        <td >
                            <input placeholder="Repeat Password" ng-model="user.passwordConfirm" type="password"
                                   id="Visitor_repeatpassword" data-match="user.passwords"
                                   name="Visitor[repeatpassword]"/>
                            <span class="required">*</span>

                            <div style='font-size:0.9em;color:red;position: static;'
                                 data-ng-show="registerform['Visitor[repeatpassword]'].$error.match">Password does
                                not match with Repeat <br> Password.
                            </div>
                            <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>

                        </td>

                    </tr>

                    <tr>
                        <td align="center">
                            <div class="row buttons" style="margin-left:23.5px;">

                                <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                <input id="generatePassword2" onclick="generatepassword();" class="complete btn btn-info" style="<?php echo $background; ?>position: relative; width:178px; overflow: hidden; cursor: default;cursor:pointer;font-size:13px" type="button" value="Autogenerate Password" />

                            </div>

                        </td>

                    </tr>

                    <tr>
                        <td> <input type="radio" value="2" class="pass_option" id="radio2" name="radiobtn" onclick="call_radio2();" />
                            &nbsp;Send User Invitation</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>

            </td>
        </tr>
        </tbody>
    </table>
</div> <!-- password-border -->

 <!-- password-border -->
<script>
    var radiochooseval = "";
    function call_radio1(){
        radiochooseval = $('#radio1').val();
        $('#Visitor_password_option').val(radiochooseval);
    }
    function call_radio2(){
        radiochooseval = $("#radio2").val();
        $('#Visitor_password_option').val(radiochooseval);
    }

    
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
        $('.pass_option[value=1]').prop('checked', true);
        $('#Visitor_password_option').val(1);

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