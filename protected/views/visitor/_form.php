<?php
$session = new CHttpSession;
$dataId = '';

if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}

$company = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}
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

    .ajax-upload-dragdrop {
        float: left !important;
        margin-top: -30px;
        background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
        background-size: 137px;
        height: 104px;
        width: 120px !important;
        padding: 87px 5px 12px 72px;
        margin-left: 20px !important;
        border: none;
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

    .select2 {
        margin: 0.2em 0 0.5em;
    }
    #cropImageBtn {
        float: left;
        margin-left: -174px !important;
        margin-top: 257px;
        position: absolute;
    }

</style>


<div data-ng-app="PwordForm">

<?php
 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'visitor-form',
    'htmlOptions' => array("name" => "registerform"),
    'enableAjaxValidation' => true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'afterValidate' => 'js:function(form,data,hasError){ 
            if(!hasError){
                window.location = "<?php echo Yii::app()->createUrl("site/login");?>";
            };return false;
        }'
        ),
    
 ));

?>

<input type="hidden" id="emailIsUnique" value="0"/>
 <input type="hidden" name="profile_type" id="Visitor_profile_type" value="<?php echo $model->profile_type; ?>"/>
<div>
<?php    
foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
 }
?>
<table id="addvisitor-table" data-ng-app="PwordForm">


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
            <table style="width:300px;float:left;min-height:320px;">
                <input type="hidden" id="Visitor_photo" name="Visitor[photo]" value="<?php echo $model['photo']; ?>">
                
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

            </table>


        </td>

    </tr>

</table>

<table style="float:left;width:300px;">
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

                    ?> ><?php echo $value['name']; ?></option>

            <?php

            }

            ?>

        </select>

        <span class="required">*</span>

        <?php  echo "<br>" . $form->error($model, 'tenant'); ?>

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

    <td>

        <?php echo $form->hiddenfield($model, "tenant", array("value"=>$session['tenant'])); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 15, 'maxlength' => 15, 'placeholder' => 'First Name')); ?>
        <span class="required">*</span>

        <?php echo "<br>" . $form->error($model, 'first_name'); ?>

    </td>

</tr>

<tr>

    <td>

        <?php echo $form->textField($model, 'last_name', array('size' => 15, 'maxlength' => 15, 'placeholder' => 'Last Name')); ?>
        <span class="required">*</span>

        <?php echo "<br>" . $form->error($model, 'last_name'); ?>

    </td>


</tr>


<tr>

    <td width="37%">


        <input type="text" id="Visitor_email" name="Visitor[email]" maxlength="50" size="50" placeholder="Email"
               value="<?php echo $model->email; ?>"/><span class="required">*</span>

        <?php echo "<br>" . $form->error($model, 'email', array('style' => 'text-transform:none;')); ?>

        <div style="" class="errorMessageEmail">A profile already exists for this email address.</div>


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


        <input type="text" placeholder="Vehicle Registration Number" id="Visitor_vehicle" name="Visitor[vehicle]"
               maxlength="6" size="6" value="<?php

        if ($this->action->id == 'update' && $model->vehicle != "") {

            echo Vehicle::model()->findByPk($model->vehicle)->vehicle_registration_plate_number;

        }

        ?>">

        <?php echo "<br>" . $form->error($model, 'vehicle'); ?>

    </td>

</tr>

<tr>

    <td>

        <?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Position')); ?>

        <?php echo "<br>" . $form->error($model, 'position'); ?>

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
            <?php echo $form->error($model, 'company'); ?>
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
        if ($_REQUEST['r'] == 'visitor/update') {
            ?>

            <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none;" class="actionForward">

                Add Company</a>

        <?php
        } else {

            ?>
            <!-- <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none;"> -->
            <a style="float: left; margin-right: 5px; width: 95px; height: 21px;" href="#addCompanyContactModal" role="button" data-toggle="modal" id="addCompanyLink" class="actionForward">Add Company</a>
            <a href="#addCompanyContactModal" style="font-size: 12px; font-weight: bold; display: none;" id="addContactLink" class="btn btn-xs btn-info actionForward" role="button" data-toggle="modal">Add Contact</a>
        <?php } ?>
    </td>
</tr>
</table>

