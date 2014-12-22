<<<<<<< HEAD
<?php
/* @var $this VisitorController */
/* @var $model Visitor */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="form" data-ng-app="PwordForm">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'visitor-form',
        'htmlOptions' => array("name" => "visitorform"),
        'enableAjaxValidation' => false,
    ));
    ?>


    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td style="vertical-align: top;">
                <table>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'role'); ?></td>
                        <td>
                            <select id="Visitor_role" name="Visitor[role]">
                                <option value="<?php echo Roles::ROLE_VISITOR ?>">Visitor / Kiosk</option>
                            </select>
                            <?php echo "<br>" . $form->error($model, 'role'); ?>
                        </td>
                    </tr>


                    <tr id="visitorTenantRow">
                        <td><?php echo $form->labelEx($model, 'tenant'); ?></td>
                        <td>
                            <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()" name="Visitor[tenant]"  >
                                <option value='' selected>Select Admin</option>
                                <?php
                                $allAdminNames = User::model()->findAllAdmin();
                                foreach ($allAdminNames as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value->tenant; ?>" <?php
                                    if ($this->action->id == 'update') {
                                        if ($model->tenant == $value->tenant) {
                                            echo " selected ";
                                        }
                                    }
                                    ?>

                                            ><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                            <?php
                                        }
                                        ?>
                            </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>
                        </td>
                    </tr>
                    <tr id="visitorTenantAgentRow">
                        <td><?php echo $form->labelEx($model, 'tenant_agent'); ?></td>
                        <td>
                            <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]" >
                            <?php
                            if ($this->action->Id != 'create') {

                                $allAgentAdminNames = User::model()->findAllTenantAgent($model->tenant);
                                foreach ($allAgentAdminNames as $key => $value) {
                                    ?>
                                            <option <?php
                                                if ($model->tenant_agent == $value['id']) {
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
                    <tr style="display: none;" id="visitorCompanyRow">
                        <td><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td>
                            <select id="Visitor_company" name="Visitor[company]" disabled>
                                <option value=''>Select Company</option>
                            </select>

                            <?php echo "<br>" . $form->error($model, 'company'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'visitor_status'); ?></td>
                        <td><?php echo $form->dropDownList($model, 'visitor_status', VisitorStatus::$VISITOR_STATUS_LIST); ?>
                            <?php echo "<br>" . $form->error($model, 'visitor_status'); ?>
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
                            <td><label for="Visitor_password">Password <span class="required">*</span></label></td>
                            <td>
                                <input ng-model="user.passwords" data-ng-class="{'ng-invalid':visitorform['Visitor[repeatpassword]'].$error.match}" type="password" id="Visitor_password" value = '<?php echo $model->password; ?>' name="Visitor[password]">			
                                <?php echo "<br>" . $form->error($model, 'password'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="Visitor_repeat_password">Repeat Password <span class="required">*</span></label></td>
                            <td >
                                <input ng-model="user.passwordConfirm" type="password" id="Visitor_repeat_password" data-match="user.passwords" name="Visitor[repeatpassword]"/>			
                                <div style='font-size:10px;color:red;' data-ng-show="visitorform['Visitor[repeatpassword]'].$error.match">New Password does not match with <br>Repeat New Password. </div>
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
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                        <td><?php echo $form->textField($model, 'contact_number'); ?>
                            <?php echo "<br>" . $form->error($model, 'contact_number'); ?></td>
                    </tr>
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


                </table>
            </td>
        </tr>
    </table>

    <button class="btn btn-success" id="submitBtn"><?php echo ($this->action->Id == 'create' ? 'Add' : 'Save') ?></button>
    <div class="row buttons" style='display:none;'>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'submitForm',)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    var patient_type = 1;
    var corporate_type = 2;

    $(document).ready(function() {

        /*
         * if visitor type is patient visitor, company is not mandatory
         * if visitor type is company visitor, company is mandatory
         */
        function showTableRowById(fieldId) {
            $("#" + fieldId).show();
        }

        function hideTableRowById(fieldId) {
            $("#" + fieldId).hide();
        }

        function disableFieldById(fieldId, action) {
            document.getElementById(fieldId).disabled = action;
        }

        $('#Visitor_visitor_type').on('change', function(e) {
            $('#Visitor_company option[value!=""]').remove();
            $('#Visitor_tenant_agent option[value!=""]').remove();

            $('#Visitor_tenant').val("");

            if ($(this).val() == corporate_type) {
                disableFieldById('Visitor_company', false);
                showTableRowById('visitorCompanyRow');
            } else {
                disableFieldById('Visitor_company', true);
                hideTableRowById('visitorCompanyRow');
            }
        });

        if ($('#Visitor_visitor_type').val() == corporate_type) {
            disableFieldById('Visitor_company', false);
            showTableRowById('visitorCompanyRow');
        }
    });

    /*
     * if visitor type = patient visitor, populate tenant agent with the same tenant chosen
     * if visitor type = corporate visitor, populate tenant agent with the same tenant chosen
     * and populate company with same tenant
     * if tenant agent is selected populate company with same tenant and tenant agent
     */

    function getTenantAgentWithSameTenant(tenant, selected) {
        $('#Visitor_tenant_agent').empty();
        $('#Visitor_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {

                $.each(r.data, function(index, value) {
                    $('#Visitor_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#Visitor_tenant_agent").val(selected);
            }


        });

    }

    function getCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function populateTenantAgentAndCompanyField()
    {
        $('#Visitor_company option[value!=""]').remove();
        $('#Visitor_tenant_agent option[value!=""]').remove();

        var visitor_type = $("#Visitor_visitor_type").val();
        var tenant = $("#Visitor_tenant").val();

        if (visitor_type == patient_type) {
            getTenantAgentWithSameTenant(tenant, '');
        } else {
            getTenantAgentWithSameTenant(tenant);
            getCompanyWithSameTenant(tenant);
        }
    }

    function populateCompanyWithSameTenantAndTenantAgent() {
        $('#Visitor_company option[value!=""]').remove();

        var visitor_type = $("#Visitor_visitor_type").val();
        var tenant_agent = $("#Visitor_tenant_agent").val();
        var tenant = $("#Visitor_tenant").val();

        if (visitor_type == corporate_type) {
            getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent);
        }
    }
</script>

<?php
//($user['permissions'] == 'admin' ? true : false);
if (isset($_POST['Visitor'])) {
    if (isset($_POST['Visitor']['tenant'])) {
        ?>
        <script>
            $("#Visitor_tenant").val("<?php echo $_POST['Visitor']['tenant']; ?>");
        </script>
        <?php
        if (isset($_POST['Visitor']['tenant_agent'])) {
            ?>
            <script>
                getTenantAgentWithSameTenant('<?php echo $_POST['Visitor']['tenant']; ?>', '<?php echo $_POST['Visitor']['tenant_agent']; ?>');
                $("#Visitor_tenant_agent").val("<?php echo $_POST['Visitor']['tenant_agent']; ?>");
            </script>
            <?php
        } else {
            ?>
            <script>
                getTenantAgentWithSameTenant('<?php echo $_POST['Visitor']['tenant']; ?>', '');
            </script>
            <?php
        }
    }
}
=======
<?php
/* @var $this VisitorController */
/* @var $model Visitor */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="form" data-ng-app="PwordForm">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'visitor-form',
        'htmlOptions' => array("name" => "visitorform"),
        'enableAjaxValidation' => false,
    ));
    ?>


    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td style="vertical-align: top;">
                <table>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'role'); ?></td>
                        <td>
                            <select id="Visitor_role" name="Visitor[role]">
                                <option value="<?php echo Roles::ROLE_VISITOR ?>">Visitor / Kiosk</option>
                            </select>
                            <?php echo "<br>" . $form->error($model, 'role'); ?>
                        </td>
                    </tr>


                    <tr id="visitorTenantRow">
                        <td><?php echo $form->labelEx($model, 'tenant'); ?></td>
                        <td>
                            <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()" name="Visitor[tenant]"  >
                                <option value='' selected>Select Admin</option>
                                <?php
                                $allAdminNames = User::model()->findAllAdmin();
                                foreach ($allAdminNames as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value->tenant; ?>" <?php
                                    if ($this->action->id == 'update') {
                                        if ($model->tenant == $value->tenant) {
                                            echo " selected ";
                                        }
                                    }
                                    ?>

                                            ><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                            <?php
                                        }
                                        ?>
                            </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>
                        </td>
                    </tr>
                    <tr id="visitorTenantAgentRow">
                        <td><?php echo $form->labelEx($model, 'tenant_agent'); ?></td>
                        <td>
                            <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]" >
                            <?php
                            if ($this->action->Id != 'create') {

                                $allAgentAdminNames = User::model()->findAllTenantAgent($model->tenant);
                                foreach ($allAgentAdminNames as $key => $value) {
                                    ?>
                                            <option <?php
                                                if ($model->tenant_agent == $value['id']) {
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
                    <tr style="display: none;" id="visitorCompanyRow">
                        <td><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td>
                            <select id="Visitor_company" name="Visitor[company]" disabled>
                                <option value=''>Select Company</option>
                            </select>

                            <?php echo "<br>" . $form->error($model, 'company'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'visitor_status'); ?></td>
                        <td><?php echo $form->dropDownList($model, 'visitor_status', VisitorStatus::$VISITOR_STATUS_LIST); ?>
                            <?php echo "<br>" . $form->error($model, 'visitor_status'); ?>
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
                            <td><label for="Visitor_password">Password <span class="required">*</span></label></td>
                            <td>
                                <input ng-model="user.passwords" data-ng-class="{'ng-invalid':visitorform['Visitor[repeatpassword]'].$error.match}" type="password" id="Visitor_password" value = '<?php echo $model->password; ?>' name="Visitor[password]">			
                                <?php echo "<br>" . $form->error($model, 'password'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="Visitor_repeat_password">Repeat Password <span class="required">*</span></label></td>
                            <td >
                                <input ng-model="user.passwordConfirm" type="password" id="Visitor_repeat_password" data-match="user.passwords" name="Visitor[repeatpassword]"/>			
                                <div style='font-size:10px;color:red;' data-ng-show="visitorform['Visitor[repeatpassword]'].$error.match">New Password does not match with <br>Repeat New Password. </div>
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
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                        <td><?php echo $form->textField($model, 'contact_number'); ?>
                            <?php echo "<br>" . $form->error($model, 'contact_number'); ?></td>
                    </tr>
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


                </table>
            </td>
        </tr>
    </table>

    <button class="btn btn-success" id="submitBtn"><?php echo ($this->action->Id == 'create' ? 'Add' : 'Save') ?></button>
    <div class="row buttons" style='display:none;'>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'submitForm',)); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    var patient_type = 1;
    var corporate_type = 2;

    $(document).ready(function() {

        /*
         * if visitor type is patient visitor, company is not mandatory
         * if visitor type is company visitor, company is mandatory
         */
        function showTableRowById(fieldId) {
            $("#" + fieldId).show();
        }

        function hideTableRowById(fieldId) {
            $("#" + fieldId).hide();
        }

        function disableFieldById(fieldId, action) {
            document.getElementById(fieldId).disabled = action;
        }

        $('#Visitor_visitor_type').on('change', function(e) {
            $('#Visitor_company option[value!=""]').remove();
            $('#Visitor_tenant_agent option[value!=""]').remove();

            $('#Visitor_tenant').val("");

            if ($(this).val() == corporate_type) {
                disableFieldById('Visitor_company', false);
                showTableRowById('visitorCompanyRow');
            } else {
                disableFieldById('Visitor_company', true);
                hideTableRowById('visitorCompanyRow');
            }
        });

        if ($('#Visitor_visitor_type').val() == corporate_type) {
            disableFieldById('Visitor_company', false);
            showTableRowById('visitorCompanyRow');
        }
    });

    /*
     * if visitor type = patient visitor, populate tenant agent with the same tenant chosen
     * if visitor type = corporate visitor, populate tenant agent with the same tenant chosen
     * and populate company with same tenant
     * if tenant agent is selected populate company with same tenant and tenant agent
     */

    function getTenantAgentWithSameTenant(tenant, selected) {
        $('#Visitor_tenant_agent').empty();
        $('#Visitor_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {

                $.each(r.data, function(index, value) {
                    $('#Visitor_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#Visitor_tenant_agent").val(selected);
            }


        });

    }

    function getCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function populateTenantAgentAndCompanyField()
    {
        $('#Visitor_company option[value!=""]').remove();
        $('#Visitor_tenant_agent option[value!=""]').remove();

        var visitor_type = $("#Visitor_visitor_type").val();
        var tenant = $("#Visitor_tenant").val();

        if (visitor_type == patient_type) {
            getTenantAgentWithSameTenant(tenant, '');
        } else {
            getTenantAgentWithSameTenant(tenant);
            getCompanyWithSameTenant(tenant);
        }
    }

    function populateCompanyWithSameTenantAndTenantAgent() {
        $('#Visitor_company option[value!=""]').remove();

        var visitor_type = $("#Visitor_visitor_type").val();
        var tenant_agent = $("#Visitor_tenant_agent").val();
        var tenant = $("#Visitor_tenant").val();

        if (visitor_type == corporate_type) {
            getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent);
        }
    }
</script>

<?php
//($user['permissions'] == 'admin' ? true : false);
if (isset($_POST['Visitor'])) {
    if (isset($_POST['Visitor']['tenant'])) {
        ?>
        <script>
            $("#Visitor_tenant").val("<?php echo $_POST['Visitor']['tenant']; ?>");
        </script>
        <?php
        if (isset($_POST['Visitor']['tenant_agent'])) {
            ?>
            <script>
                getTenantAgentWithSameTenant('<?php echo $_POST['Visitor']['tenant']; ?>', '<?php echo $_POST['Visitor']['tenant_agent']; ?>');
                $("#Visitor_tenant_agent").val("<?php echo $_POST['Visitor']['tenant_agent']; ?>");
            </script>
            <?php
        } else {
            ?>
            <script>
                getTenantAgentWithSameTenant('<?php echo $_POST['Visitor']['tenant']; ?>', '');
            </script>
            <?php
        }
    }
}
>>>>>>> origin/Issue35
?>