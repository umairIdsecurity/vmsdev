<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-birthday.js');
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$session = new CHttpSession;
$currentRoleinUrl = '';
if (isset($_GET['role'])) {
    $currentRoleinUrl = $_GET['role'];
}

$currentlyEditedUserId = '';
if (isset($_GET['id'])) {
    $currentlyEditedUserId = $_GET['id'];
}

$currentLoggedUserId = $session['id'];
$company = Company::model()->findByPk($session['company']);
$companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
?>
<style type="text/css">
	#modalBody_gen {padding-top: 10px !important;height: 204px !important;}
	#addCompanyLink {
	    display: block;
	    height: 23px;
	    margin-right: 0;
	    padding-bottom: 0;
	    padding-right: 0;
	    width: 124px;
	}
	.uploadnotetext{margin-left: -80px;margin-top: 79px;}
	.required{ padding-left:10px;}

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
	.ajax-file-upload{
		margin-left: -100px !important;
		margin-top: 128px !important;
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
	.required {
		padding-left:10px;
	}
	#content h1 {
		color: #E07D22;
		font-size: 18px;
		font-weight: bold;
		margin-left:75px;
	}
	
	select.asic-date{
		width:70px;
	}
	
	.select2 {
		margin: 0.2em 0 0.5em;
	}
</style>



