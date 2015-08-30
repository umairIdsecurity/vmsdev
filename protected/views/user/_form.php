<?php
$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-birthday.js');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/bootstrapSwitch/bootstrap-switch.js');

$cs->registerCssFile(Yii::app()->controller->assetsBase . '/bootstrapSwitch/bootstrap-switch.css');

/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$session = new CHttpSession;

$currentRoleinUrl = '';
if (isset($_GET['role'])) {
    $currentRoleinUrl = $_GET['role'];
}

$currentlyEditedUserId = '';
if (isset($_GET['id'])) {
    $currentlyEditedUserId = $_GET['id'];
    if (isset(User::model()->findByPk($currentlyEditedUserId)->password)) {
        $password = User::model()->findByPk($currentlyEditedUserId)->password;
    }

}

$currentLoggedUserId = $session['id'];
$company = Company::model()->findByPk($session['company']);

if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}
?>
<style type="text/css">
    #modalBody_gen {
        padding-top: 10px !important;
        height: 204px !important;
    }

    #addCompanyLink {
        display: block;
        height: 23px;
        margin-right: 0;
        padding-bottom: 0;
        padding-right: 0;
        width: 140px;
    }

    .uploadnotetext {
        margin-left: -80px;
        margin-top: 79px;
    }

    .required {
        padding-left: 10px;
    }

    .ajax-upload-dragdrop {
        float: left !important;
        margin-top: -30px;
        background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
        background-size: 137px;
        height: 104px;
        width: 120px !important;
        padding: 87px 5px 12px 72px;
        margin-left: 20px !important;
        border: none;
    }

    .ajax-file-upload {
        margin-left: -100px !important;
        margin-top: 128px !important;
        position: absolute !important;
        font-size: 12px !important;
        padding-bottom: 3px;
        height: 17px;
    }

    .editImageBtn {
        margin-left: -103px !important;
        color: white;
        font-weight: bold;
        text-shadow: 0 0 !important;
        font-size: 12px !important;
        height: 24px;
        width: 131px !important;
    }

    .imageDimensions {
        display: none !important;
    }

    #cropImageBtn {
        float: left;
        margin-left: -54px !important;
        margin-top: 218px;
        position: absolute;
    }

    .required {
        padding-left: 10px;
    }

    #content h1 {
        color: #E07D22;
        font-size: 18px;
        font-weight: bold;
        margin-left: 75px;
    }

    .asic-date {
        width: 80px;
    }

    .select2 {
        margin: 0.2em 0 0.5em;
    }

    #ui-datepicker-div {
        z-index: 9 !important;
    }
</style>

<input type="hidden" id="passwordUser" value="<?php echo isset($password) ? $password : ''; ?>">
<div class="form" data-ng-app="PwordForm">
<?php 
$roleLabel = array_key_exists(Yii::app()->request->getParam('role'),Roles::$labels) ? Roles::$labels[Yii::app()->request->getParam('role')] : '';
$action = $this->action->id;
if ($action == 'update') {
    echo '<h1>Edit ' . $roleLabel . '</h1>';
} else {
    echo '<h1>Add ' . ($roleLabel?$roleLabel:'User') . '</h1>';
}?>
<?php

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'userform',
    'action' => array('user/'.$action, 'role' => Yii::app()->request->getParam('role'),'id'=>$model->id),
    'htmlOptions' => array("name" => "userform"),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form,data,hasError){
            if(!hasError){
                if($(".pass_option").is(":checked")== false){
                    $("#pass_error_").show();
                    $("#User_password_em_").html("select one option");
                }
                else if($(".pass_option").is(":checked")== true && $(".pass_option:checked").val()==1 && ($("#User_password").val()== "" || $("#User_repeat_password").val()=="")){
                    if ($("#currentAction").val() == "update" && $("#passwordUser").val() !== "") {
                        $("#User_password_em_").hide();
                        checkHostEmailIfUnique();
                    } else {
                        $("#pass_error_").show();
                        $("#pass_error_").html("Type password or generate");
                    }
                }
                else if($("#User_role").val() == 7 && $("#User_tenant_agent").val() == "" && $("#currentRole").val() != 6){
                    $("#User_tenant_agent_em_").show();
                    $("#User_tenant_agent_em_").html("Please select a tenant agent");
                }
                else if($("#User_password").val() != $("#User_repeat_password").val()){
                    $("#User_tenant_agent_em_").hide();
                    $("#User_password_em_").show();
                    $("#User_password_em_").html("Password does not match with repeat password");
                } else {
                    $("#User_password_em_").hide();
                    checkHostEmailIfUnique();
                }
            }
        }'
    ),
));
?>


