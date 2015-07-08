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
<?php
// If visit status is closed and user role different from admin or superadmin then disable fields
$disabled = '';
if (in_array($model->visit_status, [VisitStatus::CLOSED])) {
    $disabled = 'disabled';
}

/**
 * Date picker config if visit status is close and other state
 * If visit status is close then disable datepicker
 */
$datePickerOptionAttributes = [];
if (in_array($model->visit_status, [VisitStatus::CLOSED])) {

    // Please edit datePicker options attributes here for apply all datePicker fields
    $datePickerOptionAttributes = [
        'disabled' => 'disabled',
        'dateFormat' => "dd-mm-yy",
        'changeMonth' => true,
        'changeYear' => true
    ];

    // Please update datePicker style here for apply to all datePicker field on visitor detail page
    $datePickerStyle = 'width:107%';
} else {

    // Please edit datePicker options attributes here for apply all datePicker fields
    $datePickerOptionAttributes = [
        'showOn' => "button",
        'buttonImage' => Yii::app()->controller->assetsBase . "/images/calendar.png",
        'buttonImageOnly' => true,
        'dateFormat' => "dd-mm-yy",
        'changeMonth' => true,
        'changeYear' => true
    ];

    // Please update datePicker style here for apply all datePicker fields
    $datePickerStyle = 'width:83%';
}
?>
<?php
$visitorForm = $this->beginWidget('CActiveForm', [
    'id' => 'update-visitor-information-form',
    'htmlOptions' => ['name' => 'update-visitor-information-form']
]);
?>
<div id='visitorInformationCssMenu' <?php //if ($model && $model->card_type <= CardType::CONTRACTOR_VISITOR) {echo 'style="height:615px !important"';} ?>>

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
                                <?php echo $visitorForm->textField($visitorModel, 'first_name', ['disabled' => $disabled]); ?>
                                <br />
                                <?php echo $visitorForm->error($model, 'first_name'); ?>
                            </td>
                        </tr>

                        <?php if ($asic) : ?>
                            <tr>
                                <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                    Middle Name
                                </td>
                                <td style="padding-left: 0 !important;">
                                    <?php echo $visitorForm->textField($visitorModel, 'middle_name', ['disabled' => $disabled]); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Last Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($visitorModel, 'last_name', ['disabled' => $disabled]); ?>
                                <br />
                                <?php echo $visitorForm->error($model, 'last_name'); ?>
                            </td>
                        </tr>

                        <?php if ($asic) : ?>
                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Date of Birth
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php
                                $visitorModel->date_of_birth = !is_null($visitorModel->date_of_birth) ? date('d-m-Y', strtotime($visitorModel->date_of_birth)) : date('d-m-Y');
                                $options = [];
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $visitorModel,
                                    'attribute' => 'date_of_birth',
                                    'htmlOptions' => array(
                                        'size' => '10', // textField size
                                        'maxlength' => '10', // textField maxlength
                                        'placeholder' => 'dd-mm-yyyy',
                                        'readOnly' => 'readOnly',
                                        'disabled' => 'disabled',
                                        'style' => $datePickerStyle
                                    ),
                                    'options' => $datePickerOptionAttributes
                                ));
                                ?>

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
                    <input type="hidden" id="emailIsUnique" value="0"/>
                    <input type="hidden" id="Visitor_id" name="Visitor[id]" value="<?php echo $model->visitor; ?>"/>
                    <div class="flash-success success-update-contact-details"> Contact Details Updated Successfully.
                    </div>
                    <table id="contactDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" style="padding-top: 7px;">Email</td>
                            <td>
                                <?php echo $visitorForm->textField($visitorModel, 'email', ['disabled' => $disabled]); ?>
                                <br />
                                <div id="Visitor_email_em_" class="errorMessage errorMessageEmail">Email invalid or a profile already exists for this email address.
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 7px;">Mobile</td>
                            <td>
                                <?php echo $visitorForm->textField($visitorModel, 'contact_number', ['disabled' => $disabled]); ?>
                                <br />
                                <?php echo $visitorForm->error($model, 'first_name'); ?>
                            </td>
                        </tr>
                    </table>
                </li>
            </ul>
        </li>

        <?php
        $company = $visitorModel->getCompany();
        if (!empty($company)) :
            $contact = $newHost->findByPk($visitorModel->staff_id);
        ?>
        <li class='has-sub' id="companyDetailsLi"><a href="#"><span>Company Details</span></a>
            <ul>
                <li>
                    <table id="companyDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" <?php echo $disabled; ?> class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Company Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($company, 'name', ['disabled' => $disabled]); ?>
                                <br />
                                <?php echo $visitorForm->error($company, 'name'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Contact Person
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($company, 'contact', ['disabled' => $disabled, 'value' => $contact->getFullName()]); ?>
                                <br />
                                <?php echo $visitorForm->error($company, 'contact'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Contact No.
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($company, 'mobile_number', ['disabled' => $disabled, 'value' => $contact->contact_number]); ?>
                                <br />
                                <?php echo $visitorForm->error($company, 'mobile_number'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Contact Email
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($company, 'email_address', ['disabled' => $disabled, 'value' => $contact->email]); ?>
                                <br />
                                <?php echo $visitorForm->error($company, 'email_address'); ?>
                            </td>
                        </tr>

                    </table>
                </li>
            </ul>
        </li>
        <?php 
        endif;
        ?>
        <?php if (!$asic) : ?>
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
        <?php endif; ?>
        <?php if (!$asic) : ?>
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
        <?php endif; ?>
        <?php if (($visitorModel->profile_type == "ASIC") || ($visitorModel->profile_type == "VIC")) : ?>
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
                            <?php
                            if (isset(Visitor::$IDENTIFICATION_TYPE_LIST) and is_array(Visitor::$IDENTIFICATION_TYPE_LIST)) {
                                echo CHtml::dropDownList('Visitor[identification_type]', $visitorModel->identification_type, Visitor::$IDENTIFICATION_TYPE_LIST, ['disabled' => $disabled]);
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                            Document No.
                        </td>
                        <td style="padding-left: 0 !important;">
                            <?php echo $visitorForm->textField($visitorModel, 'identification_document_no', ['disabled' => $disabled]); ?>
                            <br />
                            <?php echo $visitorForm->error($visitorModel, 'identification_document_no'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                            Document Expiry
                        </td>
                        <td style="padding-left: 0 !important;">
                            <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $visitorModel,
                                'attribute' => 'identification_document_expiry',
                                'htmlOptions' => array(
                                    'size' => '10', // textField size
                                    'maxlength' => '10', // textField maxlength
                                    'placeholder' => 'dd-mm-yyyy',
                                    'readOnly' => 'readOnly',
                                    'style' => $datePickerStyle
                                ),
                                'options' => $datePickerOptionAttributes
                            ));
                            ?>

                        </td>
                    </tr>
                </table>
                </li>
            </ul>
        </li>
        <?php endif;?>
        <?php if ($asic) : ?>
        <li class='has-sub' id="asicDetails1Li">
            <a href="#"><span>ASIC Sponsor</span></a>
            <ul>
                <li>
                    <table id="asicSponsorDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                First Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($asic, 'first_name', ['disabled' => $disabled, 'name' => 'ASIC[first_name]']); ?>
                                <br />
                                <?php echo $visitorForm->error($asic, 'first_name'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Last Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($asic, 'last_name', ['disabled' => $disabled, 'name' => 'ASIC[last_name]']); ?>
                                <br />
                                <?php echo $visitorForm->error($asic, 'last_name'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                ASIC No.
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($asic, 'asic_no', ['disabled' => $disabled, 'name' => 'ASIC[asic_no]']); ?>
                                <br />
                                <?php echo $visitorForm->error($asic, 'asic_no'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                ASIC Expiry
                            </td>

                            <td style="padding-left: 0 !important;">
                                <?php
                                $asic->asic_expiry = !is_null($asic->asic_expiry) ? date('d-m-Y', strtotime($asic->asic_expiry)) : date('d-m-Y');
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $asic,
                                    'attribute' => 'asic_expiry',
                                    'htmlOptions' => array(
                                        'size' => '10', // textField size
                                        'maxlength' => '10', // textField maxlength
                                        'placeholder' => 'dd-mm-yyyy',
                                        'readOnly' => 'readOnly',
                                        'style' => $datePickerStyle,
                                        'name' => 'ASIC[asic_expiry]'
                                    ),
                                    'options' => $datePickerOptionAttributes
                                ));
                                ?>

                            </td>
                        </tr>

                    </table>
                </li>
            </ul>
        </li>
        <?php elseif ($hostModel) : ?>
        <li class='has-sub' id='hostDetailsLi'>
            <a href="#"><span>Host Details</span></a>
            <ul>
                <li>
                    <input type="text" id="hostEmailIsUnique" value="0"/>
                    <table id="hostTable" class="detailsTable">
                        <tr>
                            <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                First Name
                            </td>
                            <td style="padding-left: 0 !important;">
                            <?php echo $visitorForm->textField($hostModel, 'first_name', ['disabled' => $disabled, 'name' => 'Host[first_name]']); ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Last Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php echo $visitorForm->textField($hostModel, 'last_name', ['disabled' => $disabled, 'name' => 'Host[last_name]']); ?>
                            </td>
                        </tr>
                    </table>
                </li>
            </ul>
        </li>
        <?php endif; ?>
        <?php if ($asicEscort != '') : ?>
        <li class='has-sub' id="asicEscortDetailLi">
            <a href="#"><span>ASIC Escort</span></a>
            <ul>
                <li>
                    <table id="asicSponsorDetailsTable" class="detailsTable">
                        <tr>
                            <td width="110px;" class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                First Name
                            </td>

                            <td style="padding-left: 0 !important;">
                                <input class="visitor-detail-info-field"  <?php echo $disabled; ?> type="text" value="<?php echo $asicEscort->first_name; ?>"
                                       name="Escort[asic_escort_asic_first_name]" id="Visitor_asic_first_name">
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                Last Name
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input class="visitor-detail-info-field"  <?php echo $disabled; ?> type="text" value="<?php echo $asicEscort->last_name; ?>"
                                       name="Escort[last_name]" id="Visitor_asic_last_name">
                            </td>
                        </tr>

                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                ASIC No.
                            </td>
                            <td style="padding-left: 0 !important;">
                                <input type="text" <?php echo $disabled; ?> class="visitor-detail-info-field" value="<?php echo $asicEscort->asic_no; ?>"
                                       name="Escort[asic_no]" id="Visitor_asic_no">
                            </td>
                        </tr>
                        <tr>
                            <td class="visitor-detail-info" style="padding-left: 0 !important; padding-bottom: 6px; padding-top: 6px;">
                                ASIC Expiry
                            </td>
                            <td style="padding-left: 0 !important;">
                                <?php
                                $asicEscort->asic_expiry = !is_null($asicEscort->asic_expiry) ? date('d-m-Y', strtotime($asicEscort->asic_expiry)) : date('d-m-Y');
                                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $asicEscort,
                                    'attribute' => 'asic_expiry',
                                    'htmlOptions' => array(
                                        'size'        => '10', // textField size
                                        'maxlength'   => '10', // textField maxlength
                                        'placeholder' => 'dd-mm-yyyy',
                                        'readOnly'    => 'readOnly',
                                        'style'       => 'width:83%',
                                        'name'        => 'Escort[asic_expiry]'
                                    ),
                                    'options' => array(
                                        'showOn'          => "button",
                                        'buttonImage'     => Yii::app()->controller->assetsBase . "/images/calendar.png",
                                        'buttonImageOnly' => true,
                                        'minDate'         => "0",
                                        'dateFormat'      => "dd-mm-yy",
                                    )
                                ));
                                ?>
                            </td>
                        </tr>
                    </table>
                </li>
            </ul>
        </li>
        <?php endif ?>
        <?php if (!$asic) : ?>
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
                                    if(!hasError) {
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
        <?php endif; ?>
        <li>
            <ul>
                <li>
                <?php
                if (in_array($session['role'], [Roles::ROLE_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN, Roles::ROLE_SUPERADMIN]) && !in_array($model->visit_status, [VisitStatus::CLOSED])) :
                ?>
                    <button type="submit" class="greenBtn btnUpdateVisitorInfo" name="updateVisitorInfo">Update</button>
                <?php endif; ?>
                </li>
            </ul>
        </li>
    </ul>
</div>
<?php $this->endWidget(); ?>
<script>
    function afterValidate(form, data, hasError) {
        hasError = false;
    }
    
    $(document).ready(function () {

        function validateInformation(){
            var t = 1;
            if($('#personalDetailsLi').length){
                $('#personalDetailsLi').find(':input').each(function(){
                    var em = $('#' + $(this).attr('id') + "_em_");
                    if ($(this).attr('id').indexOf('middle_name') == -1) {
                        if($(this).val() == '' || $(this).val().length < 1){
                            if (em.length) em.show();
                            t = 0;
                        } else {
                            if (em.length) em.hide();
                        }
                    }
                });
            }

            if($('#contactDetailsLi').length){
                $('#contactDetailsLi').find(':input').each(function(){
                    var em = $('#'+$(this).attr('id')+"_em_");
                    if ($(this).attr('id').indexOf('email') != -1) {
                        if ($(this).attr('id') != 'emailIsUnique') {
                            if (validateEmail1($(this).val()) == false || checkVisitorEmail($(this).val()) == false) {
                                if (em.length) em.show();
                                t = 0;
                            } else {
                                if (em.length)em.hide();
                            }
                        }
                    } else {
                        if ($(this).val() == '' || $(this).val().length < 1) {
                            if (em.length) em.show();
                             t=0;
                        } else {
                            if (em.length) em.hide();
                        }
                    }
                });
            }

            if ($('#companyDetailsLi').length) {
                $('#companyDetailsLi').find(':input').each(function(){
                    var em = $('#'+$(this).attr('id')+"_em_");
                    if ($(this).attr('id').indexOf('email_address')>0){
                        if(!validateEmail1($(this).val())){
                            if (em.length) em.show();
                            t=0;
                        }else{
                            if(em.length) em.hide();
                        }
                    } else {
                        if ($(this).val() == '' || $(this).val().length < 1) {
                            if (em.length) em.show();
                            t=0;
                        } else {
                            if (em.length) em.hide();
                        }
                    }
                });
            }

            if ($('#asicDetailsLi').length) {
                $('#asicDetailsLi').find(':input').each(function() {
                    var em = $('#' + $(this).attr('id') + "_em_");
                    if($(this).val() == ''){
                        if (em.length) em.show();
                        t = 0;
                    }else{
                        if (em.length) em.hide();
                    }
                });
            }

            if ($('#asicDetails1Li').length){
                $('#asicDetails1Li').find(':input').each(function() {
                    var em = $('#'+$(this).attr('id')+"_em_");
                    if($(this).val() == ''){
                        if (em.length) em.show();
                        t = 0;
                    }else{
                        if (em.length) em.hide();
                    }
                });
            }

            if(t == 1) 
                return true; 
            else return false;
        }

        function checkElementExist(element){
            if(element.length){
                return true;
            }
            return false;
        }

        function validateEmail1(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }

        $("#User_repeatpassword").keyup(checkPasswordMatch);
        if ($("#currentSessionRole").val() == 9) {
            $("#personalDetailsLi").html("<a href='#'><span>Personal Details</span></a>");
            $("#contactDetailsLi").html("<a href='#'><span>Contact Details</span></a>");
        }

        /*if ("<?php echo $model->visit_status; ?>" == '3')
        {
            $("#visitorInformationCssMenu :input").attr('disabled', true);
            $("#visitorInformationCssMenu input[type='submit']").hide();
        }*/

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

    //check vistor card status of host before update
    function checkVistorCardStatusOfHost(id_host){
        $.ajax({
            type: 'POST',
            url: 'index.php?r=visitor/CheckCardStatus&id=' + id_host,
            dataType: 'json',
            data: id_host,
            success: function (r) {
                if (!r){
                    alert('Please update Card Status for current Host before Update Asic Sponsor.');
                }
                return r;
            }
        });
        return true;
    }

    function checkVisitorEmail(email) {
         var t = 1;
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl("visitor/checkEmailIfUnique&email="); ?>' + email.trim() + '&id=' +<?php echo $visitorModel->id; ?>,
                dataType: 'json',
                data: {email: email, id:<?php echo $visitorModel->id; ?>},
                success: function (r) {
                    $.each(r.data, function (index, value) {
                        t = value.isTaken;
                    });

                }
            });
        if( t == 1) return true; else return false;
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
