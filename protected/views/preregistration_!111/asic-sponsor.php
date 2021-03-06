<?php
    $session = new CHttpSession;
    //this is because to ensure the CAVMS-1144 and CAVMS-1092
    $tenant = '';
    if(isset(Yii::app()->user->tenant) && (Yii::app()->user->tenant != "")){
        $tenant = Yii::app()->user->tenant;
    }
    else
    {
        $tenant = (isset($session['tenant']) && ($session['tenant'] != "")) ? $session['tenant'] : '';
    }

    $companyList = CHtml::listData(Registration::model()->findAllCompanyByTenant($tenant), 'id', 'name');
    $companyList = array_unique($companyList);
    $listsCom = implode('", "', $companyList);
	//print_r($model);
?>
<style type="text/css">

    .select2{
        width:100% !important;
    }

    table.dataTable.no-footer{
        border-bottom: 0px solid #111 !important;
    }

    table.dataTable thead th, table.dataTable thead td {
        border-bottom: 0px solid #111 !important;
        padding: 10px 18px;
    }

    table.dataTable.row-border tbody th, table.dataTable.row-border tbody td, table.dataTable.display tbody th, table.dataTable.display tbody td {
        border-top: 0px solid #ddd !important;
    }

    table.dataTable thead tr {
        background-color: #eee;
    }

    #search_asic_error{
        display: none;
    }
    #asic_search_result{
        display: none;
    }

    #loader{
        display: none;
    }
    .loader {
        margin: 60px auto;
        font-size: 10px;
        position: relative;
        text-indent: -9999em;
        border-top: .5em solid rgba(153, 153, 153, 0.20);
        border-right: .5em solid rgba(153, 153, 153, 0.20);
        border-bottom: .5em solid rgba(153, 153, 153, 0.20);
        border-left: .5em solid #428bca;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation: load8 1.1s infinite linear;
        animation: load8 1.1s infinite linear;
    }
    .loader,
    .loader:after {
        border-radius: 50%;
        width: 3em;
        height: 3em;
    }
    @-webkit-keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    #asic-notification{
        display: none;
    }
    .bg-info{
        padding: 7px;
    }

    .selected_col{
        text-align: center;
    }