<?php echo $form->errorSummary($model); ?>
<table>
<tr>
<td style="vertical-align: top; float:left; width:300px">

    <table style="width:300px;float:left;min-height:320px;">
        <tr>

            <td style="width:300px;">
                <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->

                <input type="hidden" id="Host_photo" name="User[photo]" value="<?php echo $model->photo; ?>">

                <div class="photoDiv" style='display:none;'>
                    <img id='photoPreview2'
                         src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png"
                         style='display:none;'/>
                </div>
                
                <?php require_once(Yii::app()->basePath . '/draganddrop/host.php'); ?>


                <div id="photoErrorMessage" class="errorMessage"
                     style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">
                    Please upload a photo.
                </div>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</td>


<td style="vertical-align: top; float:left; width:300px;">
<table>

<tr>
    <td><?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name')); ?>
        <span class="required">*</span>

        <?php echo "<br>" . $form->error($model, 'first_name'); ?>
    </td>
</tr>
<tr>
    <td><?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name')); ?>
        <span class="required">*</span>
        <?php echo "<br>" . $form->error($model, 'last_name'); ?>
    </td>
</tr>
<tr>
    <td>
        <input type="text" id="User_email" placeholder="Email" name="User[email]" maxlength="50" size="50"
               value="<?php echo $model->email; ?>"/>
        <span class="required">*</span>
        <?php echo "<br>" . $form->error($model, 'email', array('style' => 'text-transform:none;')); ?>
        <span class="errorMessageEmail1" style="display:none;color:red;font-size:0.9em;">A profile already exists for this email address</span>
    </td>
</tr>
<tr>
    <td><?php echo $form->textField($model, 'contact_number', array('size' => 50, 'placeholder' => 'Contact No')); ?>
        <span class="required">*</span>
        <?php echo "<br>" . $form->error($model, 'contact_number'); ?></td>
</tr>

<?php if ($session['role']==Roles::ROLE_SUPERADMIN) { ?>
    <tr class="tenantRow" > <!-- class='hiddenElement'>-->
        <td>
            <select id="User_tenant" name="User[tenant]">
                <option value='' selected>Please select a tenant</option>
                <?php
                $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                foreach ($allTenantCompanyNames as $key => $value) {
                    ?>

                    <option <?php
                    if ($model->tenant == $value['id']) {
                        echo " selected "; //if logged in is agent admin and tenant of agent admin = admin id in adminList
                    }
                    ?> value="<?php echo $value['id']; ?>"><?php echo $value["id0"]['name']; ?></option>
                <?php
                }
                ?>
            </select><span class="required">*</span><?php echo "<br>" . $form->error($model, 'tenant'); ?>
        </td>
    </tr>
<?php } ?>
<?php if (in_array($session['role'],array(Roles::ROLE_SUPERADMIN,Roles::ROLE_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN))) { ?>
    <tr class="tenantAgentRow" > <!-- class='hiddenElement'>-->

        <td>
            <select id="User_tenant_agent"  name="User[tenant_agent]">
            <option value="">Please select a tenant agent</option>
                <?php
                //if ($this->action->Id != 'create' || isset($_POST['User'])) {

                    $allAgentAdminNames = User::model()->findAllTenantAgent($model['tenant']);
                    foreach ($allAgentAdminNames as $key => $value) {
                        ?>
                        <option <?php
                        if ($model->tenant_agent == $value['id']) {
                            echo " selected "; //if logged in is agent admin and tenant agent of logged in user is = agentadminname
                        }
                        ?> value="<?php echo $value['tenant_agent']; ?>"><?php echo $value['name']; ?></option>
                    <?php
                    }
//               
                ?>
            </select>
            <span class="required">*</span>
            <?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
        </td>
    </tr>
<?php } ?>


