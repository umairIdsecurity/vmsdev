<?php
$session = new CHttpSession;
$company = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}

// Visitor ASIC model
$asicModel = new Visitor();

// get first key of asic card type:
$asicCardTypes = Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_ASIC];
reset($asicCardTypes);
$defaultKey = key($asicCardTypes);

//$asicModel->visitor_card_status = $defaultKey;
?>

<div role="tabpanel">

    <!-- Nav tabs -->
    <div style="float:left;width:280px">
        <div class="visitor-title-host" style="cursor:pointer;color:#2f96b4;font-size: 18px;font-weight: bold;margin: 5px 0;padding-left: 85px;">
            Add ASIC Sponsor
        </div>
    </div>


    <div role="tabpanel" class="tab-pane" id="searchost" style="width:882px">
        <div id="searchHostDiv">
            <div>
                <!-- <label><b>Search Name:</b></label> -->
                <input type="text" id="search-host" style="width:370px" name="search-host"
                       placeholder="Enter name, email address" class="search-text"/>
                <button class="host-findBtn" onclick="findHostRecord()" id="host-findBtn" style="display:none;"
                        data-target="#findHostRecordModal" data-toggle="modal">Search Visits
                </button>

                <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                <button class="host-findBtn" id="dummy-host-findBtn" style="<?php echo $background; ?>padding: 8px;">
                    Find ASIC Sponsor
                </button>
                <!-- <button class="host-AddBtn" <?php
                if ($session['role'] != Roles::ROLE_STAFFMEMBER) {
                    echo " style='display:none;' ";
                }
                ?>>Add Host</button>-->

                <div class="errorMessage" id="searchTextHostErrorMessage" style="display:none;"></div>
            </div>

            <div id="searchHostTableDiv" class="data-ifr">
                <h4>Search Results for : <span id='searchhostname'></span></h4>

                <div id="searchHostTable"></div>

            </div>
            <input type="text" id="selectedHostInSearchTable" value="0"/>
        </div>
        <div class="register-a-visitor-buttons-div" id="subm" style="padding-right:20px;text-align: right;">
            <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
            <input type="button" id="clicktabB2" value="Save and Continue" class="actionForward"/>
        </div>
    </div>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="addhost">

            <div id="findAddHostRecordDiv" class="findAddHostRecordDiv">

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
                                var currentURL = $("#getcurrentUrl").val();
                                if(currentURL != "" ){
                                    showHideTabs("logVisitB", "logVisitA", "logVisit", "findHostA", "findHost", "findVisitorA", "findVisitor");
                                } else {
                                    sendReasonForm();
                                }
                            }
                        }'
                    ),
                ));
                ?>

                <br>
                <?php echo $form->labelEx($patientModel, 'name'); ?> &nbsp;
                <?php echo $form->textField($patientModel, 'name', array('size' => 50, 'maxlength' => 100)); ?>
                <?php echo "<br>" . $form->error($patientModel, 'name'); ?>
                <div style="" id="Patient_name_error" class="errorMessage Patient_name_error">Patient Name has already
                    been taken.
                </div>

                <input type="text" id="patientIsUnique" value="0"/><br>

                <div class="register-a-visitor-buttons-div" style="text-align: right;">
                    <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                    <input type="submit" value="Save and Continue" name="yt0" id="submitFormPatientName"
                           style="display:inline-block;" class="actionForward"/>

                </div>
                <?php $this->endWidget(); ?>

                <div data-ng-app="PwordForm">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'register-host-form',
                        'action' => Yii::app()->createUrl('/user/create&view=1'),
                        'htmlOptions' => array("name" => "registerhostform"),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'afterValidate' => 'js:function(form,data,hasError){
                                var card_status = $(".vic-host-fields #Visitor_visitor_card_status").val();
                                if (!card_status || card_status == "") {
                                    $(".vic-host-fields #Visitor_visitor_card_status_em_").show();
                                    $(".vic-host-fields #Visitor_visitor_card_status_em_").html("Please enter a visitor card status");
                                    return false;
                                }
                                if(!hasError){
                                    document.getElementById("User_company").disabled = false;
                                    document.getElementById("User_tenant").disabled = false;
                                    document.getElementById("User_tenant_agent").disabled = false;
                                    checkHostEmailIfUnique();
                                }
                            }'
                        ),
                    ));
                    ?>
                    <?php /*echo $form->errorSummary($userModel); */?>
                    <input type="text" id="hostEmailIsUnique" value="0"/>

                    <div>

                        <table style="width:300px;float:left;" class="host-first-column">
                            <tr>

                                <td style="width:300px;">
                                    <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->

                                    <input type="hidden" id="Host_photo" name="User[photo]">

                                    <div class="photoDiv" style='display:none;'>
                                        <img id='photoPreview2'
                                             src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png"
                                             style='display:none;'/>
                                    </div>

                                    <?php require_once(Yii::app()->basePath . '/draganddrop/host.php'); ?>

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
                            <tr>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="vic-host-fields">
                                <td>
                                    <?php echo $form->dropDownList($asicModel, 'visitor_card_status', [Visitor::ASIC_ISSUED => Visitor::ASIC_ISSUED_LABEL, Visitor::ASIC_EXPIRED => Visitor::ASIC_EXPIRED_LABEL], array('empty' => 'Card Status', 'options' => array( $defaultKey => array('selected' => 'selected')))); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($asicModel, 'visitor_card_status'); ?>
                                </td>

                            </tr>
                        </table>

                        <table id="addhost-table" style="width: 280px;float: left;" class="host-second-column">
                            <input type="hidden" name="User[id]" id="User_id" value="">
                            <tr <?php echo $session['role'] != Roles::ROLE_SUPERADMIN ? "style='display:none;'" : ""; ?>>
                                <td id="hostTenantRow">
                                    <select id="User_tenant" onchange="populateHostTenantAgentAndCompanyField()"name="User[tenant]" disabled>
                                        <option value='' selected>Please select a tenant</option>
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
                                    </select><?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                                </td>
                            </tr>
                            <tr <?php echo $session['role'] != Roles::ROLE_SUPERADMIN ? "style='display:none;'" : ""; ?>>
                                <td id="hostTenantAgentRow">
                                    <select id="User_tenant_agent" name="User[tenant_agent]"
                                            onchange="populateHostCompanyWithSameTenantAndTenantAgent()" disabled>
                                        <?php
                                        echo "<option value='' selected>Please select a tenant agent</option>";
                                        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                            echo "<option value='" . $session['tenant_agent'] . "' selected>Tenant Agent</option>";
                                        }
                                        ?>
                                    </select><?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <?php echo $form->textField($userModel, 'first_name',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name')); ?> <span
                                        class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'first_name'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $form->textField($userModel, 'last_name',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name')); ?><span
                                        class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'last_name'); ?>
                                </td>
                            </tr>
                            <tr class="vms-visitor-fields">
                                <td>
                                    <?php echo $form->textField($userModel, 'department',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Department')); ?>
                                    <?php echo "<br>" . $form->error($userModel, 'deprtment'); ?>
                                </td>
                            </tr>

                            <tr class="vms-visitor-fields">
                                <td>
                                    <?php echo $form->textField($userModel, 'staff_id',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Staff ID')); ?>
                                    <?php echo "<br>" . $form->error($userModel, 'staff_id'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="35%">
                                    <?php echo $form->textField($userModel, 'email',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Email Address')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'email',
                                            array('style' => 'text-transform:none;')); ?>
                                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1">A profile
                                        already exists for this email address.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $form->textField($userModel, 'contact_number',
                                        array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Mobile No. ')); ?>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'contact_number'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="hidden">
                                    <label for="User_password">Password <span class="required">*</span></label><br>
                                    <input type="password" id="User_password" name="User[password]" value="(NULL)">
                                    <?php echo "<br>" . $form->error($userModel, 'password'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="hidden">
                                    <label for="User_repeatpassword">Repeat Password <span
                                            class="required">*</span></label><br>
                                    <input type="password" id="User_repeatpassword" name="User[repeatpassword]"
                                           onChange="checkPasswordMatch();" value="(NULL)"/>

                                    <div
                                        style='font-size:10px;color:red;font-size:0.9em;display:none;margin-bottom:-20px;'
                                        id="passwordErrorMessage">New Password does not match with <br>Repeat New
                                        Password.
                                    </div>
                                    <?php echo "<br>" . $form->error($userModel, 'repeatpassword'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td id="userCompanyRow">
                                    <div style="margin-bottom: 5px;">
                                        <?php
                                        $this->widget('application.extensions.select2.Select2', array(
                                            'model' => $userModel,
                                            'attribute' => 'company',
                                            'items' => CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']), 'id', 'name'),
                                            'selectedItems' => array(), // Items to be selected as default
                                            'placeHolder' => 'Please select a company'
                                        ));
                                        ?>
                                        <span class="required">*</span>
                                        <?php echo $form->error($userModel, 'company', array("style" => "margin-top:0px")); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="margin-bottom: 5px;" id="userStaffRow"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <a style="float: left; margin-right: 5px; width: 86px; height: 16px;   border: 1px solid #63B421; border-radius: 5px; background: -webkit-gradient(linear, center top, center bottom, from(#A1DC33), to(#82BD12)); font-size: 12px; padding: 3px 15px 5px; color: #fff;   font-weight: bold;" href="#addCompanyContactModal" role="button" data-toggle="modal" id="addUserCompanyLink">Add Company</a>
                                    <a href="#addCompanyContactModal" style="font-size: 12px; font-weight: bold; display: none;" id="addUserContactLink" class="btn btn-xs btn-info" role="button" data-toggle="modal" data-id="asic">Add Contact</a>
                                </td>
                            </tr>
                            <tr class="vic-host-fields">
                                <td>
                                    <input name="User[role]" id="User_role" value="<?php echo Roles::ROLE_STAFFMEMBER ?>"/>
                                    <input name="User[user_type]" id="User_user_type" value="<?php echo UserType::USERTYPE_INTERNAL; ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr class="vic-host-fields">
                                <td>
                                    <label><input style="margin-top: 1px;" type="checkbox" id="requestVerifyAsicSponsor"/> Request ASIC Sponsor Verification </label>
<!--                                    <a onclick="" style="text-decoration: none;" id="requestASICVerify" class="greenBtn">Request verification ASIC Sponsor </a><br>-->
                                </td>
                            </tr>
                        </table>

                        <table class="host-third-column" style="width:280px;">

                            <!-- start ASIC info -->
                            <tr class="vic-host-fields">
                                <td>
                                    <?php echo $form->textField($userModel, 'asic_no', array(
                                        'size'        => 10,
                                        'maxlength'   => 50,
                                        'placeholder' => 'ASIC No.',
                                        'style'       => 'width: 110px;'
                                    )); ?>

                                    <?php
                                    $now = new DateTime(date('Y-m-d'));
                                    $asicMaxDate = new DateTime(date('Y-m-d', strtotime('+2 month +2 year')));
                                    $interval = $asicMaxDate->diff($now);
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $userModel,
                                        'attribute' => 'asic_expiry',
                                        'options' => array(
                                            'dateFormat'  => 'dd-mm-yy',
                                            'changeMonth' => 'true',
                                            'changeYear'  => 'true',
                                            'minDate'     => '0',
                                            'maxDate'     => $interval->days
                                        ),
                                        'htmlOptions' => array(
                                            'size'        => '0',
                                            'maxlength'   => '10',
                                            'placeholder' => 'Expiry',
                                            'style'       => 'width: 80px;',
                                        ),
                                    ));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'asic_no'); ?>
                                    <?php echo $form->error($userModel, 'asic_expiry'); ?>
                                </td>
                            </tr>

                            <tr class="vic-visitor-fields">
                                <td id="passwordVicForm">
                                    <?php $this->renderPartial('/common_partials/password', array('model' => $userModel, 'form' => $form, 'session' => $session)); ?>
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


                            <tr>
                                <td>
                                    <div id="hostButtonRow" style="padding-top: 250px; padding-right: 60px; text-align: right;">
                                        <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                                        <input type="button" id="clicktabC" value="Save and Continue" style="display:none;"/>
                                        <input type="submit" value="Save and Continue" name="yt0" id="submitFormHost" class="actionForward"/>
                                    </div>
                                </td>
                            </tr>
                            <!-- end ASIC info -->
                        </table>

                    </div>

                    <?php $this->endWidget(); ?>
                    <br>

                    <div id="currentHostDetailsDiv" <?php
                    if ($session['role'] != Roles::ROLE_STAFFMEMBER) {
                        echo "style='display:none;'";
                    }
                    ?>>
                        <?php
                        #$userStaffMemberModel = User::model()->findByPk($session['id']);
                        $userStaffMemberModel = new User();
                        // $userStaffMemberModel = User::model()->findByPk($session['id']);

                        $staffmemberform = $this->beginWidget('CActiveForm', array(
                            'id' => 'staffmember-host-form',
                            'action' => Yii::app()->createUrl('/user/create'),
                            'htmlOptions' => array("name" => "staffmember-host-form"),
                        ));
                        ?>
                        <table style="width:300px;float:left;">
                            <tr>

                                <td style="width:300px;">
                                    <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->

                                    <input type="hidden" id="Host_photo3" name="User[photo]">

                                    <div class="photoDiv3" style='display:none;'>
                                        <img id='photoPreview3'
                                             src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png"
                                             style='display:none;'/>
                                    </div>


                                    <?php require_once(Yii::app()->basePath . '/draganddrop/host3.php'); ?>

                                    <div id="photoErrorMessage" class="errorMessage"
                                         style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">
                                        Please upload a photo.
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>

                        <table id="currentHostDetails" style="width: 550px;  float: left;">
                            <tr>
                                <td>
                                    <?php
                                    echo $staffmemberform->textField($userStaffMemberModel, 'first_name', array(
                                        'size' => 50,
                                        'placeholder' => 'First Name',
                                        'maxlength' => 50,
                                        #'disabled' => 'disabled'
                                    ));
                                    ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'first_name'); ?>
                                </td>
                            <tr>
                            </tr>
                            <td>

                                <?php echo $staffmemberform->textField($userStaffMemberModel, 'last_name',
                                    array('size' => 50,'placeholder' => 'Last Name', 'maxlength' => 50/*, 'disabled' => 'disabled'*/)); ?>
                                <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'last_name'); ?>
                            </td>
                            <tr>
                            </tr>
                            <td>
                                <?php echo $staffmemberform->textField($userStaffMemberModel, 'department',
                                    array(
                                        'size' => 50,
                                        'maxlength' => 50,
                                        #'disabled' => 'disabled',
                                        'placeholder' => 'Department'
                                    )); ?>
                                <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'department'); ?>
                            </td>
                            </tr>

                            <tr>
                                <td>
                                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'staff_id',
                                        array(
                                            'size' => 50,
                                            'maxlength' => 50,
                                            #'disabled' => 'disabled',
                                            'placeholder' => 'Staff ID'
                                        )); ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'staff_id'); ?>
                                </td>
                            <tr>
                            </tr>
                            <td>

                                <?php echo $staffmemberform->textField($userStaffMemberModel, 'email',
                                    array('size' => 50,'placeholder' => 'Email Address', 'maxlength' => 50/*, 'disabled' => 'disabled'*/)); ?>
                                <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'email'); ?>
                                <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1">A profile
                                    already exists for this email address.
                                </div>
                            </td>
                            <tr>
                            </tr>
                            <td>
                                <?php echo $staffmemberform->textField($userStaffMemberModel, 'contact_number',
                                    array(
                                        'size' => 50,
                                        'maxlength' => 50,
                                        #'disabled' => 'disabled',
                                        'placeholder' => 'Contact Number '
                                    )); ?>
                                <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'contact_number'); ?>
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

                            <tr>
                                <td>
                                    <div class="register-a-visitor-buttons-div"
                                         style="padding-right:67px;text-align: right;">
                                        <input type="button" class="neutral visitor-backBtn btnBackTab3"
                                               id="btnBackTab3" value="Back"/>
                                        <input type="button" id="saveCurrentUserAsHost" value="Save and Continue"/>
                                    </div>
                                </td>
                            </tr>
                        </table>


                        <?php $this->endWidget(); ?>

                    </div>

                </div>

                <input type="text" id="hostId" placeholder="host id"/>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="searchost">

            <div class="register-a-visitor-buttons-div" style="text-align: right;">
                <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                <input type="button" id="clicktabB2" value="Save and Continue" class="actionForward"/>
            </div>
        </div>
    </div>

