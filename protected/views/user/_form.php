<?php


$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-birthday.js');
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
}

$currentLoggedUserId = $session['id'];
?>

<div class="form" data-ng-app="PwordForm">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'userform',
        'htmlOptions' => array("name" => "userform"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                            if($("#User_role").val() == 7 && $("#User_tenant_agent").val() == "" && $("#currentRole").val() != 6){
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
            <td style="vertical-align: top;">
                <table>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'role'); ?></td>
                        <td><select  onchange="populateDynamicFields()" <?php
if ($this->action->Id == 'create' && isset($_GET['role'])) { //if action create with user roles selected in url
    echo "disabled";
}
?> id="User_role" name="User[role]">
                                <option disabled value='' selected>Select Role</option>
                                     <?php
                                     $assignableRowsArray = getAssignableRoles($session['role']); // roles with access rules from getaccess function
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

                            </select><?php echo "<br>" . $form->error($model, 'role'); ?></td>

                    </tr>
                    <tr id="tenantRow" class='hiddenElement'>
                        <td><?php echo $form->labelEx($model, 'tenant'); ?><span class="required">*</span></td>
                        <td>
                            <select id="User_tenant" name="User[tenant]"  >
                                <option value='' selected>Select Tenant</option>
<?php
$allTenantCompanyNames = User::model()->findAllCompanyTenant();
foreach ($allTenantCompanyNames as $key => $value) {
    ?>
                                    <option <?php
                                    if ($session['role'] == Roles::ROLE_AGENT_ADMIN && $session['tenant'] == $value['id']) {
                                        echo " selected "; //if logged in is agent admin and tenant of agent admin = admin id in adminList
                                    }
                                    ?> value="<?php echo $value['tenant']; ?>"><?php echo $value['name']; ?></option>
                                    <?php
                                    }
                                    ?>
                            </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>
                        </td>
                    </tr>
                    <tr id="tenantAgentRow" class='hiddenElement'>
                        <td><?php echo $form->labelEx($model, 'tenant_agent'); ?><span class="required tenantField">*</span></td>
                        <td>
                            <select id="User_tenant_agent" onchange='getCompanyTenantAgent()' name="User[tenant_agent]" >

<?php
if ($this->action->Id != 'create' || isset($_POST['User'])) {

    $allAgentAdminNames = User::model()->findAllTenantAgent($model['tenant_agent']);
    foreach ($allAgentAdminNames as $key => $value) {
        ?>
                                        <option <?php
                                        if ($session['role'] == Roles::ROLE_AGENT_ADMIN && $session['tenant_agent'] == $value['id']) {
                                            echo " selected "; //if logged in is agent admin and tenant agent of logged in user is = agentadminname
                                        }
                                        ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                        <?php
                                        }
                                    } else {
                                        echo "<option value='' selected>Select Tenant Agent</option>";
                                    }
                                    ?>
                            </select><?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                        </td>
                    </tr>

                    <tr >
                        <td class="workstationRow"> Primary Workstation</td>
                        <td class="workstationRow">
                            <select id="User_workstation" name="User[workstation]" disabled></select>
                        </td>
                        <td class="workstationRow"></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'user_type'); ?></td>
                        <td><?php echo $form->dropDownList($model, 'user_type', User::$USER_TYPE_LIST); ?>
<?php echo "<br>" . $form->error($model, 'user_type'); ?>
                        </td>

                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'user_status'); ?></td>
                        <td><?php echo $form->dropDownList($model, 'user_status', User::$USER_STATUS_LIST); ?>
<?php echo "<br>" . $form->error($model, 'user_status'); ?>
                        </td>

                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'notes'); ?></td>
                        <td><?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?>
<?php echo "<br>" . $form->error($model, 'notes'); ?>
                        </td>

                    </tr>