<?php if (!CHelper::is_managing_avms_user()) { ?>
    <tr>
        <td><?php echo $form->textField($model, 'department', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Department')); ?>
            <?php echo "<br>" . $form->error($model, 'department'); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Postion')); ?>
            <?php echo "<br>" . $form->error($model, 'position'); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->textField($model, 'staff_id', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Staff ID')); ?>
            <?php echo "<br>" . $form->error($model, 'staff_id'); ?></td>
    </tr>

<?php } ?>
<tr>
    <td class="birthdayDropdown">
        Date Of Birth<span class="required">*</span><br/>

        <?php echo $form->hiddenField($model,'date_of_birth',['data-format'=>"DD-MM-YYYY",'data-template'=>"DD MMM YYYY"]) ?>
        <script>
            $(function(){
                $('#User_date_of_birth').combodate({
                    minYear: (new Date().getFullYear()-100),
                    maxYear: (new Date().getFullYear()-10),
                    smartDays: true,
                    customClass: 'yearSelect'
                });
            });
        </script>

    </td>
</tr>


<tr style="display: none">
    <td class="workstationRow">

        <?php
        $listWorkstation = Workstation::model()->findAll("is_deleted = 0",'id','name');
        ?> <select disabled>
                <?php foreach ($listWorkstation as $worksta) { ?>
                        <option value="<?php echo $worksta->id; ?>" <?php if ($worksta->id == Yii::app()->session['workstation']) echo 'selected'; ?> ><?php echo $worksta->name; ?></option>
                <?php } ?>
            </select>
         <select style="display: none !important;" id="User_workstation" name="User[workstation]" disabled></select>
    </td>
</tr>

<!-- AVMS User specific form fields -->
<?php if (CHelper::is_managing_avms_user() || $model->is_avms_user()) { ?>
    <tr>
        <td>
            <?php echo $form->textField($model, 'asic_no', array('size' => 50, 'maxlength' => 9, 'placeholder' => 'ASIC No', 'autocomplete' => 'off')); ?>
            <span class="required">*</span>
            <?php echo "<br>" . $form->error($model, 'asic_no'); ?>
        </td>
    </tr>
    <tr>
        <td class="AsicExpiryDropdown">
            ASIC Expiry<span class="required">*</span><br/>
            <?php echo $form->hiddenField($model,'asic_expiry',['data-format'=>"DD-MM-YYYY",'data-template'=>"DD MMM YYYY"]) ?>
            <script>
                $(function(){
                    $('#User_asic_expiry').combodate({
                        minYear: (new Date().getFullYear()),
                        maxYear: (new Date().getFullYear()+10),
                        smartDays: true,
                        customClass: 'yearSelect'
                    });
                });
            </script>
            <?php echo "<br>" . $form->error($model, 'asic_expiry'); ?>

        </td>
    </tr>
<?php } ?>


</table>
</td>
<td style="vertical-align: top; float:left; width:300px">

    <table class="no-margin-bottom">
        <tr>
            <td>
                <select onchange="populateDynamicFields()" <?php
                ?> id="User_role" name="User[role]">
                    <option disabled value='' selected>Select Role</option>
                    <?php

                    $assignableRowsArray = Roles::getAssignableRoles($session['role'], $model); // roles with access rules from getaccess function
                    foreach ($assignableRowsArray as $assignableRoles) {
                        foreach ($assignableRoles as $key => $value) {
                            ?>

                            <option id="<?php echo $key; ?>" value="<?php echo $key; ?>" <?php
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

                </select><?php echo "<br>" . $form->error($model, 'role'); ?></td>

        </tr>
        <?php if (!CHelper::is_add_avms_user()) { // Don't Show UserType for AVMS Users' ?>
            <tr>

                <td><?php echo $form->dropDownList($model, 'user_type', User::$USER_TYPE_LIST); ?>
                    <span class="required">*</span>
                    <?php echo "<br>" . $form->error($model, 'user_type'); ?>
                </td>
            </tr>
        <?php
        } else {
            echo $form->hiddenField($model, 'user_type', array("value" => "1"));
        } ?>
        <tr>
            <td><?php echo $form->dropDownList($model, 'user_status', User::$USER_STATUS_LIST); ?>
                <?php echo "<br>" . $form->error($model, 'user_status'); ?>
            </td>

        </tr>

    </table>

    <table>
        <tr>
            <td>
                <?php echo $form->textfield($model, 'notes', array('placeholder' => 'Notes', 'style' => 'width:205px;')); ?>
                <?php echo "<br>" . $form->error($model, 'notes'); ?>
            </td>

        </tr>
    </table>
    
        <!-- ********************************************************************************** -->
    <?php if(in_array($currentRoleinUrl, array(Roles::ROLE_AIRPORT_OPERATOR , Roles::ROLE_AGENT_AIRPORT_ADMIN , Roles::ROLE_AGENT_AIRPORT_OPERATOR))) { ?>
    <div class="password-border">
        <table class="no-margin-bottom">
            <tr>
                <td><strong>Induction Information</strong></td>
            </tr>
            <tr>
                <td>
                    <table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
                        <tr>
                            <td>
                                <div style="display:inline-block;">Induction Required
                                    <div class="switch switch-blue">
                                        <input type="radio" class="switch-input is_required_induction_radio" name="User[is_required_induction]" value="0" id="week" checked>
                                        <label for="week" class="switch-label switch-label-off">OFF</label>
                                        <input type="radio" class="switch-input is_required_induction_radio" name="User[is_required_induction]" value="1" id="month" <?php if(!empty($model->is_required_induction) && ($model->is_required_induction == "1")){echo 'checked'; }?>>
                                        <label for="month" class="switch-label switch-label-on">ON</label>
                                        <span class="switch-selection"></span>
                                    </div>
                                </div>
                            </td>
                        </tr>    
                        
                        <tr <?php if(($this->action->id == "update") && !empty($model->is_required_induction) && ($model->is_required_induction == "1")){}else{ echo 'style="display:none"'; } ?> class="is_completed_tr">
                            <td>
                                Induction Completed &nbsp; <input type="radio" value="0" class="is_completed_radio" checked="checked" id="is_completed_radio_no" name="User[is_completed_induction]"/>&nbsp;No&nbsp;
                                <input type="radio" value="1" class="is_completed_radio" name="User[is_completed_induction]" <?php if(!empty($model->is_completed_induction) && ($model->is_completed_induction == "1")){echo 'checked'; } ?>/>&nbsp;Yes 
                           </td>
                        </tr>
                        
                        
                        <tr <?php if((($model->is_completed_induction == "1")) && !empty($model->induction_expiry) && ($this->action->id == "update")){}else{ echo 'style="display:none"'; } ?> class="induction_expiry_tr" id="induction_expiry_tr_id">
                            <td>
                                Induction Expiry <span class="required">*</span>
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(    
                                            'name'=>'User[induction_expiry]',
                                            'value'=>$model->induction_expiry,
                                            'options'=>array(
                                                 'changeYear' => true,
                                                'dateFormat'=>'dd-mm-yy',
                                                'changeMonth'=> true,
                                            ),
                                            'htmlOptions'=>array("style"=>"width:30%","id"=>"induction_expiry_id","readonly"=>"readonly")
                                )); ?> 
                                <br>
                                <span id="induction_expiry_error" style="display:none;color:red;">
                                    Please select an expiry date
				</span>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>

            <tr>
                <td>

                </td>
            </tr>

        </table>
    </div>
    <?php } ?>
    <!-- ********************************************************************************** -->

    <br>
    
    <div class="password-border">
        <table class="no-margin-bottom">
            <tr>
                <td><strong>Password Options</strong></td>

            </tr>


            <tr>
                <td>
                    <table
                        style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
                        <tr>
                            <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select Atleast
                                One option
                            </td>
                        </tr>


                        <tr id="password_option_3" class='hiddenElement'>

                        </tr>

                        <tr>
                            <td><input type="radio" value="1" class="pass_option" name="User[password_option]"/>&nbsp;Create
                                Password
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <input ng-model="user.passwords"
                                       data-ng-class="{'ng-invalid':userform['User[repeatpassword]'].$error.match}"
                                       placeholder="Password" type="password" id="User_password"
                                       value='<?php echo $model->password; ?>' name="User[password]">
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'password'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input ng-model="user.passwordConfirm" placeholder="Repeat Password" type="password"
                                       id="User_repeat_password" data-match="user.passwords"
                                       name="User[repeatpassword]"/>

                                <div style='font-size: 0.9em;color: #FF0000;'
                                     data-ng-show="userform['User[repeatpassword]'].$error.match">New Password does not
                                    match with <br>Repeat New Password.
                                </div>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                            </td>

                        </tr>

                        <tr>
                            <td align="center">
                                <div class="row buttons" style="margin-left:23.5px;">

                                    <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                    <input onclick="generatepassword();" class="complete btn btn-info"
                                           style="<?php echo $background; ?>position: relative; padding: 3px 6px 5px; overflow: hidden; cursor:pointer;font-size:13px"
                                           type="button" value="Autogenerate Password"/>

                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td><input class="pass_option" type="radio" name="User[password_option]" value="2"/>&nbsp;Send
                                User Invitation
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            <tr>
                <td>

                </td>
            </tr>

        </table>
    </div>
    <!-- password-border -->

    <div class="row buttons ">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('id' => 'submitForm', 'class' => 'complete')); ?>
    </div>
</td>

</tr>


</table>


<?php $this->endWidget(); ?>

</div>

<input type="hidden" id="currentAction" value="<?php echo $this->action->Id; ?>"/>
<input type="hidden" id="currentRole" value="<?php echo $session['role']; ?>"/>
<input type="hidden" id="userId" value="<?php echo $currentlyEditedUserId; ?>"/>
<input type="hidden" id="selectedUserId" value="<?php echo $session['id']; ?>"/>
<input type="hidden" id="getRole" value="<?php echo $currentRoleinUrl; ?>"/>
<input type="hidden" id="sessionCompany" value="<?php
if ($session['role'] != Roles::ROLE_SUPERADMIN) {
    echo User::model()->getCompany($currentLoggedUserId);
} else if ($this->action->id == 'update') {
    echo User::model()->getCompany($currentlyEditedUserId);
}
?>"/>


<input type="text" id="createUrlForEmailUnique" style="display:none;"
       value="<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>"/>
<input type="text" id="emailunique" style="display:none;"/>

<script>

$(".is_required_induction_radio").click(function(){
    var value=$(this).val();
    if(value == 1){
        $(".is_completed_tr").show();
        $("#is_completed_radio_no").attr("checked",true);
    }else{
        $("#induction_expiry_id").val("");
        $(".induction_expiry_tr").hide();
        $(".is_completed_tr").hide();
    }
});

$(".is_completed_radio").click(function(){
    var value=$(this).val();
    if(value == 1){
        $(".induction_expiry_tr").show();
    }else{
	$("#induction_expiry_id").val("");
        $(".induction_expiry_tr").hide();
    }
});

$("#submitForm").click(function(e){
	if($("#induction_expiry_tr_id").css('display') != 'none'){
		if($("#induction_expiry_id").val() == ''){
			$("#induction_expiry_error").show();
			e.preventDefault();	
		}else{
			$("#induction_expiry_error").hide();
		}
	}
});
	

$(document).ready(function () {
    var sessionRole = $("#currentRole").val(); //session role of currently logged in user
    var userId = $("#userId").val(); //id in url for update action
    var selectedUserId = $("#selectedUserId").val(); //session id of currenlty logged in user
    var actionId = $("#currentAction").val(); // current action
    var getRole = $("#getRole").val(); // role in url

    var admin = 1;
    var superadmin = 5;
    var agentadmin = 6;
    var agentoperator = 7;
    var operator = 8;
    var staffmember = 9;
    var agentairportadmin = 13;
    var issuingbodyadmin = 11;
    var airportoperator = 12;
    var agentairportoperator = 14;

    $(".tenantAgentRow").hide();
    $(".tenantRow").hide();
    $(".workstationRow").hide();
    $("#user_tenant_agent").disabled = true;


    if (actionId == 'update') {
        var password = $('#passwordUser').val();
        if (password) {
            $('.pass_option[value=1]').prop('checked', true);
        } else {
            $('.pass_option[value=2]').prop('checked', true);
        }
    }

    if (sessionRole == superadmin) {

        $(".tenantRow").show();

        if (getRole == agentadmin || getRole == agentairportadmin || getRole == agentoperator || getRole == agentairportoperator) {
            $("#user_tenant_agent").disabled = false;
            $(".tenantAgentRow").show();
        }else {
            $(".tenantAgentRow").hide();
        }
    }
    else if (sessionRole == admin || sessionRole == issuingbodyadmin) {

        if (getRole == operator || getRole == agentoperator) {
            $(".workstationRow").show();
        }
        if (getRole == agentairportadmin || getRole == agentoperator || getRole==agentairportoperator) {
            $("#user_tenant_agent").disabled = false;
            $(".tenantAgentRow").show();
        }
    }
    else if (sessionRole == agentadmin || sessionRole == agentairportadmin) {
        if (getRole == agentoperator || getRole == agentairportoperator) {
            getWorkstationAgentOperator();
        }
    }

    $('form').bind('submit', function () {
        $(this).find('#User_role').removeAttr('disabled');
        if (sessionRole == 6) {
            $(this).find('#User_tenant_agent').removeAttr('disabled');
        }


    });

    if (actionId == 'update') {
        document.getElementById("User_user_status").disabled = true;
        document.getElementById("User_user_type").disabled = true;
    }

    if ((selectedUserId == userId) && actionId == 'update') { //disable user role for owner
        document.getElementById("User_role").disabled = true;
    }

    $("#submitBtn").click(function (e) {
        e.preventDefault();
        checkHostEmailIfUnique();
    });


    function populateTenantAgentField(tenant) {
        $("#User_tenant_agent").empty();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentAjax&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function (r) {
                document.getElementById('User_tenant_agent').disabled = false;
                $('#User_tenant_agent option[value!=""]').remove();
                $('#User_tenant_agent').append('<option value="">Please select a tenant agent</option>');
                $.each(r.data, function (index, value) {
                    $('#User_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');
                });
                $("#User_tenant_agent").val('');
            }
        });
    }

    $('#User_tenant').on('change', function (e) {
        e.preventDefault();

        var tenant = $(this).val();
        $("#User_workstation").empty();


        if ($("#User_role").val() == operator || $("#User_role").val() == staffmember || $("#User_role").val() == agentoperator) {

            if (sessionRole == superadmin) {
                var tenant = $("#User_tenant").val();

            } else {
                var tenant = '<?php echo $session['tenant'] ?>';
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + tenant,
                dataType: 'json',
                data: tenant,
                success: function (r) {
                    $('#User_workstation option[value!=""]').remove();

                    $.each(r.data, function (index, value) {
                        $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                }
            });
        }

        if ($("#User_role").val() != operator) {
            populateTenantAgentField(tenant);
        }

    });
});

function trim(el) {
    el.value = el.value.
        replace(/(^\s*)|(\s*$)/gi, "").// removes leading and trailing spaces
        replace(/[ ]{2,}/gi, " ").// replaces multiple spaces with one space
        replace(/\n +/, "\n");           // Removes spaces after newlines
    return;
}

function sendUserForm() {

    var userform = $("#userform").serialize();
    var url;
    if ($("#currentAction").val() == 'update') {
        url = "<?php echo CHtml::normalizeUrl(array("/user/update&id=" . $currentlyEditedUserId)); ?>";
    } else {
        url = "<?php echo CHtml::normalizeUrl(array("user/create")); ?>"
    }
    $.ajax({
        type: "POST",
        url: url,
        data: userform,
        success: function (data) {
            window.location = 'index.php?r=user/admin&vms=<?php echo ($model->is_avms_user() || CHelper::is_managing_avms_user() )?'avms':'cvms' ?>';
        }
    });
}

function checkHostEmailIfUnique() {
    if ('<?php echo $model->email; ?>' == $("#User_email").val()) {
        $(".errorMessageEmail1").hide();
        $("#emailunique").val("0");
        sendUserForm();
        //$("#submitForm").click();
    } else {
        var email = $("#User_email").val();
        var tenant;
        if ($("#currentRole").val() == '5' && !is_accessing_avms_features()) { //check if superadmin
            tenant = $("#User_tenant").val();
        } else {
            tenant = '<?php echo $session['tenant']; ?>';
        }
        if ($("#User_role").val() == '1') {
            var url = $("#createUrlForEmailUnique").val() + email.trim();
        } else {
            var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
        }

        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: email,
            success: function (r) {
                $.each(r.data, function (index, value) {
                    if (value.isTaken == 1) {
                        $(".errorMessageEmail1").show();
                        $("#emailunique").val("1");

                    } else {
                        $(".errorMessageEmail1").hide();
                        $("#emailunique").val("0");
                        sendUserForm();
                        //$("#submitForm").click();

                    }
                });

            }
        });
    }
}



