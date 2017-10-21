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
<?php
$js = <<< EOJ
function beforeValidate(form) {
        if (form.data('submitObject').hasClass('jsNoValidate'))
		{
			this.validateOnSubmit = false;
			this.beforeValidate = '';
			form.submit();
			
			return false;
		}
                
        return true;
}
EOJ;
Yii::app()->clientScript->registerScript('beforeValidate', $js);
?>
<div class="page-content">

    <a href="<?php echo Yii::app()->createUrl('preregistration/identificationAsicOnline'); ?>"><h3 class="text-primary subheading-size">Identification Verification</h3></a>

    <!--<div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>-->
    <span>Please provide one identification from each of the following categories. <br>You may also upload your documentation which will save time in the processing of your application.</span><br>
		


    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'identity-details-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
			'beforeValidate'=>"js:beforeValidate"
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
            <div class="col-sm-4" style="margin-top: -40px;">
			<h3 class="text-primary subheading-size" >Category A Identification</h3>
			<span>Birth Certificate, Citizenship Certificate, Certificate or Resident Status<span></br>
                 <div class="form-group">
                    <?php echo $form->dropDownList($model, 'primary_id', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_PRIMARY, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'primary_id'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'primary_id_no', array('maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'primary_id_no'); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'country_id1', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id1'); ?>

                </div>

                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'primary_id_expiry',
                            'mode'        => 'expiry',
							'htmlOptions' => array(
                                       // 'style'    => 'width:280px',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'primary_id_expiry'); ?>
                    </div>
                </div>
				<div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
					<label>Upload Documentation (optional):</label>
		<?php if ($model->upload_1!='') echo "Previous Uploaded File: ".$model->upload_1;?>
		<?php echo $form->fileField($model,'upload_1', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
		<?php echo $form->error($model, 'upload_1'); ?>
		
		</div>
		</div>
            </div>

            <div class="col-sm-3">
                &nbsp;
            </div>


        </div>
<br>
<div class="row" id="secondary">

		
 
            <div class="col-sm-4">
			<h3 class="text-primary subheading-size" >Category B Identification</h3>
			<span>Australian Driver’s Licence, Licence Issued under the Law of Commonwealth</br> Government Employee Identification</span></br>
			
                <div class="form-group">
                    <?php echo $form->dropDownList($model, 'secondary_id', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_SECONDARY, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'secondary_id'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'secondary_id_no', array('maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'secondary_id_no'); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'country_id2', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id2'); ?>

                </div>

                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'secondary_id_expiry',
                            'mode'        => 'expiry',
							'htmlOptions' => array(
                                       // 'style'    => 'width:280px',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'secondary_id_expiry'); ?>
                    </div>
                </div>
				<div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
					<label>Upload Documentation (optional):</label>
		<?php if ($model->upload_2!='') echo "Previous Uploaded File: ".$model->upload_2;?>
		<?php echo $form->fileField($model,'upload_2', array('class'=>'input-file')); ?>
		<?php echo $form->error($model, 'upload_2'); ?>
		
		</div>
		</div>
				
			
            </div>
				

            <div class="col-sm-3">
                &nbsp;
            </div>

           
        </div>
		<div class="row" id="categoryC">

 
            <div class="col-sm-4">
			<h3 class="text-primary subheading-size" >Category C Identification</h3>
			<span>Medicare Card, Marriage Certificate, Current previous ASIC, Evidence of employment Payslip (less than 6 months)<span></br>
                <div class="form-group">
                    <?php echo $form->dropDownList($model, 'tertiary_id2', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_category, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id2'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'tertiary_id2_no', array('maxlength' => 50, 'placeholder' => 'Document No.(if applicable)', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id2_no'); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'country_id3', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id3'); ?>

                </div>

                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'tertiary_id2_expiry',
                            'mode'        => 'expiry',
							'htmlOptions' => array(
                                       // 'style'    => 'width:280px',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tertiary_id2_expiry'); ?>
                    </div>
                </div>
				<div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
					<label>Upload Documentation (optional):</label>
		<?php if ($model->upload_3!='') echo "Previous Uploaded File: ".$model->upload_3;?>
		<?php echo $form->fileField($model,'upload_3', array('class'=>'input-file')); ?>
		<?php echo $form->error($model, 'upload_3'); ?>
		
		</div>
		</div>
				
			
            </div>
				

            <div class="col-sm-3">
                &nbsp;
            </div>

           
        </div>
		<div id='check'>
	<label class="checkbox text-size" style='margin-left: 24px; width: 60%;'>
			<?php
				echo $form->checkBox($model, 'check2',array('class'=>'checkbox'));
                ?>
				<span class="checkbox-style" style='margin-left:-4.5%;'></span><span class=" text-size" style="line-height:21px">My current address is not written on Category A,B or C</span>
				<?php echo $form->error($model,'check2');?>
			</label>	
			</div>
		<div class="row" id="tertiary" style='display:none;'>
		
	

            <div class="col-sm-4">
			<h3 class="text-primary subheading-size" >Category D Identification</h3>
			<span>Only required if Category A, B and C do not include your current residential address</span></br>
                <div class="form-group">
                    <?php echo $form->dropDownList($model, 'tertiary_id1', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_TERTIARY, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id1'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'tertiary_id1_no', array('maxlength' => 50, 'placeholder' => 'Document No.(if applicable)', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id1_no'); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'country_id4', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id4'); ?>

                </div>

           
				<div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
					<label>Upload Documentation (optional):</label>
		<?php if ($model->upload_4!='') echo "Previous Uploaded File: ".$model->upload_4;?>
		<?php echo $form->fileField($model,'upload_4', array('class'=>'input-file')); ?>
		<?php echo $form->error($model, 'upload_4'); ?>
		
		</div>
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
                        <a href="<?=Yii::app()->createUrl("preregistration/immiInfo")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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









<script>
    $(document).ready(function () {
		if("<?php if(isset($session['identification_Details'])) {echo "true";} else {echo "false";} ?>"=="true" && "<?php if(isset($session['checked']) && $session['checked']==1){echo "1";} else {echo "0";}?>"=="1")
		{
			
				$('#RegistrationAsic_check2').prop('checked', true);
				$("#tertiary").show();
				//$("#secondary").hide();
				//$("#secondary:input").val("");
				$("RegistrationAsic_secondary_id_expiry_container").val('');
			
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

    $("input[name='RegistrationAsic[check2]']").on("click",function(e){
      $("#tertiary").toggle();
	  //$("#secondary").toggle();
	  
    });

        //lose focus from email and check the already entered email
        $("#Registration_email").blur(function(){
            //If it is already logged in, don't want to check and ask for to be logged in again
            <?php if ( isset(Yii::app()->user->id) ) { ?>
                return;
            <?php } ?>
            var email = $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('preregistration/checkEmailIfUnique');?>",
                dataType: 'json',
                data: {"email":email},
                success: function (r) {
                    if (r.data[0].isTaken == 1) { //if taken
                        $("#PreregLogin_username").val(email);
                        $("#loginModal").modal({
                            show : true,
                            keyboard: false,
                            backdrop: 'static'
                        });
                        $("#login_fail").empty();
                        $("#login_fail").append('A User Profile already exists for this email address. Please Login or use another email address.');
                        $("#login_fail").show();
                    }
                }
            });
        });

        //when submit button is clicked check for already registered email
        /*$("#confirm-details-form").submit(function(e){
            //If it is already logged in, don't want to check and ask for to be logged in again
            <?php if ( isset(Yii::app()->user->id) ) {?>
                return;
            <?php } ?>

            var email = $("#Registration_email").val();
            var fName = $("#Registration_first_name").val();var lName = $("#Registration_last_name").val();
            var dob = $("#Registration_date_of_birth").val();var idenType = $("#Registration_identification_type").val();
            var docNo = $("#Registration_identification_document_no").val();var idenCountry = $("#Registration_identification_country_issued").val();
            var docExp = $("#Registration_identification_document_expiry").val();var streetNo = $("#Registration_contact_street_no").val();
            var streetName = $("#Registration_contact_street_name").val();var streetType = $("#Registration_contact_street_type").val();
            var suburb = $("#Registration_contact_suburb").val();var conCountry = $("#Registration_contact_country").val();
            var state = $("#Registration_contact_state").val();var postcode = $("#Registration_contact_postcode").val();
            var conNo = $("#Registration_contact_number").val();
            
            if(email != ""){
                if(fName != "" && lName != "" && dob != "" && idenType !="" && docNo !="" && idenCountry != "" && docExp != "" && streetNo != "" && streetName != "" && streetType != "" && suburb != "" && conCountry != "" && state != "" && postcode != "" && conNo != "")
                {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo Yii::app()->createUrl('preregistration/checkEmailIfUnique');?>",
                        dataType: 'json',
                        data: {"email":email},
                        success: function (r) {
                            if (r.data[0].isTaken == 1) { //if taken
                                $("#PreregLogin_username").val(email);
                                $("#loginModal").modal({
                                    show : true,
                                    keyboard: false,
                                    backdrop: 'static'
                                });
                                $("#login_fail").empty();
                                $("#login_fail").append('A User Profile already exists for this email address. Please Login or use another email address.');
                                $("#login_fail").show();
                            }else{
                                $("#confirm-details-form").submit();
                                $("#confirm-details-form").unbind("submit");
                            }
                        }
                    });
                    //prevent form from submitting as email already registered
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
            }
            else
            {
                var fName = $("#Registration_first_name").val();
                var lName = $("#Registration_last_name").val();
                var dob = $("#Registration_date_of_birth").val();

                if(fName != "" && lName != "" && dob !="")
                {
                     if(email != "" && idenType !="" && docNo !="" && idenCountry != "" && docExp != "" && streetNo != "" && streetName != "" && streetType != "" && suburb != "" && conCountry != "" && state != "" && postcode != "" && conNo != "")
                    {
                        var newdob = dob.split("-").reverse().join("-");
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo Yii::app()->createUrl('preregistration/checkUserProfile');?>",
                            dataType: 'json',
                            data: {"firstname": fName, "lastname": lName, "dob": newdob},
                            success: function (r) {
                                if (r.data[0].isTaken == 1) { //if taken
                                    $("#PreregLogin_username").val(email);
                                    $("#loginModal").modal({
                                        show : true,
                                        keyboard: false,
                                        backdrop: 'static'
                                    });
                                    $("#login_fail").empty();
                                    $("#login_fail").append('A User Profile already exists for these credentials. Please Login.');
                                    $("#login_fail").show();
                                }
                                else{
                                    $("#confirm-details-form").submit();
                                    $("#confirm-details-form").unbind("submit");
                                }
                            },
                            error: function(err){
                                console.log('get error');
                                console.log(err);
                            }
                        });
                        //prevent form from submitting as email already registered
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    }
                }
            }
        });*/
$("#confirm-details-form").submit(function(e){
	window.location.href="<?php echo Yii::app()->createUrl('preregistration/asicOperationalNeed'); ?>"
	});
        //******************************************************************************************************
        //******************************************************************************************************
        $('#search_asic_box').on('input', function() {
            $("#search_asic_error").hide();
            $("#asic_table_wrapper").hide();
            $("#asic-notification").hide();
            $('#Registration_selected_asic_id').val("");
            //$('#new_asic_area').show();
        });

        $('#search_asic_btn').click(function(event) {
            event.preventDefault();

            var search = $("#search_asic_box").val();
            var base_url = $("#base_url").val();

            if (search.length > 0) {
                $("#loader").show();
                var search_value = 'search_value=' + search;

                $.ajax({
                    url: base_url + '/index.php/preregistration/ajaxVICHolderSearch',
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
                                    { "title": "Select", "width": "3%"},
                                    { "title": "First Name" },
                                    { "title": "Last Name" },
                                    { "title": "Company" }
                                ],
                                "fnDrawCallback": function (oSettings) {
                                    $('.selected_asic').click(function() {
                                        $('#Registration_selected_asic_id').val($(this).val());
                                        /*$('#Registration_contact_number').val("");
                                        $('#Registration_email').val("");*/
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
        //******************************************************************************************************
        //******************************************************************************************************
    });
</script>


<style type="text/css">
.bt-login,.bt-login:hover, .bt-login:active, .bt-login:focus {
    background-color: #3276B1;
    color: #ffffff;
    padding-bottom: 10px;
    padding-top: 10px;
    transition: background-color 300ms linear 0s;
}
.login-tab {
    margin: 0 auto;
    max-width: 380px;
}

.login-modal-header {
    /*background: #27ae60;*/
    color: #fff;
}

.login-modal-header .modal-title {
    /*color: #fff;*/
     color: #428BCA;
}

.login-modal-header .close {
    /*color: #fff;*/
    color: #000;
}

.login-modal i {
    color: #000;
}

.login-modal form {
    max-width: 340px;
}

.tab-pane form {
    margin: 0 auto;
}
.login-modal-footer{
    margin-top:15px;
    margin-bottom:15px;
}

body.modal-open .page-content{
    -webkit-filter: blur(7px);
    -moz-filter: blur(15px);
    -o-filter: blur(15px);
    -ms-filter: blur(15px);
    filter: blur(15px);
}
  
.modal-backdrop {background: #f7f7f7;}

    .date_of_birth_class{
        width: 32.33% !important;
          border: 1px solid #cccccc;
          border-radius: 3px;
    font-size: 12px;
    height: 30px;
    line-height: 1.5;
    }

</style>