</style>
<div class="page-content">
    <!-- <a href="<?php //echo Yii::app()->createUrl('preregistration/addAsic'); ?>"><h1 class="text-primary title">ADD / FIND ASIC SPONSOR</h1></a> -->

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
		
    <a href="<?php echo Yii::app()->createUrl('preregistration/addAsic'); ?>"><span  class="text-size" style="color:black">Please provide details of the ASIC Sponsor who will be escorting the VIC holder</span></a>

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
    ?>

    <!--  searching ASIC -->
    <div class="row">
        <div class="col-sm-4 col-xs-12" style="padding-top: 10px;">
            <?php  echo CHtml::textField('search_asic_box' , '',
                array(
                    'class'=>'form-control input-sm',
                    'placeholder'=>'First Name, Last Name or Email'
                )
            );
            ?>
             <?php
            echo CHtml::hiddenField('tenantId',$tenant);
            ?>
            <div id="search_asic_error" class="errorMessage">Please type something on search box</div>
            <?php
            echo CHtml::hiddenField('base_url',Yii::app()->getBaseUrl(true));
            ?>
        </div>
        <div class="col-sm-4 col-xs-12" style="padding-top: 10px;">
            <?php
            echo CHtml::tag('button', array(
                'id'=>'search_asic_btn',
                'type'=>'button',
                'class' => 'btn btn-primary btn-sm'
            ), 'Find ASIC Sponsor');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12" style="padding-top: 10px;">

            <div class="tableFont" id="asic_holder"></div>

            <div class="loader" id="loader">Loading...</div>

            <p id="asic-notification" class="bg-info">No Record Found</p>
        </div>
    </div>
    <!--  end searching ASIC -->


    <?php

    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'add-asic-form',
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true
        ),
        'htmlOptions'=>array(
            'class'=> 'declarations'
        )
    ));
    ?>

    <div class="row">

        <div class="col-sm-4">

            <div class="form-group">
                <?php echo $form->hiddenField($model, 'selected_asic_id' ,
                    array('value'=>'')
                ); ?>
            </div>

            <!--  new asic -->
            <div id="new_asic_area">
                <div class="form-group">
                    <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-sm', 'title'=>'Enter first name as written on identification')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'placeholder' => 'Surname' , 'class'=>'form-control input-sm', 'title'=>'Enter last name as written on identification')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
							<div class="form-group">
                               
                                <?php $this->widget('EDatePicker', array(
                                    'model'=>$model,
                                    'attribute'=>'date_of_birth',
                                    'mode'=>'date_of_birth',
                                    'htmlOptions'=>array(
									'class'=>'form-control input-sm',
									'title'=>'Date of Birth is a unique identifier. Must be correct'
									),
                                ));
                                ?>
                                
                                <?php echo $form->error($model, 'date_of_birth'); ?>
                            </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'asic_no', array('maxlength' => 50, 'placeholder' => 'ASIC No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'asic_no'); ?>
                </div>

                <div class="row form-group">
                    <div class="col-sm-12">
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'asic_expiry',
                            'mode'        => 'asic_expiry',
							'htmlOptions'=>array(
									'class'=>'form-control input-sm',
									),
                        ));
                        ?>
                        <?php echo $form->error($model, 'asic_expiry'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_number', array('maxlength' => 50, 'placeholder' => 'Contact No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'contact_number'); ?>

                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'email', array('maxlength' => 50, 'placeholder' => 'Email Address', 'class'=>'form-control input-sm','title'=>'Enter the ASIC holders unique email address or FirstName.Last Name. Do not enter in another persons email, a false or generic email address.')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>


                <div class="form-group" id="addCompanyDiv">
                    <?php
                        $visitor = Registration::model()->findByPk(Yii::app()->user->id);
                        if(isset($tenant) && ($tenant != "")){
                            $this->widget('application.extensions.select2.Select2', array(
                                'model' => $companyModel,
                                'attribute' => 'name',
                                'items' => CHtml::listData(Registration::model()->findAllCompanyByTenant($tenant), 'id', 'name'),
                                //'selectedItems' => array(), // Items to be selected as default
                                'placeHolder' => 'Select Company',
                            ));
                        }else{
							 if($tenant != "")
							{
								$this->widget('application.extensions.select2.Select2', array(
									'model' => $companyModel,
									'attribute' => 'name',
									'items' => CHtml::listData(Company::model()->findAll('is_deleted=0 and tenant = '.$tenant), 'id', 'name'),
									'placeHolder' => 'Select Company',
								));
							}
							else{
                            $this->widget('application.extensions.select2.Select2', array(
                                'model' => $companyModel,
                                'attribute' => 'name',
                                'items' => CHtml::listData(Company::model()->findAll('is_deleted=0'), 'id', 'name'),
                                //'selectedItems' => array(), // Items to be selected as default
                                'placeHolder' => 'Select Company',
                            ));
							}
                        }
                    ?>

                    <?php
                        /*$visitor = Registration::model()->findByPk($session['visitor_id']);
                        if(isset($visitor->tenant)){
                            echo $form->dropDownList($model, 'company', CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-sm'));
                        }
                        else
                        {
                            echo $form->dropDownList($model,'company',array(''=>'Select Company'),array('class'=>'form-control input-sm'));
                        }*/
                    ?>
                    <?php echo $form->error($companyModel,'name'); ?>
                </div>
                
                <div class="form-group">
                    <a class="btn btn-primary" style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal">Add Company</a>
                </div>
				<div class="form-group" id="addCompanyContactDiv" style="display:none">
                <select id="companyContact" class="form-control input-sm">
                    <option value="">Select Company Contact</option>
                </select>

                <div style="display:none" id="companyContactError" class="errorMessage">Please complete Company Contact</div>

                <?php
                    //echo $form->dropDownList($model,'host', array(''=>'Select Company'), array('prompt' => 'Select Company Contact' , 'class'=>'form-control input-sm'));
                ?>
                <?php //echo $form->error($model,'host'); ?>
                <!-- </div> -->
                <div class="form-group"> </div>
                <a style="float: left;" href="#addCompanyContactModal" role="button" data-toggle="modal" class="btn btn-primary" id="addCompanyContactModalBtn">Add Contact</a>
            </div>
            </div>
            <!--  new asic -->
            <!-- changed on 24/10/2016-->
           <!-- <div class="form-group">
                <label class="checkbox">
                    <input type="checkbox" name="Registration[is_asic_verification]" value="0" id="toggleCheckbox" />
                    <?php //echo $form->checkBox($model,'is_asic_verification'); ?>
                    <span class="checkbox-style"></span>
                    <p class="text-size" style="line-height:25px">
                        Request ASIC Sponsor Verification
                    </p>
                </label>
                <?php //echo $form->error($model,'is_asic_verification'); ?>
            </div>-->

        </div>

    </div>

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-sm-6">
            <a href="<?=Yii::app()->createUrl("preregistration/visitReason")?>" class="pull-left btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-sm-6">
            <?php
                echo CHtml::tag('button', array(
                    'type'=>'submit',
                    'class' => 'pull-right btn btn-primary btn-next'
                ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>
        </div>



    </div>  


</div>
 <?php $this->endWidget(); ?>

<!-- ************************************************ -->
<!-- ************************************** -->
<!-- -Add Company Modal- -->
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
                                            <?php echo $form->textField($companyModel, 'name', array('placeholder' => 'Company Name','class'=>'form-control input-lg ui-autocomplete-input company-autocomplete','autocomplete' => 'on')); ?>
                                        </div>
                                        <div class="errorMessage" id="companyNameErr" style="display:none;float:left"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group" style="float:left">
                                            <a class="btn btn-default" href="javascript:;" role="button" id="addComp">+</a> Add Company Contact
                                            <input type="hidden" id="is_user_field_comp" name="is_user_field_comp" value="0">
											<?php echo $form->checkBox($companyModel,'asiccheck', array("style"=>'margin-left: 13px;')). " ". $form->labelEx($companyModel,'asiccheck', array("style"=>'display: inline;font-style: italic; font-size: 13px; font-weight: 300;', "for"=>'asiccheck'));?><br>
											<span id="errorcheck" style="color: red; font-style: italic; font-size: 13px;"></span>
                                        </div>
                                    </div>

                                    <div style="display:none" id="compDiv">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_first_name', array('class'=>'form-control input-lg','placeholder'=>'First Name')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyFirstnameErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_last_name', array('class'=>'form-control input-lg','placeholder'=>'Last Name')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyLastnameErr" style="display:none;float:left"></div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_email', array('class'=>'form-control input-lg','placeholder'=>'Email Address')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyEmailErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_contact_number', array('class'=>'form-control input-lg','placeholder'=>'Contact Number')); ?>
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
    <!-- - Login Model Ends Here -->
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
                                            echo $form->hiddenField($companyModel,'name',array('class'=>'companyHiddenField'));
                                            /*$visitor = Registration::model()->findByPk($session['visitor_id']);

                                            if(isset($visitor->tenant)){
                                                echo $form->dropDownList($companyModel, 'name', CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-lg'));
                                            }
                                            else
                                            {
                                                echo $form->dropDownList($companyModel,'name',array(''=>'Select Company'),array('class'=>'form-control input-lg'));
                                            }*/
                                        ?>
                                    </div>
                                    <?php echo $form->error($companyModel,'name',array('style' =>'float:left')); ?>
                                </div>

                                    <div class="form-group">
                                        
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group" style="float:left">
                                            <a class="btn btn-default" href="javascript:;" role="button" id="addContact">+</a> Add Company Contact <label id='orhide' style="margin-left: 12px;"> OR</label>
                                            <input type="hidden" id="is_user_field_contact" name="is_user_field_contact" value="0">
											<?php echo $form->checkBox($companyModel,'asiccheck', array("style"=>'margin-left: 13px;')). " ". $form->labelEx($companyModel,'asiccheck', array("style"=>'display: inline;font-style: italic; font-size: 13px; font-weight: 300;', "for"=>'asiccheck'));?><br>
											<span id="errorcheck" style="color: red; font-style: italic; font-size: 13px;"></span>
                                        </div>
								
										
                                    </div>

                                    <div style="display:none" id="contactDiv">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_first_name', array('class'=>'form-control input-lg','placeholder'=>'First Name')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_first_name',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactFirstnameErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_last_name', array('class'=>'form-control input-lg','placeholder'=>'Last Name')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_last_name',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactLastnameErr" style="display:none;float:left"></div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_email', array('class'=>'form-control input-lg','placeholder'=>'Email Address')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_email',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactEmailErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_contact_number', array('class'=>'form-control input-lg','placeholder'=>'Contact Number')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_contact_number',array('style' =>'float:left')); ?>
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

<!-- ************************************** -->
    <!-- ************************************************ -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style type="text/css">
.ui-tooltip
{
	max-width: 10%;
}
.ui-tooltip-content{
	height:10%;
	font-size:0.65vw;
}
 .ui-tooltip-content::after{
			content: '';
			position: absolute;
			border-style: solid;
			display: block;
			width: 0;
            
         }
     
         .left .ui-tooltip-content::after {
				top: 35%;
				right: -10%;
				border-color: transparent #cccccc ;
				border-width: 10px 0 10px 10px;
         }
</style>
<script type="text/javascript">


    $(document).ready(function() {
		$( document ).tooltip({
			tooltipClass: "left",
			position: {
                  my: "right center",
                  at: "left-10 center",
                  collision: "none"
               }
		});

	 $("#Company_asiccheck").click(function(){
		
		if($('#Company_asiccheck')[0].checked ==true)
		{
			var fname=$("#add-asic-form input[name='Registration[first_name]']").val();
			var lname=$("#add-asic-form input[name='Registration[last_name]']").val();
			var email=$("#add-asic-form input[name='Registration[email]']").val();
			var contact=$("#add-asic-form input[name='Registration[contact_number]']").val();
			if(fname && lname && email && contact)
			{
			
			$('input[name="Company[user_first_name]"]').val(fname);
			$('input[name="Company[user_last_name]"]').val(lname);
			$('input[name="Company[user_email]"]').val(email);
			$('input[name="Company[user_contact_number]"]').val(contact);
			$('#errorcheck').hide();
			$('#Company_asiccheck').change(function () {
			$("#contactDiv").toggle();
			$("#compDiv").toggle();
			
			//$("#add-company-contact-form .password-border").toggleClass("hidden");
			});
			//alert($('#Company_user_first_name').val(fname));
			}
			else
			{
				$('#errorcheck').html("Please fill the Asic details first")
				$('#Company_asiccheck')[0].checked =false;
			}
			
				
			//console.log(name);
		}
    });
 });
 
 $('.close').click(function(event){
	 $('#errorcheck').hide();
 });
        $('#search_asic_box').on('input', function() {
            $("#search_asic_error").hide();
            $("#asic_table_wrapper").hide();
            $("#asic-notification").hide();
            $('#Registration_selected_asic_id').val("");
            $('#new_asic_area').show();
        });

        $("#toggleCheckbox").on("click",function(e){
            if(this.checked){
                $(this).val(1);
            }else{
                $(this).val(0);
            }
        });
//changed on 24/10/2016
        $('#search_asic_btn').click(function(event) {
            event.preventDefault();
           
            var search = $("#search_asic_box").val();
            var base_url = $("#base_url").val();
 			var tenant=$("#tenantId").val();
			//alert(tenant);
			
            if (search.length > 0) {
                $("#loader").show();
                var search_value = 'search_value=' + search + '&tenant='+ tenant;
                $.ajax({
                    url: base_url + '/index.php/preregistration/ajaxAsicSearch',
                    type: 'POST',
                    data: search_value,
                    success: function(data) {

                        if(data == 'No Record'){
                            $("#asic-notification").show();
                        }
                        else{

                            var dataSet = JSON.parse(data);

                            $('#asic_holder').html( '<table cellpadding="0" cellspacing="0" border="0" class="display" id="asic_table"></table>' );

                            $('#asic_table').dataTable( {
                                //"ordering": false,
                                "bLengthChange": false,
                                "bFilter": false,
                                "data": dataSet,
                                "columns": [
                                    { "title": "Select", "class":"selected_col"  },
                                    { "title": "First Name" },
                                    { "title": "Last Name" },
                                    { "title": "Company" }
                                ],
                                "fnDrawCallback": function (oSettings) {
                                    $('.selected_asic').click(function() {
                                        $('#Registration_selected_asic_id').val($(this).val());
                                        $('#Registration_contact_number').val("");
                                        $('#Registration_email').val("");
                                        $('#new_asic_area').empty();
                                    });
                                }
                            });


                        }

                        $("#loader").hide();

                    }

                });

            }
            else{
                $("#search_asic_error").show();
            }

        });
		$(function() {
        $(document).on('click', '#addContact', function(e) {
           $("tr.company_contact_field").toggleClass("hidden");
		   //$('#errorcheck').hide();
			$("#Company_asiccheck").toggle();
			$("label[for='asiccheck']").toggle();
			$("#orhide").toggle();
			$('#Company_firstName').val("");
			$('#Company_lastName').val("");
			$('#Company_email').val("");
			$('#Company_mobile').val("");
			//$("label[for='asiccheck']").hide();
            //$("#add-company-contact-form .password-border").toggleClass("hidden");
			$('#errorcheck').hide();
        });
     $("#addCompanyContactModalBtn").click(function(e){
            var companyId = $("#Company_name :selected").val();
            var companyName = $("#Company_name :selected").text();
            
            $("#companyPlaceholder").val(companyName);
            $(".companyHiddenField").val(companyId);
			
			
			$('#Company_firstName').val("");
			$('#Company_lastName').val("");
			$('#Company_email').val("");
			$('#Company_mobile').val("");
			//$("label[for='asiccheck']").hide();
            //$("#add-company-contact-form .password-border").toggleClass("hidden");
			//$('#errorcheck').hide();
        });

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
        
 $("#Company_name").change(function() {
            var compId = $(this).val();
            if(compId != "" && compId != null){
                $.ajax({
                    type: 'POST',
                    url: "<?php echo Yii::app()->createUrl('preregistration/findAllCompanyContactsByCompany');?>",
                    dataType: 'json',
                    data: {"compId":compId},
                    success: function (res) {
                        if (res.data == "") {
                            $("#companyContact").empty();
                            $("#companyContact").append("<option value=''>Select Company Contact</option>");
                        }
                        else
                        {
                            $("#companyContact").empty();
                            $.each(res.data,function(index,element) {
                                $("#companyContact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
                            }); 
                        }
                        $("#addCompanyContactDiv").show();

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }else{
                $("#companyContact").empty();
                $("#companyContact").append("<option value=''>Select Company Contact</option>");
                $("#addCompanyContactDiv").hide();
            }
        });
        $("#addCompanyBtn").unbind("click").click(function(event){
            $("#compDiv").show();
            var data=$("#company-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('company/addCompany');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.decision == 0)
                    {
                        if(data.errors){//console.log(data.errors);
                            if(data.errors.name)
                            {
                                if($('#Company_name').val() == ""){
                                    if($('#companyNameErr').is(':empty')){
                                        $("#companyNameErr").append("<p>"+data.errors.name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyNameErr").empty().hide();
                            }

                            if(data.errors.user_first_name)
                            {
                                if($('#Company_user_first_name').val() == ""){
                                    if($('#companyFirstnameErr').is(':empty')){
                                        $("#companyFirstnameErr").append("<p>"+data.errors.user_first_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyFirstnameErr").empty().hide();
                            }

                            if(data.errors.user_last_name)
                            {
                                if($('#Company_user_last_name').val() == ""){
                                    if($('#companyLastnameErr').is(':empty')){
                                        $("#companyLastnameErr").append("<p>"+data.errors.user_last_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyLastnameErr").empty().hide();
                            }

                            if(data.errors.user_email)
                            {
                                if($('#Company_user_email').val() == ""){
                                    if($('#companyEmailErr').is(':empty')){
                                        $("#companyEmailErr").append("<p>"+data.errors.user_email+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyEmailErr").empty().hide();
                            }

                            if(data.errors.user_contact_number)
                            {
                                if($('#Company_user_contact_number').val() == ""){
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
                        $("#Registration_company").append(data.dropDown);
                        $('.select2-selection__rendered').text(data.compName);
                         $("#companyContact").empty();
                        $.each(data.contacts,function(index,element) {
                            $("#companyContact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
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
    });
	   $("#addCompanyContactBtn").click(function(event){
            
            $("#contactDiv").show();

            var data=$("#companyContact-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('company/addCompanyContactPreg');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.decision == 0)
                    {
                        if(data.errors){//console.log(data.errors);
                            if(data.errors.user_first_name)
                            {
                                if($('#Company_user_first_name').val() == ""){
                                    if($('#companyContactFirstnameErr').is(':empty')){
                                        $("#companyContactFirstnameErr").append("<p>"+data.errors.user_first_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactFirstnameErr").empty().hide();
                            }

                            if(data.errors.user_last_name)
                            {
                                if($('#Company_user_last_name').val() == ""){
                                    if($('#companyContactLastnameErr').is(':empty')){
                                        $("#companyContactLastnameErr").append("<p>"+data.errors.user_last_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactLastnameErr").empty().hide();
                            }

                            if(data.errors.user_email)
                            {
                                if($('#Company_user_email').val() == ""){
                                    if($('#companyContactEmailErr').is(':empty')){
                                        $("#companyContactEmailErr").append("<p>"+data.errors.user_email+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactEmailErr").empty().hide();
                            }

                            if(data.errors.user_contact_number)
                            {
                                if($('#Company_user_contact_number').val() == ""){
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
                        $("#companyContact").append(data.dropDown);
                        $("#addCompanyContactModal").modal('hide');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });

    $(function() {
        var availableTags = ["<?php echo $listsCom; ?>"];
        $(".company-autocomplete").autocomplete({
            source: availableTags,
            select: function(event, ui) {
                event.preventDefault();
                $(".company-autocomplete").val(ui.item.label);
                //$('#typePostForm').val('contact');
            }
        });
        $(".ui-front").css("z-index", 1051);
    });

</script>