function populateDynamicFields()
{
    $('#password_option_3').empty();
    $("#User_workstation").empty();

    var selectedRole = $("#User_role").val();
    var sessionRole = $("#currentRole").val(); //session role of currently logged in user

    // set some roles
    var role_issusing_body_admin    = "<?php echo Roles::ROLE_ISSUING_BODY_ADMIN ?>";
    var role_agent_airport_operator = "<?php echo Roles::ROLE_AGENT_AIRPORT_OPERATOR ?>";
    var role_agent_operator         = "<?php echo Roles::ROLE_AGENT_OPERATOR ?>";
    var role_agent_airport_admin    = "<?php echo Roles::ROLE_AGENT_AIRPORT_ADMIN ?>";
    var role_agent_admin            = "<?php echo Roles::ROLE_AGENT_ADMIN ?>";
    var role_agent_operator         = "<?php echo Roles::ROLE_AGENT_OPERATOR ?>";
    var role_staff_member           = "<?php echo Roles::ROLE_STAFFMEMBER ?>";
    var role_admin                  = "<?php echo Roles::ROLE_ADMIN ?>";
    var role_operator               = "<?php echo Roles::ROLE_OPERATOR ?>";
    var role_airport_operator       = "<?php echo Roles::ROLE_AIRPORT_OPERATOR ?>";


    if([role_issusing_body_admin,role_admin,role_staff_member,role_operator,role_airport_operator].indexOf(selectedRole)!=-1){
        $("#User_tenant_agent").disabled = true;
        $("#User_tenant_agent").val('');
        $(".tenantAgentRow").hide();
    } else {
        $("#User_tenant_agent").disabled = false;
        $(".tenantAgentRow").show();
    }

    //hide required * label if role is staffmember
    if (selectedRole == role_staff_member) {
        $('#password_option_3').append('<td><input type="radio" value="3" class="pass_option" name="User[password_option]" />&nbsp;User does not require a password</td>');
        $("#password_option_3").show();
    }

    if (selectedRole == role_operator || selectedRole==role_agent_operator) {
        getWorkstationAgentOperator();
    }

}
function populateAgentOperatorWorkstations(tenant, tenantAgent, value) {

    $("#User_workstation").empty();

    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createUrl('user/getTenantAgentWorkstation&id='); ?>' + tenantAgent + '&tenant=' + tenant,
        dataType: 'json',
        data: tenantAgent,
        success: function (r) {
            $('#User_workstation option[value!=""]').remove();
            $('#User_workstation').append('<option value="">Workstation</option>');
            $.each(r.data, function (index, value) {
                $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            $("#User_workstation").val(value);
        }
    });
}