</div>


<!-- PHOTO CROP-->
<div id="light2" class="white_content">
    <img id="photoCropPreview2" src="">

</div>
<div id="fade2" class="black_overlay">
</div>
<div id="crop_button2">
    <input type="button" class="btn btn-success" id="cropPhotoBtn2" value="Crop" style="">
    <input type="button" id="closeCropPhoto2" onclick="document.getElementById('light2').style.display = 'none';
                document.getElementById('fade2').style.display = 'none';
                document.getElementById('crop_button2').style.display = 'none'" value="x" class="btn btn-danger">
</div>

<input type="hidden" id="x12"/>
<input type="hidden" id="x22"/>
<input type="hidden" id="y12"/>
<input type="hidden" id="y22"/>
<input type="hidden" id="width2"/>
<input type="hidden" id="height2"/>


<!-- PHOTO CROP-->
<div id="light3" class="white_content">
    <br>
    <img id="photoCropPreview3" src="">

</div>
<div id="fade3" class="black_overlay"></div>
<div id="crop_button3">
    <input type="button" class="btn btn-success" id="cropPhotoBtn3" value="Crop" style="">
    <input type="button" id="closeCropPhoto3" onclick="document.getElementById('light3').style.display = 'none';
                document.getElementById('fade3').style.display = 'none';
                document.getElementById('crop_button3').style.display = 'none'" value="x" class="btn btn-danger">
