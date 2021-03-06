<?php

$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');

$session = new CHttpSession;
$company = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}

$dataId = '';
if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}

$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');

// set default country is Australia = 13
$model->identification_country_issued = 13;
?>

<style>
    #addCompanyLink {width: 124px;height: 23px;padding-right: 0px;margin-right: 0px;padding-bottom: 0px;display: block;}
    .form-label {display: block;width: 200px;float: left;margin-left: 15px;}
    .ajax-upload-dragdrop {margin-left: 0px !important;}
    .uploadnotetext {margin-top: 110px;margin-left: -80px;}
    #content h1 {color: #2f96b4;font-size: 18px;font-weight: bold;margin-left: 50px;  }
    .required {padding-left: 10px;}
    .errorMessageImportant {display: block !important;}
    .date_of_birth_class{width: 71.5px !important;}
</style>

<br>
<div role="tabpanel" style="width:882px">

   
    <!-- Nav tabs -->
    <div style="float:left;width:270px;text-align:center">
    <div class="visitor-title" style="cursor:pointer;color:#2f96b4">Add Visitor Profile</div>
    </div>
    <input type="text" id="search-visitor" name="search-visitor" placeholder="Search Visitor Profiles by name, email or drivers licence"
           class="search-text" style="margin-left:30px;"/>
    <button class="visitor-findBtn" onclick="findVisitorRecord()" id="visitor-findBtn" style="display:none;"
            data-target="#findVisitorRecordModal" data-toggle="modal">Find Record
    </button>
    <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
    <button class="visitor-findBtn neutral" id="dummy-visitor-findBtn" style="<?php echo $background; ?>padding:8px;">
        Find Visitor Profile
    </button>
    <div class="errorMessage" id="searchTextErrorMessage" style="display:none;text-align:center"></div>


    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="addvisitor">
            <div id="findAddVisitorRecordDiv" class="findAddVisitorRecordDiv">

                <div data-ng-app="PwordForm">
                    <?php
                   $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'register-form',
                        'htmlOptions' => array("name" => "registerform"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form, data, hasError){
                                return afterValidate(form, data, hasError);
							}',
                            'beforeValidate' => 'js:function(form, data, hasError){
                                return beforeValidate(form, data, hasError);
                            }'
                        ),
                    ));