function populateOperatorWorkstations(tenant, value) {
    $.ajax({
        type: 'POST',
        url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + tenant,
        dataType: 'json',
        data: tenant,
        success: function (r) {
            $('#User_workstation option[value!=""]').remove();

            $.each(r.data, function (index, value) {
                $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
            $("#User_workstation").val(value);
        }
    });
}


function getWorkstation() { /*get workstations for operator*/
    var sessionRole = '<?php echo $session['role']; ?>';
    var superadmin = 5;

    if (sessionRole == superadmin) {
        var tenant = $("#User_tenant").val();
    }
    else {
        var tenant = '<?php echo $session['tenant'] ?>';
    }
    populateOperatorWorkstations(tenant);

}

function getWorkstationAgentOperator() { /*get workstation for agent operator*/

    var tenant = '<?php echo $session['tenant'] ?>';
    var tenantAgent = '<?php echo $session['tenant_agent'] ?>';

    populateAgentOperatorWorkstations(tenant, tenantAgent);

}


</script>

<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal">×</a>
        <br>
    </div>
    <div id="modalBody"></div>

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

                <div id="error_msg" style='font-size: 0.9em;color: #FF0000;padding-left: 11px; display:none'>Please Generate Password</div>

                <tr>
                    <td colspan="2" style="padding-left:10px">Your randomly generated password is :</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:55px; padding-top:24px;">
                        <input readonly="readonly" type="text" placeholder="Random Password" value="" id="random_password"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:10px; font-style:italic">
                        Note: Please copy and save this password somewhere safe.
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 11px;padding-top: 26px !important; width:50%">
                        <input onclick="copy_password();" style="border-radius: 4px; height: 35px; " type="button" value="Use Password"/>
                    </td>
                    <td style="padding-right:10px;padding-top: 25px;">
                        <input onclick="cancel();" style="border-radius: 4px; height: 35px;" type="button" value="Cancel"/>
                    </td>
                </tr>

            </table>


        </div>
        <a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none"
           class="btn btn-primary">Click me</a>
    </div>
</div>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Click me',
    'type' => 'primary',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#addCompanyModal',
        'id' => 'modalBtn',
        'style' => 'display:none',
    ),
));
?>
<script>

    $(document).ready(function () {

        /*Added by farhat aziz for upload host photo*/


        $('#photoCropPreview2').imgAreaSelect({
            handles: true,
            onSelectEnd: function (img, selection) {
                $("#cropPhotoBtn2").show();
                $("#x12").val(selection.x1);
                $("#x22").val(selection.x2);
                $("#y12").val(selection.y1);
                $("#y22").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });
        $("#cropPhotoBtn2").click(function (e) {
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
                    //imageUrl: $('#photoCropPreview2').attr('src').substring(1, $('#photoCropPreview2').attr('src').length),
                    photoId: $('#Host_photo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Host_photo').val(),
                        dataType: 'json',
                        success: function (r) {

                            $.each(r.data, function (index, value) {
                                
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
    });

    function cancel() {
        $('#User_repeat_password').val('');
        $('#User_password').val('');
        $("#random_password").val('');
        $("#close_generate").click();
    }

    function copy_password() {
        if ($('#random_password').val() == '') {
            $('#error_msg').show();
        } else {

            $('#User_password').val($('#random_password').val());
            $('#User_repeat_password').val($('#random_password').val());
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

    function dismissModal(id) {
        $("#dismissModal").click();

    }
</script>


<!-- PHOTO CROP-->
<div id="light2" class="white_content">

    <img id="photoCropPreview2" src="">

</div>
<div id="fade2" class="black_overlay">
</div>
<div  id="crop_button2">
    <input type="button" class="btn btn-success" id="cropPhotoBtn2" value="Crop" style="">
    <input type="button" id="closeCropPhoto2" onclick="document.getElementById('light2').style.display = 'none';
                document.getElementById('fade2').style.display = 'none';
                document.getElementById('crop_button2').style.display = 'none'" value="x" class="btn btn-danger">
</div>

<input type="hidden" id="x12"/>
<input type="hidden" id="x22"/>
<input type="hidden" id="y12"/>
<input type="hidden" id="y22"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>