</div>

<input type="hidden" id="x13"/>
<input type="hidden" id="x23"/>
<input type="hidden" id="y13"/>
<input type="hidden" id="y23"/>
<input type="hidden" id="width3"/>
<input type="hidden" id="height3"/>


<script>
    $(document).ready(function () {
        $("#subm").hide();
        $(".visitor-title-host").click(function () {

            $('.tab-content').show();
            $(".data-ifr").hide();
            $("#subm").hide();
        });
        $("#dummy-host-findBtn").click(function (e) {
            e.preventDefault();
            var searchText = $("#search-host").val();
            if (searchText != '') {
                $("#searchTextHostErrorMessage").hide();
                $("#host-findBtn").click();
                // $("#currentHostDetailsDiv").hide();
                $(".host-AddBtn").hide();
            } else {
                $("#searchTextHostErrorMessage").show();
                $("#searchTextHostErrorMessage").html("Search Name cannot be blank.");
            }

        });

        $("#User_repeatpassword").keyup(checkPasswordMatch);
        $("#saveCurrentUserAsHost").click(function (e) {
            e.preventDefault();
            if ('<?php echo $session['role']; ?>' != '9') {
                $("#selectedHostInSearchTable").val($("#Visit_host").val());
                $("#hostId").val($("#Visit_host").val());
            } else {
                $("#selectedHostInSearchTable").val('<?php echo $session['id']; ?>');
                $("#hostId").val('<?php echo $session['id']; ?>');
            }

            $("#search-host").val('staff');
            $("#clicktabB2").click();
        });

        $(".host-AddBtn").click(function (e) {
            e.preventDefault();
            $("#register-host-form").show();
            $("#searchHostDiv").show();
            $("#currentHostDetailsDiv").hide();
            $(".host-AddBtn").hide();
            $("#addhostTab").click();
        });


        $('#photoCropPreview2').imgAreaSelect({
            handles: true,
            onSelectEnd: function (img, selection) {
                $("#cropPhotoBtn2").show();
                $("#x12").val(selection.x1);
                $("#x22").val(selection.x2);
                $("#y12").val(selection.y1);
                $("#y22").val(selection.y2);
                $("#width2").val(selection.width);
                $("#height2").val(selection.height);
            }
        });
        /*Added by farhat aziz for upload host photo*/
        $("#cropPhotoBtn2").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>',
                data: {
                    x1: $("#x12").val(),
                    x2: $("#x22").val(),
                    y1: $("#y12").val(),
                    y2: $("#y22").val(),
                    width: $("#width2").val(),
                    height: $("#height2").val(),
                    //imageUrl: $('#photoCropPreview2').attr('src').substring(1, $('#photoCropPreview2').attr('src').length),
                    photoId: $('#Host_photo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Host_photo').val(),
                        dataType: 'json',
                        success: function (r) {

                            $.each(r.data, function (index, value) {

                                /*document.getElementById('photoPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop2").css("background", "url(<?php echo Yii::app()->request->baseUrl. '/'; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop2").css({
                                    "background-size": "132px 152px"
                                });*/

                                //showing image from DB as saved in DB -- image is not present in folder
                                var my_db_image = "url(data:image;base64,"+ value.db_image + ")";

                                document.getElementById('photoPreview2').src = "data:image;base64,"+ value.db_image;
                                document.getElementById('photoCropPreview2').src = "data:image;base64,"+ value.db_image;
                                $(".ajax-upload-dragdrop2").css("background", my_db_image + " no-repeat center top");
                                $(".ajax-upload-dragdrop2").css({"background-size": "132px 152px" });


                            });
                        }
                    });

                    $("#closeCropPhoto2").click();
                    var ias = $('#photoCropPreview2').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

        $("#closeCropPhoto2").click(function() {
            var ias = $('#photoCropPreview2').imgAreaSelect({instance: true});
            ias.cancelSelection();
        });

        /*			photo 3			*/

        $('#photoCropPreview3').imgAreaSelect({
            handles: true,
            onSelectEnd: function (img, selection) {
                $("#cropPhotoBtn3").show();
                $("#x13").val(selection.x1);
                $("#x23").val(selection.x2);
                $("#y13").val(selection.y1);
                $("#y23").val(selection.y2);
                $("#width3").val(selection.width);
                $("#height3").val(selection.height);
            }
        });
        /*Added by farhat aziz for upload host photo*/
        $("#cropPhotoBtn3").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>',
                data: {
                    x1: $("#x13").val(),
                    x2: $("#x23").val(),
                    y1: $("#y13").val(),
                    y2: $("#y23").val(),
                    width: $("#width3").val(),
                    height: $("#height3").val(),
                    //imageUrl: $('#photoCropPreview3').attr('src').substring(1, $('#photoCropPreview3').attr('src').length),
                    photoId: $('#Host_photo3').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Host_photo3').val(),
                        dataType: 'json',
                        success: function (r) {

                            $.each(r.data, function (index, value) {

                                /*document.getElementById('photoPreview3').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview3').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop3").css("background", "url(<?php echo Yii::app()->request->baseUrl. '/'; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop3").css({
                                    "background-size": "132px 152px"
                                });*/

                                //showing image from DB as saved in DB -- image is not present in folder
                                var my_db_image = "url(data:image;base64,"+ value.db_image + ")";

                                document.getElementById('photoPreview3').src = "data:image;base64,"+ value.db_image;
                                document.getElementById('photoCropPreview3').src = "data:image;base64,"+ value.db_image;
                                $(".ajax-upload-dragdrop3").css("background", my_db_image + " no-repeat center top");
                                $(".ajax-upload-dragdrop3").css({"background-size": "132px 152px" });


                            });
                        }
                    });

                    $("#closeCropPhoto3").click();
                }
            });
        });

        $("#closeCropPhoto3").click(function () {
            $('.imgareaselect-selection').parent().addClass('imgareaselect-part');
            $('.imgareaselect-part').css('display', 'none');
            $('.imgareaselect-outer').css('display', 'none');
        });

        /*			end of module			*/

    });

    function findHostRecord() {
        $("#host_fields_for_Search").hide();
        $("#selectedHostInSearchTable").val("");
        $("#searchHostTableDiv h4").html("Search Results for : " + $("#search-host").val());
        $("#searchHostTableDiv").show();
        $("#step3Tab").find(".tab-content").hide();
        $("#subm").show();
        $(".data-ifr").show();
        // $("#register-host-form").hide();
        $("#register-host-patient-form").hide();
        //append searched text in modal
        var searchText = $("#search-host").val();
        Loading.show();
        var tenant;
        var tenant_agent;
        if ($("#selectedVisitorInSearchTable").val() == '') {
            tenant = $("#Visitor_tenant").val();
            tenant_agent = $("#Visitor_tenant_agent").val();
        } else {
            tenant = $("#search_visitor_tenant").val();
            tenant_agent = $("#search_visitor_tenant_agent").val();
        }
        //change modal url to pass user searched text
        var url = 'index.php?r=visitor/findhost&id=' + searchText + '&visitortype=' + $("#Visitor_visitor_type").val() + '&tenant=' + tenant + '&tenant_agent=' + tenant_agent + '&cardType=' + $('#selectCardDiv input[name=selectCardType]:checked').val();
        $.ajax(url).done(function(data){
            Loading.hide();
            $("#searchHostTable").show();
            $("#searchHostTable").html(data);
        }).fail(function() {
            Loading.hide();
            window.location = '<?php echo Yii::app()->createUrl('site/login');?>';
        });
       // $("#searchHostTable").html('<iframe id="findHostTableIframe" onLoad="autoResize2();" width="100%" height="100%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
       return false;
    }

    function autoResize2() {
        var newheight;

        if (document.getElementById) {
            newheight = document.getElementById('findHostTableIframe').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('findHostTableIframe').height = (newheight - 60) + "px";
    }

    function sendHostForm() {
        if ($('#requestVerifyAsicSponsor').is(':checked') == true) {
            var $sendMail = $("<textarea  name='Visit[sendMail]'>"+'true'+"</textarea>");
            $("#register-visit-form").append($sendMail);
        }
        var hostform = $("#register-host-form").serialize();

        if ($("#selectCardDiv input[name=selectCardType]:checked").val() > CONTRACTOR_TYPE) {
            var url = "<?php echo $this->createUrl("visitor/addAsicSponsor");?>";
        } else {
            var url = "<?php echo CHtml::normalizeUrl(array("user/create&view=1")); ?>";
        }

        $.ajax({
            type: "POST",
            url: url,
            data: hostform,
            success: function (data) {
                getLastHostId(function (data) {
                    populateVisitFormFields(); // Do what you want with the data returned
                });
            }
        });

    }

    function sendPatientForm() {
        var patientForm = $("#register-host-patient-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("patient/create")); ?>",
            data: patientForm,
            success: function (data) {
                getLastPatientId(function (data) {
                    populateVisitFormFields(); // Do what you want with the data returned
                });
            }
        });
    }

    function checkPasswordMatch() {
        var password = $("#User_password").val();
        var confirmPassword = $("#User_repeatpassword").val();

        if (password != confirmPasswordUser)
            $("#passwordErrorMessage").show();
        else
            $("#passwordErrorMessage").hide();
    }

    // company change
    /*$('#User_company').on('change', function() {
        var companyId = $(this).val();
        $('#CompanySelectedId').val(companyId);
        $modal = $('#addCompanyContactModal');
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('company/getContacts') ?>",
            dataType: "json",
            data: {id:companyId},
            success: function(data) {
                var companyName = $('#userCompanyRow .select2-selection__rendered').text();
                $('#AddCompanyContactForm_companyName').val(companyName).prop('disabled', 'disabled');
                if (data == 0) {
                    $('#addUserContactLink').hide();
                    $('#userStaffRow').empty();
                } else {
                    $('#userStaffRow').html(data);
                    $('#addUserContactLink').show();
                }
                return false;
            }
        });
    });*/

    function isEmpty(obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }

        return true;
    }
</script>