//else if ($("#workstation").val() == ""){
//  $(".errorMessageWorkstation").show();
//  $(".visitorReason").hide();
//}
//$(".errorMessageWorkstation").hide();

                    ?>
                    <?php /*echo $form->errorSummary($model); */?>
                    <input type="hidden" id="emailIsUnique" value="0"/>
                    <input type="hidden" name="VisitCardType" id="VisitCardType" />

                    <div >

                        <table style="width:300px;float:left;" class="first-column">
                            <tr>

                                <td style="width:300px;">
                                    <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->

                                    <input type="hidden" id="Visitor_photo" name="Visitor[photo]">

                                    <div class="photoDiv" style='display:none;'>
                                        <img id='photoPreview'
                                             src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png"
                                             style='display:none;'/>
                                    </div>

                                    <?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>

                                    <div id="photoErrorMessage" class="errorMessage"
                                         style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">
                                        Please upload a photo.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr style="display: none" id="vicHolderCardStatus">
                                <td>
                                    <?php
                                    array_pop(Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_VIC]);
                                    echo $form->dropDownList($model, 'visitor_card_status', Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_VIC], ['empty' => 'Select Card Status', 'options'=>['2' => ['selected'=>true]]]); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'visitor_card_status'); ?>
                                </td>
                            </tr>

                        </table>
                        
                        <table id="addvisitor-table" class="second-column" data-ng-app="PwordForm" style="width:262px;float:left;">

                            <tr id="limit-first-name">
                                <td>
                                    <?php echo $form->textField($model, 'first_name', ['size' => 50, 'maxlength' => 15, 'placeholder' => 'First Name']); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->textField($model, 'middle_name', ['size' => 50, 'maxlength' => 50, 'placeholder' => 'Middle Name']); ?>
                                    <?php echo "<br>" . $form->error($model, 'middle_name'); ?>
                                </td>
                            </tr>
                            <tr id="limit-last-name">
                                <td>
                                    <?php echo $form->textField($model, 'last_name',
                                        array('size' => 50, 'maxlength' => 15, 'placeholder' => 'Last Name')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                                </td>
                            </tr>

                            <tr class="vic-visitor-fields" id="vic-birth-date-field">
                                <td class="birthdayDropdown">
                                   <span>Date of Birth</span> <br/>
                                    <?php $this->widget('EDatePicker', array(
                                        'model'=>$model,
                                        'attribute'=>'date_of_birth',
                                        'mode'=>'date_of_birth',
                                        'htmlOptions'=>[]
                                    ));
                                    ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'date_of_birth'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td width="37%">
                                    <?php echo $form->textField($model, 'email',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Email Address')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'email',
                                            array('style' => 'text-transform:none;')); ?>
                                    <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail">
                                        A User Profile already exists for this email address. <a href='javascript:;' id='searchVisitorsByEmailLink'>Click here</a> to Find this Visitor Profile or enter an alternate email address.
                                    </div>

                                    <div style="" id="" class="newErrorMessage newErrorMessageEmail">
                                        A User Profile already exists for First Name, Last Name and DOB. <a href='javascript:;' id='searchVisitorsByFirstnameLink'>Click here</a> to Find Visitor Profile or enter a middle name to create a new profile if a different person.
                                    </div>

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <?php echo $form->textField($model, 'contact_number',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Contact Number')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'contact_number'); ?>
                                </td>
                            </tr>

                            <tr class="vms-visitor-fields">
                                <td>
                                    <input placeholder="Vehicle Registration Number" type="text" id="Visitor_vehicle"
                                           name="Visitor[vehicle]" maxlength="6" size="6">
                                    <?php echo "<br>" . $form->error($model, 'vehicle'); ?>
                                </td>
                            </tr>

                            <!-- start VIC info -->
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->textField($model, 'contact_unit', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Unit', 'style' => 'width: 80px;')); ?>
                                    <?php echo $form->textField($model, 'contact_street_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street No.', 'style' => 'width: 110px;')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'contact_unit'); ?>
                                    <?php echo $form->error($model, 'contact_street_no'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->textField($model, 'contact_street_name', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street Name', 'style' => 'width: 110px;')); ?>
                                    <?php echo $form->dropDownList($model, 'contact_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'style' => 'width: 95px;')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'contact_street_name'); ?>
                                    <?php echo $form->error($model, 'contact_street_type'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->textField($model, 'contact_suburb', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'Suburb')); ?>
                                    <span class="required">*</span> <?php echo $form->error($model, 'contact_suburb'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <i id="cstate">
                                    <?php echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State', 'style' => 'width: 140px;')); ?>
                                    </i>
                                    <select id="state_copy" style="display: none">
                                        <?php
                                        if(isset(Visitor::$AUSTRALIAN_STATES) && is_array(Visitor::$AUSTRALIAN_STATES)){
                                            foreach (Visitor::$AUSTRALIAN_STATES as $key=>$value):
                                                echo "<option name='$key'>$value</option>";
                                            endforeach;
                                        }
                                        ?>
                                    </select>
                                    <?php echo $form->textField($model, 'contact_postcode', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Postcode', 'style' => 'width: 62px;')); ?>
                                        <span class="required">*</span>
                                    <?php echo $form->error($model, 'contact_postcode'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php
                                    echo $form->dropDownList($model, 'contact_country', $countryList,
                                        array('prompt' => 'Country', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                                    ?><span class="required">*</span>
                                    <br/>
                                    <?php echo $form->error($model, 'contact_country'); ?>
                                </td>
                            </tr>
                            <!-- .end vic info -->

                            <tr>
                                <td id="visitorCompanyRow" style="white-space: nowrap;">
                                    <div style="margin-bottom: 5px;">
                                        <?php
                                        $this->widget('application.extensions.select2.Select2', array(
                                            'model' => $model,
                                            'attribute' => 'company',
                                            'items' => CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']),
                                                'id', 'name'),
                                            'selectedItems' => array(), // Items to be selected as default
                                            'placeHolder' => 'Please select a company'
                                        ));
                                        ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($model, 'company',array("style" => "margin-top:0px")); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="margin-bottom: 5px;" id="visitorStaffRow"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a style="float: left; margin-right: 5px; width: 95px; height: 21px;  margin-bottom: 12px;" href="#addCompanyContactModal" role="button" data-toggle="modal" id="addCompanyLink" class="actionForward">Add Company</a>
                                    <a href="#addCompanyContactModal" id="addContactLink" class="btn btn-xs btn-info actionForward" style="font-size: 12px; font-weight: bold; display: none; margin-bottom: 10px;" role="button" data-toggle="modal">Add Contact</a>
                                </td>
                            </tr>


                            <tr>
                                <td id="visitorTenantRow" <?php
                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                    echo " class='hidden' ";
                                }
                                ?>>

                                    <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()"
                                            name="Visitor[tenant]">
                                        <option value=''>Please select a tenant</option>
                                        <?php
                                        $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                                        foreach ($allTenantCompanyNames as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['id']; ?>"
                                                <?php
                                                if ($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['id']) {
                                                    echo " selected ";
                                                }
                                                ?>

                                                ><?php echo $value['name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select><span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'tenant'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td id="visitorTenantAgentRow" <?php
                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                    echo " class='hidden' ";
                                }
                                ?>>

                                    <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]"
                                            onchange="populateCompanyWithSameTenantAndTenantAgent()">
                                        <?php
                                        echo "<option value='' selected>Please select a tenant agent</option>";
                                        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                            echo "<option value='" . $session['tenant_agent'] . "' selected>TenantAgent</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                                </td>

                            </tr>

                            <tr class="vms-visitor-fields">
                                <td>
                                    <?php echo $form->textField($model, 'position',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Position')); ?>

                                    <?php echo "<br>" . $form->error($model, 'position'); ?>
                                </td>
                            </tr>

                        </table>

                        <table class="third-column" style="width:280px;">
                            <tr class="workstationDropdownRow">
                                <td id="workstationRow" <?php
                                if ($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR) {
                                    echo " class='hidden' ";
                                }
                                ?>>

                                    <select id="workstation" name="Visitor[visitor_workstation]" onchange="populateVisitWorkstation(this)">
                                        <?php
                                        if ($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR) {
                                            echo '';
                                        } else {
                                           // echo '<option value="">Select Workstation</option>';
                                        }
                                        ?>

                                        <?php
                                        $workstationList = Utils::populateWorkstation();

                                        foreach ($workstationList as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['id']; ?>" <?php echo $value['id'] == $session['workstation'] ? 'selected="selected"' : ''; ?>>
                                                <?php echo 'Workstation: ' . $value['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <!--
                                    <span class="required">*</span>

                                    <div style="display:none;" class="errorMessage errorMessageWorkstation">Select Workstation</div>
                                    -->
                                </td>
                            </tr>

                            <tr class="visitorTypeDropdownRow">
                                <td>

                                    <?php
                                   // if(Yii::app()->user->role == Roles::ROLE_ADMIN) {
                                        
                                        //$list = VisitorType::model()->findAll('created_by = :c and tenant = :t and module = :m', [':c' => Yii::app()->user->id,':t' => Yii::app()->user->tenant, ':m' => CHelper::get_module_focus()]);

                                        $list = VisitorType::model()->findAll('tenant='.$_SESSION['tenant']);
                                        echo '<select onchange="showHideHostPatientName(this)" name="Visitor[visitor_type]" id="Visitor_visitor_type">';
                                        echo CHtml::tag('option', array('value' => ''), 'Select Visitor Type', true);
                                        foreach( $list as $val ) {
                                            if ( $val->tenant == Yii::app()->user->tenant && $val->is_default_value == '1' ) {
                                                echo CHtml::tag('option', array('value' => $val->id, 'selected' => 'selected'), CHtml::encode('Visitor Type: '.$val->name), true);
                                            } else {
                                                echo CHtml::tag('option', array('value' => $val->id), CHtml::encode('Visitor Type: '.$val->name), true);
                                            }
                                        } 
                                        echo "</select>";
//                                    } else {
//
//                                        echo $form->dropDownList($model, 'visitor_type',
//                                        VisitorType::model()->getCardTypeVisitorTypes(5), array(
//                                            'onchange' => 'showHideHostPatientName(this)',
//                                            'id'=>'Visitor_visitor_type2'
//                                            //'prompt' => 'Select Visitor Type',
//                                        ));
//                                    }
                                    
                                    ?>
                                    <span class="required">*</span>
                                    <?php echo $form->error($model, 'visitor_type'); ?>
                                </td>
                            </tr>

                            <tr class="visitReasonRow">
                                <td>
                                    <select id="Visit_reason" name="Visitor[reason]"
                                            onchange="ifSelectedIsOtherShowAddReasonDiv(this)">
                                        <option value='' selected>Select Reason</option>
                                        

                                    </select>
                                    <span class="required">*</span>

                                    <div class="errorMessage visitorReason">Please complete Reason</div>
                                </td>
                            </tr>

                            <tr class="visitReasonOtherRow">
                                <td>
                                    <div id="register-reason-form" style="margin-top: 0px; width: 100% !important;">
                                    <table style="/*position:relative;top:555px;left:-301px*/">
                                        <tr>
                                            <td>
                                                <textarea id="VisitReason_reason" name="VisitReason[reason]" rows="1" maxlength="128"
                                                    style="" placeholder="Add Reason"></textarea>
                                                <div class="errorMessage" id="visitReasonErrorMessage" style="display:none;">Please complete Reason</div>
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                    <?php //$this->endWidget(); ?>
                                </td>
                            </tr>

                            <!-- start VIC info -->
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Select Identification Type'));?>
                                    <span class="required primary-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_type'); ?>
                                </td>
                            </tr>

                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php
                                    echo $form->dropDownList($model, 'identification_country_issued', $countryList, array('empty' => 'Country of Issue'));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_country_issued'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->textField($model, 'identification_document_no', array( 'size'=>50,'maxlength' => 50, 'placeholder' => 'Document No.')); ?>

                                    <?php
                                    $this->widget('EDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_document_expiry',
										'mode'=>  'expiry',
											));
                                    ?><!-- <span class="required primary-identification-require">*</span> -->
                                    <?php echo "<br>" . $form->error($model, 'identification_document_no'); ?>
                                    <?php echo $form->error($model, 'identification_document_expiry'); ?>
                                </td>
                            </tr>
                            <tr id="u18_identification" style="display:none">
                                <td>
                                    <input type="checkbox" style="float: left;" id="Visitor_u18_identification" name="Visitor_u18_identification" value="">
                                    <label for="Visitor_identification" class="form-label">I have verified that the applicant is under 18<span class="required primary-identification-require">*</span></label>
                                    <div class="errorMessage" style="float: left; display: none;" id="Visitor_u18_identification_em_">Please verify the age of the applicant.</div>
                                    <input type="text" name="Visitor_u18_identification_document_no" style="" placeholder="Details">
                                </td>
                            </tr>
                            <?php if (!in_array($session['role'], [Roles::ROLE_AIRPORT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_ADMIN, Roles::ROLE_AGENT_AIRPORT_OPERATOR])): ?>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->checkBox($model, 'alternative_identification', array('style' => 'float: left;', 'onclick'=>"switchIdentification();")); ?>
                                    <label for="Visitor_alternative_identification" id="alternative_identification_label" class="form-label" onclick="switchIdentification();">
                                        Applicant does not have one of the above identifications
                                    </label>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <tr class="row_document_name_number" style="display:none">
                                <td>
                                    <?php echo $form->textField($model, 'identification_alternate_document_name1', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Document Name'));
                                    ?><span class="required alternate-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_alternate_document_name1'); ?>

                                </td>
                            </tr>
                            <tr class="row_document_name_number" style="display:none">
                                <td>
                                    <?php echo $form->textField($model, 'identification_alternate_document_no1', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Document No.', 'style' => 'width: 108px;')); ?>

                                    <?php
                                    $this->widget('EDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_alternate_document_expiry1',
                                        'mode'        => 'expiry',
                                    ));
                                    ?><span class="required alternate-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_alternate_document_no1'); ?>
                                    <?php echo $form->error($model, 'identification_alternate_document_expiry1'); ?>
                                </td>
                            </tr>
                            <tr class="row_document_name_number" style="display:none">
                                <td>
                                    <?php echo $form->textField($model, 'identification_alternate_document_name2', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Document Name'));
                                    ?><span class="required alternate-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_alternate_document_name2'); ?>

                                </td>
                            </tr>
                            <tr class="row_document_name_number" style="display:none">
                                <td>
                                    <?php echo $form->textField($model, 'identification_alternate_document_no2', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Document No.', 'style' => 'width: 108px;')); ?>

                                    <?php
                                    $this->widget('EDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_alternate_document_expiry2',
                                        'mode'        => 'expiry',
                                    ));
                                    ?><span class="required alternate-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_alternate_document_no2'); ?>
                                    <?php echo $form->error($model, 'identification_alternate_document_expiry2'); ?>

                                    <?php echo $form->checkBox($model, 'verifiable_signature', array('style' => 'float: left;')); ?>
                                    <label  class="form-label">One of these has a verifiable signature</label>
                                </td>
                            </tr>

                            <tr class="vic-visitor-fields" id="password-field">
                              <td id="passwordVicForm">
                                    <?php $this->renderPartial('/common_partials/password', array('model' => $model, 'form' => $form, 'session' => $session)); ?>
                                </td>
                            </tr>
                            <!-- end VIC info -->

                            <tr>
                                <td>
                                    <div class="register-a-visitor-buttons-div"
                                         style="padding-top:10px;padding-right:60px; text-align: right;">
                                        <input type="button" class="neutral visitor-backBtn btnBackTab2"
                                               id="btnBackTab2" value="Back"/>
                                        <input type="button" id="clicktabB" value="Save and Continue"
                                               style="display:none;"/>

                                        <input type="submit" value="Save and Continue" name="yt0" id="submitFormVisitor" style="margin-top: 2px;"
                                               class="actionForward"/>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div>
                    

                    <?php $this->endWidget(); ?>
                </div>

            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="searchvisitor" style="width: 99.99%">
            <div <?php
            if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                echo "style='display:none;'";
            }
            ?>>
                <table>
                    <tr>
                        <td style='width:250px;'><label>Tenant <span class="required">*</span></label></td>
                        <td><label>Tenant Agent </label></td>
                    </tr>
                    <tr>
                        <td>
                            <select id="search_visitor_tenant" onchange="populateTenantAgentAndCompanyField('search')">
                                <option value='' selected>Select a tenant</option>
                                <?php
                                $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                                foreach ($allTenantCompanyNames as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['id']; ?>"
                                        <?php
                                        if ($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['id']) {
                                            echo " selected ";
                                        }
                                        ?>><?php echo $value['name']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <select id="search_visitor_tenant_agent"
                                    onchange="populateAgentAdminWorkstations('search')">
                                <?php
                                echo "<option value='' selected>Please select a tenant agent</option>";
                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                    echo "<option value='" . $session['tenant_agent'] . "' selected>TenantAgent</option>";
                                }
                                ?>
                            </select>
                        </td>
                </table>
            </div>


            <div id="searchVisitorTableDiv">
                <h4>Search Results for : <span id='search'></span><?php $this->widget('ext.widgets.loading.LoadingWidget'); ?></h4>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'register-reason-form-search',
                    'action' => Yii::app()->createUrl('/visitReason/create&register=1'),
                    'htmlOptions' => array("name" => "register-reason-form"),
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){                               
                           }
                        }'
                    ),
                ));
                ?>
                <textarea id="VisitReason_reason_search" maxlength="128" name="VisitReason[reason]"></textarea>

                <div class="errorMessage" id="visitReasonErrorMessageSearch" style="display:none;">Please complete Reason</div>

                <?php $this->endWidget(); ?>

                <div id="searchVisitorTable"></div>

            </div>
            <div class="register-a-visitor-buttons-div" style="padding-right:23px;text-align: right;">
                <input type="button" class="neutral visitor-backBtn " id="btnBackTab2" value="Back" onclick="javascript:backFillNewVistor();return false;"/>
                <input type="button" id="clicktabB1" value="Save and Continue" class="actionForward"/>
            </div>
            <input type="text" id="selectedVisitorInSearchTable" value="0"/>
        </div>
    </div>

</div>


<script>
    var is_error = false;
    function beforeValidate(form, data, hasError) {
        is_error = false;
        if ($("#Visit_reason").val() == "") {
            $(".visitorReason").show();
            is_error = true;
        } else {
            $(".visitorReason").hide();
        }

        if($('#VisitCardType').val() > CONTRACTOR_TYPE) {
            if ($("#Visitor_contact_street_no").val() == "") {
                is_error = true;
                $("#Visitor_contact_street_no_em_").html("Please complete contact street no.").addClass("errorMessageImportant");
            } else {
                $("#Visitor_contact_street_no_em_").empty().removeClass("errorMessageImportant");
            }

            if ($("#Visitor_contact_street_type").val() == "") {
                is_error = true;
                $("#Visitor_contact_street_type_em_").html("Please complete contact street type").addClass("errorMessageImportant");
            } else {
                $("#Visitor_contact_street_type_em_").empty().removeClass("errorMessageImportant");
            }

            if ($("#Visitor_contact_suburb").val() == "") {
                is_error = true;
                $("#Visitor_contact_suburb_em_").html("Please complete contact suburb").addClass("errorMessageImportant");
            } else {
                $("#Visitor_contact_suburb_em_").empty().removeClass("errorMessageImportant");
            }

            if ($("#Visitor_contact_postcode").val() == "") {
                is_error = true;
                $("#Visitor_contact_postcode_em_").html("Please complete contact postcode").addClass("errorMessageImportant");
            } else {
                $("#Visitor_contact_postcode_em_").empty().removeClass("errorMessageImportant");
            }

            if ($("#Visitor_contact_country").val() == "") {
                is_error = true;
                $("#Visitor_contact_country_em_").html("Please complete contact country").addClass("errorMessageImportant");
            } else {
                $("#Visitor_contact_country_em_").empty().removeClass("errorMessageImportant");
            }

            //because of https://ids-jira.atlassian.net/browse/CAVMS-1201
            if($("#Visitor_u18_identification").is(":checked"))
            {
                $("#Visitor_identification_type_em_").empty().removeClass("errorMessageImportant");
            }
            else
            {
                if ($("#Visitor_identification_type").val() == "") 
                {
                    is_error = true;
                    $("#Visitor_identification_type_em_").html("Please complete identification type").addClass("errorMessageImportant");
                } else {
                    $("#Visitor_identification_type_em_").empty().removeClass("errorMessageImportant");
                }
            }
            

            if ($("#Visitor_identification_country_issued").val() == "") {
                is_error = true;
                $("#Visitor_identification_country_issued_em_").html("Please complete identification country issued").addClass("errorMessageImportant");
            } else {
                $("#Visitor_identification_country_issued_em_").empty().removeClass("errorMessageImportant");
            }

            /*
            CAVMS--1171
            if ($("#Visitor_identification_document_expiry").val() == "") {
                is_error = true;
                $("#Visitor_identification_document_expiry_em_").html("Please complete identification document expiry").addClass("errorMessageImportant");
            } else {
                $("#Visitor_identification_document_expiry_em_").empty().removeClass("errorMessageImportant");
            }*/
        }

        return true;
    }

    function afterValidate(form, data, hasError) 
    {
        if(is_error) return false;
        $("#selectedVisitorInSearchTable").val("");
        $("#register-host-form").show();
        $("#searchHostDiv").show();
        if($("#currentRoleOfLoggedInUser").val() == 9){
            $("#currentHostDetailsDiv").show();
            $("#register-host-form").hide();
            $(".host-AddBtn").show();
        } else {
            $("#currentHostDetailsDiv").hide();
            $("#register-host-form").show();
            $(".host-AddBtn").hide();
        }
        
        var bod_field = $("#vic-birth-date-field:hidden");
        if (bod_field.length != 1) {

        /* var dt = new Date();
            if(dt.getFullYear() < $("#fromYear").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html("Please update your Date of Birth");
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html("Please update your Date of Birth");
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html("Please update your Date of Birth");
                return false;
            }*/
        }

        
        if ($("#u18_identification:hidden").length != 1) {
            if (!$("#Visitor_u18_identification").is(":checked")) {
                $("#Visitor_u18_identification_em_").show();
                return false;
            } else {
                $("#Visitor_u18_identification_em_").hide();
            }
        } else {
            $("#Visitor_u18_identification_em_").hide();
        }
        

        if (!hasError){
            if($('#VisitCardType').val() > CONTRACTOR_TYPE) {
                if($(parentElement()+".pass_option").is(":checked")== false){
                    $(parentElement()+"#pass_error_").show();
                    $(parentElement()+"#User_password_em_").html("select one option");
                    return false;
                }
                else if($(".pass_option").is(":checked")== true && $(".pass_option:checked").val()==1 && ($("#Visitor_password").val()== "" || $("#Visitor_repeatpassword").val()=="") && parentElement() == '#step2Tab '){
                    $(parentElement()+"#pass_error_").show();
                    $(parentElement()+"#pass_error_").html("Type password or generate");
                    return false;
                }
                else if($(".pass_option").is(":checked")== true && $(".pass_option:checked").val()==1 && $("#Visitor_password").val() != "" && $("#Visitor_repeatpassword").val() !="" && $("#Visitor_repeatpassword").val() != $("#Visitor_password").val()){
                    $(parentElement()+"#pass_error_").show();
                    $(parentElement()+"#pass_error_").html("Password does not match with Repeat Password.");
                    return false;
                }
                else {
                     $(parentElement()+"#pass_error_").hide();
                }
            }
            var vehicleValue = $("#Visitor_vehicle").val();
            if(vehicleValue.length < 6 && vehicleValue != ""){

                $("#Visitor_vehicle_em_").show();
                $("#Visitor_vehicle_em_").html("Vehicle should have a min. of 6 characters");

            } else if ($("#Visit_reason").val() == "" || ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() == "")) {

                $(".visitorReason").show();

            } else if ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() != "") {

                checkReasonIfUnique();

            } else if(
                $("#Visitor_photo").val() == "" &&
                $("#cardtype").val() != <?php echo CardType::SAME_DAY_VISITOR; ?>  &&
                $("#cardtype").val() != <?php echo CardType::MANUAL_VISITOR; ?>  &&
                $("#cardtype").val() != <?php echo CardType::VIC_CARD_SAMEDATE; ?>  && 
                $("#cardtype").val() != <?php echo CardType::VIC_CARD_24HOURS; ?>  && 
                $("#cardtype").val() != <?php echo CardType::VIC_CARD_MANUAL; ?>
            ){
                $("#photoErrorMessage").show();
            } else {

                $(".visitorReason").hide();
                $("#photoErrorMessage").hide();
                //checkEmailIfUnique();
                checkAlreadyVisitor();                
            }
        }
    }

    function backFillNewVistor(){
        $('#addvisitor').show();
        $("#searchvisitor").hide();
        $('#search-visitor').val('');
        $('#search-visitor').placeholder = 'Search Visitor Profiles by name, email or drivers licence';
    }

    function switchIdentification() {
         if ($('#Visitor_alternative_identification').is(':checked')) {
            $('.primary-identification-require').hide();
            $('.alternate-identification-require').show();
            $('.row_document_name_number').show('slow');

        } else {
            $('.primary-identification-require').show();
            $('.alternate-identification-require').hide();
            $('.row_document_name_number').hide();
        }
    }

    $(document).ready(function() {

        $('.year').on('change', function () {
            var dt = new Date();

            if(dt.getFullYear()< $(".year").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $(".year").val() &&(dt.getMonth()+1)< $(".month").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $(".year").val() &&(dt.getMonth()+1) == $(".month").val() && dt.getDate() <= $(".day").val() ) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else{//u18_identification
                if (dt.getFullYear() - $(".year").val() < 18) {
                    $('#u18_identification').show();
                    $('.primary-identification-require').hide();
                } else {
                    $('#u18_identification').hide();
                    $('.primary-identification-require').show();
                }
                $("#Visitor_date_of_birth_em_").hide();
            }
        });
    


        if($('#Visitor_contact_country').length){
            $('#Visitor_contact_country').change(function(){
                if($(this).val() != <?php echo Visitor::AUSTRALIA_ID ?>){
                    $("#cstate").html('<input size="15" style="width: 126px;" maxlength="50" placeholder="State" name="Visitor[contact_state]" id="Visitor_contact_state" type="text">');
                }else{
                    $("#cstate").html('<select id="#Visitor_contact_state" name="Visitor[contact_state]" style="width: 140px;">'+$('#state_copy').html()+'</select>');
                }
            });
        }
        // for VIC visitor profile
        $("#Visitor_alternative_identification").on('change', switchIdentification);
        switchIdentification();

		$( ".visitor-title" ).click(function() {
            $('#addvisitor').show();
            $("#searchvisitor").hide();
            $("#search-visitor").val(''); 
        });
		
        if($('#photoCropPreview').imgAreaSelect) {
            $('#photoCropPreview').imgAreaSelect({
                handles: true,
                onSelectEnd: function (img, selection) {
                    $("#cropPhotoBtn").show();
                    $("#x1").val(selection.x1);
                    $("#x2").val(selection.x2);
                    $("#y1").val(selection.y1);
                    $("#y2").val(selection.y2);
                    $("#width").val(selection.width);
                    $("#height").val(selection.height);
                }
            });
        }

        $("#cropPhotoBtn").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>',
                data: {
                    x1: $("#x1").val(),
                    x2: $("#x2").val(),
                    y1: $("#y1").val(),
                    y2: $("#y2").val(),
                    width: $("#width").val(),
                    height: $("#height").val(),
                    //imageUrl: $('#photoCropPreview').attr('src').substring(1, $('#photoCropPreview').attr('src').length),
                    photoId: $('#Visitor_photo').val()
                },
                dataType: 'json',
                success: function(r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function(r) {

                            $.each(r.data, function(index, value) {

                                /*document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop").css("background", "url(<?php echo Yii::app()->request->baseUrl; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop").css({
                                    "background-size": "132px 152px"
                                });*/

                                //showing image from DB as saved in DB -- image is not present in folder
                                var my_db_image = "url(data:image;base64,"+ value.db_image + ")";

                                document.getElementById('photoPreview').src = "data:image;base64,"+ value.db_image;
                                document.getElementById('photoCropPreview').src = "data:image;base64,"+ value.db_image;
                                $(".ajax-upload-dragdrop").css("background", my_db_image + " no-repeat center top");
                                $(".ajax-upload-dragdrop").css({"background-size": "132px 152px" });
                            


                            });
                        }
                    });

                    $("#closeCropPhoto").click();
                    var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

        $("#closeCropPhoto").click(function() {
            var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
            ias.cancelSelection();
        });

        $("#dummy-visitor-findBtn").click(function(e) {
            e.preventDefault();
            $("#Visit_reason_search").val("");
            $("#register-reason-form-search").hide();
            $("#register-reason-form").hide();

            var searchText = $("#search-visitor").val();

            if (searchText != '') {
				
                
                $("#visitor-findBtn").click();
                $("#visitor_fields_for_Search").show();
                //if tenant only search tenant 
                if ($("#currentRoleOfLoggedInUser").val() != 5 && $("#search_visitor_tenant_agent").val() == '') {
                    $('#workstation_search option[value!=""]').remove();
 
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + $("#search_visitor_tenant").val(),
                        dataType: 'json',
                        data: $("#search_visitor_tenant").val(),
                        success: function(r) {
                            $('#workstation_search option[value!=""]').remove();

                            $.each(r.data, function(index, value) {
                                $('#workstation_search').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });

                        }
                    });
                } else if ($("#currentRoleOfLoggedInUser").val() != 5 && $("#search_visitor_tenant_agent").val() != '') {

					$("#searchTextErrorMessage").hide();
                    populateAgentAdminWorkstations('search');
                }
            }
            else {
				
                $("#searchTextErrorMessage").show();
                $("#searchTextErrorMessage").html("Please enter a name");
            }
        });

    });
	

    function findVisitorRecord() { 
		
        $("#visitor_fields_for_Search").show();
        $("#selectedVisitorInSearchTable").val("");
        $("#searchVisitorTableDiv h4").html("Search Results for : " + $("#search-visitor").val());
        $("#searchVisitorTableDiv").show();
        $("#searchVisitorTable").show();
		
		$('#addvisitor').hide();
		$("#searchvisitor").show();
        //  $("#register-form").hide();
        // append searched text in modal
        var searchText = $("#search-visitor").val();
        Loading.show();
        $("#searchVisitorTable").hide();
        //change modal url to pass user searched text
        var url = 'index.php?r=visitor/findVisitor&id=' + searchText + '&tenant=' + $("#search_visitor_tenant").val() + '&tenant_agent=' + $("#search_visitor_tenant_agent").val() + '&cardType=' + $('#selectCardDiv input[name=selectCardType]:checked').val();
        $.ajax(url).done(function(data){
            Loading.hide();
            $("#searchVisitorTable").show();
            $("#searchVisitorTable").html(data);
        }).fail(function() {
            Loading.hide();
            alert("Something went wrong. Please, try again.");
            /*window.location = '<?php echo Yii::app()->createUrl('site/login');?>';*/
        }); 
        //$("#searchVisitorTable").html('<iframe id="findVisitorTableIframe" onLoad="autoResize();" width="100%" height="100%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
        return false;
    }

    function populateVisitWorkstation(value) {

        $("#Visit_workstation").val(value.value);
    }

    function autoResize() {
        var newheight;

        if (document.getElementById) {
            newheight = document.getElementById('findVisitorTableIframe').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('findVisitorTableIframe').height = (newheight - 60) + "px";
    }

    function addReasonInDropdown() {
        
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitReason/GetAllReason'); ?>',
            dataType: 'json',
            success: function(r) {
                $('#Visit_reason option[value!="Other"]').remove();
                $('#Visit_reason_search option[value!="Other"]').remove();
                var textToFind;
                if ($("#Visit_reason_search").val() == 'Other' && ($("#selectedVisitorInSearchTable").val() != 0 && $("#selectedVisitorInSearchTable").val() != '')) {

                    textToFind = $("#VisitReason_reason_search").val();
                } else
                {
                    textToFind = $("#VisitReason_reason").val();
                }
                textToFind = textToFind.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
                    return letter.toUpperCase();
                });

                $.each(r.data, function(index, value, f) {
                    $('#Visit_reason').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $('#Visit_reason_search').append('<option value="' + value.id + '">' + value.name + '</option>');


                    var a = r.data;
                    if (index == a.length - 1)
                    {
                        var dd = document.getElementById('Visit_reason');
                        for (var i = 0; i < dd.options.length; i++) {
                            if (dd.options[i].text === textToFind) {
                                dd.selectedIndex = i;
                                break;
                            }
                        }
                    }

                });

                $("#Visit_reason_search").val($("#Visit_reason").val());
                $("#register-reason-form").hide();
                $("#Visit_reason").show();

                /*if visitor is not from search pass formvisitor
                 * else if visitor is from search donot pass visitor 
                 * ---if not from search determine right away if host is from search or not 
                 * if from search set patient adn host visit field to hostid
                 * else if not from search pass patient form if patient, host form if corporate
                 * */
                $("#visitReasonFormField").val($("#Visit_reason_search").val());
                if ($("#selectedVisitorInSearchTable").val() == '0' || $("#selectedVisitorInSearchTable").val() == '') { //if visitor is not from search
                    sendVisitorForm();
                } else if ($("#selectedVisitorInSearchTable").val() != '0' && $("#selectedVisitorInSearchTable").val() != '') { //if visitor is from search
                    if ($("#selectedHostInSearchTable").val() != 0) { //if host is from search
                        $("#visitReasonFormField").val($("#Visit_reason_search").val());
                        $("#Visit_patient").val($("#hostId").val());
                        $("#Visit_host").val($("#hostId").val());
                        populateVisitFormFields();
                    } else {
                        if ($("#Visitor_visitor_type").val() == 1) { //if patient
                            sendPatientForm();
                        } else {
                            /*alert("sendHostForm from addReasonInDropdown in findAddVisitorRecord");*/
                            sendHostForm();
                        }
                    }
                }
            }
        });
    }


    function ifSelectedIsOtherShowAddReasonDiv(reason) {
        if (reason.value == 'Other') {
            $("#register-reason-form").show();

        } else {
            $("#register-reason-form").hide();
        }

        $("#Visit_reason").val(reason.value);
        $("#Visit_reason_search").val(reason.value);
    }

    function ifSelectedIsOtherShowAddReasonDivSearch(reason) {
        $("#VisitReason_reason_search").val("");
        if (reason.value == 'Other') {
            $("#register-reason-form-search").show();

        } else {
            $("#register-reason-form-search").hide();
        }

        //$("#Visit_reason").val(reason.value);
        $("#Visit_reason_search").val(reason.value);
    }

    function sendVisitorForm() 
    {
        var form = $("#register-form").serialize();
        $.ajax({
            type: "POST",
            url: '<?php echo CHtml::normalizeUrl(array("visitor/create&view=1")); ?>',
            data: form,
            success: function(data) 
            {
				//alert(data);
				if ($("#selectedHostInSearchTable").val() != 0) 
                { //if host is from search
                    $("#visitReasonFormField").val($("#Visit_reason").val());
                    $("#Visit_patient").val($("#hostId").val());
                    $("#Visit_host").val($("#hostId").val());

                    // if visitor is not from search;
                    if ($("#selectedVisitorInSearchTable").val() == 0) 
                    {
                        getLastVisitorId(function(data) {
                            populateVisitFormFields(); // Do what you want with the data returned
                        });
                    }
                }  else {
                    getLastVisitorId(function(data) {
                        if ($("#Visitor_visitor_type").val() == 1) { //if patient
                            sendPatientForm();
                        } else {
                           // alert("sendHostForm from sendVisitorForm in findAddVisitorRecord");
                            //sendHostForm();
							
             }
                    });

                }
            },
            error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }

    function sendReasonForm() {
        var reasonForm;
        if ($("#Visit_reason").val() == 'Other' || $("#Visit_reason_search").val() == 'Other')
        {
            if ($("#selectedVisitorInSearchTable").val() != '0' && $("#selectedVisitorInSearchTable").val() != '') {
                reasonForm = $("#register-reason-form-search").serialize();
            } else {
                reasonForm = $("#register-reason-form").serialize();
            }

            reason_url = "<?php echo CHtml::normalizeUrl(array("visitReason/create&register=1")); ?>";

            if($("#VisitCardType").val() < CONTRACTOR_TYPE) {
                reason_url += "&vms=cvms";
            }

            $.ajax({
                type: "POST",
                url: reason_url,
                data: reasonForm,
                success: function(data) {
                    addReasonInDropdown();
                }
            });
        }
        else {
            /*alert("sendVisitorForm from sendReasonForm in findAddVisitorRecord");
            sendVisitorForm();*/
            sendHostForm();
        }
    }

    function addCompany() {
        var url;
        if ($("#Visitor_tenant").val() == '') {
            $("#Visitor_company_em_").html("Please complete tenant");
            $("#Visitor_company_em_").show();
        } else {
            /*if ($("#currentRoleOfLoggedInUser").val() == '<?php echo Roles::ROLE_SUPERADMIN; ?>') {
                *//* if role is superadmin tenant is required. Pass selected tenant and tenant agent of user to company. *//*
                url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1&tenant='); ?>' + $("#Visitor_tenant").val() + '&tenant_agent=' + $("#Visitor_tenant_agent").val();
            } else {
                url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1'); ?>';
            }

            $("#modalBody").html('<iframe id="companyModalIframe" width="100%" height="80%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
            $("#modalBtn").click();*/
            //$('#addCompanyModal').show();
        }
    }

    function dismissModal(id) {
        $("#dismissModal").click();
        $('#Visitor_company option[value!=""]').remove();
        if ($("#Visitor_tenant_agent").val() == "") {
            // populateCompanyofTenant($("#Visitor_tenant").val(), id);
            getCompanyWithSameTenant($("#Visitor_tenant").val(), id)
        } else {
            getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val(), id);
        }

    }

    function populateAgentAdminWorkstations(isSearch) 
    {
        isSearch = (typeof isSearch === "undefined") ? "defaultValue" : isSearch;
        var tenant;
        var tenant_agent;
        if (isSearch == 'search') {
            //    $("#searchVisitorTableDiv").show();
            $("#selectedVisitorInSearchTable").val("");
            tenant = $("#search_visitor_tenant").val();
            tenant_agent = $("#search_visitor_tenant_agent").val();

            $('#workstation_search option[value!=""]').remove();
        } else {
            tenant = $("#Visitor_tenant").val();
            tenant_agent = $("#Visitor_tenant_agent").val();
            $('#workstation option[value!=""]').remove();
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getTenantAgentWorkstation&id='); ?>' + tenant_agent + '&tenant=' + tenant,
            dataType: 'json',
            data: tenant_agent,
            success: function(r) {

                $.each(r.data, function(index, value) {
                    if (isSearch == 'search') {
                        $('#workstation_search').append('<option value="' + value.id + '">' + value.name + '</option>');
                    } else {
                        var selected = <?php echo isset($session['workstation']) ? $session['workstation'] : '0' ?>;
                        var workstation = $('#userWorkstation').val();
                        if (selected != 0) {
                            var selectedWorkstation = selected;
                        } else {
                            var selectedWorkstation = workstation;
                        }
                        if (value.id == selectedWorkstation) {
                            $('#workstation').append('<option selected="selected" value="' + value.id + '">' + value.name + '</option>');
                        } else {
                            $('#workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                        }

                    }
                });
            }
        });
    }

// company change
$('#Visitor_company').on('change', function() {
    var companyId = $(this).val();
    $('#CompanySelectedId').val(companyId);
    $modal = $('#addCompanyContactModal');
    $.ajax({
        type: "POST",
        url: "<?php echo $this->createUrl('company/getContacts') ?>",
        dataType: "json",
        data: {id:companyId},
        success: function(data) {
            var companyName = $('.select2-selection__rendered').text();
            $('#AddCompanyContactForm_companyName').val(companyName).prop('disabled', 'disabled');
            if (data == 0) {
                $('#addContactLink').hide();
            } else {
                $('#visitorStaffRow').html(data);
                $('#addContactLink').show();
            }
            return false;
        }
    });
});
</script>

<input type="text" id="visitorId" placeholder="visitor id"/>

<!-- PHOTO CROP-->
<div id="light" class="white_content">
    <br>
    <img id="photoCropPreview" src="">

</div>
<div id="crop_button">
    <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
    <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none';
                document.getElementById('crop_button').style.display = 'none'" value="x" class="btn btn-danger">
</div>
<div id="fade" class="black_overlay"></div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>
