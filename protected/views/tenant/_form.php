
<?php
/* @var $this CompanyController */
/* @var $model TenantForm */
/* @var $form CActiveForm */



$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');
$cs->registerCssFile(Yii::app()->controller->assetsBase . '/bootstrapSwitch/bootstrap-switch.css');

$session = new CHttpSession;
$currentRoleinUrl = '';
if (isset($_GET['role'])) {
    $currentRoleinUrl = $_GET['role'];
}

$currentlyEditedUserId = '';
if (isset($_GET['id'])) {
    $currentlyEditedUserId = $_GET['id'];
}

$currentLoggedUserId = $session['id'];

?>

<style type="text/css">
    .required{ padding-left:5px;}
    .errorMessage{
         margin-bottom: 9px;
        margin-top: -5px;
    }
</style>
<div class="form">

    <?php
        $form = $this->beginWidget('CActiveForm', array(
        'id' => 'tenant-form',
            'enableAjaxValidation'=>true,
            'enableClientValidation' => false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                 )
    ));
    ?>
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }

    if (isset($_GET['viewFrom'])) {
        $isViewedFromModal = $_GET['viewFrom'];
    } else {

        //echo $form->errorSummary($userModel);
        //echo $form->errorSummary($companyModel);
        //echo $form->errorSummary($workstationModel);

    }
    ?>


    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td style="vertical-align: top; float:left; width:300px">

                <table style="width:300px;float:left;min-height:320px;">
                    <tr>

                        <td style="width:300px;">
                            <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->

                            <input type="hidden" id="Host_photo" name="TenantForm[photo]" value="<?php echo $model->photo; ?>">
                            <div class="photoDiv" style='display:none;'>
                                <img id='photoPreview2' src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png" style='display:none;'/>
                            </div>
                            
                            <?php require_once(Yii::app()->basePath . '/draganddrop/host.php'); ?>

                            <div id="photoErrorMessage" class="errorMessage" style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">Please upload a photo.</div>
                        </td>
                    </tr>

                    <tr><td >&nbsp;</td></tr>


                </table>
            </td>


            <td style="vertical-align: top; float:left; width:300px;">

                <?php echo $form->hiddenField($model, 'role',array('value'=> $session['role'])); ?>
                <div class="password-border">
                    <table>
                        <tbody>
                        <tr>
                            <td><strong>Tenant</strong></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td><?php echo $form->textField($model, 'tenant_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Tenant Name')); ?>
                                <span class="required">*</span>

                                <?php echo "<br>" . $form->error($model, 'tenant_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->textField($model, 'tenant_code', array('size' => 50, 'maxlength' => 3,'placeholder'=>'Tenant code', 'onkeyup' => 'restrict(this)')); ?>
                                <span class="required">*</span>

                                <?php echo "<br>" . $form->error($model, 'tenant_code'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td><b>Module Access</b><span class="required">*</span> <br>
                                <input type="checkbox" id="module_access_avms" name="module_access_avms" value="1" checked> AVMS
                                <input type="checkbox" id="module_access_cvms" name="module_access_cvms" value="2"> CVMS

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="password-border" style="margin-top:10px;">
                    <table >
                        <tbody>
                        <tr>
                            <td><strong>Tenant Admin</strong></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td>
                                <select id="User_role" name="TenantForm[role]" >
                                    <option value="">Please select a user role.</option>
                                </select><?php echo "<br>" . $form->error($model, 'role'); ?>
                            </td>

                        </tr>
                        <tr>
                            <td><?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                                <span class="required">*</span>

                                <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email Address')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'email'); ?>
                                <span class="errorMessageEmail1" style="display:none;color:red;font-size:0.9em;">A profile already exists for this email address</span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->textField($model, 'contact_number', array('size' => 50, 'placeholder'=>'Contact Number')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'contact_number'); ?></td>
                        </tr>
                        <tr>
                            <td class="AsicNoInput">
                                <?php echo $form->textField($model, 'asic_no', array('size' => 50, 'maxlength' => 9, 'placeholder' => 'ASIC No', 'autocomplete' => 'off')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'asic_no'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="AsicExpiryDropdown">
                                <?php $this->widget('EDatePicker', array(
                                    'model'=>$model,
                                    'attribute'=>'asic_expiry',
                                    'mode'=>'expiry',
                                ));
                                ?>
                                <span class="required">*</span><br/>
                                <?php echo "<br>" . $form->error($model, 'asic_expiry'); ?>

                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                

                    
        </td><td style="vertical-align: top; float:left; width:300px">
                <div class="password-border" >
                    <table>
                        <tbody>
                        <tr>
                            <td><strong>Workstation</strong></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td><?php echo $form->textField($model, 'workstation', array('size' => 50,'placeholder'=>'Workstation')); ?>
                                <span class="required">*</span>

                                <?php echo "<br>" . $form->error($model, 'workstation'); ?>
                            </td>
                        </tr>

                         <tr>

                            <td>

                                <select id="Workstation_timezone_id" name="TenantForm[timezone_id]">
                                    <?php
                                        $timezoneList = Timezone::model()->findAll();
                                        foreach ($timezoneList as $key => $value) {
                                            ?>
                                            <option <?php
                                            if ($model['timezone_id'] == $value['id']) {
                                                echo " selected ";
                                            } elseif($model['timezone_id'] == '' && $value['timezone_value'] == $_SESSION["timezone"]) {
                                                echo " selected ";
                                            }
                                            ?> value="<?php echo $value['id']; ?>"><?php echo $value['timezone_name']; ?></option>
                                            <?php
                                        }?>
                                </select>



                                <?php echo $form->error($model, 'timezone_id',array('style'=>'text-transform:none;')); ?>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                    </div>


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
                                                <?php echo $form->hiddenField($model, 'password_opt'); ?>
                                                <input type="radio" value="1" class="pass_option" id="radio1" name="radiobtn" onclick="call_radio1();" />
                                                &nbsp;Create Password
                                            </td>

                                            <?php echo "<br>". $form->error($model,'password_opt'); ?>
                                        </tr>
                                        <tr>

                                            <td>
                                                <input placeholder="Password" type="password" id="TenantForm_password"  name="TenantForm[password]">
                                                <span class="required">*</span>

                                                <?php  echo $form->error($model,'password', array("class"=>"hidingMsgPassword")); ?>

                                            </td>
                                        </tr>

                                        <tr >
                                            <td >
                                                <input placeholder="Repeat Password" type="password" id="TenantForm_cnf_password"  name="TenantForm[cnf_password]">
                                                <span class="required">*</span>
                                                <?php //echo $form->error($model,'cnf_password'); ?>

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
                    <table style="margin-top:10px;">
                        <tr>
                            <td>
                                <?php echo $form->textArea($model, 'notes', array('placeholder'=>'Notes','style'=>'width:280px;','class'=>'password-border','rows'=>4)); ?>
                                <?php echo "<br>" . $form->error($model, 'notes'); ?>
                            </td>

                        </tr>
                    </table>
                </td>
                </table>
            </td>
        </tr>


    </table>


    <div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
        margin-left:173px;
    <?php
    } else {
        echo "text-align:right;";
    }
    ?>">
        <?php echo CHtml::SubmitButton('Save', array('id' => 'createBtn', 'style' => 'height:30px;margin-right:30px;', 'class' => 'complete')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>

        <?php
        }  
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<input type="hidden" id="viewFrom" value="<?php
if (isset($_GET['viewFrom'])) {
    echo "1";
} else {
    echo "0";
}
?>"/>
<script>

    function setAvailableRoles(){

        //$("#User_role").find('option').remove().end();
        //$("#User_role").append('<option value="">Please select a user role.</option>');

        if(document.getElementById("module_access_avms").checked) {
            if($("#User_role option[value='<?php echo Roles::ROLE_ISSUING_BODY_ADMIN ?>']").length == 0) {
                $("#User_role").append('<option value="<?php echo Roles::ROLE_ISSUING_BODY_ADMIN ?>">AVMS Issuing Body Admin</option>');
            }
        } else{
            $("#User_role option[value='<?php echo Roles::ROLE_ISSUING_BODY_ADMIN ?>']").remove();
        }

        if(document.getElementById("module_access_cvms").checked ) {
            if($("#User_role option[value='<?php echo Roles::ROLE_ADMIN ?>']").length==0) {
                $("#User_role").append('<option value="<?php echo Roles::ROLE_ADMIN ?>">CVMS Administrator</option>');
            }
        } else {
            $("#User_role option[value='<?php echo Roles::ROLE_ADMIN ?>']").remove();
        }
    }

    function setAsicFields(){
        if($("#User_role").val() == '<?php echo Roles::ROLE_ISSUING_BODY_ADMIN ?>') {
            $(".AsicExpiryDropdown").show();
            $(".AsicNoInput").show();
        } else {
            $(".AsicExpiryDropdown").hide();
            $(".AsicNoInput").hide();
        }
    }

    function generatepassword() {

        $("#random_password").val('');
        $( "#pass_option" ).prop( "checked", true );

        var text = "";
        var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 6; i++ ){
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        document.getElementById('random_password').value	=	text;


        $("#gen_pass").click();
    }

    function cancel(){
        $('#TenantForm_password').val('');
        $('#TenantForm_cnf_password').val('');
        $("#random_password").val('');
        $("#close_generate").click();
    }

    function copy_password(){
        if($('#random_password').val()==''){
            $('#error_msg').show();
        }else{

            $('#TenantForm_password').val($('#random_password').val());
            $('#TenantForm_cnf_password').val($('#random_password').val());
            $("#close_generate").click();
        }
    }

    $(document).ready(function() {

        /*Added by farhat aziz for upload host photo*/
        $('#photoCropPreview2').imgAreaSelect({
            handles: true,
            onSelectEnd: function(img, selection) {
                $("#cropPhotoBtn2").show();
                $("#x12").val(selection.x1);
                $("#x22").val(selection.x2);
                $("#y12").val(selection.y1);
                $("#y22").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });
        $("#cropPhotoBtn2").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>',
                data: {
                    x1: $("#x12").val(),
                    x2: $("#x22").val(),
                    y1: $("#y12").val(),
                    y2: $("#y22").val(),
                    width: $("#width").val(),
                    height: $("#height").val(),
                    photoId: $('#Host_photo').val()
                },
                dataType: 'json',
                success: function(r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Host_photo').val(),
                        dataType: 'json',
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                                //showing image from DB as saved in DB -- image is not present in folder
                                var my_db_image = "url(data:image;base64,"+ value.db_image + ")";

                                document.getElementById('photoPreview2').src = "data:image;base64,"+ value.db_image;
                                document.getElementById('photoCropPreview2').src = "data:image;base64,"+ value.db_image;
                                $(".ajax-upload-dragdrop2").css("background", my_db_image + " no-repeat center top");
                                $(".ajax-upload-dragdrop2").css({"background-size": "132px 152px" });


                            });
                        }
                    });

                    $("#closeCropPhoto2").click();
                    var ias = $('#photoCropPreview2').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

        $("#closeCropPhoto2").click(function() {
            var ias = $('#photoCropPreview2').imgAreaSelect({instance: true});
            ias.cancelSelection();
        });
        $("#module_access_avms").click(function(){
           setAvailableRoles();
        });
        $("#module_access_cvms").click(function(){
            setAvailableRoles();
        });
        $("#User_role").on('change', function (e) {
            e.preventDefault();
            setAsicFields();
        });
        setAvailableRoles();
        setAsicFields();

    });

