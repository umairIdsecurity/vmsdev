<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-birthday.js');

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
</style>

<br>
<div role="tabpanel" style="width:882px">

   
    <!-- Nav tabs -->
    <div style="float:left;width:270px;text-align:center">
    <div class="visitor-title" style="cursor:pointer;color:#2f96b4">Add Visitor Profile</div>
    </div>
    <input type="text" id="search-visitor" name="search-visitor" placeholder="Enter name, email"
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
            <div id="findAddVisitorRecordDiv" class="findAddVisitorRecordDiv form">

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

                                if (!hasError){
                                    var vehicleValue = $("#Visitor_vehicle").val();
                                    if(vehicleValue.length < 6 && vehicleValue != ""){
                                        $("#Visitor_vehicle_em_").show();
                                        $("#Visitor_vehicle_em_").html("Vehicle should have a min. of 6 characters");
                                    }else if ($("#workstation").val() == ""){
                                        $(".errorMessageWorkstation").show();
                                        $(".visitorReason").hide();
                                    }
                                    else if ($("#Visit_reason").val() == "" || ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() == "")) {
                                        $(".visitorReason").show();
                                        $(".errorMessageWorkstation").hide();
                                    } else if ($("#Visit_reason").val() == "Other" &&  $("#VisitReason_reason").val() != "") {
                                        checkReasonIfUnique();
                                        $(".errorMessageWorkstation").hide();
                                    } else if(  $("#Visitor_photo").val() == "" &&
                                                $("#cardtype").val() != 1 &&
                                                $("#cardtype").val() != ' . CardType::MANUAL_VISITOR . ' &&
                                                $("#cardtype").val() != ' . CardType::VIC_CARD_SAMEDATE . '
                                            ){
                                        $("#photoErrorMessage").show();
                                    }

                                    else {
                                        $(".errorMessageWorkstation").hide();
                                        $(".visitorReason").hide();
                                        $("#photoErrorMessage").hide();
                                        checkEmailIfUnique();
                                    }
                                }
							}'
                        ),
                    ));
                    ?>
                    <?php echo $form->errorSummary($model); ?>
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
                                    <?php echo $form->dropDownList($model, 'visitor_card_status', Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_VIC], array('empty' => 'Card Status', 'options'=>array('2'=>array('selected'=>true)))); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'visitor_card_status'); ?>
                                </td>
                            </tr>

                        </table>

                        <table id="addvisitor-table" class="second-column" data-ng-app="PwordForm" style="width:262px;float:left;">

                            <tr>
                                <td>
                                    <?php echo $form->textField($model, 'first_name',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->textField($model, 'middle_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Middle Name')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'middle_name'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $form->textField($model, 'last_name',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                                </td>
                            </tr>

                            <tr class="vic-visitor-fields">
                                <td class="birthdayDropdown">
                                    <span>Date of Birth</span> <br/>
                                    <input type="hidden" id="dateofBirthBreakdownValueYear"
                                           value="<?php echo date("Y", strtotime($model->date_of_birth)); ?>">
                                    <input type="hidden" id="dateofBirthBreakdownValueMonth"
                                           value="<?php echo date("n", strtotime($model->date_of_birth)); ?>">
                                    <input type="hidden" id="dateofBirthBreakdownValueDay"
                                           value="<?php echo date("j", strtotime($model->date_of_birth)); ?>">

                                    <select id="fromDay" name="Visitor[birthdayDay]" class='daySelect'></select>
                                    <select id="fromMonth" name="Visitor[birthdayMonth]" class='monthSelect'></select>
                                    <select id="fromYear" name="Visitor[birthdayYear]" class='yearSelect'></select>
                                </td>
                            </tr>

                            <tr>
                                <td width="37%">
                                    <?php echo $form->textField($model, 'email',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Email Address')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'email',
                                            array('style' => 'text-transform:none;')); ?>
                                    <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail">A
                                        profile already exists for this email address.
                                    </div>
                                </td>
                            </tr>

                            <tr class="hidden">
                                <td>
                                    <input placeholder="Password" ng-model="user.passwords" data-ng-class="{
                                                'ng-invalid':registerform['Visitor[repeatpassword]'].$error.match}"
                                           type="password" id="Visitor_password" name="Visitor[password]"
                                           value="(NULL)">
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'password'); ?>
                                </td>
                            </tr>
                            <tr class="hidden">
                                <td>
                                    <input placeholder="Repeat Password" ng-model="user.passwordConfirm" type="password"
                                           id="Visitor_repeatpassword" data-match="user.passwords"
                                           name="Visitor[repeatpassword]" value="(NULL)"/>
                                    <span class="required">*</span>

                                    <div style='font-size:0.9em;color:red;'
                                         data-ng-show="registerform['Visitor[repeatpassword]'].$error.match">New
                                        Password does not match with Repeat <br> New Password.
                                    </div>
                                    <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
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
                                    <?php echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State', 'style' => 'width: 140px;')); ?>
                                    <?php echo $form->textField($model, 'contact_postcode', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Postcode', 'style' => 'width: 62px;')); ?>
                                    <span class="required">*</span>
                                    <?php echo $form->error($model, 'contact_state'); ?>
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
                                <td id="visitorCompanyRow">
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
                                        <?php echo $form->error($model, 'company'); ?>
                                        <span class="required">*</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none;">Add Company</a>
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
                                        <option value='' selected>Please select a tenant</option>
                                        <?php
                                        $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                                        foreach ($allTenantCompanyNames as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['tenant']; ?>"
                                                <?php
                                                if ($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['tenant']) {
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
                                            echo '<option value="">Select Workstation</option>';
                                        }
                                        ?>

                                        <?php
                                        $workstationList = Utils::populateWorkstation();

                                        foreach ($workstationList as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id; ?>" <?php echo $value->id == $session['workstation'] ? 'selected="selected"' : ''; ?>>
                                                <?php echo $value->name; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="required">*</span>

                                    <div style="display:none;" class="errorMessage errorMessageWorkstation">Select Workstation</div>

                                </td>
                            </tr>
                            <tr class="visitorTypeDropdownRow">
                                <td>

                                    <?php
                                    echo $form->dropDownList($model, 'visitor_type',
                                        VisitorType::model()->returnVisitorTypes(), array(
                                            'onchange' => 'showHideHostPatientName(this)',
                                            //'prompt' => 'Select Visitor Type',
                                        ));
                                    ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($model, 'visitor_type'); ?>
                                </td>
                            </tr>

                            <tr class="visitReasonRow">
                                <td>
                                    <select id="Visit_reason" name="Visitor[reason]"
                                            onchange="ifSelectedIsOtherShowAddReasonDiv(this)">
                                        <option value='' selected>Select Reason</option>
                                        <option value="Other">Other</option>
                                        <?php
                                        $reason = VisitReason::model()->findAllReason();
                                        foreach ($reason as $key => $value) {
                                            ?>
                                            <option
                                                value="<?php echo $value->id; ?>"><?php echo $value->reason; ?></option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                    <span class="required">*</span>

                                    <div class="errorMessage visitorReason">Select Reason</div>
                                </td>
                            </tr>

                            <tr class="visitReasonOtherRow">
                                <td>
                                    <div id="register-reason-form" style="margin-top: 0px; width: 100% !important;">
                                    <table style="/*position:relative;top:555px;left:-301px*/">
                                        <tr>
                                            <td>
                                                <textarea id="VisitReason_reason" name="VisitReason[reason]" rows="1" maxlength="128"
                                                    style="text-transform: capitalize;" placeholder="Add Reason"></textarea>
                                                <div class="errorMessage" id="visitReasonErrorMessage" style="display:none;">Select Reason</div>
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
                                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Identification Type'));?>
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
                                    <?php echo $form->textField($model, 'identification_document_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Document No.', 'style' => 'width: 110px;')); ?>

                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_document_expiry',
                                        'options'     => array(
                                            'dateFormat' => 'dd-mm-yy',
                                            'changeMonth' => 'true',
                                            'changeYear' => 'true',
                                            'minDate' => '0'
                                        ),
                                        'htmlOptions' => array(
                                            'size'        => '0',
                                            'maxlength'   => '10',
                                            'placeholder' => 'Expiry',
                                            'style'       => 'width: 80px;',
                                        ),
                                    ));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_document_no'); ?>
                                    <?php echo $form->error($model, 'identification_document_expiry'); ?>
                                </td>
                            </tr>
                            <tr class="vic-visitor-fields">
                                <td>
                                    <?php echo $form->checkBox($model, 'alternative_identification', array('style' => 'float: left;')); ?>
                                    <label for="Visitor_alternative_identification" id="alternative_identification_label" class="form-label">
                                        Applicant does not have one of the above identifications
                                    </label>
                                </td>
                            </tr>
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
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_alternate_document_expiry1',
                                        'options'     => array(
                                            'dateFormat' => 'dd-mm-yy',
                                            'changeMonth' => 'true',
                                            'changeYear' => 'true',
                                            'minDate' => '0'
                                        ),
                                        'htmlOptions' => array(
                                            'size'        => '0',
                                            'maxlength'   => '10',
                                            'placeholder' => 'Expiry',
                                            'style'       => 'width: 80px;',
                                        ),
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
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_alternate_document_expiry2',
                                        'options'     => array(
                                            'dateFormat' => 'dd-mm-yy',
                                            'changeMonth' => 'true',
                                            'changeYear' => 'true',
                                            'minDate' => '0'
                                        ),
                                        'htmlOptions' => array(
                                            'size'        => '0',
                                            'maxlength'   => '10',
                                            'placeholder' => 'Expiry',
                                            'style'       => 'width: 80px;',
                                        ),
                                    ));
                                    ?><span class="required alternate-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_alternate_document_no2'); ?>
                                    <?php echo $form->error($model, 'identification_alternate_document_expiry2'); ?>

                                    <?php echo $form->checkBox($model, 'verifiable_signature', array('style' => 'float: left;')); ?>
                                    <label  class="form-label">One of these has a verifiable signature</label>
                                </td>
                            </tr>

                            <tr class="vic-visitor-fields">
                                <td id="passwordVicForm">
                                    <?php $this->renderPartial('/common_partials/password', array('model' => $model, 'form' => $form, 'session' => $session)); ?>
                                </td>
                            </tr>
                            <!-- end VIC info -->

                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="register-a-visitor-buttons-div"
                                         style="padding-top:180px;padding-right:60px; text-align: right;">
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

        <div role="tabpanel" class="tab-pane" id="searchvisitor">
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
                                    <option value="<?php echo $value['tenant']; ?>"
                                        <?php
                                        if ($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['tenant']) {
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
                <h4>Search Results for : <span id='search'></span></h4>

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

                <div class="errorMessage" id="visitReasonErrorMessageSearch" style="display:none;">Select Reason</div>

                <?php $this->endWidget(); ?>

                <div id="searchVisitorTable"></div>

            </div>
            <div class="register-a-visitor-buttons-div" style="padding-right:23px;text-align: right;">
                <input type="button" class="neutral visitor-backBtn btnBackTab2" id="btnBackTab2" value="Back" onclick="window.location=location.href;return false;"/>
                <input type="button" id="clicktabB1" value="Save and Continue" class="actionForward"/>
            </div>
            <input type="text" id="selectedVisitorInSearchTable" value="0"/>
        </div>
    </div>

</div>


<script>
    function switchIdentification() {
        if ($('#Visitor_alternative_identification').attr('checked')) {
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
        // for VIC visitor profile
        $("#Visitor_alternative_identification").on('change', switchIdentification);
        switchIdentification();

		$( ".visitor-title" ).click(function() {
            $('#addvisitor').show();
            $("#searchvisitor").hide();
        });
		
        $("#Visitor_password").val("(NULL)");
        $("#Visitor_repeatpassword").val("(NULL)");
        $('#photoCropPreview').imgAreaSelect({
            handles: true,
            onSelectEnd: function(img, selection) {
                $("#cropPhotoBtn").show();
                $("#x1").val(selection.x1);
                $("#x2").val(selection.x2);
                $("#y1").val(selection.y1);
                $("#y2").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });

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
                    imageUrl: $('#photoCropPreview').attr('src').substring(1, $('#photoCropPreview').attr('src').length),
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
                                document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop").css("background", "url(<?php echo Yii::app()->request->baseUrl; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop").css({
                                    "background-size": "137px 190px"
                                });
                            });
                        }
                    });

                    $("#closeCropPhoto").click();
                    var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

        $("#dummy-visitor-findBtn").click(function(e) {
            e.preventDefault();
            $("#Visit_reason_search").val("");
            $("#register-reason-form-search").hide();
            $("#register-reason-form").hide();

            var searchText = $("#search-visitor").val();
           /* if ($("#search_visitor_tenant").val() == '') {
                $("#searchTextErrorMessage").show();
                $("#searchTextErrorMessage").html("Please select a tenant");
            } else */if (searchText != '') {
				
                
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
		
//change modal url to pass user searched text
        var url = 'index.php?r=visitor/findvisitor&id=' + searchText + '&tenant=' + $("#search_visitor_tenant").val() + '&tenant_agent=' + $("#search_visitor_tenant_agent").val() + '&cardType=' + $('#selectCardDiv input[name=selectCardType]:checked').val();
        $.ajax(url).done(function(data){
          $("#searchVisitorTable").html(data);
        }).fail(function() {
           window.location = '<?php echo Yii::app()->createUrl('site/login');?>';
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

    function sendVisitorForm() {
        var form = $("#register-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visitor/create&view=1")); ?>",
            data: form,
            success: function(data) {

                if ($("#selectedHostInSearchTable").val() != 0) { //if host is from search

                    $("#visitReasonFormField").val($("#Visit_reason").val());
                    $("#Visit_patient").val($("#hostId").val());
                    $("#Visit_host").val($("#hostId").val());


                    // if visitor is not from search;
                    if ($("#selectedVisitorInSearchTable").val() == 0) {
                        getLastVisitorId(function(data) {
                            populateVisitFormFields(); // Do what you want with the data returned
                        });
                    }
                } else {

                    getLastVisitorId(function(data) {
                        if ($("#Visitor_visitor_type").val() == 1) { //if patient
                            sendPatientForm();
                        } else {
                            sendHostForm();
                        }
                    });

                }
            },
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

            $.ajax({
                type: "POST",
                url: "<?php echo CHtml::normalizeUrl(array("visitReason/create&register=1")); ?>",
                data: reasonForm,
                success: function(data) {
                    addReasonInDropdown();
                },
            });
        }
        else {
            sendVisitorForm();
        }
    }

    function addCompany() {
        var url;
        if ($("#Visitor_tenant").val() == '') {
            $("#Visitor_company_em_").html("Please select a tenant");
            $("#Visitor_company_em_").show();
        } else {
            if ($("#currentRoleOfLoggedInUser").val() == '<?php echo Roles::ROLE_SUPERADMIN; ?>') {
                /* if role is superadmin tenant is required. Pass selected tenant and tenant agent of user to company. */
                url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1&tenant='); ?>' + $("#Visitor_tenant").val() + '&tenant_agent=' + $("#Visitor_tenant_agent").val();
            } else {
                url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1'); ?>';
            }

            $("#modalBody").html('<iframe id="companyModalIframe" width="100%" height="80%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
            $("#modalBtn").click();
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

    function populateAgentAdminWorkstations(isSearch) {
        
       
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
                        var selectedWorkstation = <?php echo $session['workstation']?>;
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
</script>

<input type="text" id="visitorId" placeholder="visitor id"/>
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
<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody"></div>

</div>


<!-- PHOTO CROP-->
<div id="light" class="white_content">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
        <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
    <br>
    <img id="photoCropPreview" src="">

</div>
<div id="fade" class="black_overlay"></div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>
