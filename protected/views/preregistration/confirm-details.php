<?php

    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
    $cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');

    $countryList = CHtml::listData(Country::model()->findAll(array(
        "order" => "name asc",
        "group" => "name"
    )), 'id', 'name');
?>

<div class="page-content">

    <a href="<?php echo Yii::app()->createUrl('preregistration/personalDetails'); ?>"><h3 class="text-primary subheading-size">Personal Information</h3></a>

    <!--<div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>-->
    
    <?php if ( (isset(Yii::app()->user->account_type)) && ((Yii::app()->user->account_type == "ASIC") || (Yii::app()->user->account_type == "CORPORATE")) ) { ?>
                

    <!--  searching VIC -->
    <div class="row">
        <div class="col-sm-4 col-xs-12" style="padding-top: 10px;">
            <?php  echo CHtml::textField('search_asic_box' , '',
                array(
                    'class'=>'form-control input-sm',
                    'placeholder'=>'First Name, Last Name or Email'
                )
            );
            ?>
            <div id="search_asic_error" class="errorMessage" style="display:none">Please type something on search box</div>
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
            ), 'Find VIC Holder');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xs-12" style="padding-top: 10px;">

            <div class="tableFont" id="asic_holder"></div>

            <div class="loader" id="loader" style="display:none">Loading...</div>

            <p id="asic-notification" class="bg-info" style="display:none">No Record Found</p>
        </div>
    </div>
    <!--  end searching VIC -->
    
    <?php } ?> 

    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'confirm-details-form',
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
        <div class="form-group">
            <?php echo $form->hiddenField($model, 'selected_asic_id' ,
                array('value'=>'')
            ); ?>
        </div>

        <div class="row" id="new_asic_area">
            <div class="col-sm-4">
                <div class="form-group">
                    <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'placeholder' => 'Surname' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>


                <div class="form-group">
                    <?php echo $form->textField($model,'email',array('maxlength' => 50, 'placeholder' => 'Email Address', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model,'email'); ?>
                </div>

                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <?php echo $form->hiddenField($model,'date_of_birth',['data-format'=>"DD-MM-YYYY",'data-template'=>"DD MMM YYYY"]) ?>
                        <script>
                            $(function(){
                                $('#Registration_date_of_birth').combodate({
                                    minYear: (new Date().getFullYear()-100),
                                    maxYear: (new Date().getFullYear()-10),
                                    smartDays: true,
                                    customClass: 'date_of_birth_class'
                                });
                            });
                        </script>
                        <?php echo $form->error($model, 'date_of_birth',array('style' => 'margin-left:0')); ?>
                    </div>
                </div>


                <div class="form-group">
                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Select Identification Type' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'identification_type'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'identification_document_no', array('maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'identification_document_no'); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'identification_country_issued', $countryList, array('empty' => 'Select Country of Issue', 'class'=>'form-control input-sm' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'identification_country_issued'); ?>

                </div>

                <div class="row form-group">
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <!-- <span class="">Expiry</span> -->
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'identification_document_expiry',
                            'options'     => array(
                                'minDate'=>'0',
                                'dateFormat' => 'dd-mm-yy',
                                'changeMonth' => true,
                                'changeYear' => true
                            ),
                            'htmlOptions' => array(
                                'maxlength'   => '10',
                                'placeholder' => 'Expiry',
                                'class' => 'form-control input-sm'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'identification_document_expiry'); ?>
                    </div>
                </div>

            </div>

            <div class="col-sm-3">
                &nbsp;
            </div>

            <div class="col-sm-4">
                <div class="row form-group">
                    <div class="col-xs-5">
                        <?php echo $form->textField($model, 'contact_unit', array('maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'contact_unit'); ?>

                    </div>
                    <div class="col-xs-7">
                        <?php echo $form->textField($model, 'contact_street_no', array('maxlength' => 50, 'placeholder' => 'Street No.', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'contact_street_no'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-6">
                        <?php echo $form->textField($model, 'contact_street_name', array('maxlength' => 50, 'placeholder' => 'Street Name', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'contact_street_name'); ?>
                    </div>
                    <div class="col-xs-6">
                        <?php echo $form->dropDownList($model, 'contact_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'contact_street_type'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_suburb', array('maxlength' => 50, 'placeholder' => 'Suburb' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'contact_suburb'); ?>
                </div>


                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'contact_country', $countryList,
                        array('prompt' => 'Select Country', 'class'=>'form-control input-sm',
                            'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'contact_country'); ?>
                </div>

                <div class="row form-group">

                    <div id="stateDropdown" class="col-xs-6">
                        <?php echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'Select State', 'class'=>'form-control input-sm')); ?>
                    </div>
                    
                    <div style="display:none;" id="stateTextbox" class="col-xs-6">
                        <?php echo $form->textField($model, 'contact_state', array('maxlength' => 50, 'placeholder' => 'Enter State', 'class'=>'form-control input-sm','disabled'=>'disabled')); ?>
                    </div> 

                    <div class="col-xs-6">
                        <?php echo $form->textField($model, 'contact_postcode', array('maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-sm')); ?>
                        <?php echo $form->error($model, 'contact_postcode'); ?>
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

                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_number', array('maxlength' => 50, 'placeholder' => 'Phone No.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'contact_number'); ?>
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
                        <a href="<?=Yii::app()->createUrl("preregistration/declaration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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



<!-- ************************************** -->

<!-- -Login Modal -->


<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content login-modal">
            <div class="modal-header login-modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="loginModalLabel">AVMS LOGIN</h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div role="tabpanel" class="login-tab">
                        <!-- Nav tabs -->
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active text-center" id="home">
                                &nbsp;&nbsp;
                                <span id="login_fail" class="response_error" style="color:red;display: none;"></span>
                                
                                <br>
                                
                                <div class="clearfix"></div>
                                
                                <?php $form=$this->beginWidget('CActiveForm', array(
                                    'id'=>'prereg-login-form',
                                    'enableClientValidation'=>true,
                                    'action' => array('preregistration/login'),
                                    'clientOptions'=>array(
                                        'validateOnSubmit'=>true,
                                    ),
                                    'htmlOptions'=>array(
                                        'class'=>"form-create-login"
                                    )
                                )); ?>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <!-- <input type="text" class="form-control" id="login_username" placeholder="Username"> -->
                                             <?php echo $form->textField($preModel,'username',
                                                array(
                                                    'placeholder' => 'Username or Email',
                                                    'class'=>'form-control input-lg',
                                                    //'id'=>'login_username',
                                                    'data-validate-input'
                                                )); ?>
                                        </div>
                                        <?php echo $form->error($preModel,'username',array('style' =>'float:left')); ?>
                                        <!-- <span class="help-block has-error" id="email-error"></span> -->
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                            <!-- <input type="password" class="form-control" id="password" placeholder="Password"> -->
                                            <?php echo $form->passwordField($preModel,'password',
                                                array(
                                                    'placeholder' => 'Password',
                                                    'class'=>'form-control input-lg',
                                                    'data-validate-input'
                                                )); ?>
                                        </div>
                                        <?php echo $form->error($preModel,'password',array('style' =>'float:left')); ?>
                                        <!-- <span class="help-block has-error" id="password-error"></span> -->
                                    </div>

                                    <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary bt-login','style'=>'float:left')); ?>
                                    <!-- <button type="button" id="login_btn" class="btn btn-block bt-login" data-loading-text="Signing In....">Login</button> -->
                                    
                                    <div class="clearfix"></div>
                                    <div class="login-modal-footer">
                                        <div class="row">
                                            <div class="col-xs-8 col-sm-8 col-md-8">
                                                <i class="fa fa-lock"></i>
                                                <a style="float:left" href="<?php echo Yii::app()->createUrl('preregistration/forgot'); ?>" class="forgetpass-tab">Forgot password? </a>
                                            </div>
                                            
                                            <div class="col-xs-4 col-sm-4 col-md-4">
                                                <i class="fa fa-check"></i>
                                                <!-- <a href="<?php //echo Yii::app()->createUrl('preregistration'); ?>" class="signup-tab">Create AVMS Login</a> -->
                                            </div>
                                        </div>
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
                        $("#login_fail").append('A User Profile already exists for this email address. Please Login to AVMS or use another email address.');
                        $("#login_fail").show();
                    }
                }
            });
        });

        //when submit button is clicked check for already registered email
        $("#confirm-details-form").submit(function(e){
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
                                $("#login_fail").append('A User Profile already exists for this email address. Please Login to AVMS or use another email address.');
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
                                    $("#login_fail").append('A User Profile already exists for these credentials. Please Login to AVMS.');
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