<?php if ((($session['role'] == Roles::ROLE_SUPERADMIN || $session['role'] == Roles::ROLE_ADMIN) && $this->action->id == 'update') || $this->action->id == 'addvisitor') {

    ?>
    <div class="password-border">
        <table style="float:left;width:300px;">
            <tr>
                <td><strong>Password Options</strong></td>
            </tr>
            <tr>
                <td id="pass_error_1" style='font-size: 0.9em;color: #FF0000; display:none'>Select One Option</td>
            </tr>
            <tr>

                <td>
                    <?php echo $form->radioButtonList($model, 'password_requirement',
                        array(
                            PasswordRequirement::PASSWORD_IS_NOT_REQUIRED => 'User does not require Password',
                            PasswordRequirement::PASSWORD_IS_REQUIRED => 'User requires Password to Login',
                        ), array('class' => 'password_requirement form-label', 'style' => 'float:left;margin-right:10px;', 'separator' => ''));
                    ?>
                    <?php echo $form->error($model, 'password_requirement'); ?>
                </td>
            </tr>

            <tr style="display:none;" class="user_requires_password">
                <td>

                    <table
                        style="margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none;margin-left: 30px;">

                        <tr>
                            <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select Atleast
                                One option
                            </td>
                        </tr>


                        <tr id="third_option" class='hiddenElement'></tr>

                        <tr>
                            <td><input class="pass_option" type="radio" name="Visitor[password_option]" value="2"/>&nbsp;Send
                                User Invitation
                            </td>
                        </tr>

                        <tr>
                            <td style="padding-bottom:10px">
                                <input class="pass_option" type="radio" name="Visitor[password_option]" value="1"/>
                                &nbsp;Create Password
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input placeholder="Password" ng-model="user.passwords" data-ng-class="{
                                                                       'ng-invalid':registerform['Visitor[repeatpassword]'].$error.match}"
                                       type="password" id="Visitor_password" name="Visitor[password]">
                                <span class="required">*</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input placeholder="Repeat Password" ng-model="user.passwordConfirm" type="password"
                                       id="Visitor_repeatpassword" data-match="user.passwords"
                                       name="Visitor[repeatpassword]"/>
                                <span class="required">*</span>

                                <div style='font-size:0.9em;color:red;position: static;'
                                     data-ng-show="registerform['Visitor[repeatpassword]'].$error.match">Password does
                                    not match with Repeat <br> Password.
                                </div>
                                <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                            </td>

                        </tr>

                        <tr>
                            <td align="center">
                                <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                                <div class="row buttons" style="text-align:center;">
                                    <input onclick="generatepassword();" class="complete btn btn-info" type="button" value="Autogenerate Password"
                                    style="<?php echo $background; ?>position: relative; width: 180px; overflow: hidden;cursor:pointer;font-size:14px;margin-right:8px;"/>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                        </tr>


                    </table>

                </td>
            </tr>


        </table>
    </div> <!-- password-border -->
 <div style="float:right; margin-right: 35px"><input type="submit" value="Save" name="yt0" id="submitFormVisitor" class="complete" style="margin-top: 15px;"/></div>
<?php } ?>

</td>


</tr>


<input type="text" name="Visitor[visitor_status]" value="<?php echo VisitorStatus::VISITOR_STATUS_SAVE; ?>"
       style='display:none;'>


</table>


</div>


<?php $this->endWidget(); ?>

</div>


<input type="hidden" id="currentAction" value="<?php echo $this->action->id; ?>">

<input type="hidden" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">

<input type="hidden" id="currentlyEditedVisitorId" value="<?php

if (isset($_GET['id'])) {

    echo $_GET['id'];

}

?>">

<script>