</script>
<?php

function getAssignableRoles($user_role, $model) {

    $session = new CHttpSession;
    if (isset($_GET['id'])) { //if update
        $userIdOnUpdate = $_GET['id'];
    } else {
        $userIdOnUpdate = '';
    }

    if (CHelper::is_managing_avms_user() || $model->is_avms_user()) {
        return get_avms_assignable_roles($user_role);
    } else {

        $assignableRolesArray = array();
        switch ($user_role) {

            case Roles::ROLE_AGENT_ADMIN: //agentadmin
                //if session id = id editing ->add role of logged in
                if ($session['id'] == $userIdOnUpdate) {
                    $assignableRoles = array(Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_STAFFMEMBER
                    ); //keys
                } else {
                    $assignableRoles = array(Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys
                }
                foreach ($assignableRoles as $roles) {
                    if (isset(TenantForm::$USER_ROLE_LIST[$roles])) {
                        $assignableRolesArray[] = array(
                            $roles => TenantForm::$USER_ROLE_LIST[$roles],
                        );
                    }
                }
                break;

            case Roles::ROLE_SUPERADMIN: //superadmin

                if ($session['id'] == $userIdOnUpdate) {
                    $assignableRoles = array(Roles::ROLE_ADMIN, Roles::ROLE_SUPERADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys
                } else {
                    $assignableRoles = array(Roles::ROLE_ADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_OPERATOR, Roles::ROLE_STAFFMEMBER);
                } //keys
                foreach ($assignableRoles as $roles) {
                    if (isset(TenantForm::$USER_ROLE_LIST[$roles])) {
                        $assignableRolesArray[] = array(
                            $roles => TenantForm::$USER_ROLE_LIST[$roles],
                        );
                    }
                }
                break;

            case Roles::ROLE_ADMIN: //admin

                $assignableRoles = array(Roles::ROLE_ADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys

                foreach ($assignableRoles as $roles) {
                    if (isset(TenantForm::$USER_ROLE_LIST[$roles])) {
                        $assignableRolesArray[] = array(
                            $roles => TenantForm::$USER_ROLE_LIST[$roles],
                        );
                    }
                }
                break;

        }
        return $assignableRolesArray;
    }
}


function get_avms_assignable_roles($user_role)
{
    $assignableRolesArray = array();
    switch($user_role) {

        case Roles::ROLE_ISSUING_BODY_ADMIN:
        case Roles::ROLE_ADMIN:

            $assignableRoles = array(
                Roles::ROLE_ISSUING_BODY_ADMIN,
                Roles::ROLE_AGENT_AIRPORT_ADMIN,
                Roles::ROLE_AIRPORT_OPERATOR,
                //Roles::ROLE_AGENT_AIRPORT_OPERATOR
            );
            foreach ($assignableRoles as $roles) {
                if (isset(TenantForm::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => TenantForm::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;

        case Roles::ROLE_SUPERADMIN:
            $assignableRoles = array(
                Roles::ROLE_ISSUING_BODY_ADMIN,
                Roles::ROLE_AGENT_AIRPORT_ADMIN,
                Roles::ROLE_AIRPORT_OPERATOR,
                Roles::ROLE_AGENT_AIRPORT_OPERATOR
            );
            foreach ($assignableRoles as $roles) {
                if (isset(TenantForm::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => TenantForm::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;

        case Roles::ROLE_AGENT_ADMIN:
        case Roles::ROLE_AGENT_AIRPORT_ADMIN:
            $assignableRoles = array(
                Roles::ROLE_AGENT_AIRPORT_ADMIN,
                Roles::ROLE_AGENT_AIRPORT_OPERATOR
            );

            foreach ($assignableRoles as $roles) {
                if (isset(TenantForm::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => TenantForm::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;
    }

    return $assignableRolesArray;
}
?>
<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody"></div>
</div>

<div class="modal hide fade" id="generate_password" style="width: 410px">
    <div style="border:5px solid #BEBEBE; width:405px">
        <div class="modal-header" style=" border:none !important; height: 60px !important;padding: 0px !important;width: 405px !important;">
            <div style="background-color:#E8E8E8; padding-top:2px; width:405px; height:56px;">
                <a data-dismiss="modal" class="close" id="close_generate" >×</a>
                <h1 style="color: #000;font-size: 15px;font-weight: bold;margin-left: 9px;padding-top: 0px !important;">				     Autogenerated Password
                </h1>

            </div>
            <br>
        </div>
        <div id="modalBody_gen">
            <table >
                <div id="error_msg" style='font-size: 0.9em;color: #FF0000;padding-left: 11px; display:none' >Please Generate Password</div>
                <tr><td colspan="2" style="padding-left:10px">Your randomly generated password is :</td></tr>
                <tr><td colspan="2"></td></tr>
                <tr><td colspan="2"style="padding-left:55px; padding-top:24px;"><input readonly="readonly" type="text" placeholder="Random Password" value="" id="random_password" /></td></tr>
                <tr><td colspan="2"style="padding-left:10px; font:italic">Note: Please copy and save this password somewhere safe.</td></tr>
                <tr><td  style="padding-left: 11px;padding-top: 26px !important; width:50%"> <input onclick="copy_password();"  style="border-radius: 4px; height: 35px; " type="button" value="Use Password" /></td>
                    <td style="padding-right:10px;padding-top: 25px;"> <input  onclick="cancel();" style="border-radius: 4px; height: 35px;" type="button" value="Cancel" /></td>
                </tr>
            </table>
        </div>
        <a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none" class="btn btn-primary">Click me</a>
    </div>
</div>
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
<!-- PHOTO CROP-->
<div id="light2" class="white_content">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn2" value="Crop" style="">
        <input type="button" id="closeCropPhoto2" onclick="document.getElementById('light2').style.display = 'none';
                document.getElementById('fade2').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
    <br>
    <img id="photoCropPreview2" src="">
</div>

<input type="hidden" id="x12"/>
<input type="hidden" id="x22"/>
<input type="hidden" id="y12"/>
<input type="hidden" id="y22"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>


<script type="text/javascript">
    
    $('.hidingMsgPassword').css("color","red");
    $('#TenantForm_password, #TenantForm_cnf_password').on('keyup', function () {
        if ($('#TenantForm_password').val() == $('#TenantForm_cnf_password').val()) {
            $('#TenantForm_password').css({"background-color": "#fffff", "border": "1px solid #cccccc"});
            $('#TenantForm_cnf_password').css({"background-color": "#fffff", "border": "1px solid #cccccc"});
            $('.hidingMsgPassword').hide();
        } else {
            $('.hidingMsgPassword').css("color","red");
            $('.hidingMsgPassword').show();
            $('#TenantForm_password').css({"background-color": "#fee none repeat scroll 0 0", "border": "#c00"});
            $('#TenantForm_cnf_password').css({"background-color": "#fee none repeat scroll 0 0", "border": "#c00"});
        }
    });

    function restrict(ob){
        var invalidChars = /([^A-Z])/g;
        if(invalidChars.test(ob.value)) {
            ob.value = ob.value.toUpperCase().replace(invalidChars,"");
        }
    }


    $("#TenantForm_contact_number").on("keypress",function(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        //anything other than BACKSPACE,SPACE and numerics from 0 to 9 will not do anything in textbox
        if (charCode > 32 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    });


    var radiochooseval = "";
    function call_radio1(){
        radiochooseval = $('#radio1').val();
        $('#TenantForm_password_opt').val(radiochooseval);
    }
    function call_radio2(){
        radiochooseval = $("#radio2").val();
        $('#TenantForm_password_opt').val(radiochooseval);
    }
    /*<![CDATA[*/
    //jQuery(function($) { $('#tenant-form').yiiactiveform({'attributes':[{'inputID':'TenantForm_password','errorID':'TenantForm_password_em_'},{'inputID':'TenantForm_cnf_password','errorID':'TenantForm_cnf_password_em_'}]}); });
    /*]]>*/
    //$("#TenantForm_contact_number").mask("99 9999 9999",{placeholder:" "});
</script>