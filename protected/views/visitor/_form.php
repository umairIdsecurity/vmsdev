<?php
$session = new CHttpSession;
$dataId = '';
if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}
?>
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
                                if (!hasError){
                                    var vehicleValue = $("#Visitor_vehicle").val();
                                if(vehicleValue.length < 6 && vehicleValue != ""){
                                    $("#Visitor_vehicle_em_").show();
                                    $("#Visitor_vehicle_em_").html("Vehicle should have a min. of 6 characters");
                                } else {
                                    checkEmailIfUnique();
                                    }
                                }
                                }'
        ),
    ));
    ?>
    <input type="hidden" id="emailIsUnique" value="0"/>
    <div>
        <table  id="addvisitor-table" data-ng-app="PwordForm">
            <tr>
                <td>
                    <table>
                        <tr <?php
                        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                            echo " class='hidden' ";
                        }
                        ?>>
                            <td id="visitorTenantRow">
                                <?php echo $form->labelEx($model, 'tenant'); ?>
                            </td>
                            <td>
                                <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()" name="Visitor[tenant]"  >
                                    <option value='' selected>Select Admin</option>
                                    <?php
                                    $allAdminNames = User::model()->findAllAdmin();
                                    foreach ($allAdminNames as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->tenant; ?>"
                                        <?php
                                        if (($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] == $value->tenant && $this->action->id != 'update') || ($model->tenant == $value->tenant)) {
                                            echo "selected ";
                                        }
                                        ?> ><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>
                            </td>
                        </tr>
                        <tr <?php
                        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                            echo " class='hidden' ";
                        }
                        ?>>
                            <td id="visitorTenantAgentRow" >
                                <?php echo $form->labelEx($model, 'tenant_agent'); ?>
                            </td>
                            <td>
                                <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]" onchange="populateCompanyWithSameTenantAndTenantAgent()" >
                                    <?php
                                    echo "<option value='' selected>Select Tenant Agent</option>";
                                    if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                        echo "<option value='" . $session['tenant_agent'] . "' selected>TenantAgent</option>";
                                    }
                                    ?>
                                </select><?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td id="visitorCompanyRow">

                                <?php echo $form->labelEx($model, 'company'); ?>
                            </td>
                            <td>
                                <select id="Visitor_company" name="Visitor[company]" >
                                    <option value=''>Select Company</option>
                                </select>
                                <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none;">
                                    Add New Company</a>
                                <?php echo "<br>" . $form->error($model, 'company'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="Visitor_vehicle">Vehicle Registration Number</label>
                            </td>
                            <td>
                                <input type="text"  id="Visitor_vehicle" name="Visitor[vehicle]" maxlength="6" size="6" value="<?php
                                if ($this->action->id == 'update' && $model->vehicle != "") {
                                    echo Vehicle::model()->findByPk($model->vehicle)->vehicle_registration_plate_number;
                                }
                                ?>">  
                                       <?php echo "<br>" . $form->error($model, 'vehicle'); ?>
                            </td>
                        </tr>

                        <tr> 
                            <td><?php echo $form->labelEx($model, 'Add Photo'); ?></td>
                            <td id="uploadRow" >
                                <input type="hidden" id="Visitor_photo" name="Visitor[photo]"
                                       value="<?php echo $model['photo']; ?>">

                                <div class="photoDiv"  style="<?php
                                if ($model['photo'] == NULL) {
                                    echo "display:none;";
                                }
                                ?>margin-bottom:5px;">
                                     <?php if ($dataId != '') { ?> 
                                        <img id='photoPreview' src="<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($dataId) ?>"/>
                                    <?php } else { ?> 
                                        <img id='photoPreview' src="<?php
                                        if ($this->action->id == 'update' && $model->photo != '') {
                                            echo Yii::app()->request->baseUrl . "/" . Company::model()->getPhotoRelativePath($model->photo);
                                        }
                                        ?>

                                             " />
                                         <?php } ?>
                                </div>

                                <?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'first_name'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'last_name'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->labelEx($model, 'email'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($model, 'email'); ?>
                                <div style="" class="errorMessageEmail" >Email Address has already been taken.</div>

                            </td>
                        </tr>
                        <tr>

                            <td>
                                <?php echo $form->labelEx($model, 'contact_number'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($model, 'contact_number'); ?>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <?php echo $form->labelEx($model, 'position'); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50)); ?>
                                <?php echo "<br>" . $form->error($model, 'position'); ?>
                            </td>

                        </tr>
                        <?php if ($this->action->id != 'update') {
                            ?>
                            <tr>
                                <td>
                                    <label for="Visitor_password">Password <span class="required">*</span></label>
                                </td>
                                <td>
                                    <input ng-model="user.passwords" data-ng-class="{
                                                    'ng-invalid':registerform['Visitor[repeatpassword]'].$error.match}" type="password" id="Visitor_password" name="Visitor[password]">			
                                           <?php echo "<br>" . $form->error($model, 'password'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="Visitor_repeatpassword">Repeat Password <span class="required">*</span></label>
                                </td>
                                <td>
                                    <input ng-model="user.passwordConfirm" type="password" id="Visitor_repeatpassword" data-match="user.passwords" name="Visitor[repeatpassword]"/>			
                                    <div style='font-size:0.9em;color:red;position: static;' data-ng-show="registerform['Visitor[repeatpassword]'].$error.match">Password does not match with Repeat <br> Password. </div>
                                    <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>


            <input type="text" name="Visitor[visitor_status]" value="<?php echo VisitorStatus::VISITOR_STATUS_SAVE; ?>" style='display:none;'>

        </table>

    </div>
    <div class="register-a-visitor-buttons-div" >
        <br><br><input type="submit" value="Save" name="yt0" id="submitFormVisitor" class="complete" />
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
    $(document).ready(function() {
        if ($("#currentAction").val() == 'update') {
            if ($("#Visitor_photo").val() != '') {
                $("#cropImageBtn").show();
            }
            if ($("#currentRoleOfLoggedInUser").val() != 5) {
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
            $("#Visitor_vehicle").val("");

            if ($("#currentRoleOfLoggedInUser").val() != 5) {
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
                    imageUrl: $('#photoPreview').attr('src').substring(1, $('#photoPreview').attr('src').length),
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
                            });

                            $("#closeCropPhoto").click();
                            var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                            ias.cancelSelection();
                        }
                    });
                }
            });
        });