<div class="form" data-ng-app="PwordForm">
<?php if($this->action->id == 'update') {
echo '<h1>Edit '.Roles::$labels[Yii::app()->request->getParam('role')].'</h1>';	

}else{
echo '<h1>Add '.Roles::$labels[Yii::app()->request->getParam('role')].'</h1>';

}?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'userform',
        'action' => array('user/create','role'=>Yii::app()->request->getParam('role')),
        'htmlOptions' => array("name" => "userform"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
							
							
							
							if($(".pass_option").is(":checked")== false){
							
							$("#pass_error_").show();
							
							$("#User_password_em_").html("select one option");	
							}
							else if($(".pass_option").is(":checked")== true && $(".pass_option:checked").val()==1 && ($("#User_password").val()== "" || $("#User_repeat_password").val()=="")){
							   
                            $("#pass_error_").show();
							$("#pass_error_").html("type password or generate");	
                            	
							}
							
                            else if($("#User_role").val() == 7 && $("#User_tenant_agent").val() == "" && $("#currentRole").val() != 6){
                                $("#User_tenant_agent_em_").show();
                                $("#User_tenant_agent_em_").html("Please select a tenant agent");
                            }
							
                            else if($("#User_password").val() != $("#User_repeat_password").val()){
                                $("#User_tenant_agent_em_").hide();
                                $("#User_password_em_").show();
                                $("#User_password_em_").html("Password does not match with repeat password");
                             }
							 
							  else {
                                $("#User_password_em_").hide();
                                checkHostEmailIfUnique();
                                
                                }
                                
                                }
                        }'
        ),
    ));
    ?>


    <?php echo $form->errorSummary($model); ?>
    <table >
        <tr>
         <td style="vertical-align: top; float:left; width:300px">
        
        <table style="width:300px;float:left;min-height:320px;">
                            <tr> 

                                <td style="width:300px;">
                                   <!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->

                                    <input type="hidden" id="Host_photo" name="User[photo]" value="<?php echo $model->photo; ?>">
                                    <div class="photoDiv" style='display:none;'>
                                        <img id='photoPreview2' src="<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png" style='display:none;'/>
                                    </div>
                                    <?php require_once(Yii::app()->basePath . '/draganddrop/host.php'); ?>
                                    <div id="photoErrorMessage" class="errorMessage" style="display:none;  margin-top: 200px;margin-left: 71px !important;position: absolute;">Please upload a photo.</div>
                                </td>
                                </tr>
                               
                                <tr><td >&nbsp;</td></tr>
                               
                               
                              </table>
                              
                            
         
         </td>
        
            <td style="vertical-align: top; float:left; width:300px;">
                <table>
                
                	<tr>
                        <td><?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>
                        <span class="required">*</span>
                        
                            <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>
                        <span class="required">*</span>
                            <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="User_email" placeholder="Email" name="User[email]" maxlength="50" size="50"  value="<?php echo $model->email; ?>"/>
                           <span class="required">*</span>
                            <?php echo "<br>" . $form->error($model, 'email', array('style' => 'text-transform:none;')); ?>
                            <span class="errorMessageEmail1" style="display:none;color:red;font-size:0.9em;">A profile already exists for this email address</span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->textField($model, 'contact_number', array('size' => 50, 'placeholder'=>'Mobile Number')); ?>
                        <span class="required">*</span>
                            <?php echo "<br>" . $form->error($model, 'contact_number'); ?></td>
                    </tr>

                    <?php   if(!CHelper::is_accessing_avms_features() || Yii::app()->request->getParam("role") == Roles::ROLE_AGENT_AIRPORT_ADMIN ){ ?>
                      <tr id="tenantRow" class='hiddenElement'>
                        <td>
                            <select id="User_tenant" name="User[tenant]"  >
                                <option value='' selected>Please select a tenant</option>
                                <?php
                                $allTenantCompanyNames = User::model()->findAllCompanyTenant();
                                foreach ($allTenantCompanyNames as $key => $value) {
                                    ?>
                                    <option <?php
                                    if (($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_AGENT_ADMIN) && $session['tenant'] == $value['tenant']) {
                                        echo " selected "; //if logged in is agent admin and tenant of agent admin = admin id in adminList
                                    }
                                    ?> value="<?php echo $value['tenant']; ?>"><?php echo $value['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                            </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>
                        </td>
                    </tr>
                    <tr id="tenantAgentRow" class='hiddenElement'>
                        
                        <td>
                            <select id="User_tenant_agent" onchange='getCompanyTenantAgent()' name="User[tenant_agent]" >

                                <?php
                                if ($this->action->Id != 'create' || isset($_POST['User'])) {

                                    $allAgentAdminNames = User::model()->findAllTenantAgent($model['tenant_agent']);
                                    foreach ($allAgentAdminNames as $key => $value) {
                                        ?>
                                        <option <?php
                                        if ($session['role'] == Roles::ROLE_AGENT_ADMIN && $session['tenant_agent'] == $value['id']) {
                                            echo " selected "; //if logged in is agent admin and tenant agent of logged in user is = agentadminname
                                        }
                                        ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                    } else {
                                        echo "<option value='' selected>Please select a tenant agent</option>";
                                    }
                                    ?>
                            </select>
							<span class="required tenantField">*</span>
							<?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                        </td>
                    </tr>
                    <?php  } ?>

                    <tr id="companyTr">
                        <td id='companyRow'>
                        	<?php
	                        	$companyList = array();
	                        	$selectedItem = array();
	                        	
	                        	if (isset($_GET['role'])) {
	                        		$urlRole = $_GET['role'];
	                        	} else {
	                        		$urlRole = '';
	                        	}
	                        	if ( $this->action->id != 'create' || $session['role'] == Roles::ROLE_ADMIN || $urlRole == Roles::ROLE_ADMIN ||
	                        		$session['role'] == Roles::ROLE_AGENT_ADMIN || $urlRole == Roles::ROLE_AGENT_ADMIN || CHelper::is_accessing_avms_features())
	                        	{
	                        		$companyList = CHtml::listData(Company::model()->findAllCompany(), 'id', 'name');
	                        		
	                        		if ($this->action->id == 'update') {
	                        			$companyId = User::model()->getCompany($currentlyEditedUserId);
	                        		} elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
	                        			$companyId = User::model()->getCompany($currentLoggedUserId);
	                        		}
	                        		if (isset($company) && isset($company->id)) {
	                        			$selectedItem[] = $company->id;
	                        		} else {
	                        			$selectedItem[] = $companyId;
	                        		}
								}
								
	                        	$this->widget('application.extensions.select2.Select2', array(
	                        		'model' => $model,
	                        		'attribute' => 'company',
	                        		'items' => $companyList,
	                        		'selectedItems' => $selectedItem, // Items to be selected as default
	                        		'placeHolder' => 'Please select a company',
            
	                        	));
                        	?>
                        	
                            <span class="required">*</span>
                            
                            <select id="User_company_base" style="display:none;">
                                <?php
                                $criteria = new CDbCriteria();
                                if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                                    $criteria->addCondition("tenant='" . $session['tenant'] . "' and id!= 1 and id!=" . $session['company']);
                                } else {
                                    $criteria->addCondition("id!= 1");
                                }
                                $companyList = CHtml::listData(Company::model()->findAllCompany(), 'id', 'name');
                                foreach ($companyList as $key => $value) {
                                    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            
                            <a onclick="addCompany()" id="addCompanyLink" style="text-decoration: none; display:none;">Add New Company</a>
                            <?php echo $form->error($model, 'company'); ?>
                        </td>
                        <td></td></tr>

                    <?php if(!CHelper::is_managing_avms_user()) {?>
                    <tr>
                        <td><?php echo $form->textField($model, 'department', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Department')); ?>
                            <?php echo "<br>" . $form->error($model, 'department'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Postion')); ?>
                            <?php echo "<br>" . $form->error($model, 'position'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->textField($model, 'staff_id', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Staff ID')); ?>
                            <?php echo "<br>" . $form->error($model, 'staff_id'); ?></td>
                    </tr>

                   <?php } ?>
                    <tr>
                        <td class="birthdayDropdown">
                            <input type="hidden" id="dateofBirthBreakdownValueYear" value="<?php echo date("Y", strtotime($model->date_of_birth)); ?>">
                            <input type="hidden" id="dateofBirthBreakdownValueMonth" value="<?php echo date("n", strtotime($model->date_of_birth)); ?>">
                            <input type="hidden" id="dateofBirthBreakdownValueDay" value="<?php echo date("j", strtotime($model->date_of_birth)); ?>">
							
                            <select id="fromDay" name="User[birthdayDay]" class='daySelect'></select>
                            <select id="fromMonth" name="User[birthdayMonth]" class='monthSelect'></select>
                            <select id="fromYear" name="User[birthdayYear]" class='yearSelect'></select>
                        </td>
                    </tr>
                    
                    

                    <tr >
                        <td class="workstationRow">
                            <select id="User_workstation" name="User[workstation]" disabled></select>
                        </td>
                        <td class="workstationRow"></td>
                    </tr>



                    <!-- AVMS User specific form fields -->
                    <?php if ( CHelper::is_managing_avms_user() || $model->is_avms_user()){ ?>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'asic_no', array('size' => 50, 'maxlength' => 9,'placeholder'=>'ASIC No', 'autocomplete'=>'off')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'asic_no'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="AsicExpiryDropdown">
                                <label>ASIC Expiry</label><span class="required">*</span><br />

                                <?php
                                $days = [];
                                for($i=1;$i<=31;$i++){$days[$i] = $i;}
                                ?>
                                <?php echo $form->dropDownList($model,'asic_expiry_day',$days,['class'=>'asic-date']); ?>

                                <?php $mon = ['Jan', 'Feb', 'Mar','Apr','May','Jun','Jul', 'Aug','Sept','Oct','Nov', 'Dec']; ?>
                                <?php echo $form->dropDownList($model,'asic_expiry_month',array_combine($mon, $mon),['class'=>'asic-date']); ?>


                                <?php
                                $years = [];
                                $this_year = date('Y');
                                for($i=$this_year;$i< $this_year+10;$i++){ $years[$i] = $i;}
                                ?>
                                <?php echo $form->dropDownList($model,'asic_expiry_year',$years,['class'=>'asic-date']); ?>


                                <?php echo "<br>" . $form->error($model, 'asic_expiry'); ?>
                                <?php echo "<br>" . $form->error($model, 'asic_expiry_day'); ?>
                            </td>
                        </tr>
                    <?php } ?>


                </table>
            </td>
            <td style="vertical-align: top; float:left; width:300px">
                
                    <table class="no-margin-bottom">
                                <tr>
                        <td>
                            <select  onchange="populateDynamicFields()" <?php
                           // if ($this->action->Id == 'create' && isset($_GET['role']) && $_GET['role'] != 'avms' ) { //if action create with user roles selected in url
                            if ($this->action->Id == 'create' && !CHelper::is_add_avms_user() ) { //if action create with user roles selected in url
                                echo "disabled";
                            }
                            ?> id="User_role" name="User[role]">
                                <option disabled value='' selected>Select Role</option>
                                <?php

                                $assignableRowsArray = getAssignableRoles($session['role'],$model); // roles with access rules from getaccess function
                                foreach ($assignableRowsArray as $assignableRoles) {
                                    foreach ($assignableRoles as $key => $value) {
                                        ?>

                                        <option id= "<?php echo $key; ?>" value="<?php echo $key; ?>" <?php
                                        if (isset($_GET['role'])) { //if url with selected role 
                                            if ($currentRoleinUrl == $key) {
                                                echo "selected ";
                                            }
                                        } elseif ($this->action->Id == 'update') { //if update and $key == to role of user being updated
                                            if ($key == $model->role) {
                                                echo " selected ";
                                            }
                                        }
                                        ?>>
                                            <?php echo $value; ?></option>
                                        <?php
                                    }
                                }
                                ?>

                            </select><?php echo "<br>" . $form->error($model, 'role'); ?></td>

                    </tr>
                    <?php  if( ! CHelper::is_add_avms_user() ) { // Don't Show UserType for AVMS Users' ?>
                    <tr>
                        
                        <td><?php echo $form->dropDownList($model, 'user_type', User::$USER_TYPE_LIST); ?>
                            <?php echo "<br>" . $form->error($model, 'user_type'); ?>
                        </td>
                    </tr>
                    <?php } else {
                         echo $form->hiddenField($model, 'user_type', array("value"=>"1"));  
                    } ?>		
                    <tr>
                        <td><?php echo $form->dropDownList($model, 'user_status', User::$USER_STATUS_LIST); ?>
                            <?php echo "<br>" . $form->error($model, 'user_status'); ?>
                        </td>

                    </tr>
                                
                </table>
                
                <table>
                   <tr>
                        <td>
						<?php echo $form->textfield($model, 'notes', array('placeholder'=>'Notes','style'=>'width:205px;')); ?>
                            <?php echo "<br>" . $form->error($model, 'notes'); ?>
                        </td>

                    </tr>
                  </table>
                  <div class="password-border">
                  <table class="no-margin-bottom">
                    <tr>
                  <td><strong>Password Options</strong></td>
                  
                  </tr>  
                   
                  
                  <tr>
                  <td>
                  <table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
                    <tr>
                    <td id="pass_error_" style='font-size: 0.9em;color: #FF0000; display:none'>Select Atleast One option</td>
                    </tr>
                    
                    
                    
                   <tr id="third_option" class='hiddenElement'>
                   
                   </tr> 
                    
                   <tr>
                   <td><input type="radio" value="1" class="pass_option" name="User[password_option]" />&nbsp;Create Password</td>
                   </tr> 
                   <tr>
                  
                    <td>
                        <input ng-model="user.passwords" data-ng-class="{'ng-invalid':userform['User[repeatpassword]'].$error.match}" placeholder="Password" type="password" id="User_password" value = '<?php echo $model->password; ?>' name="User[password]">
                    <span class="required">*</span>                                                                        		
                               <?php echo "<br>" . $form->error($model, 'password'); ?>
                    </td>
                </tr>
                   <tr >
                    <td >
                        <input ng-model="user.passwordConfirm" placeholder="Repeat Password" type="password" id="User_repeat_password" data-match="user.passwords" name="User[repeatpassword]"/>			
                        <div style='font-size: 0.9em;color: #FF0000;'  data-ng-show="userform['User[repeatpassword]'].$error.match">New Password does not match with <br>Repeat New Password. </div>
                      <span class="required">*</span>
                        <?php echo "<br>" . $form->error($model, 'repeatpassword'); ?>
                    </td>

                </tr>
                
                <tr>
                <td align="center">
                    <div class="row buttons" style="margin-left:23.5px;">
                    
                    <?php $background = isset($companyLafPreferences) ? ("background:" . $companyLafPreferences->neutral_bg_color . ' !important;') : ''; ?>
                    <input onclick="generatepassword();" class="complete btn btn-info" style="<?php echo $background; ?>position: relative; width:178px; overflow: hidden; cursor: default;cursor:pointer;font-size:14px" type="button" value="Autogenerate Password" />
                        
                    </div>
    			
   				 </td>
                </tr>
                
                 <tr>
                   <td><input class="pass_option" type="radio" name="User[password_option]" value="2"/>&nbsp;Send User Invitation</td>
                   </tr>
                   
                 </table>
                 </td>
                 </tr>

                    <tr>
                        <td>
                            
                        </td>
                    </tr>

                </table>
                </div> <!-- password-border -->
                <div class="row buttons ">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('id' => 'submitForm', 'class' => 'complete')); ?>
                </div>
            </td>
            
        </tr>



    </table>
   

    <?php $this->endWidget(); ?>

</div> 

<input type="hidden" id="currentAction" value="<?php echo $this->action->Id; ?>"/>
<input type="hidden" id="currentRole" value="<?php echo $session['role']; ?>"/>
<input type="hidden" id="userId" value="<?php echo $currentlyEditedUserId; ?>"/>
<input type="hidden" id="selectedUserId" value="<?php echo $session['id']; ?>"/>
<input type="hidden" id="getRole" value="<?php echo $currentRoleinUrl; ?>"/>
<input type="hidden" id="sessionCompany" value="<?php
if ($session['role'] != Roles::ROLE_SUPERADMIN) {
    echo User::model()->getCompany($currentLoggedUserId);
} else if ($this->action->id == 'update') {
    echo User::model()->getCompany($currentlyEditedUserId);
}
?>"/>


<input type="text" id="createUrlForEmailUnique" style="display:none;" value="<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>"/>
<input type="text" id="emailunique" style="display:none;" />

<script>

    $(document).ready(function() {
        var sessionRole = $("#currentRole").val(); //session role of currently logged in user
        var userId = $("#userId").val(); //id in url for update action
        var selectedUserId = $("#selectedUserId").val(); //session id of currenlty logged in user
        var actionId = $("#currentAction").val(); // current action
        var getRole = $("#getRole").val(); // role in url

        var superadmin = 5;
        var admin = 1;
        var agentadmin = 6;
        var agentoperator = 7;
        var operator = 8;
        var staffmember = 9;
        var agentairportadmin = 13;

        $("#addCompanyLink").hide(); //button for adding company
        $("#tenantAgentRow").hide();
        $("#tenantRow").hide();
        $(".workstationRow").hide();

        document.getElementById('User_tenant').disabled = true;
        document.getElementById('User_tenant_agent').disabled = true;
        document.getElementById('User_company').disabled = true;
        
        if (actionId == 'update') {
            $("#fromYear").val($("#dateofBirthBreakdownValueYear").val());
            $("#fromMonth").val($("#dateofBirthBreakdownValueMonth").val());
            $("#fromDay").val($("#dateofBirthBreakdownValueDay").val());
        }

        if ((getRole != admin && getRole != '') && sessionRole == superadmin) {
            if (getRole == agentadmin) {
 
                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_tenant').disabled = false;
                $("#tenantRow").show();
                $("#addCompanyLink").show();
                document.getElementById("companyRow").style.paddingBottom = "10px";
            } else if (getRole == operator) {
                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                $("#tenantRow").show();
            } else if (getRole == agentoperator) {
                // $("#User_company").empty();
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_tenant_agent').disabled = false;
                $("#tenantRow").show();
                $("#tenantAgentRow").show();
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
            }
            else {
                document.getElementById('User_tenant').disabled = false;
                document.getElementById('User_tenant_agent').disabled = false;
                $("#tenantRow").show();
                $("#tenantAgentRow").show();
            }
        } else if (getRole == admin && sessionRole == superadmin) {
            $("#addCompanyLink").show();
            document.getElementById('User_company').disabled = false;
            document.getElementById("companyRow").style.paddingBottom = "10px";
        }
        else if (sessionRole == admin) {
            if (getRole == admin)
            {
                $("#User_company").val($("#sessionCompany").val());
                document.getElementById('User_company').disabled = true;
            }
            else if (getRole == operator) {
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                getWorkstation();
            }
            else if (getRole == agentadmin) {
                $("#addCompanyLink").show();
                document.getElementById("companyRow").style.paddingBottom = "10px";
                document.getElementById('User_company').disabled = false;
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').hide();
            }
        }
        else if (sessionRole == agentadmin) {
            if (getRole == agentoperator) {
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                getWorkstationAgentOperator();
            }
        } else if (sessionRole == agentairportadmin) {
            if (getRole == agentairportadmin) {
                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_tenant').disabled = false;
                $("#tenantRow").show();
                $("#tenantAgentRow").show();
            }
        }

        $('form').bind('submit', function() {
            $(this).find('#User_role').removeAttr('disabled');
            $(this).find('#User_company').removeAttr('disabled');
            if (sessionRole == 6) {
                $(this).find('#User_tenant_agent').removeAttr('disabled');
            }


        });

        if (actionId == 'update') {
            document.getElementById("User_user_status").disabled = true;
            document.getElementById("User_user_type").disabled = true;
        }

        if ((selectedUserId == userId) && actionId == 'update') { //disable user role for owner
            document.getElementById("User_role").disabled = true;
        }

        $("#submitBtn").click(function(e) {
            e.preventDefault();
            checkHostEmailIfUnique();
        });


        function populateTenantAgentField(tenant) {
            $("#User_tenant_agent").empty();
            //$("#User_company").empty();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentAjax&id='); ?>' + tenant,
                dataType: 'json',
                data: tenant,
                success: function(r) {
                    document.getElementById('User_tenant_agent').disabled = false;
                    $('#User_tenant_agent option[value!=""]').remove();
                    $('#User_tenant_agent').append('<option value="">Please select a tenant agent</option>');
                    $.each(r.data, function(index, value) {
                        $('#User_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');
                    });
                    $("#User_tenant_agent").val('');
                }
            });
        }

        $('#User_tenant').on('change', function(e) {
            e.preventDefault();

            var tenant = $(this).val();
            $("#User_company").empty();
            $("#User_workstation").empty();

            if ($("#User_role").val() == agentadmin) {
                populateCompanyofTenant(tenant);
            }
            if ($("#User_role").val() == operator || $("#User_role").val() == staffmember || $("#User_role").val() == agentoperator) {
                if (sessionRole == superadmin) {
                    var tenant = $("#User_tenant").val();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('user/getCompanyOfTenant&id='); ?>' + tenant,
                        dataType: 'json',
                        data: tenant,
                        success: function(r) {
                            $('#User_company option[value!=""]').remove();

							var selectedId = '';
							var selectedVal = '';
                            $.each(r.data, function(index, value) {
                                $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                                if (selectedId == '') {
                                	selectedId = value.id;
                                	selectedVal = value.name;
                                }
                            });
							
                            $('#User_company').val(selectedId);
                            $('#select2-User_company-container').html(selectedVal);
                        }
                    });
                } else {
                    var tenant = '<?php echo $session['tenant'] ?>';
                }

                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + tenant,
                    dataType: 'json',
                    data: tenant,
                    success: function(r) {
                        $('#User_workstation option[value!=""]').remove();

                        $.each(r.data, function(index, value) {
                            $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                    }
                });
            }

            if ($("#User_role").val() != operator) {
                populateTenantAgentField(tenant);
            }

        });
    });

    function trim(el) {
        el.value = el.value.
                replace(/(^\s*)|(\s*$)/gi, "").// removes leading and trailing spaces
                replace(/[ ]{2,}/gi, " ").// replaces multiple spaces with one space 
                replace(/\n +/, "\n");           // Removes spaces after newlines
        return;
    }

    function sendUserForm() {

        var userform = $("#userform").serialize();
        var url;
        if ($("#currentAction").val() == 'update') {
            url = "<?php echo CHtml::normalizeUrl(array("/user/update&id=" . $currentlyEditedUserId)); ?>";
        } else {
            url = "<?php echo CHtml::normalizeUrl(array("user/create")); ?>"
        }
        $.ajax({
            type: "POST",
            url: url,
            data: userform,
            success: function(data) {
               window.location = 'index.php?r=user/admin&vms=<?php echo ($model->is_avms_user() || CHelper::is_managing_avms_user() )?'avms':'cvms' ?>';
            }
        });
    }

    function checkHostEmailIfUnique() {
        if ('<?php echo $model->email; ?>' == $("#User_email").val()) {
            $(".errorMessageEmail1").hide();
            $("#emailunique").val("0");
            sendUserForm();
            //$("#submitForm").click();
        } else {
            var email = $("#User_email").val();
            var tenant;
            if ($("#currentRole").val() == '5' && !is_accessing_avms_features()) { //check if superadmin
                tenant = $("#User_tenant").val();
            } else {
                tenant = '<?php echo $session['tenant']; ?>';
            }
            if ($("#User_role").val() == '1') {
                var url = $("#createUrlForEmailUnique").val() + email.trim();
            } else {
                var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
            }

            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: email,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        if (value.isTaken == 1) {
                            $(".errorMessageEmail1").show();
                            $("#emailunique").val("1");

                        } else {
                            $(".errorMessageEmail1").hide();
                            $("#emailunique").val("0");
                              sendUserForm();
                            //$("#submitForm").click();
                            
                        }
                    });

                }
            });
        }
    }
    function populateCompanyofTenant(tenant, newcompanyId) {
        $('#User_company option[value!=""]').remove();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetTenantOrTenantAgentCompany&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value!=""]').remove();

				var selectedId = '';
				var selectedVal = '';
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                    if (selectedId == '') {
                    	selectedId = value.id;
                    	selectedVal = value.name;
                    }
                });
                
                if ($("#User_role").val() == 6) {
                    document.getElementById('User_company').disabled = false;
                    newcompanyId = (typeof newcompanyId === "undefined") ? "defaultValue" : newcompanyId;

                    if (newcompanyId != 'defaultValue') {
                        $("#User_company").val(newcompanyId);
                    }
                } else {
                    $('#User_company').val(selectedId);
                    $('#select2-User_company-container').html(selectedVal);
                }

            }
        });


    }
    function populateDynamicFields() {

        if(is_accessing_avms_features()){
            return;
        }

		$('#third_option').empty();
        /*if superadmin user company set to empty*/
        if (<?php echo $session['role'] ?> == 5)
        {
            $("#User_company").empty();
        }
        $("#User_workstation").empty();

        var selectedRole = $("#User_role").val();
		
        var sessionRole = $("#currentRole").val(); //session role of currently logged in user
		
        var actionId = $("#currentAction").val(); // current action
        var admin = 1;
        var operator = 8;
        var staffmember = 9;
        var superadmin = 5;
        var agentadmin = 6;
        


        //hide required * label if role is staffmember
        if (selectedRole == staffmember) {
			$('#third_option').append('<td><input type="radio" value="3" class="pass_option" name="User[password_option]" />&nbsp;User does not require a password</td>');
			$("#third_option").show();
            $(".tenantField").hide();
        } else {
            $(".tenantField").show();
        }
        if (sessionRole == admin )
        {
            if (selectedRole == admin)
            {
                document.getElementById('User_company').disabled = true;
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').show();
                $("#User_company").val("<?php echo $session['company']; ?>");
            }
            else if (selectedRole == operator)
            {
                $("#User_company").val($("#sessionCompany").val());
                document.getElementById('User_company').disabled = true;
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').show();
                $("#User_company").val("<?php echo $session['company']; ?>");
                getWorkstation();
            }
            else if (selectedRole == staffmember) {




                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').show();
                $("#User_company").val("<?php echo $session['company']; ?>");
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                $("#User_company").val($("#sessionCompany").val());
                document.getElementById('User_tenant').disabled = true;
                document.getElementById('User_company').disabled = true;
                var selectedUserId = $("#selectedUserId").val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentAjax&id='); ?>' + selectedUserId,
                    dataType: 'json',
                    data: selectedUserId,
                    success: function(r) {
                        $('#User_tenant_agent option[value!=""]').remove();
                        $('#User_tenant_agent').append('<option value="">Please select a tenant agent</option>');
                        $.each(r.data, function(index, value) {
                            $('#User_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');

                        });
                        $("#User_tenant_agent").val('');
                    }
                });
            }
            else {
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                //$('#User_company option[value=""]').remove;
                $('#User_company').find('option[value=<?php echo $session['company']; ?>]').hide();
                $("#User_company").val("");
                document.getElementById('User_company').disabled = false;

            }
        }
        else if (sessionRole == superadmin)
        {
            $("#User_company_em_").hide();
            if (selectedRole != admin) { // if selected is not equal to admin enable tenant
                if (selectedRole == operator) {
                    document.getElementById('User_tenant_agent').disabled = true;
                    document.getElementById('User_workstation').disabled = false;
                    $("#tenantAgentRow").hide();
                    $("#tenantRow").show();
                    $(".workstationRow").show();
                    document.getElementById('User_tenant').disabled = false;
                    document.getElementById('User_company').disabled = true;
                    $("#User_tenant").val('');


                }
                else if (selectedRole == 9) {



                    document.getElementById('User_tenant_agent').disabled = false;
                    $("#tenantAgentRow").show();
                    $("#tenantRow").show();
                    document.getElementById('User_tenant').disabled = false;
                    document.getElementById('User_company').disabled = true;
                    document.getElementById('User_workstation').disabled = true;
                    $(".workstationRow").hide();
                    $("#User_tenant").val('');
                    $("#User_tenant_agent").empty();

                }
                else if (selectedRole == 6) {
                    $("#User_tenant").val('');
                    document.getElementById('User_tenant_agent').disabled = true;
                    $("#tenantAgentRow").hide();
                    document.getElementById('User_company').disabled = true;
                    document.getElementById('User_workstation').disabled = true;
                    $(".workstationRow").hide();
                    $("#tenantRow").show();
                    document.getElementById('User_tenant').disabled = false;

                }
                else if (selectedRole == 7) {

                    $("#tenantAgentRow").show();
                    document.getElementById('User_company').disabled = true;
                    $("#tenantRow").show();
                    document.getElementById('User_tenant').disabled = false;
                    document.getElementById('User_workstation').disabled = false;
                    $(".workstationRow").show();
                    $("#User_tenant").val('');
                    $("#User_tenant_agent").empty();

                }
                else {
                    document.getElementById('User_company').disabled = false;

                }
            }
            else {
                document.getElementById('User_tenant').disabled = true;
                document.getElementById('User_tenant_agent').disabled = true;
                document.getElementById('User_company').disabled = false;

                //reset company list
                /*Taking an array of all companybase and kind of embedding it on the company*/
                $("#User_company").data('options', $('#User_company_base option').clone());
                var id = $("#User_company").val();
                var options = $("#User_company").data('options');
                $('#User_company').html(options);
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
                $("#tenantRow").hide();
                $("#tenantAgentRow").hide();
            }
        }
        else if (sessionRole == agentadmin) {
            if (selectedRole == 7) { /*if selected role field is agent operator*/
                document.getElementById('User_workstation').disabled = false;
                $(".workstationRow").show();
                getWorkstationAgentOperator();
            } else {
                document.getElementById('User_workstation').disabled = true;
                $(".workstationRow").hide();
            }
        }

        /*show or hide add company button*/
       if ((sessionRole == superadmin && (selectedRole == admin || selectedRole == agentadmin || selectedRole == issuing_body_admin )) || (sessionRole == admin && (selectedRole == agentadmin || selectedRole == issuing_body_admin))) {
            $("#addCompanyLink").show();
            document.getElementById("companyRow").style.paddingBottom = "10px";
        }
        else {
            $("#addCompanyLink").hide();
            document.getElementById("companyRow").style.paddingBottom = "0px";
        }
    }
    function populateAgentOperatorWorkstations(tenant, tenantAgent, value) {

        $("#User_workstation").empty();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getTenantAgentWorkstation&id='); ?>' + tenantAgent + '&tenant=' + tenant,
            dataType: 'json',
            data: tenantAgent,
            success: function(r) {
                $('#User_workstation option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#User_workstation").val(value);
            }
        });
    }

    function populateOperatorWorkstations(tenant, value) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/getTenantWorkstation&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_workstation option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $('#User_workstation').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#User_workstation").val(value);
            }
        });
    }
    function getCompanyTenantAgent() { /*get tenant agent company*/
        var tenantAgent = $("#User_tenant_agent").val();
        var staffmember = 9;
        var agentadmin = 6;
        var agentoperator = 7;
        var superadmin = 5;

        var airport_agent_admin = <?php echo Roles::ROLE_AGENT_AIRPORT_ADMIN; ?>;
        var airport_agent_operator = <?php echo Roles::ROLE_AGENT_AIRPORT_OPERATOR; ?>;
        var issuing_body_admin = <?php echo Roles::ROLE_ISSUING_BODY_ADMIN; ?>;

        if ($("#User_role").val() != staffmember && $("#User_role").val() != agentadmin && $("#User_role").val() != agentoperator) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('user/GetTenantOrTenantAgentCompany&id='); ?>' + tenantAgent,
                dataType: 'json',
                data: tenantAgent,
                success: function(r) {
                    $('#User_company option[value!=""]').remove();

                    var selectedId = '';
                    var selectedVal = '';
                    $.each(r.data, function(index, value) {
                        $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                        document.getElementById('User_company').disabled = true;
                        if (selectedId == '') {
                        	selectedId = value.id;
                        	selectedVal = value.name;
                        }
                    });
                    s
                    $("#User_company").val(selectedId);
                	$("#select2-User_company-container").html(selectedVal);
                }
            });
        }
        if ($("#User_role").val() == agentoperator || $("#User_role").val() == staffmember || $("#User_role").val() == airport_agent_operator || $("#User_role").val() == airport_agent_admin) {
            if ($("#currentRole").val() == superadmin)
            {
                var sessionRole = '<?php echo $session['role']; ?>';
                var tenantAgent = $("#User_tenant_agent").val();
                var tenant = $("#User_tenant").val();
                if (sessionRole == 5)
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('user/getCompanyOfTenant&id='); ?>' + tenant + '&tenantAgentId=' + tenantAgent,
                        dataType: 'json',
                        data: tenant,
                        success: function(r) {
                            $('#User_company option[value!=""]').remove();

                            var selectedId = '';
                            var selectedVal = '';
                            $.each(r.data, function(index, value) {
                                $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
								
                                if (selectedId == '') {
                                	selectedId = value.id;
                                	selectedVal = value.name;
                                }
                            });
							
                            $("#User_company").val(selectedId);
                        	$("#select2-User_company-container").html(selectedVal);
                        }
                    });
                }
            }
            else {
                var tenant = '<?php echo $session['tenant'] ?>';
                var tenantAgent = '<?php echo $session['tenant_agent'] ?>';
            }
            populateAgentOperatorWorkstations(tenant, tenantAgent);
        }
    }

    function getWorkstation() { /*get workstations for operator*/
        var sessionRole = '<?php echo $session['role']; ?>';
        var superadmin = 5;

        if (sessionRole == superadmin)
        {
            var tenant = $("#User_tenant").val();
        }
        else {
            var tenant = '<?php echo $session['tenant'] ?>';
        }
        populateOperatorWorkstations(tenant);

    }

    function getWorkstationAgentOperator() { /*get workstation for agent operator*/

        var tenant = '<?php echo $session['tenant'] ?>';
        var tenantAgent = '<?php echo $session['tenant_agent'] ?>';

        populateAgentOperatorWorkstations(tenant, tenantAgent);

    }

    function isValidExpiryDate()
    {
        var d = $("#User_asic_expiry_day").val();
        var m = getMonthFromString( $("#User_asic_expiry_month").val() );
        var y = $("#User_asic_expiry_year").val();


        var dt = new Date(y, m -1, d);
        return dt.getDate() == d &&
                dt.getMonth() +1 == m &&
                dt.getFullYear() == y;
    }

    function getMonthFromString(mon){
        return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
    }

    function is_accessing_avms_features() {
        return <?php echo CHelper::is_accessing_avms_features()? "true":"false"; ?>
    }


