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

<div class="page-content">
 <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'immi-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            /*'afterValidate'    => 'js:function(form, data, hasError){
                return afterValidate(form, data, hasError);
            }'*/
        ),
        'htmlOptions'=>array(
            'class'=> 'form-comfirm-detail'
        )
    ));
    ?>
<div class="form-group" style="width:150%;">
				 <label>Are you an Australian or New Zealand citizen? </br></label>
				 <br>
				 <?php
				echo $form->radioButtonList($model, 'is_citizen',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
					echo $form->error($model,'is_citizen');
					?>
				

    

    <!--<div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>-->
    
  
				
				<div id="postaladdress" style="display:none;">
				<a id="Immi" style="display:none;" href="<?php echo Yii::app()->createUrl('preregistration/immiInfo'); ?>"><h3 class="text-primary subheading-size"> Immigration Details</h3></a>
				<div class="row" id="new_asic_area">
				
				<div class="col-sm-4">
                <div class="form-group">
                    <?php echo $form->textField($model, 'travel_id', array('maxlength' => 50, 'placeholder' => 'Travel Document ID' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'travel_id'); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'grant_number', array('maxlength' => 50, 'placeholder' => 'Visa Grant No.' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'grant_number'); ?>
                </div>
				
                <div class="form-group">
                    <?php echo $form->textField($model, 'arrival', array('maxlength' => 50, 'placeholder' => 'Location of Arrival' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'arrival'); ?>
                </div>


                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'arrival_date',
                            'mode'        => 'Resident To Date',
							 'htmlOptions' => array(
                                      //  'style'    => 'width:280px',
									  'placeholder' => 'Date of Arrival',
										'class'=>'form-control input-sm'
                                    ),
                        ));
                        ?>
                        <?php echo $form->error($model,'arrival_date',array('style' => 'margin-left:0')); ?>
                    </div>
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'flight_number', array('maxlength' => 50, 'placeholder' => 'Flight Number' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'flight_number'); ?>
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'name_vessel', array('maxlength' => 50, 'placeholder' => 'Name of Vessel' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'name_vessel'); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'parent_family_name', array('maxlength' => 50, 'placeholder' => 'Family Name of Parent' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'parent_family_name'); ?>
                </div>
				 <div class="form-group">
                    <?php echo $form->textField($model, 'parent_given_name', array('maxlength' => 50, 'placeholder' => 'Given Name of Parent' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'parent_given_name'); ?>
                </div>
			 <div class="form-group">
                    <?php
                    echo $form->dropDownList($modelAsic, 'citizenship', $countryList, array('empty' => 'Select Country of Citizenship', 'class'=>'form-control input-sm' , /*'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))*/));
                    ?>
                    <?php echo $form->error($modelAsic, 'citizenship'); ?>

                </div>
				

            </div>
				
                </div>
             </div>  



  
        


        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="pull-left">
                        <a href="<?=Yii::app()->createUrl("preregistration/personalAsicOnline")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                    </div>
                    <div class="pull-right">
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'id' => 'btnSubmit',
                                'class' => 'btn btn-primary btn-next',
								'style'=>'margin-left:-1500%',
                            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
                    </div>
                </div>
            </div>
        </div>  
 </div>

    <?php $this->endWidget(); ?>



<!-- ************************************** -->

<!-- -Login Modal -->




<!-- ************************************** -->





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

    $("input[name='Immigration[is_citizen]']").on("click",function(e){
      var val=$(this).val();
	  if(val==2)
	  {
		  $('#postaladdress').show();
		  $('#Immi').show();
	  }
	  else
	  {
		  $('#postaladdress').hide();
		  $('#Immi').hide();
	  }
    });


        //******************************************************************************************************
        //******************************************************************************************************
    });
</script>


