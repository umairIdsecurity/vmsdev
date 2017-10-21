<?php
$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');

$session = new CHttpSession;

$dataId = '';

if ($this->action->id == 'asicUpdate') {
    $dataId = $_GET['id'];
}

$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');
// set default country is Australia = 13

?>
<script>
$(document).ready(function(){$(".flash-updated").fadeOut(5000);});
$(document).ready(function(){
	var Addressid;
	$('body').on('click','#addHistoryTb a',function(e) {
		//e.preventDefault();
	var actualid=$(this).attr('id');
    var id = $(this).attr('id').split("_");
	var s=0;
	if(id[1]=='edt')
	{
     $.ajax({
              type: 'GET',
              url: "<?php echo Yii::app()->createUrl('asicApplicant/asicUpdate',array('id'=>$_GET['id']));?>",
                    dataType: 'json',
                    data: {"idAdd":id[0]},
                    success: function (res) {
					Addressid=res.id;
					$("#AsicAddressHistory_unit").val(res.unit);
					$("#AsicAddressHistory_street_number").val(res.street_number);
					$("#AsicAddressHistory_street_name").val(res.street_name);
					$("#AsicAddressHistory_street_type").val(res.street_type);
					$("#AsicAddressHistory_suburb").val(res.suburb);
					$("#AsicAddressHistory_city").val(res.city);
					$("#AsicAddressHistory_state").val(res.state);
					$("#AsicAddressHistory_postcode").val(res.postcode);
					var frm=res.from_date.split('-');
					var newfrm=frm[2]+'/'+frm[1]+'/'+frm[0];
					var to=res.to_date.split('-');
					var newto=to[2]+'/'+to[1]+'/'+to[0];
					$("#AsicAddressHistory_from_date_container").val(newfrm);
					$("#AsicAddressHistory_to_date_container").val(newto);
					$('#AsicAddressHistory_country ').find('option:contains('+res.country+')').prop('selected', true);

					$("#addhistory :input").attr("disabled", false);
					
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
	}
	else if(id[1]=='del')
	{
		 $.ajax({
              type: 'POST',
              url: "<?php echo Yii::app()->createUrl('asicApplicant/asicAddressDelete');?>",
                    data: "&id="+id[0],
                    success: function (res) {
					if(res=='false')
					{
						 $('#'+actualid).closest('tr').remove();
					}
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
	}
			
});

$('#addHistoryBtn').click(function(e){
	$("#addhistory :input").attr("disabled", false);
	$("#addhistory :input").val('');
	Addressid=0;
});

$('#cancelHistorySave').click(function(e){
	$("#addhistory :input").attr("disabled", true);
	$("#addhistory :input").val('');
});
$('body').on('click','#addHistorySave',function(e){

var AddressData=$(this).closest('table').find('input,select').serialize();
 $.ajax({
              type: 'POST',
              url: "<?php echo Yii::app()->createUrl('asicApplicant/asicAddressUpdate');?>",
                    data: AddressData + "&id=" + Addressid + "&appId="+'<?=$_GET['id'];?>',
                    success: function (data) {
					data=data.split('\n');
					$('#flash').html(data[0]).fadeIn().animate({opacity: 1.0}, 3000).fadeOut("slow");
					//console.log(AddressData);
					if(Addressid!=0)
					{
					$('#'+Addressid+'_tdAd').html($("#AsicAddressHistory_unit").val()+'&nbsp'+$("#AsicAddressHistory_street_number").val()+','+$("#AsicAddressHistory_street_name").val()+'('+$("#AsicAddressHistory_street_type").val()+')'+','+$("#AsicAddressHistory_suburb").val()+','+$("#AsicAddressHistory_postcode").val()+','+$("#AsicAddressHistory_city").val()+'&nbsp'+$("#AsicAddressHistory_state").val()+','+$("#AsicAddressHistory_country option:selected").text());
					$('#'+Addressid+'_tdDt').html($("#AsicAddressHistory_from_date_container").val()+' To '+$("#AsicAddressHistory_to_date_container").val());
					}
					else
					{	
						$('#addHistoryTb').append('<tr><td id="'+data[1]+'_tdAd">'+$("#AsicAddressHistory_unit").val()+'&nbsp'+$("#AsicAddressHistory_street_number").val()+','+$("#AsicAddressHistory_street_name").val()+'('+$("#AsicAddressHistory_street_type").val()+')'+','+$("#AsicAddressHistory_suburb").val()+','+$("#AsicAddressHistory_postcode").val()+','+$("#AsicAddressHistory_city").val()+'&nbsp'+$("#AsicAddressHistory_state").val()+','+$("#AsicAddressHistory_country option:selected").text()+'</td><td id="'+data[1]+'_tdDt">'+$("#AsicAddressHistory_from_date_container").val()+' To '+$("#AsicAddressHistory_to_date_container").val()+'</td><td style="width:80px;"><a href="javascript:void(0);" id="'+data[1]+'_edt">Edit</a> &nbsp <a href="javascript:void(0);" id="'+data[1]+'_del">Delete</a></td></tr>');
						
					}
			
					$("#addhistory :input").attr("disabled", true);
					$("#addhistory :input").val('');
                    },
                    error: function(error){
                        console.log(error);
                    }
                });

	
});

});

</script>
<style>
	.flash-updated{
		background: #E6EFC2;
		color: #264409;
		border-color: #C6D880;
		padding: .8em;
		margin-bottom: 1em;
		border: 2px solid #ddd;
		}
	#addHistoryTb td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
	
	}
#area td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
	
	}
    #addCompanyLink {
        width: 124px;
        height: 23px;
        padding-right: 0px;
        margin-right: 0px;
        padding-bottom: 0px;
        display: block;
    }

    .form-label {
        display: block;
        width: 200px;
        float: left;
        margin-left: 15px;
    }

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

    .uploadnotetext {
        margin-top: 110px;
        margin-left: -80px;

    }

    #content h1 {
        color: #2f96b4;
        font-size: 18px;
        font-weight: bold;
        margin-left: 50px;
    }

    .required {
        padding-left: 10px;
    }

    .date_of_birth_class{
        width: 71.5px !important;
    }
	
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    /*padding: 6px 12px;*/
    /*border: 1px solid #ccc;*/
    border-top: none;
}
</style>
<h1>Edit ASIC Applicant</h1>
<?php 
if($model->is_saved==1)
{
?>
 <a style='float: right;margin-top: -30px;' href='<?php echo 'http://vmsprdev-win.identitysecurity.info/index.php/preregistration/index?tenant='.Yii::app()->user->tenant.'&em='.$model->email; ?>' target='_blank'><u> Complete Application</u> </a>
<?php 
}
?>
<div class="tab">
  <button class="tablinks" onclick="openEvent(event, 'personal')"><u>Personal Information</u></button>
  <button class="tablinks" onclick="openEvent(event, 'operational')"><u>Payment, Access & Immigration</u></button>
  <button class="tablinks" onclick="openEvent(event, 'identification')"><u>Identification, Photo & Documentation</u></button>
 
  
</div>

   

    <!--<div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>-->
    

<div id="personal" class="tabcontent" style="display:block;">
<?php if(Yii::app()->user->hasFlash('updated')): ?>
<?php
foreach(Yii::app()->user->getFlashes() as $key => $message) 
			{
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
			}
?>
<?php endif; ?>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'asic-personal-form',
		'htmlOptions'=> array("name" => "registerform"),
        'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
			
        ),
       
    ));
	
    ?>
       
	
      
           <table style="width:275px;float:left">
               
			  
			   <tr>
			    <td id="uploadRow" rowspan="7" style='width:300px;padding-top:25px;'>
				 <table>
			   <tr>
                   <td>
				   <label><b>Personal Information</b></br></label>
                    <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-sm')); ?><span class="required">*</span>
                    <?php echo $form->error($model, 'first_name'); ?>
                </td>
				</tr>
				 <tr>
                   <td>
                    <?php echo $form->textField($model, 'given_name2', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'given_name2'); ?>
                </td>
				</tr>
				 <tr>
                   <td>
                    <?php echo $form->textField($model, 'given_name3', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'given_name3'); ?>
                 </td>
				</tr>
                <tr>
                   <td>
                    <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'placeholder' => 'Surname' , 'class'=>'form-control input-sm')); ?><span class="required">*</span>
                    <?php echo $form->error($model, 'last_name'); ?>
                 </td>
				</tr>
				
				 <tr>
                   <td>
				 <div class="form-group" style="margin-bottom:10px;">
				 <label>Gender<span class="required">*</span></label>
				
				 <?php
				echo $form->radioButtonList($model, 'gender',array(
					'male'=>'Male', 
					'female'=>'Female',
					),array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					echo $form->error($model,'gender');
					?>
					
					</div>
					
					 </td>
				</tr>
				
               <tr>
                   <td>
                    <?php echo $form->textField($model,'email',array('maxlength' => 50, 'placeholder' => 'Email Address', 'class'=>'form-control input-sm')); ?><span class="required">*</span>
                    <?php echo $form->error($model,'email'); ?>
                	 </td>
				</tr>

                 <tr>
                   <td>
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
                        ?><span class="required">*</span>
                        <?php echo $form->error($model,'date_of_birth',array('style' => 'margin-left:0')); ?>
                    </div>
                 </td>
				</tr>
			 <tr>
                   <td>
                    <?php
                    echo $form->dropDownList($model, 'birth_country', $countryList, array('empty' => 'Select Country of Birth', 'class'=>'form-control input-sm' , /*'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))*/));
                    ?><span class="required">*</span>
                    <?php echo $form->error($model, 'birth_country'); ?>

                 </td>
				</tr>
				<tr>
                   <td>
                    <?php echo $form->textField($model, 'birth_state', array('maxlength' => 50, 'placeholder' => 'State of Birth' , 'class'=>'form-control input-sm')); ?><span class="required">*</span>
                    <?php echo $form->error($model, 'birth_state'); ?>
                </td>
				</tr>
				<tr>
                   <td>
                    <?php echo $form->textField($model, 'birth_city', array('maxlength' => 50, 'placeholder' => 'Town or City' , 'class'=>'form-control input-sm')); ?><span class="required">*</span>
                    <?php echo $form->error($model, 'birth_city'); ?>
                </td>
				</tr>
				 <tr>
                   <td>
                    <?php
                    echo $form->dropDownList($model, 'citizenship', $countryList, array('empty' => 'Select Country of Citizenship', 'class'=>'form-control input-sm' , /*'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))*/));
                    ?><span class="required">*</span>
                    <?php echo $form->error($model, 'citizenship'); ?>

                 </td>
				</tr>
				<tr>
                   <td>
                    <?php echo $form->textField($model, 'home_phone', array('maxlength' => 50, 'placeholder' => 'Phone (Home).', 'class'=>'form-control input-sm')); ?>
                   
					</td>
				</tr>
				<tr>
                   <td>
                    <?php echo $form->textField($model, 'work_phone', array('maxlength' => 50, 'placeholder' => 'Phone (Work).', 'class'=>'form-control input-sm')); ?>
                    
                </td>
				</tr>
				<tr>
                   <td>
                    <?php echo $form->textField($model, 'mobile_phone', array('maxlength' => 50, 'placeholder' => 'Phone (Mobile).', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'mobile_phone'); ?>
                 </td>
				</tr>
				 <tr>
                   <td>
				 <label>Preferred method of contact <span class="required">*</span></br></label>
				 
				 <?php
				echo $form->radioButtonList($model, 'preferred_contact',array(
					'Mobile'=>'Mobile', 
					'Home'=>'Home phone',
					'Work'=>'Work phone',
					),array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					echo $form->error($model,'preferred_contact');
					?>
				 </td>
				</tr>
				</table>
               </td>
			   </tr>
			   </table>
			   
			<table style="float:left;width:275px;margin-top: 23px;">


            <tr>
                   <td>
			<label><b>Current Residential Address</b></br></label>
              
                   
				  <tr>
                            <td>
                                <?php echo $form->textField($model, 'unit', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Unit', 'style' => 'width: 80px;')); ?>
                                <?php echo $form->textField($model, 'street_number', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street No.', 'style' => 'width: 110px;')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'unit'); ?>
                                <?php echo $form->error($model, 'street_number'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'street_name', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street Name', 'style' => 'width: 110px;')); ?>
                                <?php echo $form->dropDownList($model, 'street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'style' => 'width: 93px;')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'street_name'); ?>
                                <?php echo $form->error($model, 'street_type'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'suburb', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'Suburb')); ?>
                                <span class="required">*</span> <?php echo $form->error($model, 'suburb'); ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <?php echo $form->textField($model, 'city', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'City')); ?>
                                <span class="required">*</span> <?php echo $form->error($model, 'city'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i id="cstate">
                                    <?php echo $form->dropDownList($model, 'state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'Select State', 'class'=>'form-control input-sm','style' => 'width: 140px;')); ?>
									<?php echo $form->error($model, 'state'); ?>
                                </i>
                               
                                <?php echo $form->textField($model, 'postcode', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Postcode', 'style' => 'width: 62px;')); ?>
                                <span class="required">*</span>
                                
                                <?php echo $form->error($model, 'postcode'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                echo $form->dropDownList($model, 'country', $countryList,
                                    array('prompt' => 'Country', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                                ?><span class="required">*</span>
                                
                                <?php echo $form->error($model, 'country'); ?>
                            </td>
                        </tr>
						<tr>
						<td>
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
                        ?><span class="required">*</span>
                        <?php echo $form->error($model,'from_date',array('style' => 'margin-left:0')); ?>
						</td>
						</tr>
               
				 <tr>
                <td>
				 <label><b>Current Postal Address</b> <span class="required">*</span> </br></label>
				 <label>As above?</label>
				 <?php
				echo $form->radioButtonList($model, 'is_postal',array(
					'1'=>'Yes', 
					'0'=>'No',
					),array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					echo $form->error($model,'is_postal');
					?>
				</td>
				</tr>
				
				<tr>
				<td>
				<table id="postaladdress" style="display:none;">
					  <tr>
                        <td>
                        <?php echo $form->textField($model, 'postal_unit', array('maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-sm','style' => 'width: 80px;')); ?>
              
                        <?php echo $form->textField($model, 'postal_street_number', array('maxlength' => 50, 'placeholder' => 'Street No.', 'class'=>'form-control input-sm','style' => 'width: 110px;')); ?><span class="required">*</span>
                        <?php echo $form->error($model, 'postal_street_number'); ?>
						</td>
						</tr>
						<tr>
                           <td>
                        <?php echo $form->textField($model, 'postal_street_name', array('maxlength' => 50, 'placeholder' => 'Street Name', 'class'=>'form-control input-sm','style' => 'width: 110px;')); ?>
						<?php echo $form->dropDownList($model, 'postal_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'class'=>'form-control input-sm','style' => 'width: 93px;')); ?><span class="required">*</span>
						<?php echo $form->error($model, 'postal_street_name'); ?>
                        <?php echo $form->error($model, 'postal_street_type'); ?>
						</td>
						</tr>
						<tr>
                            <td>
							<?php echo $form->textField($model, 'postal_suburb', array('maxlength' => 50, 'placeholder' => 'Suburb' , 'class'=>'form-control input-sm')); ?><span class="required">*</span>
							<?php echo $form->error($model, 'postal_suburb'); ?>
						</td>
						</tr>
						<tr>
                            <td>
							<?php echo $form->textField($model, 'postal_city', array('maxlength' => 50, 'placeholder' => 'City' , 'class'=>'form-control input-sm')); ?><span class="required">*</span>
							<?php echo $form->error($model, 'postal_city'); ?>
						</td>
						</tr>
						<tr>
                            <td>
						<?php echo $form->dropDownList($model, 'postal_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'Select State', 'class'=>'form-control input-sm','style' => 'width: 140px;')); ?>
                        <?php echo $form->textField($model, 'postal_postcode', array('maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-sm', 'style' => 'width: 62px;')); ?><span class="required">*</span>
						<?php echo $form->error($model, 'postal_state'); ?>
                        <?php echo $form->error($model, 'postal_postcode'); ?>
               
                            </td>
							 </tr>
					<tr>
                       <td>
                    <?php
                    echo $form->dropDownList($model, 'postal_country', $countryList,
                        array('prompt' => 'Select Country', 'class'=>'form-control input-sm',
                            'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?><span class="required">*</span>
                    <?php echo $form->error($model, 'postal_country'); ?>
                

                   </td>
				   </tr>
                        
                   
				</table>
				 </td>
					</tr>
            </table>
			
			<table id='addhistory'  style="float:left;width:300px;margin-top: 23px;">
			
			<tr>
                            <td>
							<label><b>Address History</b></br></label>
			<p style="font-size: 11px;">Please enter 10 years of address history without gaps in the dates or residency</p>
                                <?php echo $form->textField($modelHistory, 'unit', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Unit', 'style' => 'width: 80px;')); ?>
                                <?php echo $form->textField($modelHistory, 'street_number', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street No.', 'style' => 'width: 110px;')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($modelHistory, 'unit'); ?>
                                <?php echo $form->error($modelHistory, 'street_number'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($modelHistory, 'street_name', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street Name', 'style' => 'width: 110px;')); ?>
                                <?php echo $form->dropDownList($modelHistory, 'street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'style' => 'width: 93px;')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($modelHistory, 'street_name'); ?>
                                <?php echo $form->error($modelHistory, 'street_type'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $form->textField($modelHistory, 'suburb', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'Suburb')); ?>
                                <span class="required">*</span> <?php echo $form->error($modelHistory, 'suburb'); ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <?php echo $form->textField($modelHistory, 'city', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'City')); ?>
                                <span class="required">*</span> <?php echo $form->error($modelHistory, 'city'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i id="cstate">
                                    <?php echo $form->dropDownList($modelHistory, 'state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'Select State', 'class'=>'form-control input-sm','style' => 'width: 140px;')); ?>
									<?php echo $form->error($modelHistory, 'state'); ?>
                                </i>
								<i id="state" style='display:none'>
                                    <?php echo $form->textField($modelHistory, 'state', array( 'class'=>'form-control input-sm','placeholder'=>'State','style' => 'width: 140px;')); ?>
									<?php echo $form->error($modelHistory, 'state'); ?>
                                </i>
                               
                                <?php echo $form->textField($modelHistory, 'postcode', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Postcode', 'style' => 'width: 62px;')); ?>
                                <span class="required">*</span>
                                
                                <?php echo $form->error($modelHistory, 'postcode'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                echo $form->dropDownList($modelHistory, 'country', $countryList,
                                    array('prompt' => 'Country', 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                                ?><span class="required">*</span>
                                
                                <?php echo $form->error($modelHistory, 'country'); ?>
                            </td>
                        </tr>
						<tr>
						<td>
						<?php
                        $this->widget('EDatePicker', array(
                            'model'       => $modelHistory,
                            'attribute'   => 'from_date',
                            'mode'        => 'ResidentDates',
							 'htmlOptions' => array(
                                      'placeholder'=>'Resident From Date',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?><span class="required">*</span>
                        <?php echo $form->error($modelHistory,'from_date',array('style' => 'margin-left:0')); ?>
						</td>
						</tr>
						<tr>
						<td>
						 <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $modelHistory,
                            'attribute'   => 'to_date',
                            'mode'        => 'ResidentDates',
							 'htmlOptions' => array(
                                      'placeholder'=>'Resident To Date',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($modelHistory,'to_date',array('style' => 'margin-left:0')); ?>
						</td>
						</tr>
						<tr>
		<td>
		<?php
        echo CHtml::tag('button', array(
            'type'=>'button',
            'id' => 'addHistorySave',
            'class' => 'btn btn-primary',
			'style'=>'margin-top:2px;'
            ), 'Save');
        ?>
		<?php
        echo CHtml::tag('button', array(
            'type'=>'button',
            'id' => 'cancelHistorySave',
            'class' => 'btn btn-primary',
			'style'=>'margin-top:2px;background: -webkit-gradient(linear, center top, center bottom, from(#e67171), to(#d42222)) !important;
					background: -moz-linear-gradient(center top , #e67171, #d42222) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
					background: -webkit-gradient(linear, center top, center bottom, from(#e67171), to(#d42222)) !important;
					background: -ms-linear-gradient(top, #e67171, #d42222) !important;'
            ), 'Cancel');
        ?>
		</td>
		<td>
		
		</td>
		</tr>
						
			</table>
		<table>
		<tr>
		<td>
		<?php
        echo CHtml::tag('button', array(
            'type'=>'button',
            'id' => 'addHistoryBtn',
            'class' => 'btn btn-primary',
			'style'=>'margin-top:2px;'
            ), '+Add Address History');
        ?>
		</td>
		</tr>		
		</table>
			
			<table id='addHistoryTb'>
			<caption id='flash'>
			
			
			</caption>
			<?php if(!empty($addHistory)) {?>
			<caption><b>Address History</b></caption>
			
			<?php foreach ($addHistory as $value=>$key) {?>
				<tr>
				
				<td id="<?=$key->id;?>_tdAd"><?=$key->unit; ?>&nbsp<?=$key->street_number;?>,<?=$key->street_name;?>(<?=$key->street_type;?>),<?=$key->suburb;?>,<?=$key->postcode;?>,<?=$key->city;?>,<?=$key->state;?>,<?=$key->country;?></td>
				<td id="<?=$key->id;?>_tdDt"> <?=date('d/m/Y',strtotime($key->from_date));?> To <?=date('d/m/Y',strtotime($key->to_date));?></td>
				<td style="width:80px;"><a href="javascript:void(0);" id="<?=$key->id;?>_edt">Edit</a> &nbsp <a href="javascript:void(0);" id="<?=$key->id;?>_del">Delete</a></td>
				</tr>
			<?php } ?>
			<?php } ?>			
			</table>
			
			
			
			     


            <div class="col-sm-12">
                <div class="">
        
                    <div class="pull-right">
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'id' => 'btnSubmit',
                                'class' => 'btn btn-primary btn-next'
                            ), 'Save <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
						
                    </div>
                </div>
            </div>
   

   
    <?php $this->endWidget(); ?>
</div>
<div id="operational" class="tabcontent">
<?php if(Yii::app()->user->hasFlash('updated')): ?>
<?php
foreach(Yii::app()->user->getFlashes() as $key => $message) 
			{
			echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
			}
?>

<?php endif; ?>
 <?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'asic-operational-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'style' => 'height:100%;position:relative'
                )
            ));
        ?>
<table style="width:300px;float:left">
               
			  </br>
			   <tr>
			   <td>
				<label><b>ASIC Application types</b><span class="required">*</span></br></label>
        
                
                <?php
					echo $form->radioButtonList($model, 'application_type',array(
					'New'=>'New', 
					'Renew'=>'Renewal',
					'Replacement'=>'Replacement'
					),array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					
                ?>
				<?php echo $form->error($model,'application_type'); ?>
				
                
             
            </td>
        </tr>
		<tr>
		<td>
		</br>
		<label><b>Application Fee</b></span></br></label>
        
                
                <?php echo $form->textField($modelDetails, 'fee', array('maxlength' => 50 , 'class'=>'form-control input-sm')); ?><span class="required">*</span>
                <?php echo $form->error($modelDetails, 'fee'); ?>
				
                
             
            </td>
        </tr>
		<tr>
        <td>
        <label class="checkbox text-size">
            <?php
                    echo $form->checkBox($modelDetails, 'bond_paid',array('class'=>'checkbox'));
                ?>
                <span class="checkbox-style"></span><span class=" text-size" style="line-height:26px">Bond has been paid</span>
                <?php echo $form->error($modelDetails,'bond_paid');?>
            </label>
        </td>
        </tr>
        <tr>
        <td>
        <label class="checkbox text-size">
            <?php
                    echo $form->checkBox($modelDetails, 'fee_paid',array('class'=>'checkbox'));
                ?>
                <span class="checkbox-style"></span><span class=" text-size" style="line-height:26px">Fee has been paid</span>
                <?php echo $form->error($modelDetails,'fee_paid');?>
            </label>
        </td>
        </tr>
		<tr>
		<td>
	
		<label><b>Account Name</b></span></br></label>
        
                
                <?php echo $form->textField($model, 'acc_name', array('maxlength' => 50,  'class'=>'form-control input-sm')); ?><span class="required">*</span>
                <?php echo $form->error($model, 'acc_name'); ?>
				
                
             
            </td>
        </tr>
		<tr>
		<td>        
                	
		<label><b>BSB</b></span></br></label>
                <?php echo $form->textField($model, 'acc_bsb', array('maxlength' => 50,  'class'=>'form-control input-sm')); ?><span class="required">*</span>
                <?php echo $form->error($model, 'acc_bsb'); ?>
				
                
             
            </td>
        </tr>
		<tr>
		<td>        
                	
		<label><b>Account Number</b></span></br></label>
                <?php echo $form->textField($model, 'acc_number', array('maxlength' => 50, 'class'=>'form-control input-sm')); ?><span class="required">*</span>
                <?php echo $form->error($model, 'acc_number'); ?>
				
                
             
            </td>
        </tr>
		
		<tr id='previous' style="display:none;">
		<td>        
                	
		<label><b>Current or Former ASIC No.</b></span></br></label>
                <?php echo $form->textField($modelDetails, 'previous_card', array('maxlength' => 50, 'class'=>'form-control input-sm')); ?>
                <?php echo $form->error($modelDetails, 'previous_card'); ?>

             
            </td>
        </tr>
		<tr id='previous1' style="display:none;">
		<td>        
                	
		<label><b>Previous Issuing Body Airport</b></span></br></label>
                <?php echo $form->textField($modelDetails, 'previous_issuing_body', array('maxlength' => 50, 'class'=>'form-control input-sm')); ?>
                <?php echo $form->error($modelDetails, 'previous_issuing_body'); ?>
				
                
             
            </td>
        </tr>
		<tr id='previous2' style="display:none;">
		<td>        
                	
		<label><b>Other Info </b></span></br></label>
                <?php echo $form->textField($modelDetails, 'other_info', array('maxlength' => 50, 'class'=>'form-control input-sm')); ?>
                <?php echo $form->error($modelDetails, 'other_info'); ?>
				
                
             
            </td>
        </tr>
		<tr id='previous3' style="display:none;">
		<td> 
		<label><b>Previous ASIC Expiry</b></span></br></label>
		  <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $modelDetails,
                            'attribute'   => 'previous_expiry',
                            //'mode'        => 'asic_expiry',
							'htmlOptions'=> array('class'=>'form-control input-sm')
                        ));
                        ?>
                        <?php echo $form->error($modelDetails, 'previous_expiry'); ?>
		 </td>
        </tr>
		<tr>
		<td> 
		<label><b>ASIC Type</b></span><span class="required">*</span></br></label>
		 <?php
					
					echo $form->radioButtonList($modelDetails, 'asic_type',array(
					$session['tenant']=>Company::model()->findByPk($session['tenant'])->name, 
					'2'=>'Australia Wide',),array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					
                ?>
				<?php echo $form->error($modelDetails,'asic_type'); ?>
				 </td>
        </tr>
		<tr>
		<td> 
		</br>
		<label><b>Access Area</b></span><span class="required">*</span></br></label>
		  <?php
					
					echo $form->radioButtonList($modelDetails, 'access',array(
					'1'=>'Red-Security Restricted Area', 
					'2'=>'Grey- General Aviation Area Only',),
					array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'</br>','style'=>'margin-top: -1px;'));
					
                ?>
				<?php echo $form->error($modelDetails,'access'); ?>
				 </td>
        </tr>
        <tr >
        <td>        
        </br>         
        <label><b>ASIC Card Number </b></span><span class="required">*</span></br></label>
                <?php echo $form->textField($modelDetails, 'card_number', array('maxlength' => 50, 'class'=>'form-control input-sm')); ?>
                <?php echo $form->error($modelDetails, 'card_number'); ?>
                
                
             
            </td>
        </tr>
		 </table>
		 <table style="float:left;width:275px;">
		<tr>
		<td>
		<label><b>Reason for Access</b></span><span class="required">*</span></br></label>
		<?php echo $form->textArea($modelDetails, 'security_detail', array('maxlength' => 100,'class'=>'form-control input-sm', 'style'=>'')); ?>
		<?php echo $form->error($modelDetails,'security_detail'); ?>
		</td>
		</tr>
		<tr>
		<td>
		<label><b>Door/Gate that access is required</b></span><span class="required">*</span></br></label>
		<?php echo $form->textArea($modelDetails, 'door_detail', array('maxlength' => 100 ,'class'=>'form-control input-sm', 'style'=>'')); ?>
		<?php echo $form->error($modelDetails,'door_detail'); ?>
		</td>
		</tr>
		<tr>
		<td>
		<label><b>Company Name</b></span><span class="required">*</span></br></label>
		<?php 
		if($companyName!='Company not mentioned')
		echo $form->textField($companyName, 'name', array('maxlength' => 50,  'class'=>'form-control input-sm','disabled'=>'disabled'));
		else
		echo "Company not mentioned";
		?>
		</td>
		</tr>
		<tr>
		<td>
		<label><b>Company Contact Name</b></span><span class="required">*</span></br></label>
		<?php if($companyContact!='Contact not mentioned') { ?>
		<input maxlength="50" class="form-control input-sm" disabled="disabled" type="text" value="<?=$companyContact->first_name.' '.$companyContact->last_name;?>">
		<?php } ?>
		</td>
		</tr>
		</table>
		<table style="width:300px;float:left">
		<tr>
		<td>
		<label><b>Is Australian or Newzealand Citizen</b></span><span class="required">*</span></br></label>
		<?php
				echo $form->radioButtonList($immiModel, 'is_citizen',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					echo $form->error($immiModel,'is_citizen');
					?>
		</td>
		</tr>
		<tr>
		<td>
		</br>
		<table id='immi' style="display:none">
		<tr>
		<td>
			<label><b>Travel ID</b></span><span class="required">*</span></br></label>
		  <?php echo $form->textField($immiModel, 'travel_id', array('maxlength' => 50, 'placeholder' => 'Travel Document ID' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($immiModel, 'travel_id'); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Visa Grant No.</b></span><span class="required">*</span></br></label>
		  <?php echo $form->textField($immiModel, 'grant_number', array('maxlength' => 50, 'placeholder' => 'Visa Grant No.' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($immiModel, 'grant_number'); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Arival Place</b></span><span class="required">*</span></br></label>
		   <?php echo $form->textField($immiModel, 'arrival', array('maxlength' => 50, 'placeholder' => 'Location of Arrival' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($immiModel, 'arrival'); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Date of Arrival</b></span><span class="required">*</span></br></label>
		   <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $immiModel,
                            'attribute'   => 'arrival_date',
                            'mode'        => 'Resident To Date',
							 'htmlOptions' => array(
                                      //  'style'    => 'width:280px',
									  'placeholder' => 'Date of Arrival',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($immiModel,'arrival_date',array('style' => 'margin-left:0')); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Flight No.</b></span><span class="required">*</span></br></label>
		  <?php echo $form->textField($immiModel, 'flight_number', array('maxlength' => 50, 'placeholder' => 'Flight Number' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($immiModel, 'flight_number'); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Name of Vessel</b></span><span class="required">*</span></br></label>
		   <?php echo $form->textField($immiModel, 'name_vessel', array('maxlength' => 50, 'placeholder' => 'Name of Vessel' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($immiModel, 'name_vessel'); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Family Name</b></span><span class="required">*</span></br></label>
		  <?php echo $form->textField($immiModel, 'parent_family_name', array('maxlength' => 50, 'placeholder' => 'Family Name of Parent' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($immiModel, 'parent_family_name'); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Given Name</b></span><span class="required">*</span></br></label>
		 <?php echo $form->textField($immiModel, 'parent_given_name', array('maxlength' => 50, 'placeholder' => 'Given Name of Parent' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($immiModel, 'parent_given_name'); ?>
		</td>
		</tr>
		<tr>
		<td>
			<label><b>Citizenship</b></span><span class="required">*</span></br></label>
		  <?php
                    echo $form->dropDownList($model, 'citizenship', $countryList, array('empty' => 'Select Country of Citizenship', 'class'=>'form-control input-sm' , /*'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))*/));
                    ?>
                    <?php echo $form->error($model, 'citizenship'); ?>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>
        <table style="">
		<tr>
		<td>
		
		<table id="area">
		<caption><b>Security Areas</b></caption>
			<tr id='red' style='display:none;'>
			<td> Security Restricted Area (Red)</td>
			<td>	
			 <?php
					
					echo $form->radioButtonList($modelDetails, 'frequency_red',array(
					'1'=>'Daily',
					'2'=>'Weekly',
					'3'=>'Monthly'
					),
					array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					echo $form->error($modelDetails,'frequency_red'); 
                ?>
			
			</td>
			
			</tr>
			<tr>
			<td> General Aviation Area (Grey)</td>
			<td>	
			 <?php
					
					echo $form->radioButtonList($modelDetails, 'frequency_grey',array(
					'1'=>'Daily',
					'2'=>'Weekly',
					'3'=>'Monthly'
					),
					array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					 echo $form->error($modelDetails,'frequency_grey');
                ?>
				
			</td>
			
			</tr>
			
			</table>
		</td>
		</tr>
		</table>
	
            <div class="col-sm-12">
                <div class="">
        
                    <div class="pull-right">
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'id' => 'btnSubmit',
                                'class' => 'btn btn-primary btn-next'
                            ), 'Save <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
                    </div>
                </div>
            </div>	
			 	
		
		
<?php $this->endWidget(); ?>
</div>
<div id="identification" class="tabcontent">
<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'identity-details-form',
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
<table style="width:300px;float:left">
</br>
<label style="width: 200px;"><b>Category A Identification</b></label>
<tr>
<td>
<?php echo $form->dropDownList($model, 'primary_id', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_PRIMARY, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'primary_id'); ?>

</td>
</tr>
<tr>
<td>
 <?php echo $form->textField($model, 'primary_id_no', array('maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'primary_id_no'); ?>
</td>
</tr>
<tr>
<td>
 <?php
                    echo $form->dropDownList($model, 'country_id1', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id1'); ?>

</td>
</tr>
<tr>
<td>
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
</td>
</tr>
<tr>
<td>
<label>Upload Documentation (optional):</label>
		<?php echo $form->fileField($model,'upload_1', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
		<?php echo $form->error($model, 'upload_1'); ?>		
</td>
</tr>

<tr>

<td>
<label style="width: 200px;"><b>Category B Identification</b></label>
<?php echo $form->dropDownList($model, 'secondary_id', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_SECONDARY, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'secondary_id'); ?>

</td>
</tr>
<tr>
<td>
 <?php echo $form->textField($model, 'secondary_id_no', array('maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'secondary_id_no'); ?>
</td>
</tr>
<tr>
<td>
 <?php
                    echo $form->dropDownList($model, 'country_id2', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id2'); ?>

</td>
</tr>
<tr>
<td>
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
</td>
</tr>
<tr>
<td>
<label>Upload Documentation (optional):</label>
		<?php echo $form->fileField($model,'upload_2', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
		<?php echo $form->error($model, 'upload_2'); ?>		
</td>
</tr>

<tr>

<td>
<label style="width: 200px;"><b>Category C Identification</b></label>
<?php echo $form->dropDownList($model, 'tertiary_id2', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_category, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id2'); ?>

</td>
</tr>
<tr>
<td>
 <?php echo $form->textField($model, 'tertiary_id2_no', array('maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id2_no'); ?>
</td>
</tr>
<tr>
<td>
 <?php
                    echo $form->dropDownList($model, 'country_id3', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id1'); ?>

</td>
</tr>
<tr>
<td>
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
</td>
</tr>
<tr>
<td>
<label>Upload Documentation (optional):</label>
		<?php echo $form->fileField($model,'upload_3', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
		<?php echo $form->error($model, 'upload_3'); ?>		
</td>
</tr>

<tr>

<td>
<label style="width: 200px;"><b>Category D Identification (Optional)</b></label>
<?php echo $form->dropDownList($model, 'tertiary_id1', RegistrationAsic::$IDENTIFICATION_TYPE_LIST_TERTIARY, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id1'); ?>

</td>
</tr>
<tr>
<td>
 <?php echo $form->textField($model, 'tertiary_id1_no', array('maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'tertiary_id1_no'); ?>
</td>
</tr>
<tr>
<td>
 <?php
                    echo $form->dropDownList($model, 'country_id4', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'country_id4'); ?>

</td>
</tr>

<tr>
<td>
<label>Upload Documentation (optional):</label>
		<?php echo $form->fileField($model,'upload_4', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
		<?php echo $form->error($model, 'upload_4'); ?>		
</td>
</tr>
</table>
<table style="width:300px;float:left; margin-top:-10px;">
<tr style="display: block;">
<td id="uploadRow" rowspan="7" style='width:300px;padding-top:10px;'>
		<input type="hidden" id="Visitor_photo" name="RegistrationAsic[photo]"
		value="<?php echo $model['photo']; ?>">

		<?php if ($model['photo'] != NULL) {
		$data = Photo::model()->returnVisitorPhotoRelativePath($dataId);
		$my_image = '';
		if(!empty($data['db_image'])){
		$my_image = "url(data:image;base64," . $data['db_image'] . ")";
		}else{
		$my_image = "url(" .$data['relative_path'] . ")";
		}

		?>
		<style>
		.ajax-upload-dragdrop {
			background: <?php echo $my_image ?> no-repeat center top;
			background-size: 137px 190px;
		}
		</style>
		<?php }
		?>
	
		<br>

		<?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>


		
</td>
</tr>
<tr style="position: absolute;margin-top: 60px;">
<td>
<label style=""><b>Uploaded Documents:</b></label>
<?php if($model->upload_1!='') { ?>
<a href='<?='/uploads/files/asic_uploads/'.$model->upload_1;?>'><?=$model->upload_1;?></a></br>
<?php } ?>
<?php if($model->upload_2!='') { ?>
<a href='<?='/uploads/files/asic_uploads/'.$model->upload_2;?>'><?=$model->upload_2;?></a></br>
<?php } ?>
<?php if($model->upload_3!='') { ?>
<a href='<?='/uploads/files/asic_uploads/'.$model->upload_3;?>'><?=$model->upload_3;?></a></br>
<?php } ?>
<?php if($model->upload_4!='') { ?>
<a href='<?='/uploads/files/asic_uploads/'.$model->upload_4;?>'><?=$model->upload_4;?></a>
<?php } ?>
</td>
</tr>
<tr>
<td>

</td>
</tr>
<tr>
<td>

</td>
</tr>
<tr style="position: absolute;margin-top:215px;">
<td>
<label style=""><b>Other Documents:</b></label>
<?php if($model->op_need_document!='') { ?>
<a href='<?='/uploads/files/asic_uploads/'.$model->op_need_document;?>'><?=$model->op_need_document;?></a></br>
<?php } ?>
<?php if($model->name_change_file!='') { ?>
<a href='<?='/uploads/files/asic_uploads/'.$model->name_change_file;?>'><?=$model->name_change_file;?></a></br>
<?php } ?>
</td>
</tr>                          
</table>
 
<table style="width:275px;float:left">
               
			  
			   <tr>
			    <td id="uploadRow" rowspan="7" style='width:300px;padding-top:25px;'>
				 <table>
			   <tr>
                   <td>
				   <label style="margin-top:-50px;"><b>Previous Name 1:</b></br></label>
                      <?php echo $form->textField($model, 'changed_given_name1', array('maxlength' => 50, 'placeholder' => 'First Name(optional)' , 'class'=>'form-control input-sm')); ?>          
					  </td>
				</tr>
				 <tr>
                   <td>
                    <?php echo $form->textField($model, 'changed_given_name2', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </td>
				</tr>
				 <tr>
                   <td>
                    <?php echo $form->textField($model, 'changed_given_name3', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                 </td>
				</tr>
                <tr>
                   <td>
                     <?php echo $form->textField($model, 'changed_last_name1', array('maxlength' => 50, 'placeholder' => 'Surname(optional)' , 'class'=>'form-control input-sm')); ?>
                 </td>
				</tr>
				<tr>
				<td>
				<?php
					
					echo $form->radioButtonList($model, 'name_type1',array(
					'Previous'=>'Previous', 
					'Alias'=>'Alias',
					'Maiden'=>'Maiden',
					),
					array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					
                ?>
				</td>
				</tr>
				</table>
				<table>
			   <tr>
                   <td>
				   <label><b>Previous Name 2:</b></br></label>
                      <?php echo $form->textField($model, 'changed_given_name1_1', array('maxlength' => 50, 'placeholder' => 'First Name(optional)' , 'class'=>'form-control input-sm')); ?>          
					  </td>
				</tr>
				 <tr>
                   <td>
                    <?php echo $form->textField($model, 'changed_given_name2_1', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                </td>
				</tr>
				 <tr>
                   <td>
                    <?php echo $form->textField($model, 'changed_given_name3_1', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
                 </td>
				</tr>
                <tr>
                   <td>
                     <?php echo $form->textField($model, 'changed_last_name2', array('maxlength' => 50, 'placeholder' => 'Surname(optional)' , 'class'=>'form-control input-sm')); ?>
                 </td>
				</tr>
				<tr>
				<td>
				<?php
					
					echo $form->radioButtonList($model, 'name_type2',array(
					'Previous'=>'Previous', 
					'Alias'=>'Alias',
					'Maiden'=>'Maiden',
					),
					array('labelOptions'=>array('style'=>'display:inline;'),'separator'=>'&nbsp&nbsp&nbsp','style'=>'margin-top: -1px;'));
					
                ?>
				</td>
				</tr>
					<tr>
					<td>
					<label>Upload Name Documentation (optional):</label>
					<?php echo $form->fileField($model,'name_change_file', array('class'=>'input-file','accept'=>'.jpg,.jpeg,.doc,.docx,.pdf')); ?>
						<?php echo $form->error($model, 'name_change_file'); ?>		
					</td>
					</tr>
				</table>
				</table>
<div class="col-sm-12">
                <div class="">
        
                    <div class="pull-right">
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'id' => 'btnSubmit',
                                'class' => 'btn btn-primary btn-next'
                            ), 'Save <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
                    </div>
                </div>
            </div>	
<?php $this->endWidget(); ?>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.2.0/jquery-confirm.min.js"></script>
<script>
$(document).ready(function(){
	$('#export-button').on('click', function(){
		alert($(this).attr('action'));
	});
	//$('#Visitor_photo').val().trigger('change');
	$('#Visitor_photo').on('change',function(){
				$.ajax({
                        type: 'POST',
                        url: "<?php echo Yii::app()->createUrl('photo/GetAsicPhoto'); ?>",
                        data: "id="+$('#Visitor_photo').val(),
						success: function(data) {
							 var my_db_image = "url(data:image;base64,"+ data + ")";
							 //alert(my_db_image);
                          $(".ajax-upload-dragdrop").css("background",  my_db_image+ " no-repeat center top !important");
                          $(".ajax-upload-dragdrop").css({"background-size": "137px 190px !important" });
                             //$(".photo_visitor").src = "data:image;base64,"+ value.db_image;
                        }
                    });
	
	});
	$('#AsicAddressHistory_country').on('change',function(){
			if($(this).val()=='13')
			{
				$('#cstate').show();
				$('#state').hide();
			}
			else
			{
				$('#cstate').hide();
				$('#state').show();
			}
			
		});
		
	
	if('<?=$model->application_type?>'!='' && '<?=$model->application_type?>'!='New' )
	{
		$('#previous,#previous1,#previous2,#previous3').show();
	}
	$("input[name='RegistrationAsic[application_type]']").on("click",function(e){
	var val=$(this).val();
	if(val!='New')
	{
		$('#previous,#previous1,#previous2,#previous3').show();
	}
	else
		$('#previous,#previous1,#previous2,#previous3').hide();
	});
	if('<?=$modelDetails->frequency_red?>'!='')
	{
		$('#red').show();
	}
	$("input[name='AsicInfo[access]']").on("click",function(e){
	var val=$(this).val();
	if(val=='1')
	{
		$('#red').show();
	}
	else
		$('#red').hide();
	});
	if('<?=$immiModel->is_citizen?>'!='1')
	{
		$('#immi').show();
	}
	$("input[name='Immigration[is_citizen]']").on("click",function(e){
	var val=$(this).val();
	if(val=='2')
	{
		$('#immi').show();
	}
	else
		$('#immi').hide();
	});
	
});
function openEvent(evt, Eventname) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(Eventname).style.display = "block";
    evt.currentTarget.className += " active";
}
    $(document).ready(function () {
		
		var year;
		var total;
		
			
		$("#addhistory :input").attr("disabled", true);
		
		$('#RegistrationAsic_from_date_container').on('change',function(){
			
			var From_date = new Date($(this).val().split("/").reverse().join("-"));
			var To_date = new Date();
			//alert(From_date);
			var diff_date =  To_date - From_date;
			year = Math.floor(diff_date/31536000000);
			var months = Math.floor((diff_date % 31536000000)/2628000000);
			var days = Math.floor(((diff_date % 31536000000) % 2628000000)/86400000);
			//alert(years+"years"+months+"Months"+days+"days");
			if(year!=0)
			{
				total=year;
				
			}
			else
			total=0;
			if(year<10)
			{
				$("#addhistory :input").attr("disabled", false);
			}
		});
		
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
		if($('#cstate').is(':visible')==true)
		var state=$('#cstate :input').val();
		else
		var state=$('#state :input').val();	

		var pstcd=$('#AsicAddressHistory_postcode').val();
		var frmdt=$('#AsicAddressHistory_from_date').val();
		var todt=$('#AsicAddressHistory_to_date').val();
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
				$('#addHistoryTb').append('<tr><td style="width: 3%;">'+i+'</td><td>'+stno+','+stnm+'('+sttype+')'+','+sub+','+pstcd+','+city+' '+state+','+cntry+'</td><td> '+frmdt+' To '+todt+'</td></tr>');
			
				
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
			$('#AsicAddressHistory_from_date').val('');
			$('#AsicAddressHistory_to_date').val('');
				var a=$('#addHistoryTb tr:last').find('td:last').text();
				var b=a.split(' To ');
				var fdate=b[0].split("-");
				var tdate=b[1].split("-");
				var From_date = new Date(fdate[2],fdate[1] - 1, fdate[0]);
				var To_date = new Date(tdate[2],tdate[1] - 1, tdate[0]);
				var diff_date =  To_date - From_date;
				var years = Math.floor(diff_date/31536000000);
				var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(((diff_date % 31536000000) % 2628000000)/86400000);
				
				 total+=years;
				if(total>=10)
				{
					
					$("#addhistory :input").attr("disabled", true);
				}
		}
		else
		{
			$.alert({
				title: 'No Information Added',
				content: 'Please fill in your address history details before clicking this button',
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
				var diff_date =  To_date - From_date;
				var years = Math.floor(diff_date/31536000000);
				var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(((diff_date % 31536000000) % 2628000000)/86400000);
			total=total-years;
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
				var diff_date =  To_date - From_date;
				var years = Math.floor(diff_date/31536000000);
				var months = Math.floor((diff_date % 31536000000)/2628000000);
				var days = Math.floor(((diff_date % 31536000000) % 2628000000)/86400000);
			total=total-years;
		
			$("#"+row).empty();
			
			$(this).closest('tr').remove();
			
			
		}
				
				if(total>=10)
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
       

        
        //******************************************************************************************************
        //******************************************************************************************************
    });
</script>

