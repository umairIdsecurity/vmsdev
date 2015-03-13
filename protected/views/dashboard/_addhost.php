<?php
$session = new CHttpSession;
?>
<div id="findAddHostRecordDiv" class="findAddHostRecordDiv form">
    <input type="text" id="sessionRole" value="<?php echo $session['role']; ?>" style="display:none;" >

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'registerhostform',
        'action' => Yii::app()->createUrl('/user/create'),
        'htmlOptions' => array("name" => "registerhostform", "style" => "display:block;"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                checkHostEmailIfUnique();
                                }
                        }'
        ),
    ));
    ?>
    <?php echo $form->errorSummary($userModel); ?>
    <input type="text" id="hostEmailIsUnique" value="0"/>
    <div class="visitor-title">Add Host</div>
    <div >
        <table  id="addhost-table" data-ng-app="PwordForm">
            <tr <?php
            if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                echo "style='display:none;'";
            }
            ?>
                >
                    <?php
                    if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                        ?>
                    <td id="hostTenantRow"><?php echo $form->labelEx($userModel, 'tenant'); ?><br>
                        <select id="User_tenant" onchange="populateHostTenantAgentAndCompanyField()" name="User[tenant]"  >
                            <option value='' selected>Please select a tenant</option>
                            <?php
                            $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                            foreach ($allTenantCompanyNames as $key => $value) {
                                ?>
                                <option value="<?php echo $value['tenant']; ?>" ><?php echo $value['name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                    </td>
                    <td id="hostTenantAgentRow"><?php echo $form->labelEx($userModel, 'tenant_agent'); ?><br>
                        <select id="User_tenant_agent" name="User[tenant_agent]" onchange="populateHostCompanyWithSameTenantAndTenantAgent()" >
                            <?php
                            echo "<option value='' selected>Please select a tenant agent</option>";
                            ?>
                        </select>
                        <?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                    </td>

                    <td id="hostCompanyRow">
                        <?php echo $form->labelEx($userModel, 'company'); ?><br>
                        <select id="User_company" name="User[company]" disabled>
                            <option value=''>Please select a company</option>
                        </select>
                        <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                    </td>
                    <?php
                } else {
                    ?>
                    <td id="hostTenantRow"><?php echo $form->labelEx($userModel, 'tenant'); ?><br>
                        <input type="text" id="User_tenant" name="User[tenant]" value="<?php echo $session['tenant']; ?>"/>
                        <?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                    </td>
                    <td id="hostTenantAgentRow"><?php echo $form->labelEx($userModel, 'tenant_agent'); ?><br>
                        <input type="text" id="User_tenant_agent" name="User[tenant_agent]" value="<?php echo $session['tenant_agent']; ?>"/>
                        <?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                    </td>

                    <td id="hostCompanyRow">
                        <?php echo $form->labelEx($userModel, 'company'); ?><br>
                        <input type="text" id="User_company" name="User[company]" value="<?php echo $session['company']; ?>"/>
                        <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($userModel, 'first_name'); ?><br>
                    <?php echo $form->textField($userModel, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'first_name'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($userModel, 'last_name'); ?><br>
                    <?php echo $form->textField($userModel, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'last_name'); ?>
                </td>
                <td>

                    <?php echo $form->labelEx($userModel, 'department'); ?><br>
                    <?php echo $form->textField($userModel, 'department', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'department'); ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($userModel, 'staff_id'); ?><br>
                    <?php echo $form->textField($userModel, 'staff_id', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'staff_id'); ?>
                </td>

                <td>
                    <?php echo $form->labelEx($userModel, 'email'); ?><br>
                    <?php echo $form->textField($userModel, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'email'); ?>
                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >A profile already exists for this email address.</div>
                </td>
                <td>
                    <?php echo $form->labelEx($userModel, 'contact_number'); ?><br>
                    <?php echo $form->textField($userModel, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'contact_number'); ?>
                </td>
            </tr>


            <tr>
                <td>
                    <label for="User_password">Password <span class="required">*</span></label><br>
                    <input type="password" id="User_password" name="User[password]" onChange="checkPasswordMatch();">			
                    <?php echo "<br>" . $form->error($userModel, 'password'); ?>
                </td>

                <td>
                    <label for="User_repeatpassword">Repeat Password <span class="required">*</span></label><br>
                    <input type="password" id="User_repeatpassword" name="User[repeatpassword]" onChange="checkPasswordMatch();"/>			
                    <div style='font-size:10px;color:red;font-size:0.9em;display:none;margin-bottom:-20px;' id="passwordErrorMessage">New Password does not match with <br>Repeat New Password. </div>
                    <?php echo "<br>" . $form->error($userModel, 'repeatpassword'); ?>
                </td>
            </tr>

            <tr>
                <td style="display:none;">
                    <input name="User[role]" id="User_role" value="<?php echo Roles::ROLE_STAFFMEMBER ?>"/>
                    <input name="User[user_type]" id="User_user_type" value="<?php echo UserType::USERTYPE_INTERNAL; ?>"/>             
                </td>
            </tr>


        </table>

    </div>
    <div style="text-align: right;">
        <input type="button" id="clicktabC" value="Add" style="display:none;"/>

        <input type="submit" value="Add" name="yt0" id="submitFormUser" class="complete" />
    </div>
    <?php $this->endWidget(); ?>

</div>
<input type="text" id="createUrlForEmailUnique" style="display:none;" value="<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>"/>
<script>
    $(document).ready(function() {
        $("#User_repeatpassword").keyup(checkPasswordMatch);
        $("#User_password").keyup(checkPasswordMatch);

    });
    function sendHostForm() {
        document.getElementById('User_company').disabled = false;
        var hostform = $("#registerhostform").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("user/create")); ?>",
            data: hostform,
            success: function(data) {

//                if ('<?php echo $session['role']; ?>' != 9) { //if not equal to staff member
//                    window.location = "index.php?r=dashboard";
//                } else {
//                    window.location = "index.php?r=dashboard/viewmyvisitors";
//                }

                if ('<?php echo $session['role']; ?>' == 5 || '<?php echo $session['role']; ?>' == 8 || '<?php echo $session['role']; ?>' == 7) {
                    window.location = 'index.php?r=dashboard';
                } else if ('<?php echo $session['role']; ?>' == 1 || '<?php echo $session['role']; ?>' == 6) {
                    window.location = 'index.php?r=dashboard/admindashboard';
                } else if ('<?php echo $session['role']; ?>' == 9) {
                    window.location = 'index.php?r=dashboard/viewmyvisitors';
                }
            },
            error: function() {
                if ('<?php echo $session['role']; ?>' != 9) { //if not equal to staff member
                    window.location = "index.php?r=dashboard";
                } else {
                    window.location = "index.php?r=dashboard/viewmyvisitors";
                }
            },
        });
    }

    function checkPasswordMatch() {
        var password = $("#User_password").val();
        var confirmPassword = $("#User_repeatpassword").val();

        if (password != confirmPassword)
            $("#passwordErrorMessage").show();
        else
            $("#passwordErrorMessage").hide();
    }

    function checkHostEmailIfUnique() {
        var email = $("#User_email").val();
        var tenant;
        if ($("#sessionRole").val() == 5) { //check if superadmin
            tenant = $("#User_tenant").val();
        } else {
            tenant = '<?php echo $session['tenant']; ?>';
        }
        var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: email,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isTaken == 1) {
                        $(".errorMessageEmail1").show();
                    } else {
                        $(".errorMessageEmail1").hide();
                        sendHostForm();

                    }
                });

            }
        });
    }

    function populateHostCompanyWithSameTenantAndTenantAgent() {
        $('#User_company option[value!=""]').remove();
        getHostCompanyWithSameTenantAndTenantAgent($("#User_tenant").val(), $("#User_tenant_agent").val());
    }

    function getHostCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getCompanyOfTenant&id='); ?>' + $("#User_tenant").val() + '&tenantAgentId=' + $("#User_tenant_agent").val(),
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function populateHostTenantAgentAndCompanyField()
    {
        $('#User_company option[value!=""]').remove();
        $('#User_tenant_agent option[value!=""]').remove();
        var tenant = $("#User_tenant").val();

        getHostTenantAgentWithSameTenant(tenant);
        getHostCompanyWithSameTenant(tenant);

    }

    function getHostTenantAgentWithSameTenant(tenant) {
        $('#User_tenant_agent').empty();
        $('#User_tenant_agent').append('<option value="">Please select a tenant agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('#User_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getHostCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('company/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

</script>