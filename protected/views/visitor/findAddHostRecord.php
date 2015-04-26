<?php $session = new CHttpSession;
$company = Company::model()->findByPk($session['company']);
$companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
 ?>
<div role="tabpanel">

    <!-- Nav tabs -->
    
         <div style="float:left;width:280px">
    <div class="visitor-title-host" style="cursor:pointer;color:#2f96b4;font-size: 18px;font-weight: bold;margin: 5px 0;padding-left: 85px;">Add Host</div>
    </div>
        
        
       <div role="tabpanel" class="tab-pane" id="searchost" style="width:882px">
            <div id="searchHostDiv">
                <div>
                   <!-- <label><b>Search Name:</b></label> -->
                    <input type="text" id="search-host"  style="width:370px"name="search-host" placeholder="Enter name, email address" class="search-text"/> 
                    <button class="host-findBtn" onclick="findHostRecord()" id="host-findBtn" style="display:none;" data-target="#findHostRecordModal" data-toggle="modal">Search Visits</button>
                    <button class="host-findBtn" id="dummy-host-findBtn" style="padding: 8px;background:<?php echo $companyLafPreferences->neutral_bg_color; ?> !important;">Find Host</button>
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
            <div class="register-a-visitor-buttons-div" id="subm" style="padding-right:20px">
                <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                <input type="button" id="clicktabB2"  value="Save and Continue" class="actionForward"/>
            </div>
        </div>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="addhost">

            <div id="findAddHostRecordDiv" class="findAddHostRecordDiv form">

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
                <div style="" id="Patient_name_error" class="errorMessage Patient_name_error" >Patient Name has already been taken.</div>

                <input type="text" id="patientIsUnique" value="0"/><br>
                <div class="register-a-visitor-buttons-div">
                    <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                    <input type="submit" value="Save and Continue" name="yt0" id="submitFormPatientName" style="display:inline-block;" class="actionForward"/>

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
                    <?php echo $form->errorSummary($userModel); ?>
                    <input type="text" id="hostEmailIsUnique" value="0"/>
                    
                    <div>
                    
                    <table style="width:300px;float:left;">
                            <tr> 

                                <td style="width:300px;">
                                   <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->

                                    <input type="hidden" id="Host_photo" name="User[photo]">
                                    <div class="photoDiv" style='display:none;'>
                                        <img id='photoPreview2' src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png" style='display:none;'/>
                                    </div>
                                    <?php require_once(Yii::app()->basePath . '/draganddrop/host.php'); ?>
                                    <div id="photoErrorMessage" class="errorMessage" style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">Please upload a photo.</div>
                                </td>
                                </tr>
                               
                                <tr><td>&nbsp;</td></tr>
                               
                               
                              </table>
                        <table  id="addhost-table" style="width: 492px;float: left;">
                              
                                <tr <?php if ($session['role'] != Roles::ROLE_SUPERADMIN){ echo "style='display:none;'";} ?> >
                                  <td id="hostTenantRow">

                                    <select id="User_tenant" onchange="populateHostTenantAgentAndCompanyField()" name="User[tenant]" disabled >
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
                                    </select><?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                                </td>
                                </tr>
                                <tr <?php if ($session['role'] != Roles::ROLE_SUPERADMIN){ echo "style='display:none;'";} ?> >
                                <td id="hostTenantAgentRow">

                                    <select id="User_tenant_agent" name="User[tenant_agent]" onchange="populateHostCompanyWithSameTenantAndTenantAgent()" disabled>
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
                                    <?php echo $form->textField($userModel, 'first_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?> <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'first_name'); ?>
                                </td>
                            </tr>  
                            <tr>  
                                <td>
                                    <?php echo $form->textField($userModel, 'last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?><span class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'last_name'); ?>
                                </td>
                             </tr>  
                            <tr>     
                                <td>
                                    <?php echo $form->textField($userModel, 'department', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Department')); ?>
                                    <?php echo "<br>" . $form->error($userModel, 'deprtment'); ?>
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
                                    <?php echo $form->textField($userModel, 'email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email Address')); ?><span class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'email',array('style'=>'text-transform:none;')); ?>
                                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >A profile already exists for this email address.</div>
                                </td>
                            </tr>  
                            <tr>      
                                <td>
                                    <?php echo $form->textField($userModel, 'contact_number', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact No. ')); ?><span class="required">*</span>
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
                                    <label for="User_repeatpassword">Repeat Password <span class="required">*</span></label><br>
                                    <input type="password" id="User_repeatpassword" name="User[repeatpassword]" onChange="checkPasswordMatch();" value="(NULL)"/>			
                                    <div style='font-size:10px;color:red;font-size:0.9em;display:none;margin-bottom:-20px;' id="passwordErrorMessage">New Password does not match with <br>Repeat New Password. </div>
                                    <?php echo "<br>" . $form->error($userModel, 'repeatpassword'); ?>
                                </td>
                             </tr>  
                            <tr>  
                                <td id="hostCompanyRow" <?php
                                if ($session['role'] == Roles::ROLE_AGENT_ADMIN || $session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR || $session['role'] == Roles::ROLE_STAFFMEMBER) {
                                    echo "style='display:none;'";
                                }
                                ?>>

                                     <select id="User_company" disabled name="User[company]" >
                                        <option value=''>Please select a company</option>
                                        <?php
                                        if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                                            echo "<option value='" . $session['company'] . "' selected>Company</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="required">*</span>
                                    <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                                </td>
                             </tr>  
                            <tr>     
                                <td >
                                    <input name="User[role]" id="User_role" value="<?php echo Roles::ROLE_STAFFMEMBER ?>"/>
                                    <input name="User[user_type]" id="User_user_type" value="<?php echo UserType::USERTYPE_INTERNAL; ?>"/>
                                </td>
                            </tr>
                            
                           <tr>     
                                <td > 
                             <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                        <input type="button" id="clicktabC" value="Save and Continue" style="display:none;"/>

                        <input type="submit" value="Save and Continue" name="yt0" id="submitFormHost" class="actionForward"/>
                                 </td>
                            </tr>
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
                             $userStaffMemberModel = User::model()->findByPk($session['id']);
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

                                    <input type="hidden" id="Host_photo3" name="User[photo]" >
                                    <div class="photoDiv3" style='display:none;'>
                                        <img id='photoPreview3' src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png" style='display:none;'/>
                                    </div>
                                    <?php require_once(Yii::app()->basePath . '/draganddrop/host3.php'); ?>
                                    <div id="photoErrorMessage" class="errorMessage" style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">Please upload a photo.</div>
                                </td>
                                </tr>
                               
                                <tr><td>&nbsp;</td></tr>
                               
                               
                              </table>
                        <table  id="currentHostDetails" style="width: 300px;  float: left;">

                            <tr>
                                <td>

                                    
                                    <?php
       echo $staffmemberform->textField($userStaffMemberModel, 'first_name', array(
                                        'size' => 50, 'maxlength' => 50, 'disabled' => 'disabled'
                                    ));
                                    ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'first_name'); ?>
                                </td>
                                  <tr>
                                </tr>
                                <td>
                                  
                                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'last_name', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'last_name'); ?>
                                </td>
                                  <tr>
                                </tr>
                                <td>

                                  
                                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'department', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'department'); ?>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    
                                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'staff_id', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'staff_id'); ?>
                                </td>
                                   <tr>
                                </tr>
                                <td>
                                  
                                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'email', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'email'); ?>
                                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >A profile already exists for this email address.</div>
                                </td>
                                  <tr>
                                </tr>
                                <td>
                                  
                                    <?php echo $staffmemberform->textField($userStaffMemberModel, 'contact_number', array('size' => 50, 'maxlength' => 50, 'disabled' => 'disabled')); ?>
                                    <?php echo "<br>" . $staffmemberform->error($userStaffMemberModel, 'contact_number'); ?>
                                </td>
                            </tr>
                        </table>
                        <?php $this->endWidget(); ?>
                        <div class="register-a-visitor-buttons-div"  style="padding-right:67px;float:left;">
                            <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>

                            <input type="button" id="saveCurrentUserAsHost" value="Save and Continue" />

                        </div>

                    </div>

                </div>

                <script>
                    $(document).ready(function() {
						$("#subm").hide();
						$( ".visitor-title-host" ).click(function() {
	
  		$('.tab-content').show();
		$(".data-ifr").hide();
		$("#subm").hide();
});
                        $("#dummy-host-findBtn").click(function(e) {
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
                        $("#saveCurrentUserAsHost").click(function(e) {
                            e.preventDefault();
                            if ('<?php echo $session['role']; ?>' != '9') {
                                $("#selectedHostInSearchTable").val($("#Visit_host").val());
                                $("#hostId").val($("#Visit_host").val());
                            } else {
                                $("#selectedHostInSearchTable").val('<?php echo $session['id']; ?>');
                                $("#hostId").val('<?php echo $session['id']; ?>');
                            }
                            $("#Host_attach_photo").val($("#Host_photo3").val());
							
                            $("#search-host").val('staff');
                            $("#clicktabB2").click();
                        });

                        $(".host-AddBtn").click(function(e) {
                            e.preventDefault();
                            $("#register-host-form").show();
                            $("#searchHostDiv").show();
                            $("#currentHostDetailsDiv").hide();
                            $(".host-AddBtn").hide();
                            $("#addhostTab").click();
                        });
						
												
						
						  $('#photoCropPreview2').imgAreaSelect({
            handles: true,
            onSelectEnd: function(img, selection) {
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
        $("#cropPhotoBtn2").click(function(e) {
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
                    imageUrl: $('#photoCropPreview2').attr('src').substring(1, $('#photoCropPreview2').attr('src').length),
                    photoId: $('#Host_photo').val()
                },
                dataType: 'json',
                success: function(r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Host_photo').val(),
                        dataType: 'json',
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                                document.getElementById('photoPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview2').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop2").css("background", "url(<?php echo Yii::app()->request->baseUrl. '/'; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop2").css({
                                    "background-size": "137px 190px"
                                });
                            });
                        }
                    });

                    $("#closeCropPhoto2").click();
                    var ias = $('#photoCropPreview2').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

						
						
						/*			photo 3			*/
						
						
						
						  $('#photoCropPreview3').imgAreaSelect({
            handles: true,
            onSelectEnd: function(img, selection) {
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
        $("#cropPhotoBtn3").click(function(e) {
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
                    imageUrl: $('#photoCropPreview3').attr('src').substring(1, $('#photoCropPreview3').attr('src').length),
                    photoId: $('#Host_photo3').val()
                },
                dataType: 'json',
                success: function(r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Host_photo3').val(),
                        dataType: 'json',
                        success: function(r) {

                            $.each(r.data, function(index, value) {
                                document.getElementById('photoPreview3').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview3').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                $(".ajax-upload-dragdrop3").css("background", "url(<?php echo Yii::app()->request->baseUrl. '/'; ?>" + value.relative_path + ") no-repeat center top");
                                $(".ajax-upload-dragdrop3").css({
                                    "background-size": "137px 190px"
                                });
                            });
                        }
                    });

                    $("#closeCropPhoto3").click();
                    var ias = $('#photoCropPreview3').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });

						
						
/*			end of module			*/
						
                    });

                    function findHostRecord() {
                        $("#host_fields_for_Search").hide();
                        $("#selectedHostInSearchTable").val("");
                        $("#searchHostTableDiv h4").html("Search Results for : " + $("#search-host").val());
                        $("#searchHostTableDiv").show();
						$(".tab-content").hide();
						$("#subm").show();
						$(".data-ifr").show();
                        // $("#register-host-form").hide();
                        $("#register-host-patient-form").hide();
                        //append searched text in modal
                        var searchText = $("#search-host").val();
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
                        var url = 'index.php?r=visitor/findhost&id=' + searchText + '&visitortype=' + $("#Visitor_visitor_type").val() + '&tenant=' + tenant + '&tenant_agent=' + tenant_agent;
                        $("#searchHostTable").html('<iframe id="findHostTableIframe" onLoad="autoResize2();" width="100%" height="100%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
                    }

                    function autoResize2() {
                        var newheight;

                        if (document.getElementById) {
                            newheight = document.getElementById('findHostTableIframe').contentWindow.document.body.scrollHeight;
                        }
                        document.getElementById('findHostTableIframe').height = (newheight - 60) + "px";
                    }

                    function sendHostForm() {

                        var hostform = $("#register-host-form").serialize();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo CHtml::normalizeUrl(array("user/create&view=1")); ?>",
                            data: hostform,
                            success: function(data) {
                                getLastHostId(function(data) {
                                    populateVisitFormFields(); // Do what you want with the data returned
                                });
                            },
                        });
                    }

                    function sendPatientForm() {
                        var patientForm = $("#register-host-patient-form").serialize();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo CHtml::normalizeUrl(array("patient/create")); ?>",
                            data: patientForm,
                            success: function(data) {
                                getLastPatientId(function(data) {
                                    populateVisitFormFields(); // Do what you want with the data returned
                                });
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


                </script>


                <input type="text" id="hostId" placeholder="host id"/>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="searchost">
            
            <div class="register-a-visitor-buttons-div">
                <input type="button" class="neutral visitor-backBtn btnBackTab3" id="btnBackTab3" value="Back"/>
                <input type="button" id="clicktabB2"  value="Save and Continue" class="actionForward"/>
            </div>
        </div>
    </div>

</div>


<!-- PHOTO CROP-->
<div id="light2" class="white_content">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn2" value="Crop" style="">
        <input type="button" id="closeCropPhoto2" onclick="document.getElementById('light2').style.display = 'none';
                document.getElementById('fade2').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
    <br>
    <img id="photoCropPreview2" src="">

</div>
<div id="fade2" class="black_overlay"></div>

<input type="hidden" id="x12"/>
<input type="hidden" id="x22"/>
<input type="hidden" id="y12"/>
<input type="hidden" id="y22"/>
<input type="hidden" id="width2"/>
<input type="hidden" id="height2"/>


<!-- PHOTO CROP-->
<div id="light3" class="white_content">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn3" value="Crop" style="">
        <input type="button" id="closeCropPhoto3" onclick="document.getElementById('light3').style.display = 'none';
                document.getElementById('fade3').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
    <br>
    <img id="photoCropPreview3" src="">

</div>
<div id="fade3" class="black_overlay"></div>

<input type="hidden" id="x13"/>
<input type="hidden" id="x23"/>
<input type="hidden" id="y13"/>
<input type="hidden" id="y23"/>
<input type="hidden" id="width3"/>
<input type="hidden" id="height3"/>