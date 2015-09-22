<?php
$session = new CHttpSession;
?>
<style type="text/css">
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

    <div id="menu">
        <div class="row items" style="background-color:#fff;">
            <div class="col-sm-4 col-xs-6 text-center"><a style="background-color: #eeeeee; height:40px;border-right: 1px solid #fff;" href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-sm-4 col-xs-6 text-center"><a style="background-color: #eeeeee; height:40px;" href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>" class="tableFont">ASIC Sponsor Verifications</a></div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-7">
             <h1 class="text-primary title"><a href="<?php echo Yii::app()->createUrl('preregistration/assignAsicholder'); ?>">ASSIGN TO ANOTHER ASIC SPONSOR</a></h1>
        </div>
    </div>
    <br>
    <!--  searching ASIC -->
    <div class="row">
        <div class="col-sm-3 col-xs-12" style="padding-top: 10px;">
            <?php  echo CHtml::textField('search_asic_box' , '',
                array(
                    'class'=>'form-control input-sm',
                    'placeholder'=>'First Name, Last Name or Email'
                )
            );
            ?>
            <div id="search_asic_error" class="errorMessage">Please type something on search box</div>
            <?php
            echo CHtml::hiddenField('base_url',Yii::app()->getBaseUrl(true));
            ?>
        </div>
        <div class="col-sm-3 col-xs-12" style="padding-top: 10px;">
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

        <div class="col-sm-3">

            <div class="form-group">
                <?php echo $form->hiddenField($model, 'selected_asic_id' ,
                    array('value'=>'')
                ); ?>
            </div>

            <!--  new asic -->
            <div id="new_asic_area">
                <div class="form-group">
                    <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'placeholder' => 'Last Name' , 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'asic_no', array('maxlength' => 50, 'placeholder' => 'ASIC no.', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'asic_no'); ?>
                </div>

                <div class="row form-group">
                    <div class="col-sm-12">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'asic_expiry',
                            'options'     => array(
                                'minDate' => '0',
                                'dateFormat' => 'dd-mm-yy',
                            ),
                            'htmlOptions' => array(
                                'maxlength'   => '10',
                                'placeholder' => 'Expiry',
                                'class' => 'form-control input-sm'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'asic_expiry'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_number', array('maxlength' => 50, 'placeholder' => 'Mobile Number', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'contact_number'); ?>

                </div>

                <div class="form-group">
                    <?php echo $form->textField($model, 'email', array('maxlength' => 50, 'placeholder' => 'Email', 'class'=>'form-control input-sm')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>


                <div class="form-group" id="addCompanyDiv">
                    <?php
                        echo $form->dropDownList($model, 'company', CHtml::listData(Registration::model()->findAllCompanyByTenant($session['tenant']), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-sm'));
                       /* $this->widget('application.extensions.select2.Select2', array(
                                'model' => $model,
                                'attribute' => 'company',
                                'items' =>  CHtml::listData(Registration::model()->findAllCompanyByTenant($session['tenant']), 'id', 'name'),
                                'selectedItems' => array(), // Items to be selected as default
                                'placeHolder' => 'Please select a company',        
                        ));*/
                    ?>
                </div>
                 <?php echo $form->error($model,'company'); ?>



                <div class="form-group">
                    <a class="btn btn-primary" style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal">Add Company</a>
                </div>

            </div>
            <!--  new asic -->
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-sm-3 col-xs-5">
            <?php
            echo CHtml::tag('button', array(
                'type'=>'submit',
                'class' => 'btn btn-primary btn-next'
            ), 'Send <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>

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
                                            <?php echo $form->textField($companyModel, 'name', array('placeholder' => 'Company Name','class'=>'form-control input-lg')); ?>
                                        </div>
                                        <?php echo $form->error($companyModel,'name',array('style' =>'float:left')); ?>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            Company Contact
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                            <?php echo $form->textField($companyModel, 'user_first_name', array('class'=>'form-control input-lg','placeholder'=>'First Name')); ?>
                                        </div>
                                        <?php echo $form->error($companyModel,'user_first_name',array('style' =>'float:left')); ?>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                            <?php echo $form->textField($companyModel, 'user_last_name', array('class'=>'form-control input-lg','placeholder'=>'Last Name')); ?>
                                        </div>
                                        <?php echo $form->error($companyModel,'user_last_name',array('style' =>'float:left')); ?>
                                    </div>

                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                            <?php echo $form->textField($companyModel, 'user_email', array('class'=>'form-control input-lg','placeholder'=>'Email Address')); ?>
                                        </div>
                                        <?php echo $form->error($companyModel,'user_email',array('style' =>'float:left')); ?>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                            <?php echo $form->textField($companyModel, 'user_contact_number', array('class'=>'form-control input-lg','placeholder'=>'Contact Number')); ?>
                                        </div>
                                        <?php echo $form->error($companyModel,'user_contact_number',array('style' =>'float:left')); ?>
                                    </div>


                                    <?php echo CHtml::Button('Add',array('id'=>'addCompanyBtn','class'=>'btn btn-block bt-login')); ?>
                                    
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


<script type="text/javascript">


    $(document).ready(function() {

        $('#search_asic_box').on('input', function() {
            $("#search_asic_error").hide();
            $("#asic_table_wrapper").hide();
            $("#asic-notification").hide();
            $('#Registration_selected_asic_id').val("");
            $('#new_asic_area').show();
        });

        $('#search_asic_btn').click(function(event) {
            event.preventDefault();

            var search = $("#search_asic_box").val();
            var base_url = $("#base_url").val();

            if (search.length > 0) {
                $("#loader").show();
                var search_value = 'search_value=' + search;

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


    
        $("#addCompanyBtn").click(function(event){
            var data=$("#company-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('company/addCompany');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.decision == 0)
                    {
                        console.log("errors got");
                    }
                    else
                    {
                        $("#Registration_company").append(data.dropDown);
                        $("#addCompanyModal").modal('hide');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });


    });
</script>