<?php if ($this->action->id == 'create') { ?>
                        <tr>
                            <td><label for="User_password">Password <span class="required">*</span></label></td>
                            <td>
                                <input ng-model="user.passwords" data-ng-class="{
                                                                'ng-invalid':userform['User[repeatpassword]'].$error.match}" type="password" id="User_password" value = '<?php echo $model->password; ?>' name="User[password]">			
                                       <?php echo "<br>" . $form->error($model, 'password'); ?>
                            </td>
                        </tr>
                        <tr >
                            <td style="vertical-align: top !important;padding-top: 11px;"><label for="User_repeat_password">Repeat Password <span class="required">*</span></label></td>
                            <td >
                                <input ng-model="user.passwordConfirm" type="password" id="User_repeat_password" data-match="user.passwords" name="User[repeatpassword]"/>			
                                <div style='font-size: 0.9em;color: #FF0000;'  data-ng-show="userform['User[repeatpassword]'].$error.match">New Password does not match with <br>Repeat New Password. </div>
    <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                            </td>

                        </tr>

<?php } ?>


                </table>
            </td>
            <td style="vertical-align: top;">
                <table>
                    <tr>
                        <td style="width:110 !important;"><?php echo $form->labelEx($model, 'first_name'); ?></td>
                        <td><?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
<?php echo "<br>" . $form->error($model, 'first_name'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'last_name'); ?></td>
                        <td><?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
<?php echo "<br>" . $form->error($model, 'last_name'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td><?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
<?php echo "<br>" . $form->error($model, 'email'); ?>
                            <span class="errorMessageEmail1" style="display:none;color:red;font-size:10px;">A profile already exists for this email address</span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                        <td><?php echo $form->textField($model, 'contact_number'); ?>
<?php echo "<br>" . $form->error($model, 'contact_number'); ?></td>
                    </tr>
                    <tr id="companyTr">
                        <td><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td id='companyRow'>
                            <select id="User_company" name="User[company]" <?php
if ($session['role'] == Roles::ROLE_AGENT_ADMIN || $currentRoleinUrl == Roles::ROLE_OPERATOR || $currentLoggedUserId == $currentlyEditedUserId) {
    echo " disabled ";
} //if currently logged in user is agent admin or if selected role=operator or owner is editing his account
?>>
                                <option value='' selected>Select Company</option>
                                    <?php
                                    $criteria = new CDbCriteria();

                                    $criteria->addCondition("id!= 1");
                                    $companyList = CHtml::listData(Company::model()->findAll($criteria), 'id', 'name');
                                    if (isset($_GET['role'])) {
                                        $urlRole = $_GET['role'];
                                    } else {
                                        $urlRole = '';
                                    }
                                    if ($this->action->id != 'create' || $session['role'] == Roles::ROLE_ADMIN || $urlRole == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_AGENT_ADMIN || $urlRole == Roles::ROLE_AGENT_ADMIN) {
                                        foreach ($companyList as $key => $value) {
                                            ?>
                                        <option <?php
                                        if ($this->action->id == 'update') {
                                            $company = User::model()->getCompany($currentlyEditedUserId);
                                        } elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                            $company = User::model()->getCompany($currentLoggedUserId);
                                        }
                                        if (isset($company) && $company == $key) {
                                            echo " selected ";
                                        }
                                        ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                            </select>
                            <select id="User_company_base" style="display:none;">
<?php
$criteria = new CDbCriteria();
if ($session['role'] != Roles::ROLE_SUPERADMIN) {
    $criteria->addCondition("id!= 1 and id!=" . $session['company']);
} else {
    $criteria->addCondition("id!= 1");
}
$companyList = CHtml::listData(Company::model()->findAll($criteria), 'id', 'name');
foreach ($companyList as $key => $value) {
    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none;display:none;">Add New Company</a>
<?php echo $form->error($model, 'company'); ?>
                        </td>
                        <td></td></tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'department'); ?></td>
                        <td><?php echo $form->textField($model, 'department', array('size' => 50, 'maxlength' => 50)); ?>
<?php echo "<br>" . $form->error($model, 'department'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'position'); ?></td>
                        <td><?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50)); ?>