//        $('#Visitor_vehicle').bind('keypress', function(event) {
//            var regex = new RegExp("^[a-zA-Z0-9\b]+$");
//            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
//            if (!regex.test(key)) {
//                event.preventDefault();
//                return false;
//            }
//        });

        $('#Visitor_vehicle').keydown(function(e) {
            if (e.which === 32) {
                e.preventDefault();
            }
        }).blur(function() {
            $(this).val(function(i, oldVal) {
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
                url: '<?php echo Yii::app()->createUrl('visitor/checkEmailIfUnique&id='); ?>' + email,
                dataType: 'json',
                data: email,
                success: function(r) {
                    $.each(r.data, function(index, value) {
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
            $("#Visitor_company_em_").html("Please select a tenant.");
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

    function populateTenantAgentAndCompanyField()
    {
        $('#Visitor_company option[value!=""]').remove();
        $('#Visitor_tenant_agent option[value!=""]').remove();
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
        $('#Visitor_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('#Visitor_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#Visitor_tenant_agent").val(selected);
            }
        });


    }

    function getCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });

                if ($("#currentAction").val() == 'update') {
                    $("#Visitor_company").val("<?php echo $model->company; ?>")
                }
            }
        });
    }

    function populateCompanyWithSameTenantAndTenantAgent() {
        $('#Visitor_company option[value!=""]').remove();
        getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
    }

    function getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });

                if ($("#currentAction").val() == 'update') {
                    $("#Visitor_company").val("<?php echo $model->company; ?>")
                }
            }
        });
    }

    function dismissModal(id) {
        $("#dismissModal").click();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('company/GetCompanyList&lastId='); ?>',
            dataType: 'json',
            success: function(r) {
                $('#Visitor_company option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $("#Visitor_company").val(value.id);
                });
            }
        });
    }

    function sendVisitorForm() {
        var form = $("#register-form").serialize();
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
            success: function(data) {
                window.location = 'index.php?r=visitor/admin';
            },
        });
    }
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
    <?php if ($this->action->id == 'addvisitor') { ?>
        <img id="photoCropPreview" src="">
    <?php } elseif ($this->action->id == 'update') { ?>
        <img id="photoCropPreview" src="<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($model->id) ?>">

    <?php } ?>
</div>
<div id="fade" class="black_overlay"></div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>