</script>

<?php

function getAssignableRoles($user_role, $model) {

    $session = new CHttpSession;
    if (isset($_GET['id'])) { //if update
        $userIdOnUpdate = $_GET['id'];
    } else {
        $userIdOnUpdate = '';
    }

    if (CHelper::is_managing_avms_user() || $model->is_avms_user()) {
        return get_avms_assignable_roles($user_role);
    } else {

        $assignableRolesArray = array();
        switch ($user_role) {

            case Roles::ROLE_AGENT_ADMIN: //agentadmin
                //if session id = id editing ->add role of logged in
                if ($session['id'] == $userIdOnUpdate) {
                    $assignableRoles = array(Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_STAFFMEMBER
                    ); //keys
                } else {
                    $assignableRoles = array(Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys
                }
                foreach ($assignableRoles as $roles) {
                    if (isset(User::$USER_ROLE_LIST[$roles])) {
                        $assignableRolesArray[] = array(
                            $roles => User::$USER_ROLE_LIST[$roles],
                        );
                    }
                }
                break;

            case Roles::ROLE_SUPERADMIN: //superadmin

                if ($session['id'] == $userIdOnUpdate) {
                    $assignableRoles = array(Roles::ROLE_ADMIN, Roles::ROLE_SUPERADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys
                } else {
                    $assignableRoles = array(Roles::ROLE_ADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_OPERATOR, Roles::ROLE_STAFFMEMBER);
                } //keys
                foreach ($assignableRoles as $roles) {
                    if (isset(User::$USER_ROLE_LIST[$roles])) {
                        $assignableRolesArray[] = array(
                            $roles => User::$USER_ROLE_LIST[$roles],
                        );
                    }
                }
                break;

            case Roles::ROLE_ADMIN: //admin

                $assignableRoles = array(Roles::ROLE_ADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_OPERATOR, Roles::ROLE_STAFFMEMBER); //keys

                foreach ($assignableRoles as $roles) {
                    if (isset(User::$USER_ROLE_LIST[$roles])) {
                        $assignableRolesArray[] = array(
                            $roles => User::$USER_ROLE_LIST[$roles],
                        );
                    }
                }
                break;

        }

        //echo '<p><pre>';print_r($user_role);echo '</pre></p>';

        return $assignableRolesArray;
    }
}

function get_avms_assignable_roles($user_role)
{
    $assignableRolesArray = array();
    switch($user_role) {

        case Roles::ROLE_ISSUING_BODY_ADMIN:
        case Roles::ROLE_ADMIN:

            $assignableRoles = array(
                Roles::ROLE_ISSUING_BODY_ADMIN,
                Roles::ROLE_AGENT_AIRPORT_ADMIN,
                Roles::ROLE_AIRPORT_OPERATOR,
                //Roles::ROLE_AGENT_AIRPORT_OPERATOR
            );
            foreach ($assignableRoles as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;

        case Roles::ROLE_SUPERADMIN:
            $assignableRoles = array(
                Roles::ROLE_ISSUING_BODY_ADMIN,
                Roles::ROLE_AGENT_AIRPORT_ADMIN,
                Roles::ROLE_AIRPORT_OPERATOR,
                Roles::ROLE_AGENT_AIRPORT_OPERATOR
            );
            foreach ($assignableRoles as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;

        case Roles::ROLE_AGENT_ADMIN:
        case Roles::ROLE_AGENT_AIRPORT_ADMIN:
            $assignableRoles = array(
                Roles::ROLE_AGENT_AIRPORT_ADMIN,
                Roles::ROLE_AGENT_AIRPORT_OPERATOR
            );

            foreach ($assignableRoles as $roles) {
                if (isset(User::$USER_ROLE_LIST[$roles])) {
                    $assignableRolesArray[] = array(
                        $roles => User::$USER_ROLE_LIST[$roles],
                    );
                }
            }
            break;
    }

    return $assignableRolesArray;
}

?>
<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody"></div>

</div>

<div class="modal hide fade" id="generate_password" style="width: 410px">
<div style="border:5px solid #BEBEBE; width:405px">
    <div class="modal-header" style=" border:none !important; height: 60px !important;padding: 0px !important;width: 405px !important;">
    <div style="background-color:#E8E8E8; padding-top:2px; width:405px; height:56px;">
    <a data-dismiss="modal" class="close" id="close_generate" >×</a>
    <h1 style="color: #000;font-size: 15px;font-weight: bold;margin-left: 9px;padding-top: 0px !important;">				     Autogenerated Password
    </h1>
    
    </div>
        
        <br>
    </div>
    <div id="modalBody_gen">
     
    <table >
   
    <div id="error_msg" style='font-size: 0.9em;color: #FF0000;padding-left: 11px; display:none' >Please Generate Password </div>
    		
    <tr><td colspan="2" style="padding-left:10px">Your randomly generated password is :</td></tr>
    <tr><td colspan="2"></td></tr>
    	<tr><td colspan="2"style="padding-left:55px; padding-top:24px;"><input readonly="readonly" type="text" placeholder="Random Password" value="" id="random_password" /></td></tr>
        
        <tr><td colspan="2"style="padding-left:10px; font:italic">Note: Please copy and save this password somewhere safe.</td></tr>
        <tr><td  style="padding-left: 11px;padding-top: 26px !important; width:50%"> <input onclick="copy_password();"  style="border-radius: 4px; height: 35px; " type="button" value="Use Password" /></td>
        <td style="padding-right:10px;padding-top: 25px;"> <input  onclick="cancel();" style="border-radius: 4px; height: 35px;" type="button" value="Cancel" /></td>
        </tr>
        
    </table>
          
    
    </div>
<a data-toggle="modal" data-target="#generate_password" id="gen_pass" style="display:none" class="btn btn-primary">Click me</a>
</div>
</div>
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
<script>

$(document).ready(function() {

/*Added by farhat aziz for upload host photo*/

		
		$('#photoCropPreview2').imgAreaSelect({
            handles: true,
            onSelectEnd: function(img, selection) {
                $("#cropPhotoBtn2").show();
                $("#x12").val(selection.x1);
                $("#x22").val(selection.x2);
                $("#y12").val(selection.y1);
                $("#y22").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });
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
                    width: $("#width").val(),
                    height: $("#height").val(),
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
                                    "background-size": "132px 152px"
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

		
});

	function cancel(){
	$('#User_repeat_password').val('');	
	$('#User_password').val('');
	$("#random_password").val('');	
	$("#close_generate").click();
	}
	
	function copy_password(){
	if($('#random_password').val()==''){
	$('#error_msg').show();
	}else{
	
	$('#User_password').val($('#random_password').val());
	$('#User_repeat_password').val($('#random_password').val());
	$("#close_generate").click();
		
	}
		
	}
	
	
	function generatepassword() {
		
		 $("#random_password").val('');
		$( "#pass_option" ).prop( "checked", true );
		
		var text = "";
    	var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

		for( var i=0; i < 6; i++ ){
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		}
    	document.getElementById('random_password').value	=	text;
		
	 
	  $("#gen_pass").click();
	}
    function addCompany() {
        if ($("#User_tenant").val() == '' && $("#currentRole").val() != 5) {
            $("#User_company_em_").show();
            $("#User_company_em_").html('Please select a tenant');
        } else {
            var url = '<?php echo $this->createUrl('company/create&viewFrom=1') ?>';
            var sessionRole = $("#currentRole").val();
            var selectedRole = $("#User_role").val();
            var tenant = $("#User_tenant").val();
            var superadmin = 5;
            var agentadmin = 6;
            if (sessionRole == superadmin) {
                if (selectedRole == agentadmin) {
                    url = '<?php echo $this->createUrl('company/create&viewFrom=1&tenant=') ?>' + tenant;
                }
            }

            $("#modalBody").html('<iframe width="100%" id="companyModalIframe" height="98%" frameborder="0" scrolling="no" src="' + url + '" ></iframe>');
            $("#modalBtn").click();
        }
    }

    function dismissModal(id) {
        $("#dismissModal").click();
        if ($("#User_role").val() == "6") {
            populateCompanyofTenant($("#User_tenant").val(), id);
        } else if ($("#User_role" == 1 && $("#currentRole").val() == 5)) {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('company/GetCompanyList&lastId='); ?>',
                dataType: 'json',
                success: function(r) {
                    $('#User_company option[value!=""]').remove();
                    $('#User_company_base option[value!=""]').remove();

                    $.each(r.data, function(index, value) {
                        $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                        $('#User_company_base').append('<option value="' + value.id + '">' + value.name + '</option>');
                        document.getElementById('User_company').disabled = false;
                        $("#User_company").val(value.id);
                    });

                }
            });
        }


    }
</script>



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
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>