<?php echo "<br>" . $form->error($model, 'position'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Staff ID</td>
                        <td><?php echo $form->textField($model, 'staff_id', array('size' => 50, 'maxlength' => 50)); ?>
<?php echo "<br>" . $form->error($model, 'staff_id'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'date_of_birth'); ?></td>
                        <td class="birthdayDropdown">
                            <input type="hidden" id="dateofBirthBreakdownValueYear" value="<?php echo date("Y", strtotime($model->date_of_birth)); ?>">
                            <input type="hidden" id="dateofBirthBreakdownValueMonth" value="<?php echo date("n", strtotime($model->date_of_birth)); ?>">
                            <input type="hidden" id="dateofBirthBreakdownValueDay" value="<?php echo date("j", strtotime($model->date_of_birth)); ?>">

                            <select id="fromMonth" name="User[birthdayMonth]" class='monthSelect'></select>
                            <select id="fromDay" name="User[birthdayDay]" class='daySelect'></select>
                            <select id="fromYear" name="User[birthdayYear]" class='yearSelect'></select>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <div class="buttonsAlignToRight">
        <!--<button class="btn btn-success " id="submitBtn"><?php echo ($this->action->Id == 'create' ? 'Add' : 'Save') ?></button>-->
        <div class="row buttons " >
<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'submitForm', 'class' => 'complete')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

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


<input type="text" id="createUrlForEmailUnique" style="display:none;" value="<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>"/>
<input type="text" id="emailunique" style="display:none;" />

