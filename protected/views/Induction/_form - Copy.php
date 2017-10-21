<?php
/* @var $this InductionController */
/* @var $model Induction */
/* @var $form CActiveForm */ 


$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->controller->assetsBase . '/bootstrapSwitch/bootstrap-switch.css');
$session = new CHttpSession;  

$currentRoleinUrl = '';
if (isset($_GET['role'])) {
    $currentRoleinUrl = $_GET['role'];
}

$currentlyEditedUserId = '';
if (isset($_GET['id'])) {
    $currentlyEditedUserId = $_GET['id'];
    if (isset(User::model()->findByPk($currentlyEditedUserId)->password)) {
        $password = User::model()->findByPk($currentlyEditedUserId)->password;
    }
}

//$currentLoggedUserId = $session['id'];
//$company = Company::model()->findByPk($session['company']);

//if (isset($company) && !empty($company)) {
//    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
//}
?>
<style type="text/css">
    .indcution-info {
	    margin-top: 10px;
    } 
	
	DIV.compactRadioGroup {
		padding-left: 0.5em;
	}

	div#content .compactRadioGroup LABEL, DIV#content .compactRadioGroup INPUT {
		display: inline;
	}
	
	.row {
		display: flex;
		flex-direction: row;
		padding-top:10px;
	}  
	
	#InductionRecords_required {
		display: flex;
		flex-direction: row;
	}
	
	.required:after {
		content: " *";
		color: red;
		display: inline;
	}
	
	.induction-required {
		padding-left: 20px;
	}
	
	.induction-title {
		margin-bottom: 10px;
	}
	
	#on {
		width: 50px;
	}  
	
	label[for=InductionRecords_is_required_induction] {
		line-height: 13px; 
	}
	
	label[for=InductionRecords_is_completed_induction] {
		line-height: 25px;
		padding-left: 0.1em;
	}
	
	label[for=InductionRecords_induction_expiry] {
		line-height: 27px;
		padding-left: 0.1em;
	}
	
	#expiry_airside_saftey_container, #expiry_orientation_container,
	#expiry_security_container, #expiry_staying_safe_container,
	#expiry_airside_driving_container, #expiry_drug_and_alcohol_container{
		width: 122px;
		margin-left: 10px;
	}
	
	.pieces-induction {
		margin-bottom: 15px;
	}
	
	.save_button {
		display: flex;
		justify-content: left;
		margin-left: 100px;
	}
	
	#ui-datepicker-div {
		z-index: 5 !important;
	}
	
	.induction-icons-records, .indcution-checkbox, .induction-icon-section {
		display: flex;
		flex-direction: row;
	}
	
	.adding-induction-icon {
		display: flex;
		flex-direction: column;
		margin-left: 50px;
	}
	
	.adding-print-file {
		margin-left: 10px;
	}
	
	.induction-records-title {
		width: 300px;
		height: 60px;
	}
	
	.induction-icon-section {
		width: 500px;
	}
	
	.person-icon {
		height: 60;
		line-height: 60px;
		margin-left: 50px;
	}
	
	.adding-induction-icon {
		width: 200px;
	}
	
	.adding-print-file {
		margin-right: 15px;
	}
	
	.cmn-toggle {
		position: absolute;
		visibility: hidden;
	}
	
	.cmn-toggle+label {
		display: block;
		position: relative;
		cursor: pointer;
		outline: none;
		user-select: none;
		background-color: #e7e7e7;	
	}
	
	.personal-details {
		width: 300px;
	}
	
	.title-details-input {
		height: 40px;
		line-height: 40px;
		border-radius: 4px;
		width: 320px;
		position: relative;
	}
	
	td > div > div > div > label:after {
		content: "";
		position: absolute;
		top: 18px;
		right: 14px;
		border: 5px solid transparent;
		border-left: 5px solid #ffffff;
		border-color: #4E5800 rgba(0, 0, 0, 0) rgba(0, 0, 0, 0);
	}
	
	.detail-input-row {
		height: 40px;
	}
	
	.personal-details-title {
		margin-left: 10px;
		color: #637280;
	}
	 
	.detail-title-row {
		width: 80px;
	}
	
	.detail-input-row {
		width: 200px;
	}
	
	.personal-details-section {
		display: flex;
		flex-direction: row;
		margin-top: 10px;
		height: 40px;
	}
	
	.personal-detail-title {
		width: 80px;
		color: #CCCCCC;
		margin-right: 20px;
		line-height: 30px;
	}
	
	input#Visitor_first_name, input#Visitor_middle_name,
	input#Visitor_last_name{
		width: 175px;
	}
	
	input#Visitor_contact_number, #Visitor_email {
		width: 175px;
	}
	 
	.middle-name {
		width:100px;
		margin-right:0px;
	}
	
	#date_of_birth-input_container {
		width: 175px;
	}
	 
	.company-name-title {
		width: 105px;
		color: #CCCCCC;
		margin-right: 20px;
		line-height: 30px;
	} 
	
	input#Visitor_company, input#Company_contact_person, 
	input#Contact_office_number, input#Contact_user_email {
		width: 150px;
	}
	
	input#Company_contact_person, input#Contact_office_number,
	input#Contact_user_email {
		margin-left: 24px;
	}
	
	.company-unit-title {
		width: 20px;
		color: #CCCCCC;
		margin-right: 20px;
		line-height: 30px;
	}
	
	#Company_unit {
		width: 40px;
		margin-right: 10px;
	} 
	
	input#street_number {
		width: 115px;
	}
	 
	.street-number-title {
		margin-left: 11px;
		color: #CCCCCC;
		margin-right: 10px;
		line-height: 30px;
		width: 66px;
	} 
	
	div.information-pieces-section {
		margin-top: 20px;
		height: 40px;
		font-size: 15px;
	}
	
	.informaiton-section {
		margin-top: 50px;
	}
	
	.information-row {
		height: 40px;
	} 
	
	input#Visitor_street_number {
		width: 85px;
	}
	
	input#Visitor_street_name, input#Visitor_suburb,
    input#Visitor_postcode {
		width: 175px;
	}
