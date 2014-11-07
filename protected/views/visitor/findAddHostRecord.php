<?php $session = new CHttpSession; ?>
<div id="findAddHostRecordDiv" class="findAddHostRecordDiv form">
    <div id="searchHostDiv">
        <div>
            <label><b>Search Name:</b></label> 
            <input type="text" id="search-host" name="search-host" class="search-text"/> 
            <button class="host-findBtn" onclick="findHostRecord()" id="host-findBtn" style="display:none;" data-target="#findHostRecordModal" data-toggle="modal">Find Record</button>
            <button class="host-findBtn" id="dummy-host-findBtn">Find Host</button>
            <button class="host-AddBtn" >Add Host</button>

            <div class="errorMessage" id="searchTextHostErrorMessage" style="display:none;"></div>
        </div>

        <div id="searchHostTableDiv">
            <h4>Search Results for : <span id='searchhostname'></span></h4>

            <div id="searchHostTable"></div>
            <div class="register-a-visitor-buttons-div">
                <input type="button" class="visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                <input type="button" id="clicktabB2"  value="Save and Continue"/>
            </div>
        </div>
        <input type="text" id="selectedHostInSearchTable" value="0"/>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-host-patient-form',
        'action' => Yii::app()->createUrl('/patient/create'),
        'htmlOptions' => array("name" => "register-host-patient-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                sendReasonForm();
                            }
                        }'
        ),
    ));
    ?>

    <br>
    <?php echo $form->labelEx($patientModel, 'name'); ?> &nbsp;
    <?php echo $form->textField($patientModel, 'name', array('size' => 50, 'maxlength' => 100)); ?>
    <?php echo "<br>" . $form->error($patientModel, 'name'); ?>
    <div style="" id="Patient_name_error" class="errorMessage Patient_name_error" >Patient Name has already been taken.</div>

    <input type="text" id="patientIsUnique" value="0"/><br>
    <div class="register-a-visitor-buttons-div">
        <input type="button" class="visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
        <input type="submit" value="Save and Continue" name="yt0" id="submitFormPatientName" style="display:inline-block;"/>
    </div>
    <?php $this->endWidget(); ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-host-form',
        'action' => Yii::app()->createUrl('/user/create'),
        'htmlOptions' => array("name" => "register-host-form"),
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
    <div>
        <table  id="addhost-table">

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
                    <?php echo "<br>" . $form->error($userModel, 'deprtment'); ?>
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
                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >Email Address has already been taken.</div>
                </td>
                <td>
                    <?php echo $form->labelEx($userModel, 'contact_number'); ?><br>
                    <?php echo $form->textField($userModel, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'contact_number'); ?>
                </td>
            </tr>
            <tr>

                <td id="hostTenantRow"><?php echo $form->labelEx($userModel, 'tenant'); ?><br>

                    <select id="User_tenant" onchange="populateHostTenantAgentAndCompanyField()" name="User[tenant]"  >
                        <option value='' selected>Select Admin</option>
                        <?php
                        $allAdminNames = User::model()->findAllAdmin();
                        foreach ($allAdminNames as $key => $value) {
                            ?>
                            <option value="<?php echo $value->tenant; ?>"
                            <?php
                            if ($session['role'] == Roles::ROLE_STAFFMEMBER && $session['tenant'] == $value->tenant) {
                                echo " selected ";
                            }
                            ?>
                                    ><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                    <?php
                                }
                                ?>
                    </select><?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                </td>
                <td id="hostTenantAgentRow"><?php echo $form->labelEx($userModel, 'tenant_agent'); ?><br>

                    <select id="User_tenant_agent" name="User[tenant_agent]" onchange="populateHostCompanyWithSameTenantAndTenantAgent()" >
                        <?php
                        echo "<option value='' selected>Select Tenant Agent</option>";
                        if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                            echo "<option value='" . $session['tenant_agent'] . "' selected>Tenant Agent</option>";
                        }
                        ?>
                    </select><?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                </td>
                <td id="hostCompanyRow">

                    <?php echo $form->labelEx($userModel, 'company'); ?><br>
                    <select id="User_company" name="User[company]" >
                        <option value=''>Select Company</option>
                        <?php
                        if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                            echo "<option value='" . $session['company'] . "' selected>Company</option>";
                        }
                        ?>
                    </select>

                    <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                </td>
                <td >
                    <input name="User[role]" id="User_role" value="<?php echo Roles::ROLE_STAFFMEMBER ?>"/>
                    <input name="User[user_type]" id="User_user_type" value="<?php echo UserType::USERTYPE_INTERNAL; ?>"/>
                    <input name="User[password]" id="User_password" value="0"/>
                    <input name="User[repeatpassword]" id="User_repeat_password" value="0"/>
                </td>
            </tr>


        </table>

    </div>
    <div class="register-a-visitor-buttons-div">
        <input type="button" class="visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
        <input type="button" id="clicktabC" value="Save and Continue" style="display:none;"/>

        <input type="submit" value="Save and Continue" name="yt0" id="submitFormUser" />
    </div>
    <?php $this->endWidget(); ?>
    <br>
    <div id="currentHostDetailsDiv">
        <?php
        $userStaffMemberModel = User::model()->findByPk($session['id']);

        $staffmemberform = $this->beginWidget('CActiveForm', array(
            'id' => 'staffmember-host-form',
            'action' => Yii::app()->createUrl('/user/create'),
            'htmlOptions' => array("name" => "staffmember-host-form"),
        ));
        ?>
        <table  id="currentHostDetails">

            <tr>
                <td>

                    <?php echo $staffmemberform->labelEx($userStaffMemberModel, 'first_name'); ?><br>
                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'first_name', array(
                        'size' => 50, 'maxlength' => 50,'disabled'=>'disabled'
                        )); ?>
                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'first_name'); ?>
                </td>
                <td>    
                    <?php echo $staffmemberform->labelEx($userStaffMemberModel, 'last_name'); ?><br>
                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'last_name', array('size' => 50, 'maxlength' => 50,'disabled'=>'disabled')); ?>
                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'last_name'); ?>
                </td>
                <td>

                    <?php echo $staffmemberform->labelEx($userStaffMemberModel, 'department'); ?><br>
                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'department', array('size' => 50, 'maxlength' => 50,'disabled'=>'disabled')); ?>
                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'department'); ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?php echo $staffmemberform->labelEx($userStaffMemberModel, 'staff_id'); ?><br>
                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'staff_id', array('size' => 50, 'maxlength' => 50,'disabled'=>'disabled')); ?>
                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'staff_id'); ?>
                </td>

                <td>
                    <?php echo $staffmemberform->labelEx($userStaffMemberModel, 'email'); ?><br>
                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'email', array('size' => 50, 'maxlength' => 50,'disabled'=>'disabled')); ?>
                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'email'); ?>
                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >Email Address has already been taken.</div>
                </td>
                <td>
                    <?php echo $staffmemberform->labelEx($userStaffMemberModel, 'contact_number'); ?><br>
                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'contact_number', array('size' => 50, 'maxlength' => 50,'disabled'=>'disabled')); ?>
                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'contact_number'); ?>
                </td>
            </tr>
        </table>
        <?php $this->endWidget(); ?>
        <div class="register-a-visitor-buttons-div">
            <input type="button" class="visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
            <input type="button" id="saveCurrentUserAsHost" value="Save and Continue" />
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        
        $("#dummy-host-findBtn").click(function(e) {
            e.preventDefault();
            var searchText = $("#search-host").val();
            if (searchText != '') {
                $("#searchTextHostErrorMessage").hide();
                $("#host-findBtn").click();
            } else {
                $("#searchTextHostErrorMessage").show();
                $("#searchTextHostErrorMessage").html("Search Name cannot be blank.");
            }
        });
        
        $("#saveCurrentUserAsHost").click(function(e) {
            e.preventDefault();
            $("#selectedHostInSearchTable").val('<?php echo $session['id']; ?>');
            $("#search-host").val('staff');
            $("#hostId").val('<?php echo $session['id']; ?>');
            $("#clicktabB2").click();
        });
        
        $(".host-AddBtn").click(function(e) {
            e.preventDefault();
            $("#register-host-form").show();
            $("#searchHostDiv").show();
            $("#currentHostDetailsDiv").hide();
            $(".host-AddBtn").hide();
        });
    });

    function findHostRecord() {
        $("#host_fields_for_Search").hide();
        $("#selectedHostInSearchTable").val("");
        $("#searchHostTableDiv h4").html("Search Results for : " + $("#search-host").val());
        $("#searchHostTableDiv").show();
        $("#register-host-form").hide();
        $("#register-host-patient-form").hide();
        //append searched text in modal
        var searchText = $("#search-host").val();


        //change modal url to pass user searched text
        var url = 'index.php?r=visitor/findhost&id=' + searchText + '&visitortype=' + $("#Visitor_visitor_type").val();
        $("#searchHostTable").html('<iframe id="findHostTableIframe" onLoad="autoResize2();" width="100%" height="100%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
    }

    function autoResize2() {
        var newheight;

        if (document.getElementById) {
            newheight = document.getElementById('findHostTableIframe').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('findHostTableIframe').height = (newheight - 60) + "px";
    }

    function sendHostForm() {

        var hostform = $("#register-host-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("user/create&view=1")); ?>",
            data: hostform,
            success: function(data) {
                getLastHostId();
                populateVisitFormFields();
            },
        });
    }

    function sendPatientForm() {
        var patientForm = $("#register-host-patient-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("patient/create")); ?>",
            data: patientForm,
            success: function(data) {
                getLastPatientId();
                populateVisitFormFields();
            },
        });
    }

   
</script>


<input type="text" id="hostId" placeholder="host id"/>