<?php
$session = new CHttpSession;
    $cs = Yii::app()->clientScript;
    //$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
    //$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');
	
    //this is because below country model become ambigious for name values on Window Server
    $countryList = CHtml::listData(Yii::app()->db->createCommand('select a.* from country a inner join (select distinct name, min(id) as id from country group by name) as b on a.name = b.name and a.id = b.id order by name asc')->queryAll(),'id', 'name');
    $tenant=$session['tenant'];
    /*$countryList = CHtml::listData(
                                    Country::model()->findAll(array(
                                    "order" => "name asc",
                                    "group" => "name"
                                )), 'id', 'name'
                    );*/
					
					?>

<div class="page-content">

  
    <!--<div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>-->
    


    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'operational-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            /*'afterValidate'    => 'js:function(form, data, hasError){
                return afterValidate(form, data, hasError);
            }'*/
        ),
        'htmlOptions'=>array(
            'class'=> 'form-comfirm-detail',
			'enctype'=>'multipart/form-data'
			
        )
    ));
    ?>
        

        <div class="row" id="new_asic_area">
		<div class="col-sm-4" style=";margin-top: -2.2%;" >
			<h3 class="text-primary subheading-size" >Employment Status</h3>
               
				<div class="form-group" style="width:150%;">
				 <label>Please select one  </br></label>
				 <br><br>
				 <?php
				echo $form->radioButtonList($model, 'company_radio',array(
					'1'=>'Contractor', 
					'2'=>'Airport Operator',
					'3'=>'Employee of a company'
					),array('class' => 'password_requirement form-label','separator'=>'</br></br>',/*'style'=>'display:inline; margin-left:20px;'*/));
					echo $form->error($model,'company_radio');
					?>
				</div>
				<div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12" style='font-size:smaller; margin-top:15px;'>
					<label>Download Authorised Contact Letter from <a target="_blank" href="vmsdev-win.identitysecurity.info/uploads/Employers_Certification3739.pdf">here</a></label>
					<label>Upload the Authorised Contact Letter:</label>
					<?php echo $form->fileField($model,'authorised_file', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
					<?php echo $form->error($model, 'authorised_file'); ?>
					</div>
					</div>
					<div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12" style='font-size:smaller; margin-top:15px;'>
					<label>Upload the Operational Need Letter:</label>
					<?php echo $form->fileField($fileModel,'op_need_document', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
					<?php echo $form->error($fileModel,'op_need_document'); ?>
					</div>
					</div>
            </div>
		<div class="col-sm-3">
                &nbsp;
            </div>
            <div class="col-sm-4" style="display:inline; margin-left: -28%;margin-top: -2.2%;">
			<h3 class="text-primary subheading-size" >Employment Information</h3>
                <div class="form-group">
				 <label>Company Details</br></label>
                    <?php $this->widget('application.extensions.select2.Select2', array(
                            'model' => $model,
                            'attribute' => 'name',
                            'items' => CHtml::listData(Company::model()->findAll('is_deleted=0 and company_type=3 and tenant = '.$tenant ), 'id', 'name'),
                            'placeHolder' => 'Select Company',
                        )); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>				
				 <div class="form-group">
                <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Company</a>
            </div>

                <div class="form-group" id="addCompanyContactDiv" style="display:none">
                <?php
					if(isset($session['contactData']))
                   echo $form->dropDownList($model,'contact',$session['contactData'],array('empty' => 'Select Company Contact' , 'class'=>'form-control input-sm')); 
					else
					echo $form->dropDownList($model,'contact',array(''),array('empty' => 'Select Company Contact' , 'class'=>'form-control input-sm')); 	
                ?>
                <?php echo $form->error($model,'contact'); ?>

                <div style="display:none" id="companyContactError" class="errorMessage">Please complete Company Contact</div>
					
               
                <!-- </div> -->
                <div class="form-group"> </div>
                <a style="float: left;" href="#addCompanyContactModal" role="button" data-toggle="modal" class="btn btn-primary" id="addCompanyContactModalBtn">Add Contact</a>
				<br>
				
            </div>
			
			<div id="officeno" class="" style="display:none;">
			 <div class="form-group">
                        <?php echo $form->textField($model, 'office_number', array('placeholder' => 'Office Number', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'office_number'); ?>
			</div>
                   
				</div>
				<label>Current Company Address</br></label>
				 <br>
                <div class="row form-group">
                    <div class="col-xs-5">
                        <?php echo $form->textField($model, 'unit', array('maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'unit'); ?>

                    </div>
                    <div class="col-xs-7">
                        <?php echo $form->textField($model, 'street_number', array('maxlength' => 50, 'placeholder' => 'Street No.', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'street_number'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-6">
                        <?php echo $form->textField($model, 'street_name', array('maxlength' => 50, 'placeholder' => 'Street Name', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'street_name'); ?>
                    </div>
                    <div class="col-xs-6">
                        <?php echo $form->dropDownList($model, 'street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'street_type'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'suburb', array('maxlength' => 50, 'placeholder' => 'Suburb' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'suburb'); ?>
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'city', array('maxlength' => 50, 'placeholder' => 'City' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'city'); ?>
                </div>

                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'country', $countryList,
                        array('prompt' => 'Select Country', 'class'=>'form-control input-sm',
                            'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country'); ?>
                </div>

                <div class="row form-group">

                    <div id="stateDropdown" class="col-xs-6">
                        <?php echo $form->dropDownList($model, 'state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'Select State', 'class'=>'form-control input-sm')); ?>
                    </div>
                    
                    <div style="display:none;" id="stateTextbox" class="col-xs-6">
                        <?php echo $form->textField($model, 'state', array('maxlength' => 50, 'placeholder' => 'Enter State', 'class'=>'form-control input-sm','disabled'=>'disabled')); ?>
                    </div> 

                    <div class="col-xs-6">
                        <?php echo $form->textField($model, 'post_code', array('maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'post_code'); ?>
                    </div>


            </div>
			</div>



        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        


        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="pull-left">
                        <a href="<?=Yii::app()->createUrl("preregistration/identificationAsicOnline")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                    </div>
                    <div class="pull-right">
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'id' => 'btnSubmit',
                                'class' => 'btn btn-primary btn-next'
                            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
                    </div>
                </div>
            </div>
        </div>  


    </div>
    <?php $this->endWidget(); ?>


<!-- ************************************************ -->
<!-- ************************************** -->
<!-- -Add Company Modal starts here- -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content login-modal">
            <div class="modal-header login-modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="addCompanyModalLabel">Add COMPANY</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div role="tabpanel" class="login-tab">
                        <!-- Nav tabs -->
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active text-center" id="home">
                                
                                <div class="clearfix"></div>
                                
                                <?php 
                                    $form=$this->beginWidget('CActiveForm', array(
                                        'id'=>'company-form',
                                        'enableAjaxValidation'=>false,
                                        'enableClientValidation'=>true,
                                        //'action' => array('company/addCompany'),
                                        'clientOptions'=>array(
                                            'validateOnSubmit'=>true,
                                        ),
                                        'htmlOptions'=>array(
                                            'onsubmit'=>"return false;",/* Disable normal form submit */
                                            'class'=>"form-create-login"
                                        )
                                    ));
                                ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <?php echo $form->textField($model, 'name', array('placeholder' => 'Company Name','class'=>'form-control input-lg ui-autocomplete-input company-autocomplete','autocomplete' => 'on')); ?>
                                        </div>
										<div class="errorMessage" id="companyNameErr" style="display:none;float:left"></div>
										<br>
										<div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <?php echo $form->textField($model, 'office_number', array('placeholder' => 'Head Office Number','class'=>'form-control input-lg ui-autocomplete-input company-autocomplete')); ?>
                                        </div>
										<div class="errorMessage" id="companyOfficeErr" style="display:none;float:left"></div>
										<br>
										<div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <?php echo $form->textField($model, 'website', array('placeholder' => 'Company website (Optional)','class'=>'form-control input-lg ui-autocomplete-input company-autocomplete')); ?>
                                        </div>
										<div class="errorMessage" id="companyWebErr" style="display:none;float:left"></div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group" style="float:left">
                                            <a class="btn btn-default" href="javascript:;" role="button" id="addComp">+</a> Add Company Contact
                                            <input type="hidden" id="is_user_field_comp" name="is_user_field_comp" value="0">
                                        </div>
                                    </div>

                                    <div style="display:none" id="compDiv">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_first_name', array('class'=>'form-control input-lg','placeholder'=>'First Name')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyFirstnameErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_last_name', array('class'=>'form-control input-lg','placeholder'=>'Last Name')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyLastnameErr" style="display:none;float:left"></div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_email', array('class'=>'form-control input-lg','placeholder'=>'Email Address')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyEmailErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_contact_number', array('class'=>'form-control input-lg','placeholder'=>'Contact Number')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyContactNumberErr" style="display:none;float:left"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button class="btn neutral" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <?php echo CHtml::Button('Add',array('id'=>'addCompanyBtn','class'=>'btn neutral')); ?>
                                    </div>

                                <?php $this->endWidget(); ?>

                            </div>
                          
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
       </div>
    </div>
    <!-- - company Modal Ends Here -->
<!-- ************************************** -->
<!-- ************************************************ -->
<!-- ************************************** -->
<!-- -Add Company Contact Modal starts here- -->
<div class="modal fade" id="addCompanyContactModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content login-modal">
            <div class="modal-header login-modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="addCompanyContactModalLabel">Add COMPANY CONTACT</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div role="tabpanel" class="login-tab">
                        <!-- Nav tabs -->
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active text-center" id="home">
                                
                                <div class="clearfix"></div>
                                
                                <?php 
                                    $form=$this->beginWidget('CActiveForm', array(
                                        'id'=>'companyContact-form',
                                        'enableAjaxValidation'=>false,
                                        'enableClientValidation'=>true,
                                        //'action' => array('company/addCompanyContactPreg'),
                                        'clientOptions'=>array(
                                            'validateOnSubmit'=>true,
                                        ),
                                        'htmlOptions'=>array(
                                            'onsubmit'=>"return false;",/* Disable normal form submit */
                                            'class'=>"form-create-login"
                                        )
                                    ));
                                ?>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>

                                            <input id="companyPlaceholder" type="text" class='form-control input-lg' placeholder='Company' disabled='disabled'/>
                                        <?php
                                            echo $form->hiddenField($model,'name',array('class'=>'companyHiddenField'));
                                            /*$visitor = Registration::model()->findByPk($session['visitor_id']);

                                            if(isset($visitor->tenant)){
                                                echo $form->dropDownList($model, 'name', CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-lg'));
                                            }
                                            else
                                            {
                                                echo $form->dropDownList($model,'name',array(''=>'Select Company'),array('class'=>'form-control input-lg'));
                                            }*/
                                        ?>
                                    </div>
                                    <?php echo $form->error($model,'name',array('style' =>'float:left')); ?>
                                </div>

                                    <div class="form-group">
                                        
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group" style="float:left">
                                            <a class="btn btn-default" href="javascript:;" role="button" id="addContact">+</a> Add Company Contact
                                            <input type="hidden" id="is_user_field_contact" name="is_user_field_contact" value="0">
                                        </div>
                                    </div>

                                    <div style="display:none" id="contactDiv">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_first_name', array('class'=>'form-control input-lg','placeholder'=>'First Name')); ?>
                                            </div>
                                            <?php //echo $form->error($model,'user_first_name',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactFirstnameErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_last_name', array('class'=>'form-control input-lg','placeholder'=>'Last Name')); ?>
                                            </div>
                                            <?php //echo $form->error($model,'user_last_name',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactLastnameErr" style="display:none;float:left"></div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_email', array('class'=>'form-control input-lg','placeholder'=>'Email Address')); ?>
                                            </div>
                                            <?php //echo $form->error($model,'user_email',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactEmailErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($model, 'user_contact_number', array('class'=>'form-control input-lg','placeholder'=>'Contact Number')); ?>
                                            </div>
                                            <?php //echo $form->error($model,'user_contact_number',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactContactNumberErr" style="display:none;float:left"></div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn neutral" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <?php echo CHtml::Button('Add',array('id'=>'addCompanyContactBtn','class'=>'btn neutral')); ?>
                                    </div>
                                    
                                <?php $this->endWidget(); ?>

                            </div>
                          
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
       </div>
    </div>
    <!-- - Add Company Contact Modal Ends Here -->
<!-- ************************************** -->
<!-- ************************************************ -->





<script>
    $(document).ready(function () {
        $('#Registration_contact_country').on('change', function () {
            var countryId = parseInt($(this).val());
            //Dropdown: id=13,value=Australia
            if(countryId == 13){
                $("#stateDropdown").show();
                $("#stateTextbox").hide();
                $("#stateTextbox input").prop("disabled",true);
                $("#stateDropdown select").prop("disabled",false);
            }else{
                $("#stateTextbox").show();
                $("#stateDropdown").hide();
                $("#stateDropdown select").prop("disabled",true);
                $("#stateTextbox input").prop("disabled",false);
            }

        });
		if("<?php if(isset($session['Company_Details'])) {echo "true";} else {echo "false";} ?>"=="true")
			{
				$("#addCompanyContactDiv").show();
				if("<?php if(isset($session['Company_Details'])&& $session['Company_Details']->office_number!=''){echo 1;} else echo 0; ?>"==1)
				$('#officeno').show();
			}
	$("#addComp").click(function(event){
            event.preventDefault();
            var is_user_field_comp = parseInt($("#is_user_field_comp").val());
            if(is_user_field_comp == 1)
            {
                $("#compDiv").hide();
                $('#is_user_field_comp').val("0");
            }
            else{
                $("#compDiv").show();
                $('#is_user_field_comp').val("1");
            }
        });
  
  $("#AsicOnCompany_name").change(function() {
            var compId = $(this).val();
			
            if(compId != "" && compId != null){
				
				
                $.ajax({
                    type: 'POST',
                    url: "<?php echo Yii::app()->createUrl('preregistration/findAllCompanyContactsByCompany');?>",
                    dataType: 'json',
                    data: {"compId":compId},
                    success: function (res) {
                        if (res.data == "") {
                            $("#AsicOnCompany_contact").empty();
                            $("#AsicOnCompany_contact").append("<option  value=''>Add Company Contact</option>");
							if(res.officeno===null)
							{
								$('#officeno').show();
							}
							else
							{
								$('#officeno').hide();
							}
							//$("#companyContactError").show();
                        }
                        else
                        {
							console.log(res);
                            $("#AsicOnCompany_contact").empty();
                            $.each(res.data,function(index,element) {
                                $("#AsicOnCompany_contact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
                            }); 
							if(res.officeno===null || res.officeno=='')
							{
								$('#officeno').show();
							}
							else
							{
								$('#officeno').hide();
								$("#AsicOnCompany_office_number").val('');
							}
                        }
                        $("#addCompanyContactDiv").show();

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }else{
                $("#AsicOnCompany_contact").empty();
                $("#AsicOnCompany_contact").append("<option value=''>Select Company Contact</option>");
                $("#addCompanyContactDiv").hide();
            }
        });
		  $("#addCompanyBtn").click(function(event)
        {
            
            $("#compDiv").show();

            var data=$("#company-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('preregistration/addCompany');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.decision == 0)
                    {
                        if(data.errors){//console.log(data.errors);
                            if(data.errors.name)
                            {
                                if($('#AsicOnCompany_name').val() == ""){
                                    if($('#companyNameErr').is(':empty')){
                                        $("#companyNameErr").append("<p>"+data.errors.name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyNameErr").empty().hide();
                            }
							 if(data.errors.office_number)
                            {
                                if($('#AsicOnCompany_office_number').val() == ""){
                                    if($('#companyOfficeErr').is(':empty')){
                                        $("#companyOfficeErr").append("<p>"+data.errors.office_number+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyOfficeErr").empty().hide();
                            }
							 if(data.errors.website)
                            {
                              
                                    if($('#companyWebErr').is(':empty')){
                                        $("#companyWebErr").append("<p>"+data.errors.website+"</p>").show();
                                    }
                                
                            }else{
                                $("#companyWebErr").empty().hide();
                            }
                            if(data.errors.user_first_name)
                            {
                                if($('#AsicOnCompany_user_first_name').val() == ""){
                                    if($('#companyFirstnameErr').is(':empty')){
                                        $("#companyFirstnameErr").append("<p>"+data.errors.user_first_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyFirstnameErr").empty().hide();
                            }

                            if(data.errors.user_last_name)
                            {
                                if($('#AsicOnCompany_user_last_name').val() == ""){
                                    if($('#companyLastnameErr').is(':empty')){
                                        $("#companyLastnameErr").append("<p>"+data.errors.user_last_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyLastnameErr").empty().hide();
                            }

                            if(data.errors.user_email)
                            {
                                if($('#AsicOnCompany_user_email').val() == ""){
                                    $("#companyEmailErr").empty();
                                    
                                        $("#companyEmailErr").append("<p>"+data.errors.user_email+"</p>").show();
                                    
                                }
                            }else{
                                $("#companyEmailErr").empty().hide();
                            }

                            if(data.errors.email_address)
                            {
                                $("#companyEmailErr").empty();
                                $("#companyEmailErr").append("<p>Email id already exists.</p>").show();
                                
                            }

                            if(data.errors.user_contact_number)
                            {
                                if($('#AsicOnCompany_user_contact_number').val() == ""){
                                    if($('#companyContactNumberErr').is(':empty')){
                                        $("#companyContactNumberErr").append("<p>"+data.errors.user_contact_number+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactNumberErr").empty().hide();
                            }
                        }
                    }
                    else
                    {
                        $("#AsicOnCompany_name").append(data.dropDown);
                        $('.select2-selection__rendered').text(data.compName);
                        $("#AsicOnCompany_contact").empty();
                        $.each(data.contacts,function(index,element) {
                            $("#AsicOnCompany_contact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
                        }); 
                        $("#addCompanyContactDiv").show();
                        $("#addCompanyModal").modal('hide');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
      $("#addCompanyContactModalBtn").click(function(e){
            var companyId = $("#AsicOnCompany_name :selected").val();
            var companyName = $("#AsicOnCompany_name :selected").text();
            
            $("#companyPlaceholder").val(companyName);
            $(".companyHiddenField").val(companyId);

        });
  $("#addContact").click(function(event){
            event.preventDefault();
            var is_user_field_contact = parseInt($("#is_user_field_contact").val());
            if(is_user_field_contact == 1)
            {
                $("#contactDiv").hide();
                $('#is_user_field_contact').val("0");
            }
            else{
                $("#contactDiv").show();
                $('#is_user_field_contact').val("1");
            }
        });
		 $("#addCompanyContactBtn").click(function(event){
            
            $("#contactDiv").show();

            var data=$("#companyContact-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('preregistration/addCompanyContact');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.decision == 0)
                    {
                        if(data.errors){//console.log(data.errors);
                            if(data.errors.user_first_name)
                            {
                                if($('#AsicOnCompany_user_first_name').val() == ""){
                                    if($('#companyContactFirstnameErr').is(':empty')){
                                        $("#companyContactFirstnameErr").append("<p>"+data.errors.user_first_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactFirstnameErr").empty().hide();
                            }

                            if(data.errors.user_last_name)
                            {
                                if($('#AsicOnCompany_user_last_name').val() == ""){
                                    if($('#companyContactLastnameErr').is(':empty')){
                                        $("#companyContactLastnameErr").append("<p>"+data.errors.user_last_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactLastnameErr").empty().hide();
                            }

                            if(data.errors.user_email)
                            {
                                if($('#AsicOnCompany_user_email').val() == ""){
                                    if($('#companyContactEmailErr').is(':empty')){
                                        $("#companyContactEmailErr").append("<p>"+data.errors.user_email+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactEmailErr").empty().hide();
                            }

                            if(data.errors.user_contact_number)
                            {
                                if($('#AsicOnCompany_user_contact_number').val() == ""){
                                    if($('#companyContactContactNumberErr').is(':empty')){
                                        $("#companyContactContactNumberErr").append("<p>"+data.errors.user_contact_number+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactContactNumberErr").empty().hide();
                            }
                        }
                    }
                    else
                    {
                        var contactCompany = data.contactCompany;
                        $("#AsicOnCompany_contact").append(data.dropDown);
                        $("#addCompanyContactModal").modal('hide');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
        //******************************************************************************************************
        //******************************************************************************************************
       

        //******************************************************************************************************
        //******************************************************************************************************
		
    });
</script>