</style> 
  
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'inductionform',
    //'action' => array('user/'.$action, 'role' => Yii::app()->request->getParam('role'),'id'=>$model->id),
    'htmlOptions' => array("name" => "inductionform"),
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnSubmit' => true,
    ),
));
?>

<table> 
	<tr>
		<!-- Table of photo management -->
		<td style="vertical-align: top; float:left; width:300px">			
			<table style="width:300px;float:left;min-height:320px;">
				<tr>
					<td style="vertical-align: top; float:left; width:300px">
						<table style="width:300px;float:left;min-height:320px;">
							<tr>
								<td style="width:300px;">
									
									<!-- <label for="Visitor_Add_Photo" style="margin-left:27px;">Add  Photo</label><br>-->
									<input type="hidden" id="Host_photo" name="User[photo]" value="<?php //echo $model->photo; ?>">
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
						</table>
					</td>
				</tr>
			</table> 			
		</td><!-- End Table of photo management -->
		
		<!-- Table of information management -->
		<td style="vertical-align: top; float:left; width:600px">			
			<div class = "details-information">
				<div class = "personal-details">
					<div class='has-sub' id="personalDetailsLi">  
						<a href="#"><span>Personal Details</span></a>					
					</div>
					
					<div class = "personal-details-input-section">
						<table>
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title">First Name
										</div>
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($visitor, 'first_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_first_name")); ?>
												<!--<input size="50" maxlength="50" name="Visitor[first_name]" id="Visitor_first_name" type="text">-->
											</div>
											<?php echo $form->error($visitor, 'first_name'); ?>
										</div>
									</div> 
								</td>
							</tr>
						
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title middle-name">Middle Name
										</div>
										<div class = "personal-details-input">
											<input size="50" maxlength="50" name="Visitor[middle_name]" id="Visitor_middle_name" type="text">
										</div>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title middle-name">Last Name
										</div>
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($visitor, 'last_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_last_name")); ?>
											</div>
											<?php echo $form->error($visitor, 'last_name'); ?>
										</div>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title middle-name">Date of Birth
										</div>
										<div class = "personal-details-input">
											<?php $this->widget('EDatePicker', array(
																				'model'     => $visitor,
																				'attribute' => 'date_of_birth',
																				'id'        => 'date_of_birth-input',
																			)); ?>
										</div>
									</div>  
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class = "personal-details">
					<div>  
						<input id="cmn-toggle-2" class="cmn-toggle cmn-toggle-yes" type="checkbox" checked>
						<label for="cmn-toggle-2" class = "title-details-input"><strong class = "personal-details-title has-sub"><span>Contact Details</span></strong></label>						
					</div>
					
					<div class = "contact-details-input-section">
						<table>
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title">Email
										</div>
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($visitor, 'email', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_email")); ?>
											</div>
											<?php echo $form->error($visitor, 'email'); ?>
										</div>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title middle-name">Mobile
										</div>
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($visitor, 'contact_number', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_contact_number")); ?>
											</div>
											<?php echo $form->error($visitor, 'contact_number'); ?>
										</div>
									</div>  
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class = "personal-details">
					<div>  
						<input id="cmn-toggle-3" class="cmn-toggle cmn-toggle-yes" type="checkbox" checked>
						<label for="cmn-toggle-3" class = "title-details-input"><strong class = "personal-details-title has-sub"><span>Contact Address</span></strong></label>						
					</div>
					
					<div class = "contact-address-input-section">
						<div>
							<table>	
								<tr>
									<td>
										<div class = "personal-details-section">
											<div class = "company-unit-title">Unit
											</div>
											<div class = "personal-details-input">
												<input size="50" maxlength="50" name="Conpany[unit]" id="Company_unit" type="text">
											</div>
											<div class = "street-number-title">Street No.
											</div>
											
											<div>
												<div class = "personal-details-input required">
													<?php echo $form->textField($company, 'street_number', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_street_number")); ?>
												</div>
												<?php echo $form->error($company, 'street_number'); ?>
											</div>
											</div>
									</td>
								</tr>
							</table>
						</div>
						<div>
							<table>
								<tr>
									<td>
										<div class = "personal-details-section">
											<div class = "personal-detail-title middle-name">Street Name
											</div>
											
											<div>
												<div class = "personal-details-input required">
													<?php echo $form->textField($company, 'street_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_street_name")); ?>
												</div>
												<?php echo $form->error($company, 'street_name'); ?>
											</div> 
										</div>  
									</td>
								</tr>
						
								<tr>
									<td>
										<div class = "personal-details-section">
											<div class = "personal-detail-title middle-name">Type
											</div>
											<div>
												<div class = "personal-details-input required">
													<?php echo $form->dropDownList($company, 'street_type', Visitor::$STREET_TYPES, array('empty' => '', 'style' => 'width: 190px;')); ?>
												</div>
												<?php echo $form->error($company, 'street_type'); ?>
											</div>
										</div>  
									</td>
								</tr>
						
								<tr>
									<td>
										<div class = "personal-details-section">
											<div class = "personal-detail-title middle-name">Suburb
											</div>
											<div>
												<div class = "personal-details-input required">
													<?php echo $form->textField($company, 'suburb', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_suburb")); ?>
												</div>
												<?php echo $form->error($company, 'suburb'); ?>
											</div>
										</div>  
									</td>
								</tr>
						
								<tr>
									<td>
										<div class = "personal-details-section">
											<div class = "personal-detail-title middle-name">Postcode
											</div>
											<div>
												<div class = "personal-details-input required">
													<?php echo $form->textField($company, 'postcode', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_postcode")); ?>
												</div>
												<?php echo $form->error($company, 'postcode'); ?>
											</div>
										</div>  
									</td>
								</tr>
								
								<tr>
									<td>
										<div class = "personal-details-section">
											<div class = "personal-detail-title middle-name">State
											</div>
											<div>
												<div class = "personal-details-input required">
													<?php echo $form->dropDownList($company, 'state', Visitor::$AUSTRALIAN_STATES, array('empty' => '', 'style' => 'width: 190px;')); ?>
												</div>
												<?php echo $form->error($company, 'state'); ?>
											</div>
										</div>  
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				
				<div class = "personal-details">
					<div>  
						<input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-yes" type="checkbox" checked>
						<label for="cmn-toggle-4" class = "title-details-input"><strong class = "personal-details-title has-sub"><span>Company Details</span></strong></label>						
					</div>
					
					<div class = "conpany-details-input-section">
						<table>
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "company-name-title">Company Name
										</div>
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($visitor, 'company', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_company")); ?>
											</div>
											<?php echo $form->error($visitor, 'company'); ?>
										</div>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title middle-name">Contact Person
										</div>
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($company, 'user_first_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Company_contact_person")); ?>
											</div>
											<?php echo $form->error($company, 'user_first_name'); ?>
										</div> 
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title middle-name">Contact No.
										</div>  
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($company, 'office_number', array('size' => 50, 'maxlength' => 50, 'id'=>"Contact_office_number")); ?>
											</div>
											<?php echo $form->error($company, 'office_number'); ?>
										</div> 
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class = "personal-details-section">
										<div class = "personal-detail-title middle-name">Contact Email
										</div>  
										<div>
											<div class = "personal-details-input required">
												<?php echo $form->textField($company, 'user_email', array('size' => 50, 'maxlength' => 50, 'id'=>"Contact_user_email")); ?>
											</div>
											<?php echo $form->error($company, 'user_email'); ?>
										</div> 
									</div>  
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class = "informaiton-section">
					<table>
						<tr class = "information-row">
							<td><p>Identification</p></td>
						</tr>
						<tr class = "information-row">
							<td><p>Identification Type</p></td>
						</tr>
						<tr class = "information-row">
							<td><p>Document No.</p></td>
						</tr>
						<tr class = "information-row">
							<td><p>Document Expiry</p></td>
						</tr>
						<tr class = "information-row">
							<td><p>ASIC No</p></td>
						</tr>
						<tr class = "information-row">
							<td><p>ASIC Expiry</p></td>
						</tr>
					</table>
				</div>
			</div>
		</td><!-- End Table of information management -->
		
		<!-- Table of induction management --> 
		<td style="vertical-align: top; float:left; width:300px">			
			<div style="width:500px;float:left;min-height:320px;margin-left: 100px;">
				<div class = "induction-icon-section">
					<div class = "induction-records-title">
						<h4 class = "induction-title">Induction Records</h4> 
						<strong class = "asic-holder">ASIC Holder: &nbsp Yes/No</strong>
					</div>
					<div class = "person-icon">
						put icon here
					</div>
				</div>
				
				<!-- Pieces of Induction Information -->
				<div class = "indcution-info">					
					<table>
					<!-- Induction of Airside Safety -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title">
										<strong>
											<?php echo $induction->findByPk(1)->induction_name;?>
										</strong>
									</div>
									
									<div class = "induction-icons-records">
										<div class = "password-border">
											<table class="no-margin-bottom">
												<tr>
													<td>
														<strong>Induction Information</strong>
														
													</td>												
												</tr>
											
												<tr>
													<td>
														<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
															<tr>
																<td>
																	<div style="display:inline-block;">
																		<?php echo $form->labelEx($model, 'is_required_induction'); ?>
																		<div class="switch switch-blue">
																			<input type="radio" class="switch-input is_required_induction_radio airside_saftey" name="required_induction_airside_saftey" value="0" id="week_airside_saftey" checked>
																			<label for="week_airside_saftey" class="switch-label switch-label-off" id = "off_airside_saftey">OFF</label>
																			<input type="radio" class="switch-input is_required_induction_radio airside_saftey" name="required_induction_airside_saftey" value="1" id="month_airside_saftey" <?php if(!empty($model->is_required_induction) && ($model->is_required_induction == "1")){echo 'checked'; }?>>
																			<label for="month_airside_saftey" class="switch-label switch-label-on" id = "on_airside_saftey">ON</label>
																			<span class="switch-selection"></span>
																		</div>
																	</div>
																</td>
															</tr> 
														
															<tr class = "induction-completed-row completed_airside_saftey">
																<td>
																	<div class = "row">
																		<div class = "induction-required">
																			<?php echo $form->labelEx($model, 'is_completed_induction'); ?>
																		</div>
														
																		<div class = "compactRadioGroup radioBtnlist_airside_saftey">
																			<?php echo $form->radioButtonList($model,'[1]is_completed_induction',array(0=>"No",1=>"Yes"), array('separator' => " ")); ?>
																		</div>
																	</div>
																</td>
															</tr>
											
															<tr class = "induction-expiry-row expiry_airside_saftey">
																<td>
																	<div class = "row">
																		<div class = "induction-required">
																			<?php echo $form->labelEx($model, 'induction_expiry'); ?>
																		</div>
														
																		<div class = "required">
																			<?php $this->widget('EDatePicker', array(
																				'model'     => $model,
																				'attribute' =>'induction_expiry',
																				'mode'=> 'expiry',
																				'name'=>'InductionRecords[1][induction_expiry]'
																			)); ?>
																		</div>
																	</div>
																</td>
															</tr>
														</table>
													</td>
												</tr> 
											</table>
										</div> 
								
										<div class = "adding-induction-icon">
											<div class = "indcution-checkbox">
												<div>
													<?php //echo $form->checkBox($model,'[1]induction_id'); ?>
												</div>
													
												<div class = "adding-print-file">
													<Strong>Add to Print File</Strong>
												</div>								
											</div>
											<div class = "red-cross-icon">
												add airside-safety-icons
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Airside Safety -->
						
						<!-- Induction of Orientation -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title">
										<strong>
											<?php echo $induction->findByPk(2)->induction_name;?>
										</strong>
									</div>
									
									<div class = "password-border">
										<table class="no-margin-bottom">
											<tr>
												<td>
													<strong>Induction Information</strong>
													
												</td>
											</tr>
											
											<tr>
												<td>
													<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
														<tr>
															<td>
																<div style="display:inline-block;">
																	<?php echo $form->labelEx($model, 'is_required_induction'); ?>
																	<div class="switch switch-blue">
																		<input type="radio" class="switch-input is_required_induction_radio orientation" name="required_induction_orientation" value="0" id="week_orientation" checked>
																		<label for="week_orientation" class="switch-label switch-label-off" id = "off_orientation">OFF</label>
																		<input type="radio" class="switch-input is_required_induction_radio orientation" name="required_induction_orientation" value="1" id="month_orientation" <?php if(!empty($model->is_required_induction) && ($model->is_required_induction == "1")){echo 'checked'; }?>>
																		<label for="month_orientation" class="switch-label switch-label-on" id = "on_orientation">ON</label>
																		<span class="switch-selection"></span>
																	</div>
																</div>
															</td>
														</tr> 
														
														<tr class = "induction-completed-row completed_orientation">
															<td>
																<div class = "row">
																	<div class = "induction-required">
																		<?php echo $form->labelEx($model, 'is_completed_induction'); ?>
																	</div>
														
																	<div class = "compactRadioGroup radioBtnlist_orientation">
																		<?php echo $form->radioButtonList($model,'[2]is_completed_induction',array(0=>"No",1=>"Yes"), array('separator' => " ")); ?>
																	</div>
																</div>
															</td>
														</tr>
											
														<tr class = "induction-expiry-row expiry_orientation">
															<td>
																<div class = "row">
																	<div class = "induction-required">
																		<?php echo $form->labelEx($model, 'induction_expiry'); ?>
																	</div>
														
																	<div class = "required">
																		<?php $this->widget('EDatePicker', array(
																			'model'     => $model,
																				'attribute' =>'induction_expiry',
																				'mode'=> 'expiry',
																				'name'=>'InductionRecords[2][induction_expiry]'
																			
																		)); ?>
																	</div>
																</div>
															</td>
														</tr>
													</table>
												</td>
											</tr> 
										</table>
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Orientation -->
						
						<!-- Induction of Security -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title">
										<strong>
											<?php echo $induction->findByPk(3)->induction_name;?>
										</strong>
									</div>
									
									<div class = "password-border">
										<table class="no-margin-bottom">
											<tr>
												<td>
													<strong>Induction Information</strong>
												</td>
											</tr>
											
											<tr>
												<td>
													<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
														<tr>
															<td>
																<div style="display:inline-block;">
																	<?php echo $form->labelEx($model, 'is_required_induction'); ?>
																	<div class="switch switch-blue">
																		<input type="radio" class="switch-input is_required_induction_radio security" name="required_induction_security" value="0" id="week_security" checked>
																		<label for="week_security" class="switch-label switch-label-off" id = "off_security">OFF</label>
																		<input type="radio" class="switch-input is_required_induction_radio security" name="required_induction_security" value="1" id="month_security" <?php if(!empty($model->is_required_induction) && ($model->is_required_induction == "1")){echo 'checked'; }?>>
																		<label for="month_security" class="switch-label switch-label-on" id = "on_security">ON</label>
																		<span class="switch-selection"></span>
																	</div>
																</div>
															</td>
														</tr> 
														
														<tr class = "induction-completed-row completed_security">
															<td>
																<div class = "row">
																	<div class = "induction-required">
																		<?php echo $form->labelEx($model, 'is_completed_induction'); ?>
																	</div>
														
																	<div class = "compactRadioGroup radioBtnlist_security">
																		<?php echo $form->radioButtonList($model,'[3]is_completed_induction',array(0=>"No",1=>"Yes"), array('separator' => " ")); ?>
																	</div>
																</div>
															</td>
														</tr>
											
														<tr class = "induction-expiry-row expiry_security">
															<td>
																<div class = "row">
																	<div class = "induction-required">
																		<?php echo $form->labelEx($model, 'induction_expiry'); ?>
																	</div>
														
																	<div class = "required">
																		<?php $this->widget('EDatePicker', array(
																			'model'     => $model,
																			'attribute' =>'induction_expiry',
																				'mode'=> 'expiry',
																				'name'=>'InductionRecords[3][induction_expiry]'
																		)); ?>
																	</div>
																</div>
															</td>
														</tr>
													</table>
												</td>
											</tr> 
										</table>
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Security -->
						
						<!-- Induction of Staying Safe (SMS) -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title">
										<strong>
											<?php echo $induction->findByPk(4)->induction_name;?>
										</strong>
									</div>
									
									<div class = "password-border">
										<table class="no-margin-bottom">
											<tr>
												<td>
													<strong>Induction Information</strong>
												</td>
											</tr>
											
											<tr>
												<td>
													<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
														<tr>
															<td>
																<div style="display:inline-block;">
																	<?php echo $form->labelEx($model, 'is_required_induction'); ?>
																	<div class="switch switch-blue">
																		<input type="radio" class="switch-input is_required_induction_radio staying_safe" name="required_induction_staying_safe" value="0" id="week_staying_safe" checked>
																		<label for="week_staying_safe" class="switch-label switch-label-off" id = "off_staying_safe">OFF</label>
																		<input type="radio" class="switch-input is_required_induction_radio staying_safe" name="required_induction_staying_safe" value="1" id="month_staying_safe" <?php if(!empty($model->is_required_induction) && ($model->is_required_induction == "1")){echo 'checked'; }?>>
																		<label for="month_staying_safe" class="switch-label switch-label-on" id = "on_staying_safe">ON</label>
																		<span class="switch-selection"></span>
																	</div>
																</div>
															</td>
														</tr> 
														
														<tr class = "induction-completed-row completed_staying_safe">
															<td>
																<div class = "row">
																	<div class = "induction-required">
																		<?php echo $form->labelEx($model, 'is_completed_induction'); ?>
																	</div>
														
																	<div class = "compactRadioGroup radioBtnlist_staying_safe">
																		<?php echo $form->radioButtonList($model,'[4]is_completed_induction',array(0=>"No",1=>"Yes"), array('separator' => " ")); ?>
																	</div>
																</div>
															</td>
														</tr>
											
														<tr class = "induction-expiry-row expiry_staying_safe">
															<td>
																<div class = "row">
																	<div class = "induction-required">
																		<?php echo $form->labelEx($model, 'induction_expiry'); ?>
																	</div>
														
																	<div class = "required">
																		<?php $this->widget('EDatePicker', array(
																			'model'     => $model,
																			'attribute' =>'induction_expiry',
																				'mode'=> 'expiry',
																				'name'=>'InductionRecords[4][induction_expiry]'
																		)); ?>
																	</div>
																</div>
															</td>
														</tr>
													</table>
												</td>
											</tr> 
										</table>
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Staying Safe (SMS) -->
						
						<!-- Induction of Airside Driving (ADA) -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title">
										<strong>
											<?php echo $induction->findByPk(5)->induction_name;?>
										</strong>
									</div>
									
									<div class = "induction-icons-records">
										<div class = "password-border">
											<table class="no-margin-bottom">
												<tr>
													<td>
														<strong>Induction Information</strong>
													</td>
												</tr>
											
												<tr>
													<td>
														<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
															<tr>
																<td>
																	<div style="display:inline-block;">
																		<?php echo $form->labelEx($model, 'is_required_induction'); ?>
																		<div class="switch switch-blue">
																			<input type="radio" class="switch-input is_required_induction_radio airside_driving" name="required_induction_airside_driving" value="0" id="week_airside_driving" checked>
																			<label for="week_airside_driving" class="switch-label switch-label-off" id = "off_airside_driving">OFF</label>
																			<input type="radio" class="switch-input is_required_induction_radio airside_driving" name="required_induction_airside_driving" value="1" id="month_airside_driving" <?php if(!empty($model->is_required_induction) && ($model->is_required_induction == "1")){echo 'checked'; }?>>
																			<label for="month_airside_driving" class="switch-label switch-label-on" id = "on_airside_driving">ON</label>
																			<span class="switch-selection"></span>
																		</div>
																	</div>
																</td>
															</tr> 
														
															<tr class = "induction-completed-row completed_airside_driving">
																<td>
																	<div class = "row">
																		<div class = "induction-required">
																			<?php echo $form->labelEx($model, 'is_completed_induction'); ?>
																		</div>
														
																		<div class = "compactRadioGroup radioBtnlist_airside_driving">
																			<?php echo $form->radioButtonList($model,'[5]is_completed_induction',array(0=>"No",1=>"Yes"), array('separator' => " ")); ?>
																		</div>
																	</div>
																</td>
															</tr>
											
															<tr class = "induction-expiry-row expiry_airside_driving">
																<td>
																	<div class = "row">
																		<div class = "induction-required">
																			<?php echo $form->labelEx($model, 'induction_expiry'); ?>
																		</div>
														
																		<div class = "required">
																			<?php $this->widget('EDatePicker', array(
																				'model'     => $model,
																				'attribute' =>'induction_expiry',
																				'mode'=> 'expiry',
																				'name'=>'InductionRecords[5][induction_expiry]'
																			)); ?>
																		</div>
																	</div>
																</td>
															</tr>
														</table>
													</td>
												</tr> 
											</table>
										</div>
										
										<div class = "adding-induction-icon">
											<div class = "indcution-checkbox">
												<div>
													<?php //echo $form->checkBox($model,'induction_id'); ?>
												</div>
													
												<div class = "adding-print-file">
													<Strong>Add to Print File</Strong>
												</div>								
											</div>
											<div class = "airside-driving-icon">
												add airside-driving-icons
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Airside Driving (ADA) -->
						
						<!-- Induction of Drug and Alcohol Management Policy -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title">
										<strong>
											<?php echo $induction->findByPk(6)->induction_name;?>
										</strong>
									</div>
									
									<div class = "induction-icons-records">
										<div class = "password-border">
											<table class="no-margin-bottom">
												<tr>
													<td>
														<strong>Induction Information</strong>
													</td>
												</tr>
											
												<tr>
													<td>
														<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
															<tr>
																<td>
																	<div style="display:inline-block;">
																		<?php echo $form->labelEx($model, 'is_required_induction'); ?>
																		<div class="switch switch-blue">
																			<input type="radio" class="switch-input is_required_induction_radio drug_and_alcohol" name="required_induction_drug_and_alcohol" value="0" id="week_drug_and_alcohol" checked>
																			<label for="week_drug_and_alcohol" class="switch-label switch-label-off" id = "off_drug_and_alcohol">OFF</label>
																			<input type="radio" class="switch-input is_required_induction_radio drug_and_alcohol" name="required_induction_drug_and_alcohol" value="1" id="month_drug_and_alcohol" <?php if(!empty($model->is_required_induction) && ($model->is_required_induction == "1")){echo 'checked'; }?>>
																			<label for="month_drug_and_alcohol" class="switch-label switch-label-on" id = "on_drug_and_alcohol">ON</label>
																			<span class="switch-selection"></span>
																		</div>
																	</div>
																</td>
															</tr> 
														
															<tr class = "induction-completed-row completed_drug_and_alcohol">
																<td>
																	<div class = "row">
																		<div class = "induction-required">
																			<?php echo $form->labelEx($model, 'is_completed_induction'); ?>
																		</div>
														
																		<div class = "compactRadioGroup radioBtnlist_drug_and_alcohol">
																			<?php echo $form->radioButtonList($model,'[6]is_completed_induction',array(0=>"No",1=>"Yes"), array('separator' => " ")); ?>
																		</div>
																	</div>
																</td>
															</tr>
											
															<tr class = "induction-expiry-row expiry_drug_and_alcohol">
																<td>
																	<div class = "row">
																		<div class = "induction-required">
																			<?php echo $form->labelEx($model, 'induction_expiry'); ?>
																		</div>
														
																		<div class = "required">
																			<?php $this->widget('EDatePicker', array(
																				'model'     => $model,
																				'attribute' =>'induction_expiry',
																				'mode'=> 'expiry',
																				'name'=>'InductionRecords[6][induction_expiry]'
																			)); ?>
																		</div>
																	</div>
																</td>
															</tr>
														</table>
													</td>
												</tr> 
											</table>
										</div>
										
										<div class = "adding-induction-icon">
											<div class = "indcution-checkbox">
												<div>
													<?php //echo $form->checkBox($model,'induction_id'); ?>
												</div>
													
												<div class = "adding-print-file">
													<Strong>Add to Print File</Strong>
												</div>								
											</div>
											<div class = "red-cross-icon">
												add Drug-Alcohol-icons
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Drug and Alcohol Management Policy -->						
					</table>
				</div><!-- End Pieces of Induction Information -->
				
				<div class="row buttons save_button">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('id' => 'submitForm', 'class' => 'complete')); ?>
				</div>
			</div>				
		</td><!-- End Table of induction management -->
	</tr>
</table>

<?php $this->endWidget(); ?>

<script>   
	$(".induction-completed-row").hide();
	$(".induction-expiry-row").hide();
	
		
	/*----------------Input Information Section---------------------*/
	$("#cmn-toggle-1").change(function(){
		var $input = $( this );
		if($input.prop("checked")){
			//console.log("checked");
			$(".personal-details-input-section").hide();
		} else{
			//console.log("checked not");
			$(".personal-details-input-section").show();
		}
	}).change();
	
	$("#cmn-toggle-2").change(function(){
		var $input = $( this );
		if($input.prop("checked")){
			//console.log("checked");
			$(".contact-details-input-section").hide();
		} else{
			//console.log("checked not");
			$(".contact-details-input-section").show();
		}
	}).change();
	
	$("#cmn-toggle-3").change(function(){
		var $input = $( this );
		if($input.prop("checked")){
			//console.log("checked");
			$(".contact-address-input-section").hide();
		} else{
			//console.log("checked not");
			$(".contact-address-input-section").show();
		}
	}).change();
	
	$("#cmn-toggle-4").change(function(){
		var $input = $( this );
		if($input.prop("checked")){
			//console.log("checked");
			$(".conpany-details-input-section").hide();
		} else{
			//console.log("checked not");
			$(".conpany-details-input-section").show();
		}
	}).change();
	
	/*--------------------------------------------------------------*/
	
	/*----------------Induction Records Section---------------------*/
	/* Airside Saftey selection */
	$(".airside_saftey").click(function(){
		//console.log("airside saftey completed");
		var value=$(this).val();        // selected value 
		if(value == 1){
			//console.log("a1");
			$(".completed_airside_saftey").show();
		}else{ 
			console.log("a2");
			$(".completed_airside_saftey").hide(); 
			$(".expiry_airside_saftey").hide();
		}
	});

	$("#InductionRecords_1_is_completed_induction_0").click(function(){
		//console.log("airside saftey expiry");
		$(".expiry_airside_saftey").hide();
	});
	
	$("#InductionRecords_1_is_completed_induction_1").click(function(){
		//console.log("airside saftey expiry");
		$(".expiry_airside_saftey").show();
	});
	/*----------------------------------------------------------------*/

/* Orientation selection */
	$(".orientation").click(function(){
		//console.log("orientation completed");
		var value=$(this).val();        // selected value 
		if(value == 1){
			//console.log("o1");
			$(".completed_orientation").show();
		}else{ 
			//console.log("o2");
			$(".completed_orientation").hide(); 
			$(".expiry_orientation").hide();
		}
	});

	$("#InductionRecords_2_is_completed_induction_0").click(function(){
		//console.log("orientation expiry");
		$(".expiry_orientation").hide();
	});
	
	$("#InductionRecords_2_is_completed_induction_1").click(function(){
		//console.log("orientation expiry");
		$(".expiry_orientation").show();
	});
	/*----------------------------------------------------------------*/

/* Security selection */
	$(".security").click(function(){
		var value=$(this).val();        // selected value 
		if(value == 1){ 
			$(".completed_security").show();
		}else{  
			$(".completed_security").hide(); 
			$(".expiry_security").hide();
		}
	});

	$(".radioBtnlist_security > #InductionRecords_is_completed_induction_3 > #InductionRecords_is_completed_induction_0").click(function(){
		//console.log("security expiry");
		$(".expiry_security").hide();
	});
	
	$(".radioBtnlist_security > #InductionRecords_is_completed_induction_3 > #InductionRecords_is_completed_induction_1").click(function(){
		//console.log("security expiry");
		$(".expiry_security").show();
	});
	/*----------------------------------------------------------------*/

/* Staying Safe (SMS) selection */
	$(".staying_safe").click(function(){
		var value=$(this).val();        // selected value 
		//console.log(value);
		if(value == 1){ 
		//console.log("staying_safe 1");
			$(".completed_staying_safe").show();
		}else{  
			//console.log("staying_safe 0");
			$(".completed_staying_safe").hide(); 
			$(".expiry_staying_safe").hide();
		}
	});

	$(".radioBtnlist_staying_safe > #InductionRecords_is_completed_induction_4 > #InductionRecords_is_completed_induction_0").click(function(){
		//console.log("orientation expiry");
		$(".expiry_staying_safe").hide();
	});
	
	$(".radioBtnlist_staying_safe > #InductionRecords_is_completed_induction_4 > #InductionRecords_is_completed_induction_1").click(function(){
		//console.log("orientation expiry");
		$(".expiry_staying_safe").show();
	});
	/*----------------------------------------------------------------*/	
	
	/* Airside Driving (ADA) selection */
	$(".airside_driving").click(function(){
		var value=$(this).val();        // selected value 
		//console.log(value);
		if(value == 1){ 
		//console.log("airside_driving 1");
			$(".completed_airside_driving").show();
		}else{  
			//console.log("airside_driving 0");
			$(".completed_airside_driving").hide(); 
			$(".expiry_airside_driving").hide();
		}
	});

	$(".radioBtnlist_airside_driving > #InductionRecords_is_completed_induction_5 > #InductionRecords_is_completed_induction_0").click(function(){
		//console.log("airside_driving expiry");
		$(".expiry_airside_driving").hide();
	});
	
	$(".radioBtnlist_airside_driving > #InductionRecords_is_completed_induction_5 > #InductionRecords_is_completed_induction_1").click(function(){
		//console.log("airside_driving expiry");
		$(".expiry_airside_driving").show();
	});
	/*----------------------------------------------------------------*/	
	
	/* Drug and Alcohol Management Policy selection */
	$(".drug_and_alcohol").click(function(){
		var value=$(this).val();        // selected value 
		//console.log(value);
		if(value == 1){ 
		//console.log("drug_and_alcohol 1");
			$(".completed_drug_and_alcohol").show();
		}else{  
			//console.log("drug_and_alcohol 0");
			$(".completed_drug_and_alcohol").hide(); 
			$(".expiry_drug_and_alcohol").hide();
		}
	});

	$(".radioBtnlist_drug_and_alcohol > #InductionRecords_is_completed_induction_5 > #InductionRecords_is_completed_induction_0").click(function(){
		//console.log("drug_and_alcohol expiry");
		$(".expiry_drug_and_alcohol").hide();
	});
	
	$(".radioBtnlist_drug_and_alcohol > #InductionRecords_is_completed_induction_5 > #InductionRecords_is_completed_induction_1").click(function(){
		//console.log("drug_and_alcohol expiry");
		$(".expiry_drug_and_alcohol").show();
	});
	/*----------------------------------------------------------------*/
</script>