<script>

    $(document).ready(function() {


        var sessionRole = $("#currentRole").val(); //session role of currently logged in user
        var userId = $("#userId").val(); //id in url for update action
        var selectedUserId = $("#selectedUserId").val(); //session id of currenlty logged in user
        var actionId = $("#currentAction").val(); // current action
        var getRole = $("#getRole").val(); // role in url

        var superadmin = 5;
        var admin = 1;
        var agentadmin = 6;
        var agentoperator = 7;
        var operator = 8;
        var staffmember = 9;

        $("#addCompanyLink").hide(); //button for adding company
        $("#tenantAgentRow").hide();
        $("#tenantRow").hide();
        $(".workstationRow").hide();
        
        document.getElementById('User_tenant').disabled = true;
        document.getElementById('User_tenant_agent').disabled = true;
        document.getElementById('User_company').disabled = true;
        if (actionId == 'update') {
            $("#fromYear").val($("#dateofBirthBreakdownValueYear").val());
            $("#fromMonth").val($("#dateofBirthBreakdownValueMonth").val());
            $("#fromDay").val($("#dateofBirthBreakdownValueDay").val());

        }
      
        if ((getRole != admin && getRole != '') && sessionRole == superadmin) {
            if (getRole == agentadmin) {

                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_tenant').disabled = false;
                $("#tenantRow").show();
                $("#addCompanyLink").show();
                document.getElementById("companyRow").style.paddingBottom = "10px";
            }
            else if (getRole == operator) {
                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                $("#tenantRow").show();
            }
            else if (getRole == agentoperator) {
                // $("#User_company").empty();
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_tenant_agent').disabled = false;
                $("#tenantRow").show();
                $("#tenantAgentRow").show();
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
            }
            else {
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_tenant_agent').disabled = false;
                $("#tenantRow").show();
                $("#tenantAgentRow").show();
            }
        } else if (getRole == admin && sessionRole == superadmin) {
            $("#addCompanyLink").show();
            document.getElementById("companyRow").style.paddingBottom = "10px";
        }
        else if (sessionRole == admin) {
            if (getRole == admin)
            {
                $("#User_company").val($("#sessionCompany").val());
                document.getElementById('User_company').disabled = true;
            }
            else if (getRole == operator) {
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                getWorkstation();
            }
            else if (getRole == agentadmin) {
                $("#addCompanyLink").show();
                document.getElementById("companyRow").style.paddingBottom = "10px";
                document.getElementById('User_company').disabled = false;
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').hide();
                $("#User_company").val("");
            }
        }
        else if (sessionRole == agentadmin) {
            if (getRole == agentoperator) {
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                getWorkstationAgentOperator();
            }
        }

        $('form').bind('submit', function() {
            $(this).find('#User_role').removeAttr('disabled');
            $(this).find('#User_company').removeAttr('disabled');
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

        $("#submitBtn").click(function(e) {
            e.preventDefault();
            checkHostEmailIfUnique();


        });

        function populateTenantAgentField(tenant) {
            $("#User_tenant_agent").empty();
            //$("#User_company").empty();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentAjax&id='); ?>' + tenant,
                dataType: 'json',
                data: tenant,
                success: function(r) {
                    document.getElementById('User_tenant_agent').disabled = false;
                    $('#User_tenant_agent option[value!=""]').remove();
                    $('#User_tenant_agent').append('<option value="">Select Tenant Agent</option>');
                    $.each(r.data, function(index, value) {
                        $('#User_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');
                    });
                    $("#User_tenant_agent").val('');
                }
            });
        }

        $('#User_tenant').on('change', function(e) {
            e.preventDefault();

            var tenant = $(this).val();
            $("#User_company").empty();
            $("#User_workstation").empty();

            if ($("#User_role").val() == agentadmin) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('user/GetTenantOrTenantAgentCompany&id='); ?>' + tenant,
                    dataType: 'json',
                    data: tenant,
                    success: function(r) {
                        $('#User_company option[value!=""]').remove();

                        $.each(r.data, function(index, value) {
                            $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');

                        });
                        if ($("#User_role").val() == 6) {
                            document.getElementById('User_company').disabled = false;
                        }
                    }
                });
            }
            if ($("#User_role").val() == operator || $("#User_role").val() == staffmember || $("#User_role").val() == agentoperator) {
                if (sessionRole == superadmin)
                {
                    var tenant = $("#User_tenant").val();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('user/getCompanyOfTenant&id='); ?>' + tenant,
                        dataType: 'json',
                        data: tenant,
                        success: function(r) {
                            $('#User_company option[value!=""]').remove();

                            $.each(r.data, function(index, value) {
                                $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');

                            });

                        }
                    });
                }
                else {
                    var tenant = '<?php echo $session['tenant'] ?>';
                }

                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + tenant,
                    dataType: 'json',
                    data: tenant,
                    success: function(r) {
                        $('#User_workstation option[value!=""]').remove();

                        $.each(r.data, function(index, value) {
                            $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                    }
                });
            }

            if ($("#User_role").val() != operator)
            {
                populateTenantAgentField(tenant);
            }

        });
    });

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
            success: function(data) {
                window.location = 'index.php?r=user/admin';
            },
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
            if ($("#currentRole").val() == 5) { //check if superadmin
                tenant = $("#User_tenant").val();
            } else {
                tenant = '<?php echo $session['tenant']; ?>';
            }
            if ($("#User_role").val() == 1) {
                var url = $("#createUrlForEmailUnique").val() + email.trim();
            } else {
                var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
            }

            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: email,
                success: function(r) {
                    $.each(r.data, function(index, value) {
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

    function populateDynamicFields() {
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
        if(selectedRole == staffmember){
            $(".tenantField").hide();
        } else {
            $(".tenantField").show();
        }
        if (sessionRole == admin)
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
                        $('#User_tenant_agent').append('<option value="">Select Tenant Agent</option>');
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
        if ((sessionRole == superadmin && (selectedRole == admin || selectedRole == agentadmin)) || (sessionRole == admin && selectedRole == agentadmin)) {
            $("#addCompanyLink").show();
            document.getElementById("companyRow").style.paddingBottom = "10px";
        }
        else {
            $("#addCompanyLink").hide();
            document.getElementById("companyRow").style.paddingBottom = "0px";
        }
    }
    function populateAgentOperatorWorkstations(tenant, tenantAgent, value) {

        $("#User_workstation").empty();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getTenantAgentWorkstation&id='); ?>' + tenantAgent + '&tenant=' + tenant,
            dataType: 'json',
            data: tenantAgent,
            success: function(r) {
                $('#User_workstation option[value!=""]').remove();

                $.each(r.data, function(index, value) {
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
            success: function(r) {
                $('#User_workstation option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#User_workstation").val(value);
            }
        });
    }
    function getCompanyTenantAgent() { /*get tenant agent company*/
        var tenantAgent = $("#User_tenant_agent").val();
        var staffmember = 9;
        var agentadmin = 6;
        var agentoperator = 7;
        var superadmin = 5;

        if ($("#User_role").val() != staffmember && $("#User_role").val() != agentadmin && $("#User_role").val() != agentoperator) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('user/GetTenantOrTenantAgentCompany&id='); ?>' + tenantAgent,
                dataType: 'json',
                data: tenantAgent,
                success: function(r) {
                    $('#User_company option[value!=""]').remove();

                    $.each(r.data, function(index, value) {
                        $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                        document.getElementById('User_company').disabled = true;
                    });

                }
            });
        }
        if ($("#User_role").val() == agentoperator || $("#User_role").val() == staffmember) {
            if ($("#currentRole").val() == superadmin)
            {
                var sessionRole = '<?php echo $session['role']; ?>';
                var tenantAgent = $("#User_tenant_agent").val();
                var tenant = $("#User_tenant").val();
                if (sessionRole == 5)
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('user/getCompanyOfTenant&id='); ?>' + tenant + '&tenantAgentId=' + tenantAgent,
                        dataType: 'json',
                        data: tenant,
                        success: function(r) {
                            $('#User_company option[value!=""]').remove();

                            $.each(r.data, function(index, value) {
                                $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');

                            });

                        }
                    });
                }
            }
            else {
                var tenant = '<?php echo $session['tenant'] ?>';
                var tenantAgent = '<?php echo $session['tenant_agent'] ?>';
            }
            populateAgentOperatorWorkstations(tenant, tenantAgent);
        }
    }

    function getWorkstation() { /*get workstations for operator*/
        var sessionRole = '<?php echo $session['role']; ?>';
        var superadmin = 5;

        if (sessionRole == superadmin)
        {
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

<?php

function getAssignableRoles($user_role) {
    $session = new CHttpSession;
    if (isset($_GET['id'])) { //if update
        $userIdOnUpdate = $_GET['id'];
    } else {
        $userIdOnUpdate = '';
    }

    $assignableRolesArray = array();
    switch ($user_role) {
        case Roles::ROLE_AGENT_ADMIN: //agentadmin
            //if session id = id editing ->add role of logged in
            if ($session['id'] == $userIdOnUpdate) {
                $assignableRoles = array(Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys
            } else {
                $assignableRoles = array(Roles::ROLE_AGENT_ADMIN,Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys
            }
            foreach ($assignableRoles as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
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
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;

        case Roles::ROLE_ADMIN: //admin
            $assignableRoles = array(Roles::ROLE_ADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys

            foreach ($assignableRoles as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
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
    function addCompany() {
        var url = '<?php echo $this->createUrl('company/create&viewFrom=1') ?>';
        var sessionRole = $("#currentRole").val();
        var selectedRole = $("#User_role").val();
        var tenant = $("#User_tenant").val();
        var superadmin = 5;
        var agentadmin = 6;
        if (sessionRole == superadmin) {
            if (selectedRole == agentadmin) {
                url = '<?php echo $this->createUrl('company/create&viewFrom=1&tenant=') ?>' + tenant;
            }
        }

        $("#modalBody").html('<iframe width="100%" id="companyModalIframe" height="98%" frameborder="0" scrolling="no" src="' + url + '" ></iframe>');
        $("#modalBtn").click();
    }

    function dismissModal(id) {
        $("#dismissModal").click();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('company/GetCompanyList&lastId='); ?>',
            dataType: 'json',
            success: function(r) {
              //  $('#User_company option[value!=""]').remove();
              //  $('#User_company_base option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $('#User_company_base').append('<option value="' + value.id + '">' + value.name + '</option>');
                    document.getElementById('User_company').disabled = false;
                    $("#User_company").val(value.id);
                });

                var duplicateChk = {};

                $('#User_company').each(function() {
                    if (duplicateChk.hasOwnProperty(this.id)) {
                        $(this).remove();
                    } else {
                        duplicateChk[this.id] = 'true';
                    }
                });
            }
        });
    }
</script>



