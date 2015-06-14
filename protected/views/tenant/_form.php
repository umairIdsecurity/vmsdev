
<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */


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
</style>
<div class="form">

    <?php
        $form = $this->beginWidget('CActiveForm', array(
        'id' => 'tenant-form',
            'enableAjaxValidation'=>true,
            'enableClientValidation' => false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'afterValidate'=>'js:function(form,data,hasError){
                        if(!hasError){
                                $.ajax({
                                        "type":"POST",
                                        "url":"'.$this->createAbsoluteUrl("tenant/create").'",
                                        "data":form.serialize(),
                                        "success":function(data){

                                                obj = JSON.parse(data);

                                                if(obj["success"]){
                                                    window.location.href = "'.$this->createUrl("tenant/create/&role=1").'";
                                                }else{
                                                    //window.location.href = "'.$this->createUrl("tenant/create/&role=1").'";
                                                }
                                            },

                                        });
                                }
                        }'


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
        //echo $form->errorSummary($model);
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
                            <td><?php echo $form->textField($model, 'tenant_code', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Tenant code')); ?>
                                <span class="required">*</span>

                                <?php echo "<br>" . $form->error($model, 'tenant_code'); ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="password-border" style="margin-top:20px;">
                    <table >
                        <tbody>
                        <tr>
                            <td><strong>Tenant Admin</strong></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
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
                        </tbody>
                    </table>
                </div>
        </td>

            <td style="vertical-align: top; float:left; width:300px">

                <table>
                    <tr>
                        <td>

                            <select  onchange="populateDynamicFields()" <?php
                            // if ($this->action->Id == 'create' && isset($_GET['role']) && $_GET['role'] != 'avms' ) { //if action create with user roles selected in url
                            if ($this->action->Id == 'create' && !CHelper::is_add_avms_user() ) { //if action create with user roles selected in url
                                echo "disabled";
                            }
                            ?> id="User_role" name="User[role]">
                                <option disabled value='' selected>Select Role</option>
                                <?php

                                $assignableRowsArray = getAssignableRoles($session['role'],$model); // roles with access rules from getaccess function
                                foreach ($assignableRowsArray as $assignableRoles) {
                                    foreach ($assignableRoles as $key => $value) {
                                        ?>

                                        <option id= "<?php echo $key; ?>" value="<?php echo $key; ?>" <?php
                                        if (isset($_GET['role'])) { //if url with selected role
                                            if ($currentRoleinUrl == $key) {
                                                echo "selected ";
                                            }
                                        } elseif ($this->action->Id == 'update') { //if update and $key == to role of user being updated
                                            if ($key == $model->role) {
                                                echo " selected ";
                                            }
                                        }
                                        ?>>
                                            <?php echo $value; ?></option>
                                    <?php
                                    }
                                }
                                ?>

                            </select><?php echo "<br>" . $form->error($model, 'role'); ?>
                        </td>

                    </tr>


                    <tr>

                        <td><?php echo $form->dropDownList($model, 'user_type', TenantForm::$USER_TYPE_LIST); ?>
                            <span class="required">*</span>
                            <?php echo "<br>" . $form->error($model, 'user_type'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->dropDownList($model, 'user_status', TenantForm::$USER_STATUS_LIST); ?>
                            <?php echo "<br>" . $form->error($model, 'user_status'); ?>
                        </td>

                    </tr>

                </table>

                <table>
                    <tr>
                        <td>
                            <?php echo $form->textfield($model, 'notes', array('placeholder'=>'Notes','style'=>'width:205px;')); ?>
                            <?php echo "<br>" . $form->error($model, 'notes'); ?>
                        </td>

                    </tr>
                </table>
                <div class="password-border">
                    <table>
                        <tr>
                            <td><strong>Password Options</strong></td>

                        </tr>


                        <tr>
                            <td>
                                <table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
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

                                        <?php echo $form->error($model,'password_opt'); ?>
                                    </tr>
                                    <tr>

                                        <td>
                                            <input placeholder="Password" type="password" id="TenantForm_password"  name="TenantForm[password]">
                                            <span class="required">*</span>
                                            <?php echo $form->error($model,'password'); ?>

                                        </td>
                                    </tr>
                                    <tr >
                                        <td >
                                            <input placeholder="Repeat Password" type="password" id="TenantForm_cnf_password"  name="TenantForm[cnf_password]">
                                            <span class="required">*</span>
                                            <?php echo $form->error($model,'cnf_password'); ?>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td align="center">
                                            <div class="row buttons" style="margin-left:23.5px;">

                                                <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                                <input onclick="generatepassword();" class="complete btn btn-info" style="<?php echo $background; ?>position: relative; width:178px; overflow: hidden; cursor: default;cursor:pointer;font-size:14px" type="button" value="Autogenerate Password" />

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

                    </table>
                </div> <!-- password-border -->

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
        } else {/*
        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
            ?>
            <button class="yiiBtn" id="modalBtn" style="padding:1.5px 6px;margin-top:-4.1px;height:30.1px;" data-target="#viewLicense" data-toggle="modal">View License Details</button>
        <?php } else { ?>
        <button class="yiiBtn actionForward" style="padding:2px 6px;margin-top:-4.1px;height:30.1px;" type='button' onclick="gotoLicensePage()">License Details</button>
            <?php
            }
            */
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

    function closeParent() {
        window.parent.dismissModal();
    }

    function gotoLicensePage() {
        window.location = 'index.php?r=licenseDetails/update&id=1';
    }


    $(document).ready(function() {

    });

    function populateDynamicFields() {

        if(is_accessing_avms_features()){
            return;
        }

        $('#third_option').empty();
        /*if superadmin user company set to empty*/
        if (<?php echo $session['role'] ?> == 5)
        {
            $("#User_company").empty();
        }
        $("#User_workstation").empty();

        var selectedRole = $("#User_role").val();

        var sessionRole = $("#currentRole").val(); //session role of currently logged in user

        var actionId = $("#currentAction").val(); // current action
        var admin = 1;
        var operator = 8;
        var staffmember = 9;
        var superadmin = 5;
        var agentadmin = 6;



        //hide required * label if role is staffmember
        if (selectedRole == staffmember) {
            $('#third_option').append('<td><input type="radio" value="3" class="pass_option" name="User[password_option]" />&nbsp;User does not require a password</td>');
            $("#third_option").show();
            $(".tenantField").hide();
        } else {
            $(".tenantField").show();
        }
        if (sessionRole == admin )
        {
            if (selectedRole == admin)
            {
                document.getElementById('User_company').disabled = true;
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').show();
                $("#User_company").val("<?php echo $session['company']; ?>");
            }
            else if (selectedRole == operator)
            {
                $("#User_company").val($("#sessionCompany").val());
                document.getElementById('User_company').disabled = true;
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').show();
                $("#User_company").val("<?php echo $session['company']; ?>");
                getWorkstation();
            }
            else if (selectedRole == staffmember) {




                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').show();
                $("#User_company").val("<?php echo $session['company']; ?>");
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                $("#User_company").val($("#sessionCompany").val());
                document.getElementById('User_tenant').disabled = true;
                document.getElementById('User_company').disabled = true;
                var selectedUserId = $("#selectedUserId").val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentAjax&id='); ?>' + selectedUserId,
                    dataType: 'json',
                    data: selectedUserId,
                    success: function(r) {
                        $('#User_tenant_agent option[value!=""]').remove();
                        $('#User_tenant_agent').append('<option value="">Please select a tenant agent</option>');
                        $.each(r.data, function(index, value) {
                            $('#User_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');

                        });
                        $("#User_tenant_agent").val('');
                    }
                });
            }
            else {
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                //$('#User_company option[value=""]').remove;
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').hide();
                $("#User_company").val("");
                document.getElementById('User_company').disabled = false;

            }
        }
        else if (sessionRole == superadmin)
        {
            $("#User_company_em_").hide();
            if (selectedRole != admin) { // if selected is not equal to admin enable tenant
                if (selectedRole == operator) {
                    document.getElementById('User_tenant_agent').disabled = true;
                    document.getElementById('User_workstation').disabled = false;
                    $("#tenantAgentRow").hide();
                    $("#tenantRow").show();
                    $(".workstationRow").show();
                    document.getElementById('User_tenant').disabled = false;
                    document.getElementById('User_company').disabled = true;
                    $("#User_tenant").val('');


                }
                else if (selectedRole == 9) {



                    document.getElementById('User_tenant_agent').disabled = false;
                    $("#tenantAgentRow").show();
                    $("#tenantRow").show();
                    document.getElementById('User_tenant').disabled = false;
                    document.getElementById('User_company').disabled = true;
                    document.getElementById('User_workstation').disabled = true;
                    $(".workstationRow").hide();
                    $("#User_tenant").val('');
                    $("#User_tenant_agent").empty();

                }
                else if (selectedRole == 6) {
                    $("#User_tenant").val('');
                    document.getElementById('User_tenant_agent').disabled = true;
                    $("#tenantAgentRow").hide();
                    document.getElementById('User_company').disabled = true;
                    document.getElementById('User_workstation').disabled = true;
                    $(".workstationRow").hide();
                    $("#tenantRow").show();
                    document.getElementById('User_tenant').disabled = false;

                }
                else if (selectedRole == 7) {

                    $("#tenantAgentRow").show();
                    document.getElementById('User_company').disabled = true;
                    $("#tenantRow").show();
                    document.getElementById('User_tenant').disabled = false;
                    document.getElementById('User_workstation').disabled = false;
                    $(".workstationRow").show();
                    $("#User_tenant").val('');
                    $("#User_tenant_agent").empty();

                }
                else {
                    document.getElementById('User_company').disabled = false;

                }
            }
            else {
                document.getElementById('User_tenant').disabled = true;
                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_company').disabled = false;

                //reset company list
                /*Taking an array of all companybase and kind of embedding it on the company*/
                $("#User_company").data('options', $('#User_company_base option').clone());
                var id = $("#User_company").val();
                var options = $("#User_company").data('options');
                $('#User_company').html(options);
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                $("#tenantRow").hide();
                $("#tenantAgentRow").hide();
            }
        }
        else if (sessionRole == agentadmin) {
            if (selectedRole == 7) { /*if selected role field is agent operator*/
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                getWorkstationAgentOperator();
            } else {
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
            }
        }

        /*show or hide add company button*/
        if ((sessionRole == superadmin && (selectedRole == admin || selectedRole == agentadmin || selectedRole == issuing_body_admin )) || (sessionRole == admin && (selectedRole == agentadmin || selectedRole == issuing_body_admin))) {
            $("#addCompanyLink").show();
            document.getElementById("companyRow").style.paddingBottom = "10px";
        }
        else {
            $("#addCompanyLink").hide();
            document.getElementById("companyRow").style.paddingBottom = "0px";
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
                    imageUrl: $('#photoCropPreview2').attr('src').substring(1, $('#photoCropPreview2').attr('src').length),
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
                                document.getElementById('photoPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop2").css("background", "url(<?php echo Yii::app()->request->baseUrl. '/'; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop2").css({
                                    "background-size": "137px 190px"
                                });
                            });
                        }
                    });

                    $("#closeCropPhoto2").click();
                    var ias = $('#photoCropPreview2').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });


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

        //echo '<p><pre>';print_r($user_role);echo '</pre></p>';

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

                <div id="error_msg" style='font-size: 0.9em;color: #FF0000;padding-left: 11px; display:none' >Please Generate Password </div>

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
    $("#TenantForm_contact_number").mask("99 9999 9999",{placeholder:" "});
</script>