<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-birthday.js');

$session = new CHttpSession;

$dataId = '';

if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}

$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');

?>

<style>

    #addCompanyLink {
        width: 124px;
        height: 23px;
        padding-right: 0px;
        margin-right: 0px;
        padding-bottom: 0px;
        display: block;
    }

    .form-label {
        display: block;
        width: 200px;
        float: left;
        margin-left: 15px;
    }

    .ajax-upload-dragdrop {
        float:left !important;
        margin-top: -30px;
        background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
        background-size:137px;
        height: 104px;
        width: 120px !important;
        padding: 87px 5px 12px 72px;
        margin-left: 20px !important;
        border:none;
    }

    .uploadnotetext {
        margin-top: 110px;
        margin-left: -80px;

    }

    #content h1 {
        color: #2f96b4;
        font-size: 18px;
        font-weight: bold;
        margin-left: 50px;
    }

    .required {
        padding-left: 10px;
    }

</style>
 

<div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'                     => 'register-form',
        'htmlOptions'            => array("name" => "registerform"),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
            'afterValidate'    => 'js:function(form, data, hasError){ return afterValidate(form, data, hasError); }'
        ),
    ));
    ?>

    <input type="hidden" id="emailIsUnique" value="0"/>
    <input type="hidden" name="profile_type" id="Visitor_profile_type" value="<?php echo $model->profile_type; ?>"/>

    <div>

        <table id="addvisitor-table">
            <tr>
                <td>
                    <?php $this->renderPartial('profile_type', array('model' => $model)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width:300px;float:left">
                        <tr>
                            <td id="uploadRow" rowspan="7" style='width:300px;padding-top:10px;'>
                                <table>
                                    <input type="hidden" id="Visitor_photo" name="Visitor[photo]"
                                           value="<?php echo $model['photo']; ?>">
                                    <?php if ($model['photo'] != NULL) { ?>
                                        <style>
                                            .ajax-upload-dragdrop {
                                                background: url('<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($dataId) ?>') no-repeat center top !important;
                                                background-size: 137px 190px !important;
                                            }
                                        </style>
                                    <?php }
                                    ?>
                                    <br>
                                    <?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
                                    <div class="photoDiv" style="display:none;">
                                        <?php if ($dataId != '' && $model['photo'] != NULL) { ?>
                                            <img id='photoPreview'
                                                 src="<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($dataId) ?>"
                                                 style='display:block;height:174px;width:133px;'/>
                                        <?php } elseif ($model['photo'] == NULL) { ?>
                                            <img id='photoPreview'
                                                 src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png"
                                                 style='display:block;height:174px;width:133px;'/>
                                        <?php } else { ?>
                                            <img id='photoPreview' src="<?php
                                            if ($this->action->id == 'update' && $model->photo != '') {
                                                echo Yii::app()->request->baseUrl . "/" . Company::model()->getPhotoRelativePath($model->photo);
                                            }
                                            ?>
                                             " style='display:none;'/>
                                        <?php } ?>
                                    </div>
                                    </td>
                                    </tr>
                                </table>
                                <table style="float:left;width:300px; margin-top: 20px;">
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
                                                        if (($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['tenant'] && $this->action->id != 'update') || ($model['tenant'] == $value['tenant'])) {
                                                            echo "selected ";
                                                        }
                                                        ?> ><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <span class="required">*</span>
                                            <?php echo "<br>" . $form->error($model, 'tenant'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td id="visitorTenantAgentRow" <?php
                                        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                            echo " class='hidden' ";
                                        }
                                        ?> >
                                            <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]"
                                                    onchange="populateCompanyWithSameTenantAndTenantAgent()">
                                                <?php
                                                echo "<option value='' selected>Please select a tenant agent</option>";
                                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                                    echo "<option value='" . $session['tenant_agent'] . "' selected>TenantAgent</option>";
                                                }
                                                ?>
                                            </select>

                                            <?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                                </table>
                                <table style="margin-top: 70px;">
                                    <tr>
                                        <td>
                                            <?php echo $form->dropDownList($model, 'visitor_card_status', Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_VIC], array('empty' => 'Card Status', 'options'=>array('2'=>array('selected'=>true)))); ?>
                                            <span class="required">*</span>
                                            <?php echo "<br>" . $form->error($model, 'visitor_card_status'); ?>
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
                                                        if (($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['tenant'] && $this->action->id != 'update') || ($model['tenant'] == $value['tenant'])) {
                                                            echo "selected ";
                                                        }
                                                        ?> ><?php echo $value['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <span class="required">*</span>
                                            <?php echo "<br>" . $form->error($model, 'tenant'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td id="visitorTenantAgentRow" <?php
                                        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                            echo " class='hidden' ";
                                        }
                                        ?> >
                                            <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]"
                                                    onchange="populateCompanyWithSameTenantAndTenantAgent()">
                                                <?php
                                                echo "<option value='' selected>Please select a tenant agent</option>";
                                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                                    echo "<option value='" . $session['tenant_agent'] . "' selected>TenantAgent</option>";
                                                }
                                                ?>
                                            </select>

                                            <?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="workstationRow">
                                            <select id="User_workstation" name="Visitor[visitor_workstation]" disabled>
                                            </select>
                                            <span class="required">*</span>
                                            <?php echo "<br>" . $form->error($model, 'visitor_workstation'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                           // Show Default selected to Admin only 
                                           if(Yii::app()->user->role == Roles::ROLE_ADMIN) {
                                               echo '<select name="Visitor[visitor_type]" id="Visitor_visitor_type">';
                                               echo CHtml::tag('option',array('value' => ''),'Select Visitor Type',true);
                                               $list = VisitorType::model()->findAll();
                                               
                                               foreach( $list as $val ) {
                                                   if ( $val->tenant == Yii::app()->user->tenant && $val->is_default_value == '1' )
                                                        echo CHtml::tag('option',array('value' => $val->id, 'selected' => 'selected'),CHtml::encode($val->name),true);
                                                    else
                                                        echo CHtml::tag('option',array('value' => $val->id),CHtml::encode($val->name),true);
                                                   
                                              } echo "</select>";
                                           }  else {
                                               echo $form->dropDownList($model, 'visitor_type', VisitorType::model()->returnVisitorTypes());
                                           }
                                          
                                            ?>
                                            <span class="required">*</span>
                                            <?php echo "<br>" . $form->error($model, 'visitor_type'); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table style="float:left;width:300px;">
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'middle_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Middle Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'middle_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                            </td>
                        </tr>
                        <tr>
                        <tr>
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
                                <input type="text" id="Visitor_email" name="Visitor[email]" maxlength="50" size="50"
                                       placeholder="Email" value="<?php echo $model->email; ?>"/><span
                                    class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'email', array('style' => 'text-transform:none;')); ?>
                                <div style="" class="errorMessageEmail">A profile already exists for this email address.
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Mobile Number')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'contact_number'); ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_unit', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Unit', 'style' => 'width: 80px;')); ?>
                                <?php echo $form->textField($model, 'contact_street_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street No.', 'style' => 'width: 110px;')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'contact_unit'); ?>
                                <?php echo $form->error($model, 'contact_street_no'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_street_name', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street Name', 'style' => 'width: 110px;')); ?>
                                <?php echo $form->dropDownList($model, 'contact_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'style' => 'width: 95px;')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'contact_street_name'); ?>
                                <?php echo $form->error($model, 'contact_street_type'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'contact_suburb', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'Suburb')); ?>
                               <span class="required">*</span> <?php echo $form->error($model, 'contact_suburb'); ?>
                            </td>
                        </tr>  
                        <tr>
                            <td>
                                <?php echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State')); ?>
                                <span class="required">*</span>
                                
                                <?php echo $form->error($model, 'contact_state'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                echo $form->dropDownList($model, 'contact_country', $countryList,
                                    array('prompt' => 'Country', 'disabled' => 'disabled', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                                ?><span class="required">*</span>
                                <br/>
                                <?php echo $form->error($model, 'contact_country'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td id="visitorCompanyRow">
<!--                                <select id="Visitor_company" name="Visitor[company]">
                                    <option value=''>Select Company</option>
                                </select><span class="required">*</span>-->
                                
                                 
                                        <?php
                                        $this->widget('application.extensions.select2.Select2', array(
                                            'model' => $model,
                                            'attribute' => 'company',
                                            'items' => CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']),
                                            'id', 'Visitor_company'),
                                            'selectedItems' => array(), // Items to be selected as default
                                            'placeHolder' => 'Please select a company',
                                            
                                            
                                        ));
                                        ?>
                                <?php echo $form->error($model, 'company'); ?>
                                 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if ($_REQUEST['r'] == 'visitor/update') { ?>
                                    <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none; margin-top: 10px;">
                                        Add Company</a>
                                <?php } else { ?>
                                    <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none; margin-top: 10px;">
                                        Add New Company</a>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                    <?php if ((($session['role'] == Roles::ROLE_SUPERADMIN || $session['role'] == Roles::ROLE_ADMIN) &&
                            $this->action->id == 'update') || $this->action->id == 'addvisitor'
                    ) { ?>
                        <table style="float:left;width:300px;">
                            <tr>
                                <td>
                                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Identification Type'));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_type'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo $form->dropDownList($model, 'identification_country_issued', $countryList, array('empty' => 'Country of Issue'));
                                    ?><span class="required primary-identification-require">*</span>
                                    <?php echo "<br>" . $form->error($model, 'identification_country_issued'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $form->textField($model, 'identification_document_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Document No.', 'style' => 'width: 110px;')); ?>

                                    <?php
                                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'       => $model,
                                        'attribute'   => 'identification_document_expiry',
                                        'options'     => array(
                                         'dateFormat' => 'dd-mm-yy',
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
                            <tr>
                                <td>
                                    <?php echo $form->checkBox($model, 'alternative_identification', array('style' => 'float: left;')); ?>
                                    <label for="Visitor_alternative_identification" class="form-label">Alternative
                                        identifications<br/>One must have a signature</label>
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
                            <tr>
                                <td>
                                    <?php $this->renderPartial('/common_partials/password', array('model' => $model, 'form' => $form, 'session' => $session)); ?>
                                </td>
                            </tr>

                        </table>
                    <?php } ?>

                </td>
            </tr>
        </table>
        <input type="hidden" name="Visitor[visitor_status]" value="<?php echo VisitorStatus::VISITOR_STATUS_SAVE; ?>"
               style='display:none;' />
    </div>
    <?php $this->endWidget(); ?>
</div>

<input type="hidden" id="currentAction" value="<?php echo $this->action->id; ?>">
<input type="hidden" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="hidden" id="currentlyEditedVisitorId" value="<?php if (isset($_GET['id'])) {
    echo $_GET['id'];
} ?>">

<script>

    function afterValidate(form, data, hasError) {
        if (!hasError) {
            checkEmailIfUnique();
        }
    }

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

    $(document).ready(function () {

        $(".workstationRow").show();
        getWorkstation();

        $("#Visitor_alternative_identification").on('change', switchIdentification);
        switchIdentification();

        if ($("#currentAction").val() == 'update') {

            $("#fromYear").val($("#dateofBirthBreakdownValueYear").val());
            $("#fromMonth").val($("#dateofBirthBreakdownValueMonth").val());
            $("#fromDay").val($("#dateofBirthBreakdownValueDay").val());

            if ($("#Visitor_photo").val() != '') {
                $("#cropImageBtn").show();
            }

            if ($("#currentRoleOfLoggedInUser").val() != 5) {
                $("#User_workstation").prop("disabled", false);
                $('#Visitor_company option[value!=""]').remove();

                if ($("#Visitor_tenant_agent").val() == '') {
                    getCompanyWithSameTenant($("#Visitor_tenant").val());
                } else {
                    getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
                }
            } else {
                populateTenantAgentAndCompanyField();
            }

        } else {

            if ($("#currentRoleOfLoggedInUser").val() != 5) {
                $("#User_workstation").prop("disabled", false);
                $('#Visitor_company option[value!=""]').remove();

                if ($("#Visitor_tenant_agent").val() == '') {
                    getCompanyWithSameTenant($("#Visitor_tenant").val());
                } else {
                    getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
                }
            }
        }

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

        $("#cropPhotoBtn").click(function (e) {
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
                    imageUrl: $('#photoPreview').attr('src').substring(1, $('#photoPreview').attr('src').length),
                    photoId: $('#Visitor_photo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function (r) {
                            $.each(r.data, function (index, value) {
                                document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop").css("background", "url(<?php echo Yii::app()->request->baseUrl; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop").css({"background-size": "137px 190px"});
                            });
                            $("#closeCropPhoto").click();
                            var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                            ias.cancelSelection();
                        }
                    });
                }
            });
        });
    });

    function checkEmailIfUnique() {

        var email = $("#Visitor_email").val();

        if (email != "<?php echo $model->email ?>") {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/checkEmailIfUnique&id='); ?>' + email,
                dataType: 'json',
                data: email,
                success: function (r) {
                    $.each(r.data, function (index, value) {
                        if (value.isTaken == 1) { //if taken
                            $(".errorMessageEmail").show();
                        } else {
                            $(".errorMessageEmail").hide();
                            sendVisitorForm();
                        }
                    });
                }
            });
        } else {
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

    function populateTenantAgentAndCompanyField() {

        $('#Visitor_company option[value!=""]').remove();

        $('#Visitor_tenant_agent option[value!=""]').remove();
        $("#User_workstation").empty();
        getWorkstation();
        $("#User_workstation").prop("disabled", false);
        var tenant = $("#Visitor_tenant").val();
        var selected;

        if ($("#currentAction").val() == 'update') {
            selected = "<?php echo $model->tenant_agent; ?>";
        } else {
            selected = "";
        }

        getTenantAgentWithSameTenant(tenant, selected);
        getCompanyWithSameTenant(tenant);
    }

    function getTenantAgentWithSameTenant(tenant, selected) {

        $('#Visitor_tenant_agent').empty();
        $('#Visitor_tenant_agent').append('<option value="">Please select a tenant agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function (r) {
                $.each(r.data, function (index, value) {
                    $('#Visitor_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');
                });
                $("#Visitor_tenant_agent").val(selected);
            }
        });
    }

    function getCompanyWithSameTenant(tenant, newcompanyId) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function (r) {
                $.each(r.data, function (index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });

                if ($("#currentAction").val() == 'update') {
                    $("#Visitor_company").val("<?php echo $model->company; ?>")
                }

                newcompanyId = (typeof newcompanyId === "undefined") ? "defaultValue" : newcompanyId;

                if (newcompanyId != 'defaultValue') {
                    $("#Visitor_company").val(newcompanyId);
                }
            }
        });

        if ($("#Visitor_tenant_agent").val() != '') {
            getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), '<?php echo $model->tenant_agent; ?>');
        }
    }

    function populateCompanyWithSameTenantAndTenantAgent() {

        $('#Visitor_company option[value!=""]').remove();
        getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
    }

    function getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent, newcompanyId) {

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function (r) {
                // $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function (index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });

                if ($("#currentAction").val() == 'update') {
                    $("#Visitor_company").val("<?php echo $model->company; ?>")
                }

                newcompanyId = (typeof newcompanyId === "undefined") ? "defaultValue" : newcompanyId;

                if (newcompanyId != 'defaultValue') {
                    $("#Visitor_company").val(newcompanyId);
                }
            }
        });
    }

    function trim(el) {

        el.value = el.value.
            replace(/(^\s*)|(\s*$)/gi, "").// removes leading and trailing spaces
            replace(/[ ]{2,}/gi, " ").// replaces multiple spaces with one space
            replace(/\n +/, "\n");           // Removes spaces after newlines
        return;
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

    function sendVisitorForm() {

        $('#Visitor_contact_country').removeAttr('disabled');
        var form = $("#register-form").serialize();
        $('#Visitor_contact_country').attr('disabled', 'disabled');
        var url;

        if ($("#currentAction").val() == 'update') {
            url = "<?php echo CHtml::normalizeUrl(array("visitor/update&id=")); ?>" + $("#currentlyEditedVisitorId").val();
        } else {
            url = "<?php echo CHtml::normalizeUrl(array("visitor/addvisitor")); ?>";
        }

        $.ajax({
            type: "POST",
            url: url,
            data: form,
            success: function (data) {
                if ($("#currentRoleOfLoggedInUser").val() == 8 || $("#currentRoleOfLoggedInUser").val() == 7) {
                    window.location = 'index.php?r=dashboard';
                } else if ($("#currentRoleOfLoggedInUser").val() == 9) {
                    window.location = 'index.php?r=dashboard/viewmyvisitors';
                } else {
                    window.location = 'index.php?r=visitor/admin';
                }
            },
            error: function (data) {
                if ($("#currentRoleOfLoggedInUser").val() == 8 || $("#currentRoleOfLoggedInUser").val() == 7) {
                    window.location = 'index.php?r=dashboard';
                } else if ($("#currentRoleOfLoggedInUser").val() == 9) {
                    window.location = 'index.php?r=dashboard/viewmyvisitors';
                } else {
                    window.location = 'index.php?r=visitor/admin';
                }
            }
        });
    }

    function getWorkstation() { /*get workstations for operator*/

        var sessionRole = '<?php echo $session['role']; ?>';
        var superadmin = 5;

        if (sessionRole == superadmin) {
            var tenant = $("#Visitor_tenant").val();
        } else {
            var tenant = '<?php echo $session['tenant'] ?>';
        }

        populateOperatorWorkstations(tenant);
    }

    function populateOperatorWorkstations(tenant, value) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function (r) {
                $('#User_workstation option[value!=""]').remove();

                $('#User_workstation').append('<option value="">Workstation</option>');
                $.each(r.data, function (index, value) {
                    $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#User_workstation").val(value);
            }
        });
    }
</script>



<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'label'       => 'Click me',
    'type'        => 'primary',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#addCompanyModal',
        'id'          => 'modalBtn',
        'style'       => 'display:none',
    ),
));

?>

<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal">×</a>
        <br>
    </div>
    <div id="modalBody">
    </div>

</div>
<!-- PHOTO CROP-->

<div id="light" class="white_content">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
        <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
    <br>
    <?php if ($this->action->id == 'addvisitor') { ?>
        <img id="photoCropPreview" src="">
    <?php } elseif ($this->action->id == 'update') { ?>
        <img id="photoCropPreview"
             src="<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($model->id) ?>">
    <?php } ?>
</div>

<div id="fade" class="black_overlay"></div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>