$(document).ready(function () {
    if( $("#Visitor_password_requirement_1").is(":checked") ) {
         $(".user_requires_password").css("display", "block");
    }
    if ($("#currentAction").val() == 'update') {

        if ($("#Visitor_photo").val() != '') {

            $("#cropImageBtn").show();

        }

        if ($("#currentRoleOfLoggedInUser").val() != 5) { 

           // $('#Visitor_company option[value!=""]').remove();

            if ($("#Visitor_tenant_agent").val() == '') {

                getCompanyWithSameTenant($("#Visitor_tenant").val());

            } else {

                getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());

            }

        } else {

            populateTenantAgentAndCompanyField();

        }

    } else {

        $("#Visitor_vehicle").val("");


        if ($("#currentRoleOfLoggedInUser").val() != 5) {

           // $('#Visitor_company option[value!=""]').remove();

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

                //imageUrl: $('#photoPreview').attr('src').substring(1, $('#photoPreview').attr('src').length),

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

                            /*document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;

                            document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;


                            $(".ajax-upload-dragdrop").css("background", "url(<?php echo Yii::app()->request->baseUrl. '/'?>" + value.relative_path + ") no-repeat center top");

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


                        $("#closeCropPhoto").click();

                        var ias = $('#photoCropPreview').imgAreaSelect({instance: true});

                        ias.cancelSelection();

                    }

                });

            }

        });

    });

    $("#closeCropPhoto").click(function() {
        var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
        ias.cancelSelection();
    });


    /***********************hide password section if not required************************/
    $('.password_requirement').click(function () {
        if ($('#Visitor_password_requirement_1').is(':checked')) {
            $('.user_requires_password').css("display", "block");
            $('.pass_option').prop('checked', false);
        }
        else {
            $('.user_requires_password').css("display", "none");
        }

    });

    $('#Visitor_vehicle').keydown(function (e) {

        if (e.which === 32) {

            e.preventDefault();

        }

    }).blur(function () {

        $(this).val(function (i, oldVal) {

            return oldVal.replace(/\s/g, '');

        });


        $("#Visitor_vehicle").val(($("#Visitor_vehicle").val()).toUpperCase());

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

        //if ($("#currentRoleOfLoggedInUser").val() == '<?php echo Roles::ROLE_SUPERADMIN; ?>') {

            /* if role is superadmin tenant is required. Pass selected tenant and tenant agent of user to company. */

            //url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1&tenant='); ?>' + $("#Visitor_tenant").val() + '&tenant_agent=' + $("#Visitor_tenant_agent").val();

        //} else {

            //url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1'); ?>';

        //}submitFormVisitor


        //$("#modalBody").html('<iframe id="companyModalIframe" width="100%" height="80%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');

        //$("#modalBtn").click();

    }

}


function populateTenantAgentAndCompanyField() {

    //$('#Visitor_company option[value!=""]').remove();

 //   $('#Visitor_tenant_agent option[value!=""]').remove();

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
                $("#Visitor_company").val("<?php echo $model->company; ?>");
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

    //$('#Visitor_company option[value!=""]').remove();

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
   // $('#Visitor_company option[value!=""]').remove();

    if ($("#Visitor_tenant_agent").val() == "") {
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

    var form = $("#register-form").serialize();
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
        success: function (data) {
            
            if ($("#currentRoleOfLoggedInUser").val() == 8 || $("#currentRoleOfLoggedInUser").val() == 7) {
                window.location = 'index.php?r=dashboard';
            } else if ($("#currentRoleOfLoggedInUser").val() == 9) {
                window.location = 'index.php?r=dashboard/viewmyvisitors';
            } else {
                window.location = 'index.php?r=visitor/admin&vms=cvms';
            }
        },
        error: function (data) {
            if ($("#currentRoleOfLoggedInUser").val() == 8 || $("#currentRoleOfLoggedInUser").val() == 7) {
                window.location = 'index.php?r=dashboard';
            } else if ($("#currentRoleOfLoggedInUser").val() == 9) {
                window.location = 'index.php?r=dashboard/viewmyvisitors';
            } else {
                window.location = 'index.php?r=visitor/admin&vms=cvms';
            }
        }
    };
    requestRunning = true;
    $.ajax(ajaxOpts);
    return false;
}


function cancel() {
    $('#Visitor_repeatpassword').val('');
    $('#Visitor_password').val('');
    $("#random_password").val('');
    $("#close_generate").click();
}

function copy_password() {
    if ($('#random_password').val() == '') {
        $('#error_msg').show();
    } else {
        $('#Visitor_password').val($('#random_password').val());
        $('#Visitor_repeatpassword').val($('#random_password').val());
        $("#close_generate").click();
    }
}


function generatepassword() {
    $("#random_password").val('');
    $("#pass_option").prop("checked", true);

    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 6; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    document.getElementById('random_password').value = text;
    $("#gen_pass").click();
}

// company change
$('#Visitor_company').on('change', function() {
    var companyId = $(this).val();
//    $('#CompanySelectedId').val(companyId);
//    $modal = $('#addCompanyContactModal');
//    if(!companyId || companyId == ""){
//        $('#Visitor_company_em_').show();
//        $('#Visitor_company_em_').html('Please select a Company');
//    } else {
//        $('#Visitor_company_em_').hide();
//    }
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

        <a data-dismiss="modal" class="close" id="dismissModal">×</a>

        <br>

    </div>

    <div id="modalBody"></div>


</div>


<div class="modal hide fade" id="generate_password" style="width: 410px">
    <div style="border:5px solid #BEBEBE; width:405px">
        <div class="modal-header"
             style=" border:none !important; height: 60px !important;padding: 0px !important;width: 405px !important;">
            <div style="background-color:#E8E8E8; padding-top:2px; width:405px; height:56px;">
                <a data-dismiss="modal" class="close" id="close_generate">×</a>

                <h1 style="color: #000;font-size: 15px;font-weight: bold;margin-left: 9px;padding-top: 0px !important;">
                    Autogenerated Password
                </h1>

            </div>

            <br>
        </div>
        <div id="modalBody_gen">

            <table>

                <div id="error_msg" style='font-size: 0.9em;color: #FF0000;padding-left: 11px; display:none'>Please
                    Generate Password
                </div>

                <tr>
                    <td colspan="2" style="padding-left:10px">Your randomly generated password is :</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left:55px; padding-top:24px;"><input readonly="readonly" type="text" placeholder="Random Password" value="" id="random_password"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="padding-left:10px; font:italic">Note:Please copy and save this password
                        somewhere safe.
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 11px;padding-top: 26px !important; width:50%"><input onclick="copy_password();" style="border-radius: 4px; height: 35px; " type="button" value="Use Password"/></td>
                    <td style="padding-right:10px;padding-top: 25px;"><input onclick="cancel();" style="border-radius: 4px; height: 35px;" type="button" value="Cancel"/></td>
                </tr>

            </table>


        </div>
        <a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none"
           class="btn btn-primary">Click me</a>
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

<div id="fade" class="black_overlay">
</div>
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