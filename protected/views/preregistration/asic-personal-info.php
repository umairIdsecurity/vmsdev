<?php
$session = new CHttpSession;
    $cs = Yii::app()->clientScript;
    //$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
    //$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');

    //this is because below country model become ambigious for name values on Window Server
    $countryList = CHtml::listData(Yii::app()->db->createCommand('select a.* from country a inner join (select distinct name, min(id) as id from country group by name) as b on a.name = b.name and a.id = b.id order by name asc')->queryAll(),'id', 'name');
    
    /*$countryList = CHtml::listData(
                                    Country::model()->findAll(array(
                                    "order" => "name asc",
                                    "group" => "name"
                                )), 'id', 'name'
                    );*/
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.css">
<style>
td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
	
}
span.glyphicon.glyphicon-remove
{
	position:inherit !important;
	line-height:12px !important;
}
span.glyphicon.glyphicon-remove:before
{
	font-size: 14px !important;
	position:inherit !important;
}
span.glyphicon.glyphicon-remove:after
{
	font-size:14px !important;
	position:inherit !important;
}
</style>
<?php
$js = <<< EOJ
function beforeValidate(form) {
        if (form.data('submitObject').hasClass('jsNoValidate'))
		{
			this.validateOnSubmit = false;
			this.beforeValidate = '';
			this.attr('action','preregistration/saveExit');
			form.submit();
			
			return false;
		}
                
        return true;
}
EOJ;
Yii::app()->clientScript->registerScript('beforeValidate', $js);
?>
<div class="page-content">

    <a href="<?php echo Yii::app()->createUrl('preregistration/personalAsicOnline'); ?>"><h3 class="text-primary subheading-size">Personal Information</h3></a>

    <!--<div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>-->
    


    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'asic-info-form',
        'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
			'beforeValidate'=>"js:beforeValidate"
			
        ),
        'htmlOptions'=>array(
            'class'=> 'form-comfirm-detail',
			'enctype'=>'multipart/form-data'
        )
    ));
	
    ?>
        <div class="form-group">
            <?php echo $form->hiddenField($model, 'selected_asic_id' ,
                array('value'=>'')
            ); ?>
        </div>

        <div class="row" id="new_asic_area">
            <div class="col-sm-4" style='width:30%;'>
                <div class="form-group">
                    <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'given_name2', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'given_name2'); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'given_name3', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'given_name3'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'placeholder' => 'Surname' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
				<div >
				<label class="checkbox text-size" style='margin-left: 30px;; width: 60%;'>
				<?php
					echo CHtml::checkBox('asic-info-form[pre1]',false,array('class'=>'checkbox'));
				?>
					<span class=" text-size" style="line-height:21px">Add a previous name</span>
					</label>
				</div>
				<div id='previousName1' style='display:none'>
				<div class="form-group" >
				<label>Previous Names 1:</label></br>
                    <?php echo $form->textField($model, 'changed_given_name1', array('maxlength' => 50, 'placeholder' => 'First Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'changed_given_name2', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'changed_given_name3', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'changed_last_name1', array('maxlength' => 50, 'placeholder' => 'Surname(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
				<div class="form-group" style="width:150%;">
				 <label>Name Type</label><br>
				 &nbsp&nbsp
				 <?php
				echo $form->radioButtonList($model, 'name_type1',array(
					'Previous'=>'Previous', 
					'Alias'=>'Alias',
					'Maiden'=>'Maiden',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:0px;'));
				
					?>
					</div>
				<div >
				<label class="checkbox text-size" style='margin-left: 30px;; width: 65%;'>
				<?php
					echo CHtml::checkBox('asic-info-form[pre2]',false,array('class'=>'checkbox'));
				?>
					<span class=" text-size" style="line-height:21px">Add another previous name</span>
					</label>
				</div>	
					
				</div>
				<div id='previousName2' style='display:none'>
				<div class="form-group">
				<label>Previous Names 2:</label></br>
                    <?php echo $form->textField($model, 'changed_given_name1_1', array('maxlength' => 50, 'placeholder' => 'First Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'changed_given_name2_1', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'changed_given_name3_1', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'changed_last_name2', array('maxlength' => 50, 'placeholder' => 'Surname(optional)' , 'class'=>'form-control input-sm')); ?>
                </div>
				<div class="form-group" style="width:150%;">
				 <label>Name Type</label><br>
				 &nbsp&nbsp
				 <?php
				echo $form->radioButtonList($model, 'name_type2',array(
					'Previous'=>'Previous', 
					'Alias'=>'Alias',
					'Maiden'=>'Maiden',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:0px;'));
			
					?>
					</div>
					</div>
					<div id='uploadPre' style='display:none;'>
					<div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
					<label>Upload scanned copy of all previous name documents in one file (optional):</label>
					<?php echo $form->fileField($model,'name_change_file', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
					<?php echo $form->error($model, 'name_change_file'); ?>
					</div>
					</div>
					</div>
			 <div class="form-group">
				 <label>Gender</label>
				 &nbsp&nbsp
				 <?php
				echo $form->radioButtonList($model, 'gender',array(
					'male'=>'Male', 
					'female'=>'Female',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
					echo $form->error($model,'gender');
					?>
					</div>

                <div class="form-group">
                    <?php echo $form->textField($model,'email',array('maxlength' => 50, 'placeholder' => 'Email Address', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>

                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'date_of_birth',
                            'mode'        => 'date_of_birth',
							 'htmlOptions' => array(
                                      //  'style'    => 'width:280px',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($model,'date_of_birth',array('style' => 'margin-left:0')); ?>
                    </div>
                </div>
			 <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'birth_country', $countryList, array('empty' => 'Select Country of Birth', 'class'=>'form-control input-sm' , /*'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))*/));
                    ?>
                    <?php echo $form->error($model, 'birth_country'); ?>

                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'birth_state', array('maxlength' => 50, 'placeholder' => 'State of Birth' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'birth_state'); ?>
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'birth_city', array('maxlength' => 50, 'placeholder' => 'Town or City' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'birth_city'); ?>
                </div>
				 <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'citizenship', $countryList, array('empty' => 'Select Country of Citizenship', 'class'=>'form-control input-sm' , /*'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))*/));
                    ?>
                    <?php echo $form->error($model, 'citizenship'); ?>

                </div>
					<div class="form-group">
                    <?php echo $form->textField($model, 'home_phone', array('maxlength' => 50, 'placeholder' => 'Phone (Home).', 'class'=>'form-control input-sm')); ?>
                   
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'work_phone', array('maxlength' => 50, 'placeholder' => 'Phone (Work).', 'class'=>'form-control input-sm')); ?>
                    
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'mobile_phone', array('maxlength' => 50, 'placeholder' => 'Phone (Mobile).', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'mobile_phone'); ?>
                </div>
				 <div class="form-group" style="width:150%;">
				 <label>Preferred method of contact </br></label>
				 <br>
				 <?php
				echo $form->radioButtonList($model, 'preferred_contact',array(
					'Mobile'=>'Mobile', 
					'Home'=>'Home phone',
					'Work'=>'Work phone',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
					echo $form->error($model,'preferred_contact');
					?>
				</div>
               

            </div>

            <div class="col-sm-3">
                &nbsp;
            </div>

            <div class="col-sm-4" style="margin-left: -20%;margin-top: -2.2%; width:30%">
			<label>Current Residential Address</br></label>
				 <br>
                <div class="row form-group">
                    <div class="col-xs-5">
                        <?php echo $form->textField($model, 'unit', array('maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-sm')); ?>


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
						<?php echo $form->error($model, 'state'); ?>
                    </div>
                    
                    <div style="display:none;" id="stateTextbox" class="col-xs-6">
                        <?php echo $form->textField($model, 'state', array('maxlength' => 50, 'placeholder' => 'Enter State', 'class'=>'form-control input-sm','disabled'=>'disabled')); ?>
						<?php echo $form->error($model, 'state'); ?>
                    </div> 

                    <div class="col-xs-6">
                        <?php echo $form->textField($model, 'postcode', array('maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'postcode'); ?>
                    </div>
					
                    
                </div>
				 <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'from_date',
                            'mode'        => 'ResidentDates',
							 'htmlOptions' => array(
                                      'placeholder'=>'Resident From Date',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($model,'from_date',array('style' => 'margin-left:0')); ?>
                    </div>
                </div>

                <?php 
                    if(isset($error_message) && !empty($error_message)){
                ?>

                <div class="row form-group">
                    <div class="col-xs-6">
                        <?php  echo '<span style="color:red">'.$error_message.'</span>'; ?>
                    </div>
                </div>

                <?php } ?>
				<div class="form-group" style="width:150%;">
				 <label>Current Postal Address </br></label>
				 <br>
				 <label>As above?</label>
				 <?php
				echo $form->radioButtonList($model, 'is_postal',array(
					'1'=>'Yes', 
					'0'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
					echo $form->error($model,'is_postal');
					?>
				</div>
				<div id="postaladdress" style="display:none;">
				<label>Current Postal Address</br></label>
				 <br>
                <div class="row form-group">
                    <div class="col-xs-5">
                        <?php echo $form->textField($model, 'postal_unit', array('maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-sm')); ?>
                      

                    </div>
                    <div class="col-xs-7">
                        <?php echo $form->textField($model, 'postal_street_number', array('maxlength' => 50, 'placeholder' => 'Street No.', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'postal_street_number'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-6">
                        <?php echo $form->textField($model, 'postal_street_name', array('maxlength' => 50, 'placeholder' => 'Street Name', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'postal_street_name'); ?>
                    </div>
                    <div class="col-xs-6">
                        <?php echo $form->dropDownList($model, 'postal_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'postal_street_type'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'postal_suburb', array('maxlength' => 50, 'placeholder' => 'Suburb' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'postal_suburb'); ?>
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'postal_city', array('maxlength' => 50, 'placeholder' => 'City' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'postal_city'); ?>
                </div>

                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'postal_country', $countryList,
                        array('prompt' => 'Select Country', 'class'=>'form-control input-sm',
                            'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'postal_country'); ?>
                </div>

                <div class="row form-group">

                    <div id="stateDropdown" class="col-xs-6">
                        <?php echo $form->dropDownList($model, 'postal_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'Select State', 'class'=>'form-control input-sm')); ?>
						<?php echo $form->error($model, 'postal_state'); ?>
                    </div>
                    
                    <div style="display:none;" id="stateTextbox" class="col-xs-6">
                        <?php echo $form->textField($model, 'postal_state', array('maxlength' => 50, 'placeholder' => 'Enter State', 'class'=>'form-control input-sm','disabled'=>'disabled')); ?>
						<?php echo $form->error($model, 'postal_state'); ?>
                    </div> 

                    <div class="col-xs-6">
                        <?php echo $form->textField($model, 'postal_postcode', array('maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'postal_postcode'); ?>
                    </div>
					
                    
                </div>
                </div>
            </div>
			 <div id='addhistory' class="col-sm-4" style="margin-left: 1%;margin-top: -2.2%; width:30%">
			<label>Address History</br></label>
			<p style="font-size: 11px;">Please enter 10 years of address history without gaps in the dates of residency</p>

                <div class="row form-group">
                    <div class="col-xs-5">
                        <?php echo $form->textField($addHistory, 'unit', array('maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-sm')); ?>
                        

                    </div>
                    <div class="col-xs-7">
                        <?php echo $form->textField($addHistory, 'street_number', array('maxlength' => 50, 'placeholder' => 'Street No.', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($addHistory, 'street_number'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-6">
                        <?php echo $form->textField($addHistory, 'street_name', array('maxlength' => 50, 'placeholder' => 'Street Name', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($addHistory, 'street_name'); ?>
                    </div>
                    <div class="col-xs-6">
                        <?php echo $form->dropDownList($addHistory, 'street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($addHistory, 'street_type'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($addHistory, 'suburb', array('maxlength' => 50, 'placeholder' => 'Suburb' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($addHistory, 'suburb'); ?>
                </div>
				<div class="form-group">
                    <?php echo $form->textField($addHistory, 'city', array('maxlength' => 50, 'placeholder' => 'City' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($addHistory, 'city'); ?>
                </div>

				

                <div class="form-group">
                    <?php
                    echo $form->dropDownList($addHistory, 'country', $countryList,
                        array('prompt' => 'Select Country', 'class'=>'form-control input-sm',
                            'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($addHistory, 'country'); ?>
                </div>

                <div class="row form-group">

                    <div id="stateAddDropdown" class="col-xs-6">
                        <?php echo $form->dropDownList($addHistory, 'state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'Select State', 'class'=>'form-control input-sm')); ?>
                    </div>
                    
                    <div style="display:none;" id="stateAddTextbox" class="col-xs-6">
                        <?php echo $form->textField($addHistory, 'state', array('maxlength' => 50, 'placeholder' => 'Enter State', 'class'=>'form-control input-sm','disabled'=>'disabled')); ?>
                    </div> 

                    <div class="col-xs-6">
                        <?php echo $form->textField($addHistory, 'postcode', array('maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($addHistory, 'postcode'); ?>
                    </div>
					 
					 
					 
                    
                </div>
				<div class="form-group">
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $addHistory,
                            'attribute'   => 'from_date',
                            'mode'        => 'ResidentDates',
							 'htmlOptions' => array(
                                      'placeholder'=>'Resident From Date',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($addHistory,'from_date',array('style' => 'margin-left:0')); ?>
                    </div>
					 <div class="form-group">
                       <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $addHistory,
                            'attribute'   => 'to_date',
                            'mode'        => 'ResidentDates',
							 'htmlOptions' => array(
                                      'placeholder'=>'Resident To Date',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($addHistory,'to_date',array('style' => 'margin-left:0')); ?>
                    </div>
				 <div>
				   <a href="#" id='addHistoryBttn' class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-plus"></span> Add Address History</a>
				   <br><br>
				   <div class="form-group" style="position: absolute;width: 190%;font-size: 12px;">
					<table id='addHistoryTb'>
		
					</table>
					</div>
				  
				 </div>
			
			</div>
			 
        </div>
	
	<div id='addressinputs'>
</div>        


        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="pull-left">
                        <a href="<?=Yii::app()->createUrl("preregistration/asicType")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                    </div>

					
				
                    <div class="pull-right">
					 <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'id' => 'btnSave',
								'name'=>'save',
                                'class' => 'btn btn-primary jsNoValidate'
                            ), 'SAVE & EXIT ');
                        ?>
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








<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>
<script>
    $(document).ready(function () {
		
			if($('#RegistrationAsic_changed_given_name1').val()!='')
			{
				$('#asic-info-form_pre1').prop("checked",true);
							$('#previousName1').show();
							$('#uploadPre').show();
			}
			if($('#RegistrationAsic_changed_given_name2').val()!='')
			{
				
				$('#asic-info-form_pre2').prop("checked",true);
				$('#previousName2').show();
			}
			var total=0;
			
			if($('#RegistrationAsic_from_date_container').val()!='')
			{
				var From_date = new Date($('#RegistrationAsic_from_date_container').val().split("/").reverse().join("-"));
				var To_date = new Date();
				//alert(From_date);
				var diff_date =  Math.floor(To_date.getTime() - From_date.getTime());
				//var years = Math.floor(diff_date/31536000000);
				//var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(diff_date/(1000 * 60 * 60 * 24));
			//alert(years+"years"+months+"Months"+days+"days");
			
			if(days!=0)
			{
				if(total==0)
				total=days;
				else
				total+=days;
				
			}
			else
			{   
		       if(total==0)
				total=0;
			}
			//alert(total);
			if(days<3650)
			{
				//alert('here');
				$("#addhistory :input").attr("disabled", false);
			}
			
			}
		$('#asic-info-form_pre1').on('click',function(){
			$('#previousName1').toggle();
			$('#uploadPre').toggle();
		});
		$('#asic-info-form_pre2').on('click',function(){
			$('#previousName2').toggle();
		});
		$('#AsicAddressHistory_country').on('change',function(){
			if($(this).val()=='13')
			{
				$('#stateAddDropdown').show();
				$('#stateAddTextbox').hide();
			}
			else
			{
				$('#stateAddDropdown').hide();
				$('#stateAddTextbox').show();
			}
			
		});
		var year;
		var total;
		if("<?php if (isset($session['AddHistory'])) {echo 'notempty';} else {echo '';}  ?>" !='') 
		{
			//alert('here');
			var From_date = new Date($('#RegistrationAsic_from_date_container').val().split("/").reverse().join("-"));
			var To_date = new Date();
			
			var diff_date =  Math.floor(To_date.getTime() - From_date.getTime());
				//var years = Math.floor(diff_date/31536000000);
				//var months = Math.floor((diff_date % 31536000000)/2628000000);
			var days = Math.floor(diff_date/(1000 * 60 * 60 * 24));
			
			if(days!=0)
			{
				total=days;
			
			}
			
			else if(isNaN(days))
			{
				days=0;
				total=0;
			}
			else
			total=0;
			
			
			if(days<3650)
			{
				
				$("#addhistory :input").attr("disabled", false);
			}
			var addArr=[];
			
			addArr='<?php echo json_encode($session['AddHistory']);?>';
			
			var x;
			data = $.parseJSON(addArr);
			
			for(x=0; x<data.cntry.length; x++)
			{
				var rowCount = $('#addHistoryTb tr').length;
				var i='<a href="#" id="removeRow"><span  class="glyphicon glyphicon-remove"></span></a>';
				if(rowCount==0)
				{
					$('#addHistoryTb').append('<b><p style="width: 250%;font-size: 15px;">You address summary</p></b>');
					if(data.unit[x]!='')
					$('#addHistoryTb').append('<tr><td style="width: 3%;">'+i+'</td><td>'+data.unit[x]+','+data.stno[x]+','+data.stnm[x]+'('+data.sttype[x]+')'+','+data.sub[x]+','+data.pstcd[x]+','+data.city[x]+' '+data.state[x]+','+data.cntry[x]+'</td><td> '+data.frm[x]+' To '+data.to[x]+'</td></tr>');
					else
					$('#addHistoryTb').append('<tr><td style="width: 3%;">'+i+'</td><td>'+data.stno[x]+','+data.stnm[x]+'('+data.sttype[x]+')'+','+data.sub[x]+','+data.pstcd[x]+','+data.city[x]+' '+data.state[x]+','+data.cntry[x]+'</td><td> '+data.frm[x]+' To '+data.to[x]+'</td></tr>');
				}
				else
				{
					if(data.unit[x]!='')
					$('#addHistoryTb tr:last').after('<tr><td style="width: 3%;">'+i+'</td><td>'+data.unit[x]+','+data.stno[x]+','+data.stnm[x]+'('+data.sttype[x]+')'+','+data.sub[x]+','+data.pstcd[x]+','+data.city[x]+' '+data.state[x]+','+data.cntry[x]+'</td><td> '+data.frm[x]+' To '+data.to[x]+'</td></tr>');
					else
					$('#addHistoryTb tr:last').after('<tr><td style="width: 3%;">'+i+'</td><td>'+data.stno[x]+','+data.stnm[x]+'('+data.sttype[x]+')'+','+data.sub[x]+','+data.pstcd[x]+','+data.city[x]+' '+data.state[x]+','+data.cntry[x]+'</td><td> '+data.frm[x]+' To '+data.to[x]+'</td></tr>');
				}
			$("#addressinputs").append('<div id="'+x+'">');
			$("#"+x).append('<input type="hidden" name="unit[]" value="'+data.unit[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="stno[]" value="'+data.stno[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="stnm[]" value="'+data.stnm[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="sttype[]" value="'+data.sttype[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="sub[]" value="'+data.sub[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="city[]" value="'+data.city[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="pstcd[]" value="'+data.pstcd[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="state[]" value="'+data.state[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="cntry[]" value="'+data.cntry[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="frm[]" value="'+data.frm[x]+'"/>');
			 $("#"+x).append('<input type="hidden" name="to[]" value="'+data.to[x]+'"/>');
			 $("#addressinputs").append('</div>');
			}
		$('#addHistoryTb tr').each(function(){
				var a=$(this).find('td:last').text();
				var b=a.split(' To ');
				var fdate=b[0].split("-");
				var tdate=b[1].split("-");
				var From_date = new Date(fdate[2],fdate[1] - 1, fdate[0]);
				var To_date = new Date(tdate[2],tdate[1] - 1, tdate[0]);
				var diff_date =  Math.floor(To_date.getTime() - From_date.getTime());
				//var years = Math.floor(diff_date/31536000000);
				//var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(diff_date/(1000 * 60 * 60 * 24));
				
				 total+=days;
				 //alert(total);
				if(total>=3650)
				{
					
					$("#addhistory :input").attr("disabled", true);
				}
			
		});
				
			
		}
		
		
		$('#RegistrationAsic_from_date_container').on('change',function(){
			
			var From_date = new Date($(this).val().split("/").reverse().join("-"));
			var To_date = new Date();
			//alert(From_date);
			var diff_date =  Math.floor(To_date.getTime() - From_date.getTime());
				//var years = Math.floor(diff_date/31536000000);
				//var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(diff_date/(1000 * 60 * 60 * 24));
			//alert(years+"years"+months+"Months"+days+"days");
			
			if(days!=0)
			{
				if(total==0)
				total=days;
				else
				total+=days;
				
			}
			else
			{   
		       if(total==0)
				total=0;
			}
			//alert(total);
			if(days<3650)
			{
				$("#addhistory :input").attr("disabled", false);
			}
			if(days>=3650)
			{
				$("#addhistory :input").attr("disabled", true);
			}
		});
		if(days>=3650 || total>=3650)
			{
				$("#addhistory :input").attr("disabled", true);
			}
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

    $("input[name='RegistrationAsic[is_postal]']").on("click",function(e){
      var val=$(this).val();
	  if(val==0)
	  {
		  $('#postaladdress').show();
		  
	  }
	  else
	  {
		  $('#postaladdress').hide();
	  }
    });
	var xi=0;
	$('#addHistoryBttn').on("click",function(e){
		
		var unit=$('#AsicAddressHistory_unit').val();
		var stno=$('#AsicAddressHistory_street_number').val();
		var stnm=$('#AsicAddressHistory_street_name').val();
		var sttype=$('#AsicAddressHistory_street_type').val();
		var sub=$('#AsicAddressHistory_suburb').val();
		var city=$('#AsicAddressHistory_city').val();
		var cntry=$('#AsicAddressHistory_country option:selected').text();
		if($('#stateAddDropdown').is(':visible')==true)
		var state=$('#stateAddDropdown :input').val();
		else
		var state=$('#stateAddTextbox :input').val();	
		var pstcd=$('#AsicAddressHistory_postcode').val();
		var frmdt=$('#AsicAddressHistory_from_date').val();
		var todt=$('#AsicAddressHistory_to_date').val();
		//alert(state);
		if(stno!=''&& stnm!='' && sttype!='' && sub!='' && cntry!='' && state!='' && pstcd!='' && frmdt!='' && todt!='')
		{
			
			var i='<a href="#" id="removeRow"><span  class="glyphicon glyphicon-remove"></span></a>';
			
			var rowCount = $('#addHistoryTb tr').length;
			if(rowCount==0)
			{
				
				$('#addHistoryTb').append('<b><p style="width: 250%;font-size: 15px;">You address summary</p></b>');
				
			if(unit!='')
				$('#addHistoryTb').append('<tr><td style="width: 3%;">'+i+'</td><td>'+unit+','+stno+','+stnm+'('+sttype+')'+','+sub+','+pstcd+','+city+' '+state+','+cntry+'</td><td> '+frmdt+' To '+todt+'</td></tr>');
			else
				$('#addHistoryTb').append('<tr><td style="width: 3%;">'+i+'</td><td>'+stno+','+stnm+'('+sttype+')'+','+sub+','+pstcd+' ,'+city+' '+state+','+cntry+'</td><td> '+frmdt+' To '+todt+'</td></tr>');
			
				
			}
			else
			{
			if(unit!='')
				$('#addHistoryTb tr:last').after('<tr><td style="width: 3%;">'+i+'</td><td>'+unit+','+stno+','+stnm+'('+sttype+')'+','+sub+','+pstcd+','+city+' '+state+','+cntry+'</td><td> '+frmdt+' To '+todt+'</td></tr>');
			else
				$('#addHistoryTb tr:last').after('<tr><td style="width: 3%;">'+i+'</td><td>'+stno+','+stnm+'('+sttype+')'+','+sub+','+pstcd+','+city+' '+state+','+cntry+'</td><td> '+frmdt+' To '+todt+'</td></tr>');
			}
			 $("#addressinputs").append('<div id="'+xi+'">');
			 $("#"+xi).append('<input type="hidden" name="unit[]" value="'+unit+'"/>');
			 $("#"+xi).append('<input type="hidden" name="stno[]" value="'+stno+'"/>');
			 $("#"+xi).append('<input type="hidden" name="stnm[]" value="'+stnm+'"/>');
			 $("#"+xi).append('<input type="hidden" name="sttype[]" value="'+sttype+'"/>');
			 $("#"+xi).append('<input type="hidden" name="sub[]" value="'+sub+'"/>');
			 $("#"+xi).append('<input type="hidden" name="city[]" value="'+city+'"/>');
			 $("#"+xi).append('<input type="hidden" name="pstcd[]" value="'+pstcd+'"/>');
			 $("#"+xi).append('<input type="hidden" name="state[]" value="'+state+'"/>');
			 $("#"+xi).append('<input type="hidden" name="cntry[]" value="'+cntry+'"/>');
			 $("#"+xi).append('<input type="hidden" name="frm[]" value="'+frmdt+'"/>');
			 $("#"+xi).append('<input type="hidden" name="to[]" value="'+todt+'"/>');
			 $("#addressinputs").append('</div>');
			$('#AsicAddressHistory_unit').val('');
			$('#AsicAddressHistory_street_number').val('');
			$('#AsicAddressHistory_street_name').val('');
			$('#AsicAddressHistory_street_type').find('option:first').attr('selected', 'selected');
			$('#AsicAddressHistory_suburb').val('');
			$('#AsicAddressHistory_country').val('13').attr('selected', 'selected');
			$('#AsicAddressHistory_state').find('option:first').attr('selected', 'selected');
			$('#AsicAddressHistory_postcode').val('');
			$('#AsicAddressHistory_from_date_container').val('');
			$('#AsicAddressHistory_to_date_container').val('');
				var a=$('#addHistoryTb tr:last').find('td:last').text();
				var b=a.split(' To ');
				var fdate=b[0].split("-");
				var tdate=b[1].split("-");
				var From_date = new Date(fdate[2],fdate[1] - 1, fdate[0]);
				var To_date = new Date(tdate[2],tdate[1] - 1, tdate[0]);
				var diff_date =  Math.floor(To_date.getTime() - From_date.getTime());
				//var years = Math.floor(diff_date/31536000000);
				//var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(diff_date/(1000 * 60 * 60 * 24));
				
				 total+=days;
				// alert(days);
				if(total>=3650)
				{
					
					$("#addhistory :input").attr("disabled", true);
					$.alert({
						title: '10 years of history Completed',
						content: 'If you have filled all required fields please proceed to the next page',
					});
				}
		}
		else
		{
			$.alert({
				title: 'Incomplete or Incorrect Information Added',
				content: 'Please complete the form or check if the dates format is in DD/MM/YYYY',
					});
		}
		xi++;
	});

				
				
		$(document).on("click", 'a#removeRow', function(){
				var rowCount = $('#addHistoryTb tr').length;
				var row = $(this).closest('tr').index()
				//alert(row);

		if(rowCount==1)
		{
				var a=$('#addHistoryTb tr').find('td:last').text();
				var b=a.split(' To ');
				var fdate=b[0].split("-");
				var tdate=b[1].split("-");
				var From_date = new Date(fdate[2],fdate[1] - 1, fdate[0]);
				var To_date = new Date(tdate[2],tdate[1] - 1, tdate[0]);
				var diff_date =  Math.floor(To_date.getTime() - From_date.getTime());
				//var years = Math.floor(diff_date/31536000000);
				//var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(diff_date/(1000 * 60 * 60 * 24));
			total=total-days;
			$('#addHistoryTb tr').remove();
			$('#addHistoryTb p').remove();
			$("#addressinputs").empty();
			rowCount=0;
		}
		else
		{
			var a=$(this).closest('tr').find('td:last').text();
				var b=a.split(' To ');
				var fdate=b[0].split("-");
				var tdate=b[1].split("-");
				var From_date = new Date(fdate[2],fdate[1] - 1, fdate[0]);
				var To_date = new Date(tdate[2],tdate[1] - 1, tdate[0]);
				var diff_date =  Math.floor(To_date.getTime() - From_date.getTime());
				//var years = Math.floor(diff_date/31536000000);
				//var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(diff_date/(1000 * 60 * 60 * 24));
			total=total-days;
		
			$("#"+row).empty();
			
			$(this).closest('tr').remove();
			
			
		}
				
				if(total>=3650)
				{
					$("#addhistory :input").attr("disabled", true);
				}
				else
				{
					$("#addhistory :input").attr("disabled", false);
				}
			//return false;
		
		
		});
        //lose focus from email and check the already entered email
       
	$('#btnSubmit').on("click",function(e){
	if(total<3650)
	{
		$.alert({
				title: '10 years of Address History is not completed',
				content: 'Please check the dates and make sure it equals 10 years',
					});
	 e.preventDefault(e);
	}
		
	});
        
        //******************************************************************************************************
        //******************************************************************************************************
    });
</script>
