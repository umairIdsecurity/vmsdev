<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-visitordetail.js');
$session = new CHttpSession;

if (preg_match('/(?i)msie [1-8]/', $_SERVER['HTTP_USER_AGENT'])) {
    ?>
    <style>
        #visitorDetailDiv #visitorInformationCssMenu .complete, #visitorDetailDiv #visitorInformationCssMenu .host-findBtn {
            width: 88px !important;
            height: 24px !important;
        }

    </style>
<?php
}

?>
<style type="text/css" media="screen">
    .visitor-detail-info-field {
        color: #000000 !important;
    }
</style>
<input type="text" id="currentSessionRole" value="<?php echo $session['role']; ?>" style="display:none;"/>
<div id='visitorInformationCssMenu'>
    <ul>
        <li class='has-sub' id="personalDetailsLi">
            <a href="#"><span>Personal Details</span></a>
            <ul>
                <li>
                    <table id="personalDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                First Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo $visitorModel->first_name; ?>" disabled="disabled"
                                       name="Visitor[first_name]" id="Visitor_first_name">
                            </td>
                        </tr>

                        <?php if ($asic) : ?>
                            <tr>
                                <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                    Middle Name
                                </td>
                                <td style="padding-left: 0 !important;">
                                    <input type="text" class="visitor-detail-info-field" value="<?php echo $visitorModel->middle_name; ?>" disabled="disabled"
                                           name="Visitor[middle_name]" id="Visitor_middle_name">
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Last Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo $visitorModel->last_name; ?>" disabled="disabled"
                                       name="Visitor[last_name]" id="Visitor_last_name">
                            </td>
                        </tr>

                        <?php if ($asic) : ?>
                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Date of Birth
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo date('d-m-Y', strtotime($visitorModel->date_of_birth)); ?>" disabled="disabled"
                                       name="Visitor[date_of_birth]" id="Visitor_date_of_birth">
                            </td>
                        </tr>
                        <?php endif; ?>

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
                                    $("#workstationForm").submit();
                                }
                                }'
                        ),
                    ));
                    ?>
                    <input type="hidden" id="emailIsUnique" value="0"/>
                    <input type="hidden" name="Visitor[id]" value="<?php echo $model->visitor; ?>"/>
                    <div class="flash-success success-update-contact-details"> Contact Details Updated Successfully.
                    </div>
                    <table id="contactDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" style="padding-top: 7px;">Email</td>
                            <td><?php echo $visitorForm->textField($visitorModel, 'email',
                                    array('size' => 50, 'maxlength' => 50, 'class' =>  "visitor-detail-info-field")); ?>
                                <?php echo "<br>" . $visitorForm->error($visitorModel, 'email'); ?>
                                <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail">A profile
                                    already exists for this email address.
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="  padding-top: 7px;">Mobile</td>
                            <td><?php echo $visitorForm->textField($visitorModel, 'contact_number',
                                    array('size' => 50, 'maxlength' => 50, 'class' =>  "visitor-detail-info-field")); ?>
                                <?php echo "<br>" . $visitorForm->error($visitorModel, 'contact_number'); ?></td>
                        </tr>
                        <!--<tr><td><input type="submit" value="Update" name="yt0" id="submitContactDetailForm" class="complete" /></td></tr>-->
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>

        <?php
        if ($asic) :
            $company = $visitorModel->getCompany();
            if (!empty($company)) :
                $contact = $newHost->findByPk($visitorModel->staff_id);
        ?>
        <li class='has-sub' id="companyDetailsLi"><a href="#"><span>Company Details</span></a>
            <ul>
                <li>
                    <table id="companyDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Company Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo isset($company->name) ? $company->name : '' ; ?>" disabled="disabled"
                                       name="Visitor[company_name]" id="Visitor_company_name">
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Contact Person
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo (!empty($contact)) ? $contact->getFullName() : ''; ?>" disabled="disabled"
                                       name="Visitor[company_contact]" id="Visitor_company_contact">
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Contact No.
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo isset($contact->contact_number) ? $contact->contact_number : ''; ?>" disabled="disabled"
                                       name="Visitor[mobile_number]" id="Visitor_mobile_number">

                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Contact Email
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo isset($contact->email) ? $contact->email : ''; ?>" disabled="disabled"
                                       name="Visitor[email_address]" id="Visitor_email_address">

                            </td>
                        </tr>

                    </table>
                </li>
            </ul>
        </li>

        <?php 
            endif;
        endif;
        ?>
        <li class='has-sub' id="visitorTypeDetailsLi" <?php echo !is_null($asic) ? 'style="display: none;"' : ""; ?>><a href="#"><span>Visitor Type</span></a>
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
                                if($("#Visitor_photo").val() == "" && $("#Visit_card_type").val() == "2" ){
                                    alert("Please upload a photo.");
                                }
                                   else if($(".visitortypedetails").val() == 1){
                                        if($(".visitortypepatient").val() == ""){
                                            $("#visitorTypePatientHost").html("Patient Name cannot be blank");
                                            $("#visitorTypePatientHost").show();
                                        }
                                    } else if ($(".visitortypedetails").val() == 2) {
                                        if($(".visitortypehost").val() == ""){
                                            $("#visitorTypePatientHost").html("Please select a host");
                                            $("#visitorTypePatientHost").show();
                                        }
                                        else {
                                            $(".visitorTypePatientHost").hide();
                                            sendVisitForm("update-visit-form"); 
                                        }
                                    } else {
                                    $(".visitorTypePatientHost").hide();
                                    sendVisitForm("update-visit-form"); 
                                    }
                                }
                                }'
                        ),
                    ));
                    ?>
                    <div class="flash-success success-update-visitor-type"> Visitor Type Updated Successfully.</div>

                    <table id="visitorTypeTable" class="detailsTable">
                        <tr>

                            <td width="110px;" style="padding-top: 4px;"><?php echo $visitForm->labelEx($model,
                                    'card_type'); ?></td>
                            <td>
                                <select id="Visit_card_type" name="Visit[card_type]">
                                    <?php
                                    $cardType = CardType::model()->findAll();
                                    foreach ($cardType as $key => $value) {
                                        if (in_array($key, CardType::$VIC_CARD_TYPE_LIST)) {
                                            $prefix = 'VIC: ';
                                        } else {
                                            $prefix = 'CORPORATE: ';
                                        }
                                        ?>
                                        <option value="<?php echo $value->id; ?>" <?php
                                        if ($model->card_type == $value->id) {
                                            echo " selected ";
                                        }
                                        ?>><?php echo $prefix . $value->name; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                                <?php echo "<br>" . $visitForm->error($model, 'card_type'); ?>
                            </td>

                        </tr>
                        <tr>

                            <td width="110px;" style="padding-top:4px;"><?php echo $visitForm->labelEx($model,
                                    'visitor_type', array('style' => 'padding-left:0;')); ?></td>
                            <td><?php
                                if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                                    ?>
                                    <select id="Visit_visitor_type" name="Visit[visitor_type]"
                                            class="visitortypedetails">
                                        <option selected="selected" value="2">Corporate Visitor</option>
                                    </select>
                                <?php
                                } else {
                                    echo $visitForm->dropDownList($model, 'visitor_type',
                                        VisitorType::model()->returnVisitorTypes(), array(
                                            'onchange' => 'visitorTypeOnChange()',
                                            'class' => 'visitortypedetails',
                                        ));
                                }
                                ?>
                                <?php echo "<br>" . $visitForm->error($model, 'visitor_type'); ?>
                                <div class="errorMessage" id="visitorTypePatientHost" style="display:none;">hello</div>
                                <input type="text" name="Visit[patient]" id="Visit_patient" style="display:none;"
                                       class="visitortypepatient" value="<?php echo $model->patient; ?>"/>
                                <input type="text" name="Visit[host]" id="Visit_host" class="visitortypehost"
                                       style="display:none;" value="<?php echo $model->host; ?>"/>
                            </td>

                        </tr>
                        <?php /* if ($session['role'] != Roles::ROLE_STAFFMEMBER) { */ ?><!--
                            <tr>
                                <td><input type='submit' value='Update' class='submitBtn complete'></td>
                            </tr>
                        --><?php /* } */ ?>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <li class='has-sub' id="reasonLi" <?php echo !is_null($asic) ? 'style="display: none;"' : ""; ?>><a href="#"><span>Reason</span></a>
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
                    <div class="flash-success success-update-reason">Reason Updated Successfully.</div>
                    <div class="flash-success success-add-reason">Reason Added Successfully.</div>

                    <table id="reasonTable" class="detailsTable">
                        <tr>
                            <td width="110px;" style="padding-top:4px;"><label for="Visit_reason">Reason</label></td>
                            <td>
                                <select id="Visit_reason" name="Visit[reason]"
                                        onchange="ifSelectedIsOtherShowAddReasonDiv(this)">
                                    <option value='' selected>Please select a reason</option>
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
                                <div class="errorMessage visitorReason" id="visitReason">Please select a reason</div>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Update" name="yt0" id="submitReasonForm" class="complete"/>
                            </td>
                        </tr>
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
                            <td width="110px;"><label for="VisitReason_reason">Reason</label></td>
                            <td><textarea id="VisitReason_reason" name="VisitReason[reason]"
                                          style="width:200px !important;text-transform: capitalize;" cols="80" rows="3"><?php
                                    echo $reasonModel->reason;
                                    ?></textarea> <?php echo $addReasonForm->error($reasonModel, 'reason'); ?>
                                <div class="errorMessage visitorReason" id="visitReasonErrorMessage">Please select a
                                    reason
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="submit" value="Add" name="yt0" id="submitAddReasonForm" class="complete"/>
                            </td>
                        </tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <?php if(($visitorModel->profile_type == "ASIC")||($visitorModel->profile_type == "VIC")):?>
        <li class='has-sub' id="asicDetailsLi">
            <a href="#"><span>Identification</span></a>
            <ul>
                <li>
                <table id="asicSponsorDetailsTable" class="detailsTable">
                    <tr>
                        <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                            Type
                        </td>
                        <td style="padding-left: 0 !important;">
                            <input type="text" class="visitor-detail-info-field" value="<?php
                            if (!empty($visitorModel->identification_type)) {
                                if (isset(Visitor::$IDENTIFICATION_TYPE_LIST[$visitorModel->identification_type])) {
                                    echo Visitor::$IDENTIFICATION_TYPE_LIST[$visitorModel->identification_type];
                                }
                            }
                            ?>" disabled="disabled"
                                   name="Visitor[identification_type]" id="identification_type">

                        </td>
                    </tr>
                    <tr>
                        <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                            Document No.
                        </td>
                        <td style="padding-left: 0 !important;">
                            <input type="text" class="visitor-detail-info-field" value="<?php echo $visitorModel->identification_document_no; ?>" disabled="disabled"
                                   name="Visitor[identification_document_no]" id="identification_document_no">
                        </td>
                    </tr>
                    <tr>
                        <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                            Document Expiry
                        </td>
                        <td style="padding-left: 0 !important;">
                            <input type="text" class="visitor-detail-info-field" value="<?php echo $visitorModel->identification_document_expiry; ?>" disabled="disabled"
                                   name="Visitor[identification_document_expiry]" id="identification_document_expiry">
                        </td>
                    </tr>
                </table>
                </li>
            </ul>
        </li>
           <?php endif;?>
        <?php if ($asic) : ?>
        <li class='has-sub' id="asicDetailsLi">
            <a href="#"><span>ASIC Sponsor</span></a>
            <ul>
                <li>
                    <table id="asicSponsorDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                First Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input class="visitor-detail-info-field" type="text" value="<?php echo $asic->first_name; ?>" disabled="disabled"
                                       name="Visitor[asic_first_name]" id="Visitor_asic_first_name">

                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Last Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input class="visitor-detail-info-field" type="text" value="<?php echo $asic->last_name; ?>" disabled="disabled"
                                       name="Visitor[asic_last_name]" id="Visitor_asic_last_name">

                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                ASIC No.
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo $asic->asic_no; ?>" disabled="disabled"
                                       name="Visitor[asic_no]" id="Visitor_asic_no">

                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                ASIC Expiry
                            </td>
                            <?php
                            ?>
                            <td style="padding-left: 0 !important;">
                                <input type="text" class="visitor-detail-info-field" value="<?php echo ($asic->asic_expiry != '0000-00-00' && $asic->asic_expiry != '')?date("d-m-Y" , strtotime($asic->asic_expiry)):''; ?>" disabled="disabled"
                                       name="Visitor[asic_expiry]" id="Visitor_asic_expiry">

                            </td>
                        </tr>

                    </table>
                </li>
            </ul>
        </li>
        <?php else : ?>
        <li class='has-sub' id='hostDetailsLi'>
            <a href="#"><span>Host Details</span></a>

            <ul>
                <li>
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
                            <td style="width:110px !important; padding-top: 3px;"><?php echo $hostForm->labelEx($hostModel,
                                    'first_name'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'first_name',
                                    array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled', 'class' => "visitor-detail-info-field")); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="110px;" style="  padding-top: 3px;"><?php echo $hostForm->labelEx($hostModel,
                                    'last_name'); ?></td>
                            <td>
                                <?php echo $hostForm->textField($hostModel, 'last_name',
                                    array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled', 'class' =>  "visitor-detail-info-field")); ?>
                                <?php echo "<br>" . $hostForm->error($hostModel, 'last_name'); ?>
                            </td>
                        </tr>
                    </table>
                    <?php $this->endWidget(); ?>
                </li>
            </ul>
        </li>
        <?php endif; ?>

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
                        <div class="flash-success success-add-patient">Patient Added Successfully.</div>

                        <table id='newPatientTable' class='detailsTable'>
                            <tr>
                                <td width="110px"><?php echo $newPatientForm->labelEx($newPatient, 'name'); ?></td>
                                <td>
                                    <?php echo $newPatientForm->textField($newPatient, 'name',
                                        array('size' => 50, 'maxlength' => 100, 'class' => "visitor-detail-info-field")); ?>
                                    <?php echo "<br>" . $newPatientForm->error($newPatient, 'name'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="submit" value="Add" name="yt0" style="display:inline-block;"
                                           class="complete"/>
                                </td>
                            </tr>
                        </table>

                        <?php $this->endWidget(); ?>
                    </div>
                </li>
            </ul>
        </li>
        <li>
            <ul>
                <li>
                    <?php
                    if (in_array($session['role'], [Roles::ROLE_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN, Roles::ROLE_SUPERADMIN])) {
                        echo '<input type="submit" class="complete btnUpdateVic"  value="Update">';
                    }
                    ?>
                </li>
            </ul>
        </li>
    </ul>

</div>
<script>
    $(document).ready(function () {
        $(".complete.btnUpdateVic").click(function(){

                    $('#update-visitor-form').submit();



        });


        $("#User_repeatpassword").keyup(checkPasswordMatch);
        if ($("#currentSessionRole").val() == 9) {
            $("#personalDetailsLi").html("<a href='#'><span>Personal Details</span></a>");
            $("#contactDetailsLi").html("<a href='#'><span>Contact Details</span></a>");
        }

        if ("<?php echo $model->visit_status; ?>" == '3')
        {
            $("#visitorInformationCssMenu :input").attr('disabled', true);
            $("#visitorInformationCssMenu input[type='submit']").hide();
        }

        $("#dummy-host-findBtn").click(function (e) {
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

        $(".host-AddBtn").click(function (e) {
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
        var url = 'index.php?r=visitor/findhost&id=' + $("#search-host").val() + '&visitortype=2&tenant=<?php echo $model->tenant; ?>&tenant_agent=<?php echo $model->tenant_agent; ?>';
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
            url: '<?php echo Yii::app()->createUrl("visitor/getHostDetails&id="); ?>' + id,
            dataType: 'json',
            data: id,
            success: function (r) {
                $.each(r.data, function (index, value) {
                    $("#searchHostTableDiv .findDivTitle").html("Selected ASIC Sponsor Record : " + value.first_name + " " + value.last_name);

                });

                $('#findHostTableIframe').contents().find('.findHostButtonColumn a').removeClass('delete');
                $('#findHostTableIframe').contents().find('.findHostButtonColumn a').html('Select ASIC Sponsor');
                $('#findHostTableIframe').contents().find('#' + id).addClass('delete');
                $('#findHostTableIframe').contents().find('#' + id).html('Selected ASIC Sponsor');
                alert(id);

                $("#selectedHostInSearchTable").val(id);
                $(".visitortypehost").val(id);
                alert($("#selectedHostInSearchTable").val());
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

    function populateHostTenantAgentAndCompanyField() {
        $('.New_user_company option[value!=""]').remove();
        $('.New_user_tenant_agent option[value!=""]').remove();
        var tenant = $(".New_user_tenant").val();

        getHostTenantAgentWithSameTenant(tenant);
        getHostCompanyWithSameTenant(tenant);

    }

    function getHostTenantAgentWithSameTenant(tenant) {
        $('.New_user_tenant_agent').empty();
        $('.New_user_tenant_agent').append('<option value="">Please select a tenant agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function (r) {
                $.each(r.data, function (index, value) {
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
            success: function (r) {
                $('.New_user_company option[value=""]').remove();
                $.each(r.data, function (index, value) {
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
            success: function (r) {
                $('.New_user_company option[value=""]').remove();
                $.each(r.data, function (index, value) {
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
<input type="button" id="findHostModalBtn" value="findhost" data-target="#findHostModal" data-toggle="modal"
       style="display:none;"/>
<div class="modal hide fade" id="findHostModal" style="width:69%; margin-left:-435px;">
    <div class="modal-header">

        <a data-dismiss="modal" class="close" id="dismissModal">×</a>
        <br>
    </div>
    <div id="findHostModalBody" style="padding:20px;">
        <div class="findDivTitle" style="font-weight:bold;font-size:12px;"></div>
        <div id="modalIframe" style="overflow-x: hidden !important; overflow-y: auto !important;"></div>
    </div>
</div>
