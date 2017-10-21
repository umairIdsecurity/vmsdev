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
$company = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}

$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');

// set default country is Australia = 13
$visitor->identification_country_issued = 13;
?>
<style type="text/css">
	div.ajax-upload-dragdrop {
		margin-left: -15px !important;
		margin-top: -396px !important;
		position: absolute;
	}
	
	div.uploadnotetext {
		margin-top: 76px;
	}

	div.actionForward.ajax-file-upload.btn.btn-info {
		margin-left: -69px !important;
		margin-top: 328px !important;
	} 

	.columns-induction-section {
		vertical-align: top; 
		float: left; 
		width: 300px"
	}

	.upload-photo-table {
		width: 300px;
		float: left;
		min-height: 320px;
		margin-left: -8px !important;
	} 

	.cardPhotoPreview{
		height: 0px; 
		margin-left: 15px;
	}
	
	#Visitor_photo_em {
		display: none;
	}
	
	.btn editImageBtn actionForward {
		margin-bottom: 2px!important;		
	}
	
	div.details-information {
		margin-left: 10px;
		width: 320px;
	}
	
	.cmn-toggle {
		position: absolute;
		visibility: hidden;
	}

	span.personal-details-title.has-sub {
		font-size: 12px;
		color: #58585A;
		font-weight: bold;
		margin-left: 8px;
	}
	
	.cmn-toggle+label {
		display: block;
		position: relative;
		cursor: pointer;
		outline: none;
		user-select: none;
		background-color: #f1f1f1;	
		border-radius: 5px;
		border-radius: 5px;
	}
	
	.title-details-input {
		height: 31px;
		line-height: 31px;
		width: 320px;
		position: relative;
		margin-bottom: 2px;
	}
	
	td > div > div > div > label:after {
		content: "";
		position: absolute;
		top: 14px;
		right: 14px;
		border: 5px solid transparent;
		border-left: 5px solid #ffffff;
		border-color: #4E5800 rgba(0, 0, 0, 0) rgba(0, 0, 0, 0);
	}
	
	input#Visitor_first_name, input#Visitor_middle_name,
	input#Visitor_last_name,  
	#Visitor_email{ 
		height: 17px;
		border: 1px solid #cccccc;	
		width: 205px;
	}
	
	input#Visitor_first_name, input#Visitor_last_name {
		margin-left: 5px;
	}
	
	input#Visitor_contact_number {
		width: 208px;
		margin-left: -2px;
	}
	
	input#Visitor_unit_number {
		height: 17px;
	}
	
	input#Visitor_middle_name, #date_of_birth-input_container {
		margin-left: 22px;
	}  
	 
	.input-title {
		margin-right: -18px;
		width: 110px;
		color: #CCCCCC;
		padding-left: 0;
		padding-top: -18px;
		padding-bottom: 6px;
		line-height: 30px;
		font-size: 13px;
		vertical-align: top !important;
	}
	
	#date_of_birth-input_container {
		width: 205px; 
		height: 17px;
	}
	 
	div.visitor-input-text {
		width: 200px;
		height: 17px;
	}
	
	#Company_unit {
		width: 30px;
		margin-right: 7px;
		height: 17px;
	} 
	
	.personal-details-section {
		display: flex;
		flex-direction: row;
		margin-top: 17px;
		height: 30px; 
		width: 350px;
	}
	
	input#Visitor_street_number {
		width: 117px;
	}
	
	.unit-street-no-table {
		width: 350px;
	}
	
	.personal-details-section unit-street-no {
		widget: 350px;
	}
	
	.company-unit-title {
		width: 20px;
		color: #CCCCCC;
		margin-right: 20px;
		line-height: 30px;
	}
	
	#Company_street_type, #Company_state {
		width: 200px !important;
	}
	
	.street-number-title {
		margin-left: 16px;
		color: #CCCCCC;
		margin-right: 6px;
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
	
	input#Visitor_street_name, input#Visitor_suburb,
    input#Visitor_postcode {
		width: 205px;
	}
	
	.information-row {
		height: 40px;
	} 
	
	input#Visitor_company {
		width: 205px;
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
		padding-top:0px;
		margin-left: 0px;
		font-weight: bold;
		
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
		margin-top: -2px;
		font-size: 15px !important;
		color: #637280 !important;
	}
	
	.adding-print-file {
		font-size: 12px;
		font-weight: bold;
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
	
	.induction-records-title {
		width: 300px;
		height: 60px;
	} 
	
	.induction-section-column {
		width: 300px;
		float: left;
		min-height: 320px;
		margin-left: 40px;"
	}
	
	.add-company-button {
		margin-top: 4px;
		margin-left: 98px;
	}
	
	.asic-holder {
		font-size: 15px; 
		color: #637280;
	}
	
	input#Visitor_profile_type_1 {
		margin-left: 7px;
	}
	
	.asic-holder-title {
		font-weight: bold;
		margin-right: 6px;
	}
	
	.induction-information-strong {
		font-size: 13px;
		color: #637280;
		margin-left: -6px;
	}
	
	.completed-expiry-title {
		margin-left: -27px;
	}
	
	.required-title {
		margin-left: -6px;
	}
	
	.piece-of-induction-title {
		font-size: 12px !important; 
	}
	
	input#InductionRecords_1_induction_expiry_container.hasDatepicker,
	input#InductionRecords_2_induction_expiry_container.hasDatepicker,
	input#InductionRecords_3_induction_expiry_container.hasDatepicker,
	input#InductionRecords_4_induction_expiry_container.hasDatepicker,
	input#InductionRecords_5_induction_expiry_container.hasDatepicker,
	input#InductionRecords_6_induction_expiry_container.hasDatepicker{
		margin-left: 7px;
		width: 102px;
	}
	
	.switch-blue {
		margin-left: 120px;
	}
	
	.password-border {
		max-width: 244px;
		height: auto;
	}
	 
	input.adding-print-file.induction-1, 
	input.adding-print-file.induction-5, 
	input.adding-print-file.induction-6 {
		margin-right: 5px;
	} 
	
	#Visitor_unit_number {
		width: 45px;
	} 
	
	#Visitor_contact_street_type, #Visitor_contact_state {
		width: 220px;
		color: darkgray;
		font-size: 15px;
	}
	
	.select2 select2-container select2-container--default {
		width: 125px !important;
		font-size: 13p !important; 
	}
	
	span.select2-selection.select2-selection--single {
		border-radius: 5px;
		border: 1px solid #CCCCCC;
		height: 30px;
		width: 210px;
		margin-left: 10px;
	}
	
	.actionForward button {
		text-decoration: none;
	}
	
	.actionForward ajax-button {
		float: left; 
		margin-right: 5px; 
		width: 95px; 
		height: 21px;
	}
	
	.personal-details-input {
		width: 320px;
	}
	 
	.personal-details-input.unit {
		width: 53px !important;
	}
	
	#Visitor_identification_type {
		width: 208px;
		margin-left: 20px;
		color: #99999f;
	}
	
	#Visitor_identification_document_no {
		margin-left: 20px;
		width: 195px;
	}
	
	.contact-address-details {
		display: flex;
		flex-direction: row;
		margin-top: 14px;
		margin-bottom: -22px;
	} 
	
	#Visitor_identification_document_expiry_container,
	#Visitor_asic_expiry_container.hasDatepicker,
	#Visitor_asic_no	{
		margin-left: 19px;
		width: 200px;
	} 
	 
	.display-contact-person {
		display: flex;
		flex-direction: row;
	}
	
	#visitorStaffRowTitle, #visitorStaffRow {
		margin-top: 15px;
	}
	
	#Visitor_staff_id {
		width: 211px;
	}
	
	#visitorStaffRow {
		width: 211px !important;
		margin-left: 9px;
	}
	
	
	#visitorStaffRowTitle {
		margin-right: -18px;
		width: 110px;
		color: #CCCCCC;
		padding-left: 0;
		padding-top: -18px;
		padding-bottom: 6px;
		line-height: 30px;
		font-size: 13px;
		vertical-align: top !important;
	}
	 
