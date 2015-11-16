<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');

$session = new CHttpSession;

$dataId = '';

if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}

$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');
// set default country is Australia = 13

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

    .date_of_birth_class{
        width: 71.5px !important;
    }

</style>


<div data-ng-app="PwordForm">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'                     => 'register-form',
        'htmlOptions'            => array("name" => "registerform"),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
            'afterValidate'    => 'js:function(form, data, hasError){
                if (hasError) {
                    var currentYear = new Date().getFullYear();
                    var selectedYear = $("#fromYear").val();

                    if (currentYear - selectedYear < 18) {
                        $("#Visitor_identification_type_em_").hide();
                        $("#Visitor_identification_document_no_em_").hide();
                        $("#Visitor_identification_document_expiry_em_").hide();

                        //remove item
                        delete data.Visitor_identification_document_expiry;
                        delete data.Visitor_identification_document_no;
                        delete data.Visitor_identification_type;
                    }

                }
                    hasError = false;
                    return afterValidate(form, data, hasError);
            }'
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
                                    
                                    <?php if ($model['photo'] != NULL) {
                                        $data = Photo::model()->returnVisitorPhotoRelativePath($dataId);
                                        $my_image = '';
                                        if(!empty($data['db_image'])){
                                            $my_image = "url(data:image;base64," . $data['db_image'] . ")";
                                        }else{
                                            $my_image = "url(" .$data['relative_path'] . ")";
                                        }
                                        
                                     ?>
                                        <style>
                                            .ajax-upload-dragdrop {
                                                background: <?php echo $my_image ?> no-repeat center top !important;
                                                background-size: 137px 190px !important;
                                            }
                                        </style>
                                    <?php }
                                    ?>

                                    <br>
                                    
                                    <?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
                                    

                                    <div class="photoDiv" style="display:none;">
                                        <?php if ($dataId != '' && $model['photo'] != NULL) {
                                            $data = Photo::model()->returnVisitorPhotoRelativePath($dataId);
                                            $my_image = '';
                                            if(!empty($data['db_image'])){
                                                $my_image = "data:image;base64," . $data['db_image'];
                                            }else{
                                                $my_image = $data['relative_path'];
                                            }
                                         ?>
                                            <img id='photoPreview'
                                                 src = "<?php echo $my_image ?>"
                                                 style='display:block;height:174px;width:133px;'/>
                                        <?php } elseif ($model['photo'] == NULL) {
                                            ?>

                                            <img id='photoPreview'
                                                 src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png"
                                                 style='display:block;height:174px;width:133px;'/>

                                        <?php } else { ?>

                                            <img id='photoPreview' src="data:image;base64,<?php
                                                if ($this->action->id == 'update' && $model->photo != '') {
                                                    echo Company::model()->getPhotoRelativePath($model->photo);
                                                }
                                                ?>
                                                " style='display:none;'/>

                                        <?php } ?>
                                    </div>

                                    </td>
                                    </tr>
                                </table>
                                <table style="margin-top: 70px;">
                                    <tr>
                                        <td>
                                            <?php
                                            echo $form->dropDownList($model, 'visitor_card_status', Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_VIC], ['empty' => 'Select Card Status', 'options'=>['1' => ['selected'=>true]]]); ?>
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
                                            <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()" name="Visitor[tenant]">
                                                <option value='' selected>Please select a tenant</option>
                                                <?php
                                                $allTenantCompanyNames = User::model()->findAllCompanyTenant();

                                                foreach ($allTenantCompanyNames as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['id']; ?>"
                                                        <?php
                                                        if (($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value['id'] && $this->action->id != 'update') || ($model['tenant'] == $value['id'])) {
                                                            echo "selected ";
                                                        }
                                                        ?> ><?php echo $value["id0"]['name']; ?></option>
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
                                            <!--<span class="required">*</span>-->
                                            <?php //echo "<br>" . $form->error($model, 'visitor_workstation'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
                                            // Show Default selected to Admin only
                                            
                                            $condition = '';
                                            if(Yii::app()->user->role == Roles::ROLE_ADMIN) {
                                                $condition .= "t.tenant =".Yii::app()->user->tenant." and ";
                                            }

                                            $condition .= "module ='AVMS'";
                                            
                                            //$list = VisitorType::model()->findAll('created_by = :c and t.tenant = :t and module = :m', [':c' => Yii::app()->user->id,':t' => Yii::app()->user->tenant, ':m' => "AVMS"]);    
                                            
                                            $list = VisitorType::model()->findAll($condition);    
                                            
                                            echo '<select name="Visitor[visitor_type]" id="Visitor_visitor_type">';
                                            echo CHtml::tag('option',array('value' => ''),'Select Visitor Type',true);
                                            foreach( $list as $val ) {
                                                if ( $val->tenant == Yii::app()->user->tenant && $val->is_default_value == '1' ) {
                                                    echo CHtml::tag('option', array('value' => $val->id, 'selected' => 'selected'), CHtml::encode('Visitor Type: '.$val->name), true);
                                                } else {
                                                    echo CHtml::tag('option', array('value' => $val->id), CHtml::encode('Visitor Type: '.$val->name), true);
                                                }
                                            } echo "</select>";

                                            /*}  else {

                                                echo $form->dropDownList($model, 'visitor_type', VisitorType::model()->returnVisitorTypes(NULL,"name like '{$model->profile_type}%'"));
                                            }*/

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
                                <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 15, 'placeholder' => 'First Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'middle_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Middle Name')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 15, 'placeholder' => 'Last Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="birthdayDropdown">
                               <span>Date of Birth</span> <br/>
                                <?php echo $form->hiddenField($model,'date_of_birth',['data-format'=>"DD-MM-YYYY",'data-template'=>"DD MMM YYYY"]) ?>
                                <script>
                                    $(function(){
                                        $('#Visitor_date_of_birth').combodate({
                                            minYear: (new Date().getFullYear()-100),
                                            maxYear: (new Date().getFullYear()-10),
                                            smartDays: true,
                                            customClass: 'date_of_birth_class'
                                        });
                                    });
                                </script>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'date_of_birth'); ?>
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
                                <i id="cstate">
                                    <?php
                                    if(Yii::app()->controller->action->id == 'addvisitor'){
                                        echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State', 'style' => 'width: 140px;'));
                                    } elseif(Yii::app()->controller->action->id == 'update' && $model->contact_country == Visitor::AUSTRALIA_ID ) {
                                        echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State', 'style' => 'width: 140px;'));
                                    } else {
                                        echo $form->textField($model, 'contact_state', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'State', 'style' => 'width: 126px;'));
                                    } ?>
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
                                <?php echo $form->error($model, 'contact_state'); ?>
                                <?php echo $form->error($model, 'contact_postcode'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                echo $form->dropDownList($model, 'contact_country', $countryList,
                                    array('prompt' => 'Country', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                                ?><span class="required">*</span>
                                <br/>
                                <?php echo $form->error($model, 'contact_country'); ?>
                            </td>
                        </tr>
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
                                    <span class="required">*</span>
                                    <?php echo $form->error($model, 'company', array("style" => "margin-top:0px")); ?>
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
                                <?php
                                if ($_REQUEST['r'] == 'visitor/update') { ?>
                                    <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none; margin-top: 10px;" class="actionForward">
                                        Add Company</a>
                                <?php } else { ?>
                                    <!-- <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none; margin-top: 10px;">Add New Company</a> -->
                                    <a style="float: left; margin-right: 5px; width: 95px; height: 21px;" href="#addCompanyContactModal" role="button" data-toggle="modal" id="addCompanyLink" class="actionForward">Add Company</a>
                                    <a href="#addCompanyContactModal" style="font-size: 12px; font-weight: bold; display: none;" id="addContactLink" class="btn btn-xs btn-info actionForward" role="button" data-toggle="modal">Add Contact</a>
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
                                    echo $form->dropDownList($model, 'identification_country_issued', $countryList, array('empty' => 'Country of Issue', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
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
                                            'changeMonth' => true,
                                            'changeYear' => true
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
                            <?php
                            $birthYear = date('Y', strtotime($model->date_of_birth));
                            $visibility = 'none';
                            if (Yii::app()->controller->action->id == 'update' && (date('Y') - $birthYear) < 18) {
                                $visibility = 'block';
                            }
                            ?>
                            <tr id="u18_identification" style="display: <?php echo $visibility; ?>">
                                <td>
                                    <?php
                                    echo $form->checkBox($model, 'is_under_18', ['style' => 'float:left;']);
                                    ?>
                                    <label for="Visitor_identification" class="form-label">I have verified that the applicant is under 18<span class="required primary-identification-require">*</span></label>
                                    <div class="errorMessage" style="float: left; display: none;" id="Visitor_is_under_18_em_">Please verify the age of the applicant.</div>
                                    <?php echo $form->textField($model, 'under_18_detail', ['placeholder' => 'Detail']); ?>

                                </td>
                            </tr>
                            <?php if (!in_array($session['role'], [Roles::ROLE_AIRPORT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_ADMIN, Roles::ROLE_AGENT_AIRPORT_OPERATOR])): ?>
                            <tr>
                                <td>
                                    <?php echo $form->checkBox($model, 'alternative_identification', array('style' => 'float: left;')); ?>
                                    <label for="Visitor_alternative_identification" class="form-label">Applicant does not have one of the above identifications</label>
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
                        <div style="float:right; margin-right: 35px"><input type="submit" value="Save" name="yt0" id="submitFormVisitor" class="complete" style="margin-top: 15px;"/></div>
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
       /* 
       var dt = new Date();
       if(dt.getFullYear()< $("#fromYear").val()) {
            $("#Visitor_date_of_birth_em_").show();
            $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
            return false;
        }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
            $("#Visitor_date_of_birth_em_").show();
            $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
            return false;
        }else if(
            dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
            $("#Visitor_date_of_birth_em_").show();
            $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
            return false;
        }*/

        if ($('#u18_identification:hidden').length != 1) {
            if (!$('#Visitor_is_under_18').is(':checked')) {
                $('#Visitor_is_under_18_em_').show();
                return false;
            } else {
                $('#Visitor_is_under_18_em_').hide();
            }
        } else {
            $('#Visitor_is_under_18_em_').hide();
        }

        var companyValue = $("#Visitor_company").val();
        var workstation = $("#User_workstation").val();

//        if (!workstation || workstation == "") {
//            $("#Visitor_visitor_workstation_em_").show();
//            $("#Visitor_visitor_workstation_em_").html('Please enter Workstation');
//            return false;
//        }
    
        if($(".pass_option").is(":checked")== false){
            $("#pass_error_").show();
            $("#User_password_em_").html("select one option");
            return false;
        }

        
        if ($('.pass_option').filter(':checked').val() == "<?php echo PasswordOption::CREATE_PASSWORD; ?>") {
            $('.visitor_password').empty().hide();
            $('.visitor_password_repeat').empty().hide();
            var password_temp = $('#Visitor_password_input').val();
            var password_repeat_temp = $('#Visitor_repeatpassword_input').val();
            if (password_temp == '') {
                $('.visitor_password').html('Password should be specified').show();
                return false;
            } else if (password_repeat_temp == '') {
                $('.visitor_password_repeat').html('Please confirm a password').show();
                return false;
            } else if (password_temp != password_repeat_temp) {
                $('.visitor_password_repeat').html('Passwords are not matched').show();
                return false;
            }
            $('input[name="Visitor[password]"]').val(password_temp);
            $('input[name="Visitor[repeatpassword]"]').val(password_repeat_temp);
        }

        if (!hasError) {
            if (!companyValue || companyValue == "") {
                $("#company_error_").show();
                return false;
            } else {
                checkEmailIfUnique();
            }
        }
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

    $(document).ready(function () {

        $(".workstationRow").show();
        getWorkstation();

        $('#Visitor_identification_document_expiry').datepicker({
            minDate: '0',
            maxDate: '+2y +2m',
            changeYear: true,
            changeMonth: true
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

        /*$('#fromDay').on('change', function () {
            
            var dt = new Date();

            if(dt.getFullYear()< $("#fromYear").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else{
                $("#Visitor_date_of_birth_em_").hide();
            }
        });

        $('#fromMonth').on('change', function () {
            var dt = new Date();

            if(dt.getFullYear()< $("#fromYear").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else{
                $("#Visitor_date_of_birth_em_").hide();
            }
        });

        $('#fromYear').on('change', function () {
            var dt = new Date();

            if(dt.getFullYear()< $("#fromYear").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
                $("#Visitor_date_of_birth_em_").show();
                $("#Visitor_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else{//u18_identification
                if (dt.getFullYear() - $("#fromYear").val() < 18) {
                    $('#u18_identification').show();
                    $('.primary-identification-require').hide();
                } else {
                    $('#u18_identification').hide();
                    $('.primary-identification-require').show();
                }
                $("#Visitor_date_of_birth_em_").hide();
            }
        });
*/

//        $('#User_workstation').on('change', function () {
//            var workstation = $("#User_workstation").val();
//            if (!workstation || workstation == "") {
//                $("#Visitor_visitor_workstation_em_").show();
//                $("#Visitor_visitor_workstation_em_").html('Please enter Workstation');
//            } else {
//                $("#Visitor_visitor_workstation_em_").hide();
//            }
//        });

        $("#Visitor_alternative_identification").on('change', switchIdentification);
        switchIdentification();

        if ($("#currentAction").val() == 'update') {

            $("#fromYear").val($("#dateofBirthBreakdownValueYear").val());
            $("#fromMonth").val($("#dateofBirthBreakdownValueMonth").val());
            $("#fromDay").val($("#dateofBirthBreakdownValueDay").val());

            $('#Visitor_visitor_card_status').val(<?php echo $model->visitor_card_status; ?>);
            $('#Visitor_visitor_type').val(<?php echo $model->visitor_type; ?>);
            $('#Visitor_contact_country').val(<?php echo $model->contact_country; ?>);
            $('#Visitor_identification_country_issued').val(<?php echo $model->identification_country_issued; ?>);

            if ($("#Visitor_photo").val() != '') {
                $("#cropImageBtn").show();
            }

            if ($("#currentRoleOfLoggedInUser").val() != 5 && $("#currentRoleOfLoggedInUser").val() != 1) {
                $("#User_workstation").prop("disabled", false);
               // $('#Visitor_company option[value!=""]').remove();

                if ($("#Visitor_tenant_agent").val() == '') {
                    getCompanyWithSameTenant($("#Visitor_tenant").val());
                } else {
                    getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
                }
            } else {
                populateTenantAgentAndCompanyField();
            }

            if ($('#Visitor_identification_alternate_document_name1').val() != '') {
                $('#Visitor_alternative_identification').prop('checked', true);
                $('.row_document_name_number').show();
            }

        } else {

            if ($("#currentRoleOfLoggedInUser").val() != 5 && $("#currentRoleOfLoggedInUser").val() != 1) {
                $("#User_workstation").prop("disabled", false);
              //  $('#Visitor_company option[value!=""]').remove();

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
                url: "<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>",
                data: {
                    x1: $("#x1").val(),
                    x2: $("#x2").val(),
                    y1: $("#y1").val(),
                    y2: $("#y2").val(),
                    width: $("#width").val(),
                    height: $("#height").val(),
                    //imageUrl: $('#photoPreview').attr('src').substring(1, $('#photoPreview').attr('src').length),
                    photoId: $('#Visitor_photo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>" + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function (r) {
                            $.each(r.data, function (index, value) {
                                /*document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop").css("background", "url(" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop").css({"background-size": "132px 152px"});*/

                                //showing image from DB as saved in DB -- image is not present in folder
                                var my_db_image = "url(data:image;base64,"+ value.db_image + ")";

                                document.getElementById('photoPreview').src = "data:image;base64,"+ value.db_image;
                                document.getElementById('photoCropPreview').src = "data:image;base64,"+ value.db_image;
                                $(".ajax-upload-dragdrop").css("background", my_db_image + " no-repeat center top");
                                $(".ajax-upload-dragdrop").css({"background-size": "132px 152px" });
                            });
                            $("#closeCropPhoto").click();
                            var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                            ias.cancelSelection();
                        }
                    });
                }
            });
            $("#closeCropPhoto").click(function() {
                var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                ias.cancelSelection();
            });
        });
    });

    function checkEmailIfUnique() {
        var email = $("#Visitor_email").val();

        if (email != "<?php echo $model->email ?>") {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/checkEmailIfUnique&email='); ?>' + email,
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
                url = "<?php echo Yii::app()->createUrl('company/create&viewFrom=1&tenant='); ?>" + $('#Visitor_tenant').val() + "&tenant_agent=" + $('#Visitor_tenant_agent').val();
            } else {
                url = "<?php echo Yii::app()->createUrl('company/create&viewFrom=1'); ?>";
            }

            $("#modalBody").html('<iframe id="companyModalIframe" width="100%" height="80%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
            $("#modalBtn").click();
        }
    }

    function populateTenantAgentAndCompanyField() {

        //$('#Visitor_company option[value!=""]').remove();

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

    var requestRunning = false;
    function sendVisitorForm() {
        if (requestRunning) { // don't do anything if an AJAX request is pending
            return;
        }
        $('#Visitor_contact_country').removeAttr('disabled');

        if (!$('#Visitor_alternative_identification').attr('checked')) {
            $('#Visitor_identification_alternate_document_name1').val('');
            $('#Visitor_identification_alternate_document_no1').val('');
            $('#Visitor_identification_alternate_document_expiry1').val('');
            $('#Visitor_identification_alternate_document_name2').val('');
            $('#Visitor_identification_alternate_document_no2').val('');
            $('#Visitor_identification_alternate_document_expiry2').val('');
        }

        var form = $("#register-form").serialize();
        //$('#Visitor_contact_country').attr('disabled', 'disabled');
        var url;

        if ($("#currentAction").val() == 'update') {
            url = "<?php echo CHtml::normalizeUrl(array("visitor/update&id=")); ?>" + $("#currentlyEditedVisitorId").val();
        } else {
            url = "<?php echo CHtml::normalizeUrl(array("visitor/addvisitor")); ?>";
        }

        var ajaxOpts = {
            type: "POST",
            url: url,
            data: form,
            success: function (data, response) {
                if(data == ''){
                    if ($("#currentRoleOfLoggedInUser").val() == 8 || $("#currentRoleOfLoggedInUser").val() == 7) {
                        window.location = 'index.php?r=dashboard';
                    } else if ($("#currentRoleOfLoggedInUser").val() == 9) {
                        window.location = 'index.php?r=dashboard/viewmyvisitors';
                    } else {
                        window.location = 'index.php?r=visitor/admin&vms=avms';
                    }
                     
                }else {
                     alert(data); 
                      return;
                }
            },
            complete: function() {
                //$("#submitFormVisitor").data('requestRunning', false);
                requestRunning = false;
            },
            error: function (data) {
                return;
                if ($("#currentRoleOfLoggedInUser").val() == 8 || $("#currentRoleOfLoggedInUser").val() == 7) {
                    window.location = 'index.php?r=dashboard';
                } else if ($("#currentRoleOfLoggedInUser").val() == 9) {
                    window.location = 'index.php?r=dashboard/viewmyvisitors';
                } else {
                    window.location = 'index.php?r=visitor/admin&vms=avms';
                }
            }
        };
        requestRunning = true;
        $.ajax(ajaxOpts);
        return false;
    }

    function getWorkstation() { /*get workstations for operator*/

        var sessionRole = "<?php echo $session['role']; ?>";
        var superadmin = 5;

        if (sessionRole == superadmin) {
            var tenant = $("#Visitor_tenant").val();
        } else {
            var tenant = "<?php echo $session['tenant'] ?>";
        }

        populateOperatorWorkstations(tenant);
    }

    function populateOperatorWorkstations(tenant, value) {
        $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>" + tenant,
            dataType: 'json',
            data: tenant,
            success: function (r) {
                
               
                $('#User_workstation option[value!=""]').remove();

                //$('#User_workstation').append('<option value="">Workstation</option>');

                $.each(r.data, function (index, value) {
                    var str = '<option ';
                    
                    if (value.id == parseInt("<?php echo $model->visitor_workstation; ?>"))
                    {
                         str += 'selected';   
                    }

                    str += ' value="' + value.id + '">' + 'Workstation: ' + value.name + '</option>';
                    $('#User_workstation').append(str);
                });
                //$("#User_workstation").val(value);
                /*if ($("#currentAction").val() == 'update') {
                    $("#User_workstation").val("<?php echo $model->visitor_workstation; ?>");
                }*/
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
                    $('#visitorStaffRow').empty();
                } else {
                    $('#visitorStaffRow').html(data);
                    $('#addContactLink').show();
                }
                return false;
            }
        });
    });

    function isEmpty(obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }

        return true;
    }

    var first_click = true;

    $("#visitorCompanyRow").on("click", function(e) {
        e.preventDefault();
        if (first_click) {
            first_click = false;
            $(function(){
                if($(window).scrollTop() == 0)
                    $(window).scrollTop($(window).scrollTop()+1);
                else
                    $(window).scrollTop($(window).scrollTop()-0.1);
            }) 
        }
    });
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
    <?php if ($this->action->id == 'addvisitor') { ?>
        <img id="photoCropPreview" src="">
    <?php } elseif ($this->action->id == 'update') {
                $data = Photo::model()->returnVisitorPhotoRelativePath($model->id);
                $my_image = '';
                if(!empty($data['db_image'])){
                    $my_image = "data:image;base64," . $data['db_image'];
                }else{
                    $my_image = $data['relative_path'];
                }
     ?>

        <img id="photoCropPreview"
            src = "<?php echo $my_image ?>" >
    <?php } ?>
</div>

<div id="fade" class="black_overlay"></div>
<div id="crop_button">
    <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
    <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none';
                document.getElementById('crop_button').style.display = 'none'" value="x" class="btn btn-danger">
</div>
<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>