<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
$session = new CHttpSession;
if (isset($_GET['role'])) {
    $userRole = $_GET['role'];
} else {
    $userRole = '';
}
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
} else { //if no id means its create
    if ($session['role'] != 5) {
        $userId = $session['id'];
    } else {
        $userId = '';
    }
}
?>

<div class="form" data-ng-app="PwordForm">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        'htmlOptions' => array("name" => "userform"),
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td style="width:200px !important;"><?php echo $form->labelEx($model, 'first_name'); ?></td>
            <td><?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'first_name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'last_name'); ?></td>
            <td><?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'last_name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'email'); ?></td>
            <td><?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'email'); ?></td>
        </tr>
<?php if ($this->action->id == 'create') { ?>
            <tr>
                <td><label for="User_password">Password <span class="required">*</span></label></td>
                <td>
                    <input ng-model="user.passwords" data-ng-class="{'ng-invalid':userform['User[repeatpassword]'].$error.match}" type="password" id="User_password" value = '<?php echo $model->password; ?>' name="User[password]">			
                </td>
                <td><?php echo $form->error($model, 'password'); ?></td>
            </tr>
            <tr>
                <td><label for="User_repeat_password">Repeat Password <span class="required">*</span></label></td>
                <td >
                    <input ng-model="user.passwordConfirm" type="password" id="User_repeat_password" data-match="user.passwords" name="User[repeatpassword]"/>			
                    <div style='font-size:10px;color:red;' data-ng-show="userform['User[repeatpassword]'].$error.match">New Password does not match with Repeat New Password. </div>
                </td>
                <td><?php echo $form->error($model, 'repeatpassword'); ?> </td>

            </tr>

                <?php } ?>
        <tr>
            <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
            <td><?php echo $form->textField($model, 'contact_number'); ?></td>
            <td><?php echo $form->error($model, 'contact_number'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'date_of_birth'); ?></td>
            <td><?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'date_of_birth',
                    'htmlOptions' => array(
                        'size' => '10', // textField size
                        'maxlength' => '10', // textField maxlength
                    ),
                ));
                ?></td>
            <td><?php echo $form->error($model, 'date_of_birth'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'role'); ?></td>
            <td><select  onchange="getTenant()" <?php
                    if ($this->action->Id != 'update' && isset($_GET['role'])) {
                        echo "disabled";
                    }
                    ?> id="User_role" name="User[role]">
                    <option disabled value='' selected>Select Role</option>
                    <?php
                    $userRoles = getAccess($session['role']); // roles with access rules from getaccess function
                    foreach ($userRoles as $values) {
                        foreach ($values as $key => $value) {
                            //put here option html 
                            ?>

                            <option id= "<?php echo $key; ?>" value="<?php echo $key; ?>" <?php
                                if (isset($_GET['role'])) {
                                    if ($userRole == $key) {
                                        echo "selected ";
                                    }
                                } elseif ($this->action->Id == 'update') {
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

                </select></td>
            <td><?php echo $form->error($model, 'role'); ?></td>
        </tr>
        <tr id="tenantRow">
            <td><?php echo $form->labelEx($model, 'tenant'); ?></td>
            <td>
                <select id="User_tenant" name="User[tenant]"  >
                    <option value='' selected>Select Admin</option>
                    <?php
                    $criteria = new CDbCriteria;
                    $criteria->select = 'id,tenant,first_name,last_name';
                    $criteria->addCondition('role = 1');

                    $opts = User::model()->findAll($criteria);
                    foreach ($opts as $key => $value) {
                        ?>
                        <option <?php
                        if ($session['role'] == '6' && $session['tenant'] == $value->id) {
                            echo " selected ";
                        }
                        ?> value="<?php echo $value->tenant; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
    <?php
}
?>
                </select>
            </td>
            <td><?php echo $form->error($model, 'tenant'); ?></td>
        </tr>
        <tr id="tenantAgentRow">
            <td><?php echo $form->labelEx($model, 'tenant_agent'); ?></td>
            <td>
                <select id="User_tenant_agent" onchange='getCompanyTenantAgent()' name="User[tenant_agent]" >

                    <?php
                    if ($this->action->Id != 'create') {
                        $criteria = new CDbCriteria;
                        $criteria->select = 'id,first_name,last_name';
                        $criteria->addCondition('role = 6');

                        $opts = User::model()->findAll($criteria);
                        foreach ($opts as $key => $value) {
                            ?>
                            <option <?php
                        if ($session['role'] == '6' && $session['tenant_agent'] == $value->id) {
                            echo " selected ";
                        }
                        ?> value="<?php echo $value->id; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
        <?php
    }
} else {
    echo "<option value='' selected>Select Tenant Agent</option>";
}
?>
                </select>
            </td>
            <td><?php echo $form->error($model, 'tenant'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'company'); ?></td>
            <td>
                <select id="User_company" name="User[company]" <?php
                    if ($session['role'] == '6' || $userRole == '8' || $session['id'] == $userId) {
                        echo " disabled ";
                    }
                    ?>>
                    <option value='' selected>Select Company</option>
                    <?php
                    $opts = CHtml::listData(Company::model()->findAll(), 'id', 'name');
                    if ($this->action->id != 'create' || $session['role'] == 1 || $userRole == 1 || $userRole == 7 || $session['role'] == 6) {
                        foreach ($opts as $key => $value) {
                            ?>
                            <option <?php
                        if ($this->action->id == 'update' || $session['role'] != 5) {
                            $company = User::model()->getCompany($userId);
                            if ($company == $key) {
                                echo " selected ";
                            }
                        }
                            ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php
                                }
                            }
                            ?>
                </select>
                <select id="User_company_base" <?php
                    if ($session['role'] == '6' || $userRole == '8') {
                        echo " disabled";
                    }
                    ?>>
<?php
$opts = CHtml::listData(Company::model()->findAll(), 'id', 'name');
foreach ($opts as $key => $value) {
    ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
    <?php
}
?>
                </select>
                <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none;">
<?php //echo CHtml::image(Yii::app()->request->baseUrl . '/images/plus_icon.png');   ?>
                    Add New Company

                </a>
            </td>
            <td><?php echo $form->error($model, 'company'); ?></td>
        </tr>
        <tr id="workstationRow">
            <td>Primary Wor
                kstation</td>
            <td>
                <select id="User_workstation" name="User[workstation]" disabled>

                </select>

            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'department'); ?></td>
            <td><?php echo $form->textField($model, 'department', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'department'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'position'); ?></td>
            <td><?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'position'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'Staff ID'); ?></td>
            <td><?php echo $form->textField($model, 'staff_id', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'staff_id'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'notes'); ?></td>
            <td><?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?></td>
            <td><?php echo $form->error($model, 'notes'); ?></td>
        </tr>

        <tr>
            <td><?php echo $form->labelEx($model, 'user_type'); ?></td>
            <td><?php echo $form->dropDownList($model, 'user_type', User::$USER_TYPE_LIST); ?></td>
            <td><?php echo $form->error($model, 'user_type'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'user_status'); ?></td>
            <td><?php echo $form->dropDownList($model, 'user_status', User::$USER_STATUS_LIST); ?></td>
            <td><?php echo $form->error($model, 'user_status'); ?></td>
        </tr>
    </table>


    <button class="btn btn-success" id="submitBtn"><?php echo ($this->action->Id == 'create' ? 'Create' : 'Save') ?></button>
    <div class="row buttons" style='display:none;'>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submitForm',)); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<input type="hidden" id="currentAction" value="<?php echo $this->action->Id; ?>"/>
<input type="hidden" id="currentRole" value="<?php echo $session['role']; ?>"/>
<input type="hidden" id="userId" value="<?php echo $userId; ?>"/>
<input type="hidden" id="selectedUserId" value="<?php echo $session['id']; ?>"/>
<input type="hidden" id="getRole" value="<?php echo $userRole; ?>"/>
<input type="hidden" id="sessionCompany" value="<?php
if ($session['role'] != 5 && $this->action->id == 'update') {
    echo User::model()->getCompany($userId);
}
?>"/>
<script>

    $(document).ready(function() {
        $("#addCompanyLink").hide(); //button for adding company
        $("#User_company_base").hide();
        $("#tenantAgentRow").hide();
        $("#tenantRow").hide();
        $("#workstationRow").hide();

        document.getElementById('User_tenant').disabled = true;
        document.getElementById('User_tenant_agent').disabled = true;

        var sessionRole = $("#currentRole").val(); //session role of currently logged in user
        var userId = $("#userId").val(); //id in url for update action
        var selectedUserId = $("#selectedUserId").val(); //session id of currenlty logged in user
        var actionId = $("#currentAction").val(); // current action
        var getRole = $("#getRole").val(); // role in url

        if ((getRole != 1 && getRole != '') && sessionRole == 5) { //5 is superadmin and add user with role url
            if (getRole == 6) {

                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_tenant').disabled = false;
                $("#tenantRow").show();
                $("#addCompanyLink").show();
            }
            else if (getRole == 8) {
                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_workstation').disabled = false;
                $("#workstationRow").show();
                $("#tenantRow").show();

            }
            else if (getRole == 7) {
                $("#User_company").empty();
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_tenant_agent').disabled = false;
                $("#tenantRow").show();
                $("#tenantAgentRow").show();
                document.getElementById('User_workstation').disabled = false;
                $("#workstationRow").show();
            }
            else {
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_tenant_agent').disabled = false;
                $("#tenantRow").show();
                $("#tenantAgentRow").show();
            }
        } else if (getRole == 1 && sessionRole == 5) {
            $("#addCompanyLink").show();
        }
        else if (sessionRole == 1) {
            if (getRole == 1)
            {
                $("#User_company").val($("#sessionCompany").val());
                document.getElementById('User_company').disabled = true;

            }
            else if (getRole == 8) {
                document.getElementById('User_workstation').disabled = false;
                $("#workstationRow").show();
                getWorkstation();
            }
            else if (getRole == 6) {
                $("#addCompanyLink").show();
            }
        }
        else if (sessionRole == 6) {
            if (getRole == 7) {
                document.getElementById('User_workstation').disabled = false;
                $("#workstationRow").show();
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

        if ((selectedUserId == userId) && actionId == 'update') {
            document.getElementById("User_role").disabled = true;
        }

        $("#submitBtn").click(function(e) {

            e.preventDefault();
            var Password = $("#User_password").val();
            var repeatPassword = $("#User_repeat_password").val();
            $("#submitForm").click();
//            if (((Password != '' && repeatPassword != '') && (Password === repeatPassword))) {
//                $("#submitForm").click();
//            }else {
//                alert("Password cannot be blank.");
//            }
        });

        $('#User_tenant').on('change', function(e) {
            e.preventDefault();
            var tenant = $(this).val();
            $("#User_company").empty();
            $("#User_workstation").empty();
            if ($("#User_role").val() == 8 || $("#User_role").val() == 9 || $("#User_role").val() == 6) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentCompany&id='); ?>' + tenant,
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
            if ($("#User_role").val() == 8) {
                if (sessionRole == 5)
                {
                    var tenant = $("#User_tenant").val();
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

            if ($("#User_role").val() != 8)
            {
                $("#User_tenant_agent").empty();
                $("#User_company").empty();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('user/GetTenantAjax&id='); ?>' + tenant,
                    dataType: 'json',
                    data: tenant,
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

        });
    });

    function getTenant() {
        if (<?php echo $session['role'] ?> == 5)
        {
            $("#User_company").empty();
        }
        var selectedRole = $("#User_role").val();
        var sessionRole = $("#currentRole").val(); //session role of currently logged in user
        var actionId = $("#currentAction").val(); // current action

        if (actionId == 'update' || actionId == 'create') {
            if (sessionRole == 1)
            {
                if (selectedRole == 1)
                {
                    // $("#User_company").val($("#sessionCompany").val());
                    document.getElementById('User_company').disabled = true;
                    document.getElementById('User_workstation').disabled = true;
                    $("#workstationRow").hide();


                }
                else if (selectedRole == 8)
                {
                    $("#User_company").val($("#sessionCompany").val());
                    document.getElementById('User_company').disabled = true;
                    document.getElementById('User_workstation').disabled = false;
                    $("#workstationRow").show();
                    getWorkstation();
                }
                else if (selectedRole == 9) {
                    document.getElementById('User_workstation').disabled = true;
                    $("#workstationRow").hide();
                    $("#User_company").val($("#sessionCompany").val());
                    document.getElementById('User_tenant').disabled = true;
                    document.getElementById('User_company').disabled = true;
                    var selectedUserId = $("#selectedUserId").val();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('user/GetTenantAjax&id='); ?>' + selectedUserId,
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
                    $("#workstationRow").hide();
                    document.getElementById('User_company').disabled = false;
                }
            }
            else if (sessionRole == 5)
            {

                if (selectedRole != 1) { // if selected is not equal to admin enable tenant
                    if (selectedRole == 8) {
                        document.getElementById('User_tenant_agent').disabled = true;
                        document.getElementById('User_workstation').disabled = false;
                        $("#tenantAgentRow").hide();
                        $("#tenantRow").show();
                        $("#workstationRow").show();
                        document.getElementById('User_tenant').disabled = false;
                        document.getElementById('User_company').disabled = true;
                        $("#User_tenant").val('');

                    } else if (selectedRole == 9) {
                        document.getElementById('User_tenant_agent').disabled = false;
                        $("#tenantAgentRow").show();
                        $("#tenantRow").show();
                        document.getElementById('User_tenant').disabled = false;
                        document.getElementById('User_company').disabled = true;
                        document.getElementById('User_workstation').disabled = true;
                        $("#workstationRow").hide();
                        $("#User_tenant").val('');
                        $("#User_tenant_agent").empty();
                    }
                    else if (selectedRole == 6) {
                        $("#User_tenant").val('');
                        document.getElementById('User_tenant_agent').disabled = true;
                        $("#tenantAgentRow").hide();
                        document.getElementById('User_company').disabled = true;
                        document.getElementById('User_workstation').disabled = true;
                        $("#workstationRow").hide();
                        $("#tenantRow").show();



                        document.getElementById('User_tenant').disabled = false;
                    } else if (selectedRole == 7) {
                        document.getElementById('User_tenant_agent').disabled = false;
                        $("#tenantAgentRow").show();
                        document.getElementById('User_company').disabled = true;
                        $("#tenantRow").show();
                        document.getElementById('User_tenant').disabled = false;
                        document.getElementById('User_workstation').disabled = false;
                        $("#workstationRow").show();
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
                    /*Taking an array of all options-2 and kind of embedding it on the select1*/
                    $("#User_company").data('options', $('#User_company_base option').clone());
                    var id = $("#User_company").val();
                    var options = $("#User_company").data('options');
                    $('#User_company').html(options);
                    document.getElementById('User_workstation').disabled = true;
                    $("#workstationRow").hide();
                    $("#tenantRow").hide();
                    $("#tenantAgentRow").hide();
                }
            }
            else if (sessionRole == 6) {
                if (selectedRole == 7) {
                    document.getElementById('User_workstation').disabled = false;
                    $("#workstationRow").show();
                    getWorkstationAgentOperator();
                } else {
                    document.getElementById('User_workstation').disabled = true;
                    $("#workstationRow").hide();
                }
            }
        }

        if (sessionRole == 5 && (selectedRole == '1' || selectedRole == '6')) {
            $("#addCompanyLink").show();
        } else if (sessionRole == 1 && selectedRole == '6') {
            $("#addCompanyLink").show();
        }
        else {
            $("#addCompanyLink").hide();
        }
    }

    function getCompanyTenantAgent() {
        var tenantAgent = $("#User_tenant_agent").val();
        if ($("#User_role").val() != 9 && $("#User_role").val() != 6) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentCompany&id='); ?>' + tenantAgent,
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
        if ($("#User_role").val() == 7) {
            if ($("#currentRole").val() == 5)
            {
                var tenantAgent = $("#User_tenant_agent").val();
                var tenant = $("#User_tenant").val();
            }
            else {
                var tenant = '<?php echo $session['tenant'] ?>';
                var tenantAgent = '<?php echo $session['tenant_agent'] ?>';
            }
            $("#User_company").empty();
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

                }
            });
        }
    }

    function getWorkstation() {
        var sessionRole = '<?php echo $session['role']; ?>';
        if ($("#User_role").val() == 8) {
            if (sessionRole == 5)
            {
                var tenant = $("#User_tenant").val();
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
    }

    function getWorkstationAgentOperator() {
        if ($("#User_role").val() == 7) {

            var tenant = '<?php echo $session['tenant'] ?>';
            var tenantAgent = '<?php echo $session['tenant_agent'] ?>';

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

                }
            });
        }
    }
</script>

<?php

function getAccess($user_role) {
    $session = new CHttpSession;
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
    } else {
        $userId = '';
    }

    $accessRoles = array();
    switch ($user_role) {
        case 6: //agentadmin
            if ($session['id'] == $userId) {
                $canAccess = array("6", "7", "9"); //keys
            } else {
                $canAccess = array("7", "9"); //keys
            }
            $search_array = User::$USER_ROLE_LIST;
            foreach ($canAccess as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $accessRoles[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;

        case 5: //superadmin

            if ($session['id'] == $userId) {
                $canAccess = array("1", "5", "6", "7", "8", "9"); //keys
            } else {
                $canAccess = array("1", "6", "7", "8", "9");
            } //keys
            $search_array = User::$USER_ROLE_LIST;
            foreach ($canAccess as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $accessRoles[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;

        case 1: //admin
            $canAccess = array("1", "6", "8", "9"); //keys
            $search_array = User::$USER_ROLE_LIST;
            foreach ($canAccess as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $accessRoles[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;
    }
    return $accessRoles;
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

        if (sessionRole == 5) {
            if (selectedRole == 6) {
                url = '<?php echo $this->createUrl('company/create&viewFrom=1&tenant=') ?>' + tenant;
            }
        }
        $("#modalBody").html('<iframe width="100%" height="80%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
        $("#modalBtn").click();
    }

    function dismissModal(id) {
        $("#dismissModal").click();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('company/GetCompanyList&lastId='); ?>',
            dataType: 'json',
            success: function(r) {
                $('#User_company option[value!=""]').remove();
                $('#User_company_base option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $('#User_company_base').append('<option value="' + value.id + '">' + value.name + '</option>');
                    document.getElementById('User_company').disabled = false;
                    $("#User_company").val(value.id);
                });

            }
        });
    }
</script>