</style> 
  
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'inductionform',
    //'action' => array('user/'.$action, 'role' => Yii::app()->request->getParam('role'),'id'=>$model->id),
    'htmlOptions' => array("name" => "inductionform"),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>

<table> 
	<tr>
		<!-- Table of photo management -->
		<td class="columns-induction-section">			
			<table class="upload-photo-table">
				<tr>
					<td class="columns-induction-section">
						<table class="upload-photo-table">
							<tr>
								<td >
									<div class="cardPhotoPreview">
										<?php 
											if ($visitor->photo != '') {
												$data = Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
												$my_image = '';
												
												if(!empty($data['db_image'])){
													$my_image = "data:image;base64," . $data['db_image'];
												}else{
													$my_image = $data['relative_path'];
												}
										?>
												<img id="photoPreview2" src="<?php echo $my_image; ?>" class="photo_visitor">
										<?php 
											} else { 
										?>
												<img id="photoPreview2" src="" style="display:none;" class="photo_visitor">
										<?php 
											} 
										?>
									</div>
									<?php
										$bgcolor = CardGenerated::CORPORATE_CARD_COLOR;
										$this->renderPartial("_card",['bgcolor' => $bgcolor,'visitor' => $visitor]);
									?>
									<div id="Visitor_photo_em" class="errorMessage">Please upload a profile image.</div>
									<?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
									<?php 
										if ($visitor->photo != '') : 
									?>
									<input type="button" class="btn editImageBtn actionForward" id="editImageBtn"value="Edit Photo" onclick = "document.getElementById('light').style.display = 'block';
											document.getElementById('fade').style.display = 'block'"/>
									<?php endif; ?>
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
		<td class="columns-induction-section">			
			<div class="details-information">
				<div class="personal-details">
					<div>  
						<input id="cmn-toggle-1" class="cmn-toggle cmn-toggle-yes" type="checkbox">
						<label for="cmn-toggle-1" class="title-details-input"><span class="personal-details-title has-sub">Personal Detials</span></label>						
					</div>
					
					<div class="personal-details-input-section">
						<table>
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">First Name
										</div>
										<div class="visitor-input-text">
											<div class="personal-details-input">
												<?php echo $form->textField($visitor, 'first_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_first_name", 'placeholder' => 'First Name')); ?>
												<span class="required"></span>
											</div>
											<?php echo $form->error($visitor, 'first_name'); ?>
										</div>
									</div> 
								</td>
							</tr>
						
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Middle Name
										</div>
										<div class="personal-details-input">
											<?php echo $form->textField($visitor, 'middle_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_middle_name", 'placeholder' => 'Middle Name')); ?>
										</div>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Last Name</div>
										<div class="visitor-input-text">
											<div class="personal-details-input required">
												<?php echo $form->textField($visitor, 'last_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_last_name", 'placeholder' => 'Last Name')); ?>
											</div>
											<?php echo $form->error($visitor, 'last_name'); ?>
										</div>	
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Date of Birth
										</div>
										<div class="personal-details-input required">
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
				
				<div class="contact-details">
					<div>  
						<input id="cmn-toggle-2" class="cmn-toggle cmn-toggle-yes" type="checkbox">
						<label for="cmn-toggle-2" class="title-details-input"><span class="personal-details-title has-sub">Contact Details</span></label>						
					</div>
					
					<div class="contact-details-input-section">
						<table>
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Email
										</div>
										<div class="visitor-input-text">
											<div class="personal-details-input required">
												<?php echo $form->textField($visitor, 'email', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_email", 'placeholder' => 'Email')); ?>
											</div>
											<?php echo $form->error($visitor, 'email'); ?>
										</div>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Mobile
										</div>
										<div>
											<div class="contact-details required">
												<?php echo $form->textField($visitor, 'contact_number', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_contact_number", 'placeholder' => 'Mobile')); ?>
											</div>
											<?php echo $form->error($visitor, 'contact_number'); ?>
										</div>
									</div>  
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="contact-address">
					<div>  
						<input id="cmn-toggle-3" class="cmn-toggle cmn-toggle-yes" type="checkbox">
						<label for="cmn-toggle-3" class = "title-details-input"><span class="personal-details-title has-sub">Contact Address</span></label>						
					</div>
					
					<div class="contact-address-input-section">
						<div class="unit-street-no-table">
							<table>	
								<tr>
									<td>
										<div class="contact-address-details">
											<div class="company-unit-title">Unit</div>
											<div class="personal-details-input unit">
												<?php echo $form->textField($visitor, 'contact_unit', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_unit_number", 'placeholder' => 'Unit')); ?>
											</div>
											
											<div class="street-number-title">Street No.</div>
											<div>
												<div class="personal-details-input street-no required">
													<?php echo $form->textField($visitor, 'contact_street_no', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_street_number", 'placeholder' => 'Street No.')); ?>
												</div>
												<?php echo $form->error($visitor, 'contact_street_no'); ?>
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
										<div class="personal-details-section">
											<div class="input-title">Street Name
											</div>
											
											<div class="visitor-input-text">
												<div class="personal-details-input">
													<?php echo $form->textField($visitor, 'contact_street_name', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_street_name", 'placeholder' => 'Street Name')); ?>
													<span class="required"></span>
												</div>
												<?php echo $form->error($visitor, 'contact_street_name'); ?>
											</div> 
										</div>  
									</td>
								</tr>
						
								<tr>
									<td>
										<div class="personal-details-section">
											<div class="input-title">Type
											</div>
											<div class="visitor-input-text">
												<div class = "personal-details-input">
													<?php echo $form->dropDownList($visitor, 'contact_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type')); ?>
													<span class="required"></span>
												</div>
												<?php echo $form->error($visitor, 'contact_street_type'); ?>
											</div>
										</div>  
									</td>
								</tr>
						
								<tr>
									<td>
										<div class="personal-details-section">
											<div class="input-title">Suburb
											</div>
											<div class="visitor-input-text">
												<div class = "personal-details-input required">
													<?php echo $form->textField($visitor, 'contact_suburb', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_suburb", 'placeholder' => 'Suburb')); ?>
												</div>
												<?php echo $form->error($visitor, 'contact_suburb'); ?>
											</div>
										</div>  
									</td>
								</tr>
						
								<tr>
									<td>
										<div class="personal-details-section">
											<div class="input-title">Postcode
											</div>
											<div class="visitor-input-text">
												<div class="personal-details-input">
													<?php echo $form->textField($visitor, 'contact_postcode', array('size' => 50, 'maxlength' => 50, 'id'=>"Visitor_postcode", 'placeholder' => 'Postcode')); ?>
													<span class="required"></span>
												</div>
												<?php echo $form->error($visitor, 'contact_postcode'); ?>
											</div>
										</div>  
									</td>
								</tr>
								
								<tr>
									<td>
										<div class="personal-details-section">
											<div class="input-title">State
											</div>
											<div class="visitor-input-text">
												<div class="personal-details-input required">
													<?php echo $form->dropDownList($visitor, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State')); ?>
												</div>
												<?php echo $form->error($visitor, 'contact_state'); ?>
											</div>
										</div>  
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				
				<div class="company-details">
					<div>  
						<input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-yes" type="checkbox">
						<label for="cmn-toggle-4" class="title-details-input"><span class="personal-details-title has-sub">Company Details</span></label>						
					</div>
					
					<div class="conpany-details-input-section">
						<table>
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Company Name
										</div>
										
										<div class="search-company-name">
											<?php
												$this->widget('application.extensions.select2.Select2', array(
												'model' => $visitor,
												'attribute' => 'company',
												'items' => CHtml::listData(Visitor::model()->findAllCompanyByTenant($session['tenant']),
												'id', 'name'),
												'selectedItems' => array(), // Items to be selected as default
												'placeHolder' => 'Please select a company'
												));
											?>
												<span class="required"></span>
												<?php echo $form->error($model, 'company'); ?>
										</div>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class="display-contact-person">
										<div id="visitorStaffRowTitle"></div>
										<div id="visitorStaffRow"></div>
									</div>
								</td>
							</tr>
							
							<tr>
								<td>
									<div class="add-company-button">
										<a style="float: left; margin-right: 5px; width: 95px; height: 21px;  margin-bottom: 12px;" href="#addCompanyContactModal" role="button" data-toggle="modal" id="addCompanyLink" class="actionForward">Add Company</a>
										<a href="#addCompanyContactModal" id="addContactLink" class="btn btn-xs btn-info actionForward" style="font-size: 12px; font-weight: bold; display: none; margin-bottom: 10px;" role="button" data-toggle="modal">Add Contact</a>
                                 
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="identification-details">
					<div>  
						<input id="cmn-toggle-5" class="cmn-toggle cmn-toggle-yes" type="checkbox">
						<label for="cmn-toggle-5" class="title-details-input"><span class="personal-details-title has-sub">Identification</span></label>						
					</div>
					
					<div class="identification-details-input-section">
						<table>
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Identification Type
										</div> 
										<div class="identification-input required">
											<?php
												echo $form->dropDownList($visitor, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Select Identification Type'));
											?>
										</div>
											<?php echo $form->error($visitor, 'identification_type'); ?>
									</div>  
								</td>
							</tr>
						
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">Document No.
										</div>
										<div>
											<div class="identification-input required">
												<?php echo $form->textField($visitor, 'identification_document_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Document No.')); ?>
											</div>
											<?php echo $form->error($visitor, 'identification_document_no'); ?>
										</div>
									</div>  
								</td>
							</tr>
							
							<tr>
								<td>
									<div class="personal-details-section required">
										<div class="input-title">Document Expiry
										</div>
										<div>
											<?php
												$this->widget('EDatePicker', array(
												'model'       => $visitor,
												'attribute'   => 'identification_document_expiry',
												'mode'        => 'expiry',
												));
											?>
										</div>	
										<?php echo $form->error($model, 'identification_document_expiry'); ?> 	
									</div>  
								</td>
							</tr>
							
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">ASIC No.
										</div>
										<div>
											<div class="identification-input required">
												<?php echo $form->textField($visitor, 'asic_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'ASIC No.')); ?>
											</div>
											<?php echo $form->error($visitor, 'asic_no'); ?>
										</div>
									</div>  
								</td>
							</tr>
							
							<tr>
								<td>
									<div class="personal-details-section">
										<div class="input-title">ASIC Expiry
										</div>
										<div>
											<div class="identification-input required">
												<?php
													$this->widget('EDatePicker', array(
														'model'       =>  $visitor,
														'attribute'   => 'asic_expiry',
														'mode'        => 'asic_expiry',
													));
												?>
											 </div>
											<?php echo $form->error($visitor, 'asic_expiry'); ?>
										</div>
									</div>  
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</td><!-- End Table of information management -->
		
		<!-- Table of induction management --> 
		<td class="columns-induction-section">			
			<div class="induction-section-column">
				<div class="induction-icon-section">
					<div class="induction-records-title">
						<h4 class="induction-title">Induction Records</h4> 
						<div class = "row">
							<div class = "asic-holder">
								<?php echo $form->labelEx($model, 'ASIC Holder :', array('class'=>'asic-holder-title')); ?>
							</div>
							<div class = "compactRadioGroup radioBtnlist_airside_saftey">
								<?php echo $form->radioButtonList($visitor,'profile_type',array(0=>"Yes",1=>"No"), array('separator' => " ")); ?>
							</div>
						</div>
					</div> 
				</div>
				
				<!-- Pieces of Induction Information -->
				<div>					
					<table>
					<!-- Induction of Airside Safety -->
						<tr>
							<td>
								<div class="pieces-induction">
									<div class = "induction-title add-print-file">
										<div>
											<strong class="piece-of-induction-title">
												<?php echo $induction->findByPk(1)->induction_name;?>
												
											</strong>
										</div>
										<div class = "adding-print-file">
											<input type="checkbox" name="print-file" class="adding-print-file induction-1">Add to Print File
										</div>
									</div>
									
									<div class = "induction-icons-records">
										<div class = "password-border">
											<table class="no-margin-bottom">
												<tr>
													<td>
														<strong class="induction-information-strong">Induction Information</strong>
														
													</td>												
												</tr>
											
												<tr>
													<td>
														<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
															<tr>
																<td>
																	<div style="display:inline-block;">
																		<?php echo $form->labelEx($model, 'is_required_induction', array('class'=>'required-title')); ?>
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
																			<?php echo $form->labelEx($model, 'is_completed_induction', array('class'=>'completed-expiry-title')); ?>
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
																			<?php echo $form->labelEx($model, 'induction_expiry', array('class'=>'completed-expiry-title')); ?>
																		</div>
														
																		<div class = "required">
																			<?php $this->widget('EDatePicker', array(
																				'model'     => $model,
																				'attribute' =>'induction_expiry',
																				'mode'=> 'expiry',
																				'name'=>'InductionRecords[1][induction_expiry]',
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
								</div>
							</td>
						</tr><!-- End Induction of Airside Safety -->
						
						<!-- Induction of Orientation -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title">
										<strong class="piece-of-induction-title">
											<?php echo $induction->findByPk(2)->induction_name;?>
										</strong>
									</div>
									
									<div class = "password-border">
										<table class="no-margin-bottom">
											<tr>
												<td>
													<strong class="induction-information-strong">Induction Information</strong>
													
												</td>
											</tr>
											
											<tr>
												<td>
													<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
														<tr>
															<td>
																<div style="display:inline-block;">
																	<?php echo $form->labelEx($model, 'is_required_induction', array('class'=>'required-title')); ?>
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
																		<?php echo $form->labelEx($model, 'is_completed_induction', array('class'=>'completed-expiry-title')); ?>
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
																		<?php echo $form->labelEx($model, 'induction_expiry', array('class'=>'completed-expiry-title')); ?>
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
										<strong class="piece-of-induction-title">
											<?php echo $induction->findByPk(3)->induction_name;?>
										</strong>
									</div>
									
									<div class = "password-border">
										<table class="no-margin-bottom">
											<tr>
												<td>
													<strong class="induction-information-strong">Induction Information</strong>
												</td>
											</tr>
											
											<tr>
												<td>
													<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
														<tr>
															<td>
																<div style="display:inline-block;">
																	<?php echo $form->labelEx($model, 'is_required_induction', array('class'=>'required-title')); ?>
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
																		<?php echo $form->labelEx($model, 'is_completed_induction', array('class'=>'completed-expiry-title')); ?>
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
																		<?php echo $form->labelEx($model, 'induction_expiry', array('class'=>'completed-expiry-title')); ?>
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
										<strong class="piece-of-induction-title">
											<?php echo $induction->findByPk(4)->induction_name;?>
										</strong>
									</div>
									
									<div class = "password-border">
										<table class="no-margin-bottom">
											<tr>
												<td>
													<strong class="induction-information-strong">Induction Information</strong>
												</td>
											</tr>
											
											<tr>
												<td>
													<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
														<tr>
															<td>
																<div style="display:inline-block;">
																	<?php echo $form->labelEx($model, 'is_required_induction', array('class'=>'required-title')); ?>
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
																		<?php echo $form->labelEx($model, 'is_completed_induction', array('class'=>'completed-expiry-title')); ?>
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
																		<?php echo $form->labelEx($model, 'induction_expiry', array('class'=>'completed-expiry-title')); ?>
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
									<div class = "induction-title add-print-file">
										<div>
											<strong class="piece-of-induction-title">
												<?php echo $induction->findByPk(5)->induction_name;?>
											</strong>
										</div>
										<div class = "adding-print-file">
											<input type="checkbox" name="print-file" class="adding-print-file induction-5">Add to Print File
										</div>
									</div>
									
									<div class = "induction-icons-records">
										<div class = "password-border">
											<table class="no-margin-bottom">
												<tr>
													<td>
														<strong class="induction-information-strong">Induction Information</strong>
													</td>
												</tr>
											
												<tr>
													<td>
														<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
															<tr>
																<td>
																	<div style="display:inline-block;">
																		<?php echo $form->labelEx($model, 'is_required_induction', array('class'=>'required-title')); ?>
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
																			<?php echo $form->labelEx($model, 'is_completed_induction', array('class'=>'completed-expiry-title')); ?>
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
																			<?php echo $form->labelEx($model, 'induction_expiry', array('class'=>'completed-expiry-title')); ?>
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
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Airside Driving (ADA) -->
						
						<!-- Induction of Drug and Alcohol Management Policy -->
						<tr>
							<td>
								<div class = "pieces-induction">
									<div class = "induction-title add-print-file">
										<div>
											<strong class="piece-of-induction-title">
												<?php echo $induction->findByPk(6)->induction_name;?>
											</strong> 
										</div>
										<div class = "adding-print-file">
											<input type="checkbox" name="print-file" class="adding-print-file induction-6">Add to Print File
										</div>
									</div>
									
									<div class = "induction-icons-records">
										<div class = "password-border">
											<table class="no-margin-bottom">
												<tr>
													<td>
														<strong class="induction-information-strong">Induction Information</strong>
													</td>
												</tr>
											
												<tr>
													<td>
														<table style=" margin-top:18px !important; width:253px; border-left-style:none; border-top-style:none">
															<tr>
																<td>
																	<div style="display:inline-block;"> 
																		<?php echo $form->labelEx($model, 'is_required_induction', array('class'=>'required-title')); ?>
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
																			<?php echo $form->labelEx($model, 'is_completed_induction', array('class'=>'completed-expiry-title')); ?>
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
																			<?php echo $form->labelEx($model, 'induction_expiry', array('class'=>'completed-expiry-title')); ?>
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
									</div>
								</div>
							</td>
						</tr><!-- End Induction of Drug and Alcohol Management Policy -->						
					</table>
				</div><!-- End Pieces of Induction Information -->
				
				<div class="row buttons save_button">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('id' => '
					
					', 'class' => 'complete')); ?>
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
	
	$("#cmn-toggle-5").change(function(){
		var $input = $( this );
		if($input.prop("checked")){
			//console.log("checked");
			$(".identification-details-input-section").hide();
		} else{
			//console.log("checked not");
			$(".identification-details-input-section").show();
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

	$("#InductionRecords_3_is_completed_induction_0").click(function(){
		//console.log("orientation expiry");
		$(".expiry_security").hide();
	});
	
	$("#InductionRecords_3_is_completed_induction_1").click(function(){
		//console.log("orientation expiry");
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

	$("#InductionRecords_4_is_completed_induction_0").click(function(){
		//console.log("orientation expiry");
		$(".expiry_staying_safe").hide();
	});
	
	$("#InductionRecords_4_is_completed_induction_1").click(function(){
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

	$("#InductionRecords_5_is_completed_induction_0").click(function(){
		//console.log("orientation expiry");
		$(".expiry_airside_driving").hide();
	});
	
	$("#InductionRecords_5_is_completed_induction_1").click(function(){
		//console.log("orientation expiry");
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

	$("#InductionRecords_6_is_completed_induction_0").click(function(){
		//console.log("orientation expiry");
		$(".expiry_drug_and_alcohol").hide();
	});
	
	$("#InductionRecords_6_is_completed_induction_1").click(function(){
		//console.log("orientation expiry");
		$(".expiry_drug_and_alcohol").show();
	});
	/*----------------------------------------------------------------*/
		

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

    function populateAgentAdminWorkstations(isSearch) 
    {
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
                        var selected = <?php echo isset($session['workstation']) ? $session['workstation'] : '0' ?>;
                        var workstation = $('#userWorkstation').val();
                        if (selected != 0) {
                            var selectedWorkstation = selected;
                        } else {
                            var selectedWorkstation = workstation;
                        }
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

// // company change
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
				$('#visitorStaffRowTitle').empty();
            } else {
                $('#visitorStaffRow').html(data);
				$('#visitorStaffRowTitle').text("Contact Person");
                $('#addContactLink').show();
            }
            return false;
			
			display-contact-person
        }
    });
});
	
	
	
	
	
</script>