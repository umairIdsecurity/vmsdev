<?php
$session = new CHttpSession;
?>
<style type="text/css">
.uploadnotetext{margin-left: -80px;margin-top: 110px;}
.required{ padding-left:10px;}

        .ajax-upload-dragdrop {
            float:left !important;
            margin-top: -30px;
            background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
            background-size:137px;
            height: 150px;
            width: 120px !important;
            padding: 87px 5px 12px 90px;
            margin-left: 20px !important;
            border:none;
        }
        .ajax-file-upload{
            margin-left: -107px !important;
            margin-top: 170px !important;
            position:absolute !important;
            font-size: 12px !important;
            padding-bottom:3px;
            height:17px;
        }

        .editImageBtn{
            margin-left: -103px !important;
            color:white;
            font-weight:bold;
            text-shadow: 0 0 !important;
            font-size:12px !important;
            height:24px;
            width:131px !important;
        }
        .imageDimensions{
            display:none !important;
        }
        #cropImageBtn{
            float: left;
            margin-left: -54px !important;
            margin-top: 218px;
            position: absolute;
        }

</style>
<div id="findAddHostRecordDiv" class="findAddHostRecordDiv form">
    <input type="text" id="sessionRole" value="<?php echo $session['role']; ?>" style="display:none;" >

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'registerhostform',
        'action' => Yii::app()->createUrl('/user/create'),
        'htmlOptions' => array("name" => "registerhostform", "style" => "display:block;"),
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
    <?php echo $form->errorSummary($userModel); ?>
    <input type="text" id="hostEmailIsUnique" value="0"/>
    <div class="visitor-title">Add Host</div>
    <div >
    
    	<table style="width:300px;float:left;">
                            <tr> 

                                <td style="width:300px;">
                                  <div class="ajax-upload-dragdrop" style="vertical-align: top; width: 200px;margin-top:0px;"><div class="actionForward ajax-file-upload btn btn-info" style="position: relative; overflow: hidden; cursor: default;">Upload Photo <form method="POST" action="/vms/index.php?r=site/upload&amp;id=visitor&amp;companyId=&amp;actionId=create" enctype="multipart/form-data" style="margin: 0px; padding: 0px;"><input type="file" id="ajax-upload-id-1429303468602" name="myfile[]" accept="*" multiple="" style="position: absolute; cursor: pointer; top: 0px; width: 100%; height: 100%; left: 0px; z-index: 100; opacity: 0;"></form></div><div class="uploadnotetext"><b>Drag &amp; Drop File</b><br><span style="font-size:10px;">Max Size: 2MB ;File Ext. : jpeg/png<br><span class="imageDimensions">Dimensions: 180px(Width) x 60px(Height)</span></span></div></div>
                                </td>
                                </tr>
                                </table>
        
        <table  id="addhost-table" data-ng-app="PwordForm" style="width:277px;float:left;">
        <tr <?php
                    if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                        echo "style='display:none;'";
                    }
                    ?>>
                    <?php
                    if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                        ?>
                    <td id="hostTenantRow">
                        <select id="User_tenant" onchange="populateHostTenantAgentAndCompanyField()" name="User[tenant]"  >
                            <option value='' selected>Please select a tenant</option>
                            <?php
                            $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                            foreach ($allTenantCompanyNames as $key => $value) {
                                ?>
                                <option value="<?php echo $value['tenant']; ?>" ><?php echo $value['name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                    </td>
                    </tr>
                    <tr <?php
                    if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                        echo "style='display:none;'";
                    }
                    ?>>
                    <td id="hostTenantAgentRow">
                        <select id="User_tenant_agent" name="User[tenant_agent]" onchange="populateHostCompanyWithSameTenantAndTenantAgent()" >
                            <?php
                            echo "<option value='' selected>Please select a tenant agent</option>";
                            ?>
                        </select>
                        <?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                    </td>
                    
                    </tr>
					 <tr <?php
                    if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                        echo "style='display:none;'";
                    }
                    ?>>
                    <td id="hostCompanyRow">
                       
                        <select id="User_company" name="User[company]" disabled>
                            <option value=''>Please select a company</option>
                        </select>
                        <span class="required">*</span>
                       
                        <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                    </td>
                    </tr>
                    <?php
                } else {
                    ?>
                    
                     <tr <?php
                    if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                        echo "style='display:none;'";
                    }
                    ?>>
                    <td id="hostTenantRow">
                        <input type="text" id="User_tenant" name="User[tenant]" value="<?php echo $session['tenant']; ?>"/>
                        <?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                    </td>
                    </tr>
                     <tr <?php
                    if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                        echo "style='display:none;'";
                    }
                    ?>>
                    <td id="hostTenantAgentRow">
                        <input type="text" id="User_tenant_agent" name="User[tenant_agent]" value="<?php echo $session['tenant_agent']; ?>"/>
                        <?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                    </td>
                    
                    </tr>
                    
                     <tr <?php
                    if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                        echo "style='display:none;'";
                    }
                    ?>>

                    <td id="hostCompanyRow">
                        
                        <input type="text" id="User_company" name="User[company]" value="<?php echo $session['company']; ?>"/>
                        
                        <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                    </td>
                    
                    </tr>
                <?php } ?>
            	<tr>
                <td>
                    
                    <?php echo $form->textField($userModel, 'first_name', array('size' => 50, 'maxlength' => 50 ,'placeholder'=>'First Name')); ?>
                    <span class="required">*</span>
                    <?php echo "<br>" . $form->error($userModel, 'first_name'); ?>
                </td>
                </tr>
                <tr>
                <td>
                   
                    <?php echo $form->textField($userModel, 'last_name', array('size' => 50, 'maxlength' => 50 ,'placeholder'=>'Last Name')); ?>
                    <span class="required">*</span>
                    <?php echo "<br>" . $form->error($userModel, 'last_name'); ?>
                </td>
                </tr>
                <tr>
                <td>

                  
                    <?php echo $form->textField($userModel, 'department', array('size' => 50, 'maxlength' => 50 ,'placeholder'=>'Department')); ?>
                    
                    <?php echo "<br>" . $form->error($userModel, 'department'); ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?php echo $form->textField($userModel, 'staff_id', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Staff ID')); ?>
                  
                    <?php echo "<br>" . $form->error($userModel, 'staff_id'); ?>
                </td>
               </tr>
 				<tr>
                <td width="35%">
                    <?php echo $form->textField($userModel, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>
                    <span class="required">*</span>
                    <?php echo "<br>" . $form->error($userModel, 'email'); ?>
                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >A profile already exists for this email address.</div>
                </td>
                </tr>
                 <tr>
                <td>
                    <?php echo $form->textField($userModel, 'contact_number', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact Number')); ?>
                    <span class="required">*</span>
                    <?php echo "<br>" . $form->error($userModel, 'contact_number'); ?>
                </td>
            </tr>


            

            <tr>
                <td style="display:none;">
                    <input name="User[role]" id="User_role" value="<?php echo Roles::ROLE_STAFFMEMBER ?>"/>
                    <input name="User[user_type]" id="User_user_type" value="<?php echo UserType::USERTYPE_INTERNAL; ?>"/>             
                </td>
            </tr>
            
           


        </table>
        
        <table style="float:left; width:280px">
       <tr>
                <td>
                    <input type="password" id="User_password" placeholder="Password" name="User[password]" onChange="checkPasswordMatch();">	
                    <span class="required">*</span>		
                    <?php echo "<br>" . $form->error($userModel, 'password'); ?>
                </td>
             </tr>
				
                 <tr>
                <td>
                    <input type="password" placeholder="Repeat Password" id="User_repeatpassword" name="User[repeatpassword]" onChange="checkPasswordMatch();"/>		
                    <span class="required">*</span>	
                    <div style='font-size:10px;color:red;font-size:0.9em;display:none;margin-bottom:-20px;' id="passwordErrorMessage">New Password does not match with <br>Repeat New Password. </div>
                    <?php echo "<br>" . $form->error($userModel, 'repeatpassword'); ?>
                </td>
            </tr>
            
           
        </table>
        <div style="clear:both;"></div>
        <div style="float:right;padding-right:104px">
        
        <input type="button" id="clicktabC" value="Add" style="display:none;"/>

        <input type="submit" value="Save" name="yt0" id="submitFormUser" class="complete" />
           
            </tr>
        </div>

    </div>
 
    <?php $this->endWidget(); ?>

</div>
<input type="text" id="createUrlForEmailUnique" style="display:none;" value="<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>"/>
<script>
    $(document).ready(function() {
        $("#User_repeatpassword").keyup(checkPasswordMatch);
        $("#User_password").keyup(checkPasswordMatch);

    });
    function sendHostForm() {
        document.getElementById('User_company').disabled = false;
        var hostform = $("#registerhostform").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("user/create")); ?>",
            data: hostform,
            success: function(data) {

//                if ('<?php echo $session['role']; ?>' != 9) { //if not equal to staff member
//                    window.location = "index.php?r=dashboard";
//                } else {
//                    window.location = "index.php?r=dashboard/viewmyvisitors";
//                }

                if ('<?php echo $session['role']; ?>' == 5) {
                    window.location = 'index.php?r=dashboard';
                } else if ('<?php echo $session['role']; ?>' == 1 || '<?php echo $session['role']; ?>' == 6 || '<?php echo $session['role']; ?>' == 8 || '<?php echo $session['role']; ?>' == 7) {
                    window.location = 'index.php?r=dashboard/admindashboard';
                } else if ('<?php echo $session['role']; ?>' == 9) {
                    window.location = 'index.php?r=dashboard/viewmyvisitors';
                }
            },
            error: function() {
                if ('<?php echo $session['role']; ?>' != 9) { //if not equal to staff member
                    window.location = "index.php?r=dashboard";
                } else {
                    window.location = "index.php?r=dashboard/viewmyvisitors";
                }
            },
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

    function checkHostEmailIfUnique() {
        var email = $("#User_email").val();
        var tenant;
        if ($("#sessionRole").val() == 5) { //check if superadmin
            tenant = $("#User_tenant").val();
        } else {
            tenant = '<?php echo $session['tenant']; ?>';
        }
        var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: email,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isTaken == 1) {
                        $(".errorMessageEmail1").show();
                    } else {
                        $(".errorMessageEmail1").hide();
                        sendHostForm();

                    }
                });

            }
        });
    }

    function populateHostCompanyWithSameTenantAndTenantAgent() {
        $('#User_company option[value!=""]').remove();
        getHostCompanyWithSameTenantAndTenantAgent($("#User_tenant").val(), $("#User_tenant_agent").val());
    }

    function getHostCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getCompanyOfTenant&id='); ?>' + $("#User_tenant").val() + '&tenantAgentId=' + $("#User_tenant_agent").val(),
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function populateHostTenantAgentAndCompanyField()
    {
        $('#User_company option[value!=""]').remove();
        $('#User_tenant_agent option[value!=""]').remove();
        var tenant = $("#User_tenant").val();

        getHostTenantAgentWithSameTenant(tenant);
        getHostCompanyWithSameTenant(tenant);

    }

    function getHostTenantAgentWithSameTenant(tenant) {
        $('#User_tenant_agent').empty();
        $('#User_tenant_agent').append('<option value="">Please select a tenant agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('#User_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');
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
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

</script>