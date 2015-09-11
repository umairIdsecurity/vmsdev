<?php
$session = new CHttpSession;
?>

<div class="page-content">
    <h3 class="text-primary title">ASIC Sponsor Information</h3>


    <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
    ?>

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
        <div class="col-lg-6">
            <div class="form-create-login">
                <!--  new asic -->
                <div id="new_asic_area">
                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'asic_no', array('maxlength' => 50, 'placeholder' => 'ASIC no.', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'asic_no'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
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

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php

                            $ws=Workstation::model()->findAll('is_deleted=0');

                            $list=CHtml::listData($ws,'id','name');

                            echo $form->dropDownList($model,'visitor_workstation',
                                $list,
                                array(
                                    'class'=>'form-control input-sm',
                                    'id'=>'WorkstationDropdown',
                                    'empty' => 'Chose your entry point')
                            );
                            ?>
                        </div>
                        <?php echo $form->error($model,'visitor_workstation'); ?>
                    </div>


                    <div class="row form-group" id="addCompanyDiv">
                         <div class="col-md-8">
                            <?php
                                /*$visitor = Registration::model()->findByPk($session['visitor_id']);

                                if(isset($visitor->tenant)){
                                    echo $form->dropDownList($model, 'company', CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-sm'));
                                }
                                else
                                {
                                    echo $form->dropDownList($model,'company',array(''=>'Select Company'),array('class'=>'form-control input-sm'));
                                }*/
                                if(isset($model->visitor_workstation) && ($model->visitor_workstation != "" && $model->visitor_workstation != null)){
                                    $worsktation = Workstation::model()->findByPk($model->visitor_workstation);
                                    $Criteria = new CDbCriteria();
                                    $Criteria->condition = "tenant = ".$worsktation->tenant." and is_deleted = 0";
                                    $companies = Company::model()->findAll($Criteria);
                                    echo $form->dropDownList($model, 'company', CHtml::listData($companies, 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-sm'));
                                }else{
                                     echo $form->dropDownList($model,'company',array(''=>'Select Company'),array('class'=>'form-control input-sm'));
                                }
                            ?>
                            <?php
                                /*$this->widget('application.extensions.select2.Select2', array(
                                        'model' => $model,
                                        'attribute' => 'company',
                                        'items' => CHtml::listData(Company::model()->findAll('is_deleted=0'),'id', 'name'),
                                        'selectedItems' => array(), // Items to be selected as default
                                        'placeHolder' => 'Please select a company',        
                                ));*/
                            ?>
                            <?php echo $form->error($model,'company'); ?>
                        </div>
                    </div>
                     

                    <div class="form-group">
                        <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Company</a>
                    </div>
                </div>
            </div>
        </div>
    </div>        

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/visitReason")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-9 col-md-1 col-sm-1 col-xs-1">
            <?php
            echo CHtml::tag('button', array(
                'type'=>'submit',
                'class' => 'btn btn-primary btn-next'
            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>

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
                                        'enableAjaxValidation'=>true,
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


                                    <?php //echo CHtml::Button('Add',array('id'=>'addCompanyBtn','class'=>'btn btn-block bt-login')); ?>
                                    
                                    <?php echo CHtml::submitButton('Add Company',array('id'=>'addCompanyBtn','class'=>'btn btn-block bt-login')); ?>


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
    <!-- ************************************************ -->
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#addCompanyBtn").unbind("click").click(function(event){
            var data=$("#company-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('company/addCompany');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
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

        $("#WorkstationDropdown").change(function() {
            var workstationId = $(this).val();
            alert(workstationId);
            if(workstationId != "" && workstationId != null){
                $.ajax({
                    type: 'POST',
                    url: "<?php echo Yii::app()->createUrl('preregistration/findAllCompanyFromWorkstation');?>",
                    dataType: 'json',
                    data: {"workstationId":workstationId},
                    success: function (res) {
                        if (res.data == "") {
                            $("#Registration_company").empty();
                            $("#Registration_company").append("<option value=''>Select Company</option>");
                        }
                        else
                        {
                            $("#Registration_company").empty();
                            $("#Registration_company").append("<option value=''>Select Company</option>");
                            $.each(res.data,function(index,element) {
                                $("#Registration_company").append("<option value='"+element.id+"'>"+element.name+"</option>");
                            }); 
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }else{
                $("#Registration_company").empty();
                $("#Registration_company").append("<option value=''>Select Company</option>");
            }
        });
    });

</script>