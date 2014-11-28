<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/script-visitordetail.js');
$session = new CHttpSession;
?>
<input type="text" id="currentSessionRole" value="<?php echo $session['role']; ?>" style="display:none;"/>
<div id='visitorInformationCssMenu'>
    <ul>
        <li class='has-sub' id="personalDetailsLi"><a href="#"><span>Personal Details</span></a>
            <ul>
                <li>
                    <table id="personalDetailsTable" class="detailsTable">
                        <tr>
                            <td width="100px;">First Name:</td>
                            <td><?php echo $visitorModel->first_name; ?></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td><?php echo $visitorModel->last_name; ?></td>
                        </tr>
                    </table>
                </li>
            </ul>
        </li>
        <li class='has-sub' id="contactDetailsLi"><a href="#"><span>Contact Details</span></a>
            <ul>
                <li>
                    <?php
                    $visitorForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-visitor-form',
                        'action' => Yii::app()->createUrl('/visitor/update&id=' . $model->visitor . '&view=1'),
                        'htmlOptions' => array("name" => "update-visitor-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    checkEmailIfUnique();
                                }
                                }'
                        ),
                    ));
                    ?>
                    <input type="hidden" id="emailIsUnique" value="0"/>
                    <div class="flash-success success-update-contact-details"> Contact Details Updated Successfully. </div>
                    <table id="contactDetailsTable" class="detailsTable">
                        <tr>
                            <td width="100px;">Email:</td>
                            <td><?php echo $visitorForm->textField($visitorModel, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $visitorForm->error($visitorModel, 'email'); ?>
                                <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail" >Email Address has already been taken.</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Mobile:</td>
                            <td><input type="text" value="<?php echo $visitorModel->contact_number; ?>" name="Visitor[contact_number]" id="Visitor_contact_number"></td>
                        </tr>
                        <tr><td><input type="submit" value="Update" name="yt0" id="submitContactDetailForm" /></td></tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub' id="visitorTypeDetailsLi"><a href="#"><span>Visitor Type</span></a>
            <ul>
                <li>
                    <?php
                    $visitForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-visit-form',
                        'htmlOptions' => array("name" => "update-visit-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    if($(".visitortypedetails").val() == 1){
                                        if($(".visitortypepatient").val() == ""){
                                            $("#visitorTypePatientHost").html("Patient Name cannot be blank.");
                                            $("#visitorTypePatientHost").show();
                                        }
                                    } else if ($(".visitortypedetails").val() == 2) {
                                        if($(".visitortypehost").val() == ""){
                                            $("#visitorTypePatientHost").html("Please select a host.");
                                            $("#visitorTypePatientHost").show();
                                        }
                                    } else {
                                    $(".visitorTypePatientHost").hide();
                                    sendVisitForm("update-visit-form"); }
                                }
                                }'
                        ),
                    ));
                    ?>
                    <div class="flash-success success-update-visitor-type"> Visitor Type Updated Successfully. </div>

                    <table id="visitorTypeTable" class="detailsTable">
                        <tr>
                            <td width="100px;"><?php echo $visitForm->labelEx($model, 'visitor_type'); ?></td>
                            <td><?php
                                if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                                    ?>
                                    <select id = "Visit_visitor_type" name = "Visit[visitor_type]" class="visitortypedetails">
                                        <option selected = "selected" value = "2">Corporate Visitor</option>
                                    </select>
                                    <?php
                                } else {
                                    echo $visitForm->dropDownList($model, 'visitor_type', VisitorType::$VISITOR_TYPE_LIST, array(
                                        'onchange' => 'visitorTypeOnChange()', 'class' => 'visitortypedetails',
                                    ));
                                }
                                ?>
                                <?php echo "<br>" . $visitForm->error($model, 'visitor_type'); ?>
                                <div class="errorMessage" id="visitorTypePatientHost" style="display:none;">hello</div>
                                <input type="text" name="Visit[patient]" id="Visit_patient" style="display:none;" class="visitortypepatient" value="<?php echo $model->patient; ?>"/>
                                <input type="text" name="Visit[host]" id="Visit_host" class="visitortypehost" style="display:none;" value="<?php echo $model->host; ?>"/>
                            </td>

                        </tr>
                        <?php if ($session['role'] != Roles::ROLE_STAFFMEMBER) { ?>
                            <tr>
                                <td><input type='submit' value='Update' class='submitBtn'></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub' id="reasonLi"><a href="#"><span>Reason</span></a>
            <ul>
                <li>
                    <?php
                    $reasonForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-reason-form',
                        'action' => Yii::app()->createUrl('/visit/update&id=' . $model->reason),
                        'htmlOptions' => array("name" => "update-reason-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    if($("#Visit_reason").val() == "" || $("#Visit_reason").val() == "Other" ){
                                        $("#visitReason").show();
                                        
                                    }else 
                                    {
                                        $("#visitReason").hide();
                                        sendUpdateReasonForm();
                                    }
                                }
                                }'
                        ),
                    ));
                    ?>
                    <div class="flash-success success-update-reason">Reason Updated Successfully. </div>
                    <div class="flash-success success-add-reason">Reason Added Successfully. </div>

                    <table id="reasonTable" class="detailsTable">
                        <tr>
                            <td width="100px;"><label for="Visit_reason">Reason</label></td>
                            <td>
                                <select id="Visit_reason" name="Visit[reason]" onchange="ifSelectedIsOtherShowAddReasonDiv(this)">
                                    <option value='' selected>Select Reason</option>
                                    <option value="Other">Other</option>
                                    <?php
                                    $reason = VisitReason::model()->findAllReason();
                                    foreach ($reason as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id; ?>" <?php
                                        if ($model->reason == $value->id) {
                                            echo " selected ";
                                        }
                                        ?>><?php echo $value->reason; ?></option>
                                                <?php
                                            }
                                            ?>

                                </select><br>
                                <?php echo $reasonForm->error($model, 'reason'); ?>
                                <div class="errorMessage visitorReason" id="visitReason">Reason cannot be blank.</div>
                            </td>
                        </tr>
                        <tr><td><input type="submit" value="Update" name="yt0" id="submitReasonForm" /></td></tr>
                    </table>
                    <?php $this->endWidget(); ?>
                    <?php
                    $addReasonForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'add-reason-form',
                        'action' => Yii::app()->createUrl('/visitReason/create&register=1'),
                        'htmlOptions' => array("name" => "add-reason-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    checkReasonIfUnique();
                                }
                                }'
                        ),
                    ));
                    ?>
                    <table id="addreasonTable" class="detailsTable">
                        <tr>
                            <td width="100px;"><label for="VisitReason_reason">Reason</label></td>
                            <td><textarea id="VisitReason_reason" name="VisitReason[reason]" style="width:200px !important;text-transform: capitalize;" cols="80" rows="3"><?php
                                    echo $reasonModel->reason;
                                    ?></textarea> <?php echo $addReasonForm->error($reasonModel, 'reason'); ?>
                                <div class="errorMessage visitorReason" id="visitReasonErrorMessage">Reason cannot be blank.</div>
                            </td>
                        </tr>
                        <tr><td><input type="submit" value="Add" name="yt0" id="submitAddReasonForm" /></td></tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub' id='hostDetailsLi'><a href="#"><span>Host Details</span></a>
            <ul>
                <li>
                    <?php
                    $updateHostVisitForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-host-visit-form',
                        'action' => Yii::app()->createUrl('/visit/update&id=' . $model->id),
                        'htmlOptions' => array("name" => "update-host-visit-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                sendVisitForm("update-host-visit-form");
                                sendVisitForm("update-visit-form");
                                
                                }
                        }'
                        ),
                    ));
                    ?>
                    <div class="flash-success success-update-host-details"> Host Details Updated Successfully. </div>

                    <div id="searchHostDiv" style="display:block;">
                        <div>
                            <label style="font-size:12px;">Search Name:</label> 
                            <input type="text" id="search-host" name="search-host" class="search-text" style="width:96%;"/> 
                            <button class="host-findBtn" onclick="findHostRecord()" id="host-findBtn" style="display:none;" data-target="#findHostRecordModal" data-toggle="modal">Find Record</button>
                            <div class="errorMessage" id="searchTextHostErrorMessage" style="display:none;font-size:12px;"></div>

                            <button class="host-findBtn" id="dummy-host-findBtn">Find Host</button>
                        </div>
                        <input type="text" name="Visit[host]" id="selectedHostInSearchTable" style="display:none;"/>
                        <input type="text" name="Visit[visitor_type]" id="visitorTypeUnderSearchForm" style="display:none;" value="<?php
                        if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                            echo "2";
                        }
                        ?>"/>
                               <?php echo "<br>" . $updateHostVisitForm->error($model, 'host'); ?>
                        <div id="searchHostTableDiv">
                            <br><div style="font-weight:bold;" class="findDivTitle"></div><br>

                            <div>
                                <input type="submit" id="updateVisitHostFromSearch"  value="Update"/>
                            </div>
                        </div>

                    </div>
                    <?php $this->endWidget(); ?>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'register-newhost-form',
                        'action' => Yii::app()->createUrl('/user/create'),
                        'htmlOptions' => array("name" => "register-newhost-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                            
                                checkNewHostEmailIfUnique("New_user_email","register-newhost-form");}
                                
                        }'
                        ),
                    ));
                    ?>
                    <div class="flash-success success-add-host">Host Added Successfully. </div>

                    <table  id="addnewhost-table" class="detailsTable" style="display:none;">

                        <tr>
                            <td style="width:107px !important;">
                                <?php echo $form->labelEx($newHost, 'first_name'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($newHost, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($newHost, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($newHost, 'last_name'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($newHost, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($newHost, 'last_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($newHost, 'department'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($newHost, 'department', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($newHost, 'deprtment'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($newHost, 'staff_id'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($newHost, 'staff_id', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($newHost, 'staff_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($newHost, 'email'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($newHost, 'email', array('size' => 50, 'maxlength' => 50, 'class' => 'New_user_email')); ?>
                                <?php echo "<br>" . $form->error($newHost, 'email'); ?>
                                <div style="" id="New_user_email_em_" class="errorMessage errorMessageEmail2" >Email Address has already been taken.</div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($newHost, 'contact_number'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($newHost, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($newHost, 'contact_number'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="User_password">Password <span class="required">*</span></label>
                            </td>
                            <td>
                                <input type="password" id="User_password" name="User[password]">			
                                <?php echo "<br>" . $form->error($newHost, 'password'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="User_repeatpassword">Repeat Password <span class="required">*</span></label>
                            </td>
                            <td>
                                <input type="password" id="User_repeatpassword" name="User[repeatpassword]" onChange="checkPasswordMatch();"/>			
                                <div style='font-size:10px;color:red;font-size:11.5px;display:none;' id="passwordErrorMessage">New Password does not match with Repeat New Password. </div>
                                <?php echo "<br>" . $form->error($newHost, 'repeatpassword'); ?>
                            </td>
                        </tr>
                        <tr id="hostTenantRow">

                            <td ><?php echo $form->labelEx($newHost, 'tenant'); ?></td>
                            <td>
                                <select id="User_tenant" class="New_user_tenant" onchange="populateHostTenantAgentAndCompanyField()" name="User[tenant]"  >
                                    <option value='' selected>Select Admin</option>
                                    <?php
                                    $allAdminNames = User::model()->findAllAdmin();
                                    foreach ($allAdminNames as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->tenant; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select><?php echo "<br>" . $form->error($newHost, 'tenant'); ?>
                            </td>
                        </tr>
                        <tr id="hostTenantAgentRow">
                            <td ><?php echo $form->labelEx($newHost, 'tenant_agent'); ?></td>
                            <td>
                                <select id="User_tenant_agent" class="New_user_tenant_agent" name="User[tenant_agent]" onchange="populateHostCompanyWithSameTenantAndTenantAgent()" >
                                    <?php
                                    echo "<option value='' selected>Select Tenant Agent</option>";
                                    ?>
                                </select><?php echo "<br>" . $form->error($newHost, 'tenant_agent'); ?>
                            </td>
                        </tr>
                        <tr id="hostCompanyRow">
                            <td><?php echo $form->labelEx($newHost, 'company'); ?></td>
                            <td>
                                <select id="User_company" name="User[company]" class="New_user_company">
                                    <option value=''>Select Company</option>
                                </select>

                                <?php echo "<br>" . $form->error($newHost, 'company'); ?>
                            </td>
                            <td style="display:none;">
                                <input name="User[role]" id="User_role" value="<?php echo Roles::ROLE_STAFFMEMBER ?>"/>
                                <input name="User[user_type]" id="User_user_type" value="<?php echo UserType::USERTYPE_INTERNAL; ?>"/>
                                <input name="User[password]" id="User_password" value="0"/>
                                <input name="User[repeatpassword]" id="User_repeat_password" value="0"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" value="Add" name="yt0" />
                            </td>
                        </tr>

                    </table>

                    <?php $this->endWidget(); ?>

                    <?php
                    $hostForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-host-form',
                        'action' => Yii::app()->createUrl('/user/update&id=' . $model->host),
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
                    <input type="text" id="hostEmailIsUnique" value="0"/>

                    <table id="hostTable" class="detailsTable">
                        <tr>
                            <td style="width:100px !important;"><?php echo $hostForm->labelEx($hostModel, 'first_name'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'first_name', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'last_name'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'last_name', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'last_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'department'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'department', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'department'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'staff_id'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'staff_id', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'staff_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;"><?php echo $hostForm->labelEx($hostModel, 'email'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'email', array('class' => 'update_user_email', 'disabled' => 'disabled')); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'email'); ?>
                                <div style="display:none;" id="User_email_em_1a" class="errorMessage errorMessageEmail1" >Email Address has already been taken.</div>
                            </td>
                        </tr>
                        <tr>
                            <td width="100px;">Mobile:</td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'contact_number', array('disabled' => 'disabled')); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'contact_number'); ?>
                            </td>
                        </tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub' id='patientDetailsLi'><a href="#"><span>Patient Details</span></a>
            <ul>
                <li>
                    <div id='addPatientDiv' style='display:none;'>
                        <?php
                        $newPatientForm = $this->beginWidget('CActiveForm', array(
                            'id' => 'register-host-patient-form',
                            'action' => Yii::app()->createUrl('/patient/create'),
                            'htmlOptions' => array("name" => "register-host-patient-form"),
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                                'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                sendNewPatientForm();
                            }
                        }'
                            ),
                        ));
                        ?>
                        <div class="flash-success success-add-patient">Patient Added Successfully. </div>

                        <table id='newPatientTable' class='detailsTable'>
                            <tr>
                                <td width="100px"><?php echo $newPatientForm->labelEx($newPatient, 'name'); ?></td>
                                <td>
                                    <?php echo $newPatientForm->textField($newPatient, 'name', array('size' => 50, 'maxlength' => 100)); ?>
                                    <?php echo "<br>" . $newPatientForm->error($newPatient, 'name'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value="Add" name="yt0" style="display:inline-block;"/>
                                </td>
                            </tr>
                        </table>

                        <?php $this->endWidget(); ?>
                    </div>
                    <?php
                    $patientForm = $this->beginWidget('CActiveForm', array(
                        'id' => 'update-patient-form',
                        'action' => Yii::app()->createUrl('/patient/update&id=' . $model->patient),
                        'htmlOptions' => array("name" => "update-patient-form"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                sendPatientForm();
                                }
                        }'
                        ),
                    ));
                    if ($patientModel !== null) {
                        ?>
                        <div class="flash-success success-update-patient">Patient Updated Successfully. </div>

                        <table id="patientTable" class="detailsTable">
                            <tr>
                                <td width="100px;"><?php echo $patientForm->labelEx($patientModel, 'first_name');
                        ?></td>
                                <td>
                                    <?php echo $patientForm->textField($patientModel, 'name', array('size' => 50, 'maxlength' => 50)); ?>
                                    <?php echo "<br>" . $patientForm->error($patientModel, 'name'); ?>
                                </td>
                            </tr>

                            <tr><td><input type="submit" value="Update" name="yt0" id="submit" /></td></tr>
                        </table>
                        <?php
                    }
                    $this->endWidget();
                    ?>
                </li>
            </ul>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function() {

        $("#User_repeatpassword").keyup(checkPasswordMatch);
        if ($("#currentSessionRole").val() == 9) {
            $("#personalDetailsLi").html("<a href='#'><span>Personal Details</span></a>");
            $("#contactDetailsLi").html("<a href='#'><span>Contact Details</span></a>");
        }

        if (<?php echo $model->visit_status; ?> == '3') {
//            $("#personalDetailsLi").html("<a href='#'><span>Personal Details</span></a>");
//            $("#contactDetailsLi").html("<a href='#'><span>Contact Details</span></a>");
//            $("#visitorTypeDetailsLi").html("<a href='#'><span>Visitor Type</span></a>");
//            $("#reasonLi").html("<a href='#'><span>Reason</span></a>");
//            $("#hostDetailsLi").html("<a href='#'><span>Host Details</span></a>");
//            $("#patientDetailsLi").html("<a href='#'><span>Patient Details</span></a>");
            $("#visitorInformationCssMenu :input").attr('disabled', true);
            $("#visitorInformationCssMenu input[type='submit']").hide();
        }

        $("#dummy-host-findBtn").click(function(e) {
            e.preventDefault();
            var searchText = $("#search-host").val();
            if (searchText != '') {
                $("#searchTextHostErrorMessage").hide();
                $("#host-findBtn").click();
                $("#addnewhost-table").hide();
            } else {
                $("#searchTextHostErrorMessage").show();
                $("#searchTextHostErrorMessage").html("Search Name cannot be blank.");
            }
        });

        $(".host-AddBtn").click(function(e) {
            e.preventDefault();
            $("#register-newhost-form").show();
            $("#addnewhost-table").show();
            $("#update-host-form").hide();
            $(".host-AddBtn").hide();
        });

        /*if visit type == patient visitor, hide host details else hide patient details*/
        if ('<?php echo $model->visitor_type ?>' == '1') {
            $("#hostDetailsLi").hide();
            $("#patientDetailsLi").show();
        } else {
            $("#hostDetailsLi").show();
            $("#patientDetailsLi").hide();
            $("#searchHostDiv").show();
        }
    });

    function findHostRecord() {
        $("#selectedHostInSearchTable").val("");
        $(".findDivTitle").html("Search Results for : " + $("#search-host").val());
        $("#searchHostTableDiv").show();
        $("#hostTable").hide();
        //append searched text in modal

        $("#findHostModalBtn").click();
        //change modal url to pass user searched text
        var url = 'index.php?r=visitor/findhost&id=' + $("#search-host").val() + '&visitortype=2';
        $("#findHostModalBody #modalIframe").html('<iframe id="findHostTableIframe" scrolling="no" onLoad="autoResize2();" width="100%" height="100%" style="max-height:400px !important;" frameborder="0" src="' + url + '"></iframe>');
    }

    function autoResize2() {
        var newheight;

        if (document.getElementById) {
            newheight = document.getElementById('findHostTableIframe').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('findHostTableIframe').height = (newheight - 60) + "px";
    }

    function populateFieldHost(id) {
        $("#dismissModal").click();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/getHostDetails&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#searchHostTableDiv .findDivTitle").html("Selected Host Record : " + value.first_name + " " + value.last_name);

                });

                $('#findHostTableIframe').contents().find('.findHostButtonColumn a').removeClass('delete');
                $('#findHostTableIframe').contents().find('.findHostButtonColumn a').html('Select Host');
                $('#findHostTableIframe').contents().find('#' + id).addClass('delete');
                $('#findHostTableIframe').contents().find('#' + id).html('Selected Host');
                $("#selectedHostInSearchTable").val(id);
                $(".visitortypehost").val(id);
            }
        });
    }

    function closeParent() {
        window.parent.dismissModal();
    }

    function visitorTypeOnChange() {
        /*if visit type is patient show add patient div
         * if visit type is corporate show add user div show search
         * if visit type is patient and visit type in database is patient show update patient
         * if visit type is corporate and visit type in database is corporate show update host, hide search
         * */
        var visit_type = $("#Visit_visitor_type").val();
        $("#visitorTypeUnderSearchForm").val($("#Visit_visitor_type").val());

        if (visit_type == 1 && '<?php echo $model->visitor_type; ?>' == 1) {
            $("#addPatientDiv").hide();
            $("#hostDetailsLi").hide();
            $("#patientDetailsLi").show();
            $("#update-patient-form").show();
        }
        else if (visit_type == 2 && '<?php echo $model->visitor_type; ?>' == 2) {
            $("#hostDetailsLi").show();
            $("#patientDetailsLi").hide();
            $("#update-host-form").show();
            $("#register-newhost-form").hide();
            $("#addnewhost-table").hide();
        }
        else if (visit_type == 1) {
            $("#addPatientDiv").show();
            $("#hostDetailsLi").hide();
            $("#patientDetailsLi").show();
            $("#update-patient-form").hide();
        } else if (visit_type = 2) {
            $("#hostDetailsLi").show();
            $("#patientDetailsLi").hide();
            $("#update-host-form").hide();
            $("#register-newhost-form").show();
            $("#addnewhost-table").show();
        }
    }

    function populateHostTenantAgentAndCompanyField()
    {
        $('.New_user_company option[value!=""]').remove();
        $('.New_user_tenant_agent option[value!=""]').remove();
        var tenant = $(".New_user_tenant").val();

        getHostTenantAgentWithSameTenant(tenant);
        getHostCompanyWithSameTenant(tenant);

    }

    function getHostTenantAgentWithSameTenant(tenant) {
        $('.New_user_tenant_agent').empty();
        $('.New_user_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('.New_user_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
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
                $('.New_user_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('.New_user_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function populateHostCompanyWithSameTenantAndTenantAgent() {
        $('.New_user_company option[value!=""]').remove();
        getHostCompanyWithSameTenantAndTenantAgent($(".New_user_tenant").val(), $(".New_user_tenant_agent").val());
    }

    function getHostCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('.New_user_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('.New_user_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
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

</script>
<input type="button" id="findHostModalBtn" value="findhost" data-target="#findHostModal" data-toggle="modal" style="display:none;"/>
<div class="modal hide fade" id="findHostModal" style="width:69%; margin-left:-435px;">
    <div class="modal-header">

        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="findHostModalBody" style="padding:20px;">
        <div class="findDivTitle" style="font-weight:bold;font-size:12px;"></div>
        <div id="modalIframe" style="overflow-x: hidden !important; overflow-y: auto !important;"></div>
    </div>
</div>
