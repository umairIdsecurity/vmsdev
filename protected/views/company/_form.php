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
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }

    if (isset($_GET['viewFrom'])) {
        $isViewedFromModal = $_GET['viewFrom'];
    } else {
        echo $form->errorSummary($model);
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
                                if (isset($_GET['viewFrom'])) {
                                    echo "<br>" . $form->error($model, 'name');
                                }
                                ?>
                            </td>
                            <td><?php
                                if (!isset($_GET['viewFrom'])) {
                                    echo $form->error($model, 'name');
                                }
                                ?></td>
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

                                <?php echo "<br>" . $form->error($model, 'user_first_name'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>

                                <?php echo "<br>" . $form->error($model, 'user_last_name'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>

                                <?php echo "<br>" . $form->error($model, 'user_email'); ?>
                            </td>
                        </tr>

                        <tr class="user_fields">
                            <td style="width:160px;">&nbsp;</td>
                            <td><?php echo $form->textField($model, 'user_contact_number', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact Number')); ?>

                                <?php echo "<br>" . $form->error($model, 'user_contact_number'); ?>
                            </td>
                        </tr>

                    </table><!--Company Contact field-->
                    <div class="password-border" style="float: right; margin-right: 147px; margin-top: -230px;">
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
                                            <td><input class="pass_option" type="radio" name="Visitor[password_option]" value="2"/>&nbsp;Send
                                                User Invitation
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding-bottom:10px">
                                                <input class="pass_option" type="radio" name="Visitor[password_option]" value="1"/>
                                                &nbsp;Create Password
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input placeholder="Password" ng-model="user.passwords" data-ng-class="{
                                                                       'ng-invalid':registerform['Visitor[repeatpassword]'].$error.match}"
                                                       type="password" id="Visitor_password" name="Visitor[password]">
                                                <span class="required">*</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
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
                                                <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                                <div class="row buttons" style="text-align:center;">
                                                    <input onclick="generatepassword();" class="complete btn btn-info" type="button" value="Autogenerate Password"
                                                           style="<?php echo $background; ?>position: relative; width: 180px; overflow: hidden;cursor:pointer;font-size:14px;margin-right:8px;"/>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;</td>
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
        echo "text-align:right;";
    }
    ?>">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px;', 'class' => 'complete')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>

        <?php
        } else {
        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
            ?>
            <button class="yiiBtn" id="modalBtn" style="padding:1.5px 6px;margin-top:-4.1px;height:30.1px;" data-target="#viewLicense" data-toggle="modal">View License Details</button>
        <?php } else { ?>
        <button class="yiiBtn actionForward" style="padding:2px 6px;margin-top:-4.1px;height:30.1px;" type='button' onclick="gotoLicensePage()">License Details</button>
        <?php
            }
        }
        ?>
    </div>

    <?php $this->endWidget(); ?>
    <div class="page-header">
      <h1>Organisation Contacts</h1>
    </div>
    <?php if (isset($contacts) && !empty($contacts)): ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Number</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($contacts as $contact): ?>
                <tr>
                    <td><?php echo $contact->getFullName(); ?></td>
                    <td><?php echo $contact->email; ?></td>
                    <td><?php echo $contact->contact_number; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div><!-- form -->

<input type="hidden" id="viewFrom" value="<?php
if (isset($_GET['viewFrom'])) {
    echo "1";
} else {
    echo "0";
}
?>"/>
<script>

    function closeParent() {
        window.parent.dismissModal();
    }

    function gotoLicensePage() {
        window.location = 'index.php?r=licenseDetails/update&id=1';
    }


    $(document).ready(function() {

        var default_field = $("#is_user_field").attr('value');

        if(default_field == "") {
            $( ".user_fields" ).hide();
            $(".password-border").hide();
        }
        else{
            $( ".user_fields" ).show();
            $(".password-border").show();
        }

        $("#addContact").click(function(e) {
            e.preventDefault();

            var is_user_field = $("#is_user_field").attr('value');
            if(is_user_field==""){
                $('#is_user_field').val(1);
                $( ".user_fields" ).show();
                $(".password-border").show();
            }
            else{
                $('#is_user_field').val("");
                $( ".user_fields" ).hide();
                $(".password-border").hide();
            }

        });

        $('.password_requirement').click(function () {
            if ($('#Company_password_requirement_1').is(':checked')) {
                $('.user_requires_password').css("display", "block");
                $('.pass_option').prop('checked', false);
            }
            else {
                $('.user_requires_password').css("display", "none");
            }

        });

    });


</script>

<div class="modal hide fade" id="viewLicense" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody" style="padding:20px;">
        <?php
        echo LicenseDetails::model()->getLicenseDetails();
        ?>
    </div>

</div>


