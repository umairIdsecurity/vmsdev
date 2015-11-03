
<div class="page-content">

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
    ?>

    <?php
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'add-companyAdmin-form',
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
                <div id="">

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
                            <?php echo $form->error($model,'company'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Company</a>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'placeholder' => 'First Name', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'first_name'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'placeholder' => 'Surname', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'last_name'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'contact_number', array('maxlength' => 50, 'placeholder' => 'Contact No.', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'contact_number'); ?>
                        </div>    
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'email', array('maxlength' => 50, 'placeholder' => 'Email Address', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>    
                    </div>

                </div>
            </div>
        </div>
    </div>        


    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/compAdminPrivacyPolicy")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <?php
                        echo CHtml::tag('button', array(
                            'type'=>'submit',
                            'class' => 'btn btn-primary btn-next'
                        ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                    ?>
                </div>
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
                                            <?php

                                            $ws=Workstation::model()->findAll('is_deleted=0');

                                            $list=CHtml::listData($ws,'id','name');

                                            /*echo $form->dropDownList($companyModel,'visitor_workstation',
                                                $list,
                                                array(
                                                    'class'=>'form-control input-lg',
                                                    'id'=>'WorkstationDropdownPopup',
                                                    'empty' => 'Chose your entry point')
                                            );*/
                                            ?>

                                            <select id="companyWorkstation" name="Company[workstation]" class="form-control input-lg">
                                                <option value="">Chose your entry point</option>
                                                <?php foreach ($list as $key => $value) {?>
                                                    <option value="<?= $key ?>"><?= $value ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        <?php //echo $form->error($model,'visitor_workstation'); ?>
                                        <div id="entryPointErr" class="errorMessage" style="display:none;float: left;">Please chose your entry point</div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                            <?php echo $form->textField($companyModel, 'name', array('placeholder' => 'Company Name','class'=>'form-control input-lg')); ?>
                                        </div>
                                        <?php echo $form->error($companyModel,'name',array('style' =>'float:left')); ?>
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
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button class="btn neutral" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <?php echo CHtml::submitButton('Add',array('id'=>'addCompanyBtn','class'=>'btn neutral')); ?>
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
<!-- - Add Company Model Ends Here -->
<!-- ************************************** -->
<!-- ************************************************ -->

</div>

<script type="text/javascript">
    $(document).ready(function() {

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

        $("#addCompanyBtn").unbind("click").click(function(event){
            $("#compDiv").show();
            var workstation = $("#companyWorkstation").val();
            if(workstation != ""){
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
                            console.log(data.errors);
                        }
                        else
                        {
                            //$("#WorkstationDropdown").($("#companyWorkstation").val());
                            $("#Registration_company").append(data.dropDown);
                            //$('.select2-selection__rendered').text(data.compName);
                            $("#addCompanyModal").modal('hide');
                        }  
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
                $("#entryPointErr").hide();
            }
            else{
                $("#entryPointErr").show();
            }
        });



        $("#WorkstationDropdown").change(function() {
            var workstationId = $(this).val();
            if(workstationId != "" && workstationId != null){
                $.ajax({
                    type: 'POST',
                    url: "<?php echo Yii::app()->createUrl('preregistration/findAllCompanyFromWorkstation');?>",
                    dataType: 'json',
                    data: {"workstationId":workstationId},
                    success: function (res) {
                        if (res.data == "") {
                            $("#Registration_company").empty();
                            $("#Registration_company").append("<option value=''>No results found. Please add company</option>");
                            $('.select2-selection__rendered').text("No results found. Please add company");
                        }
                        else
                        {
                            $("#Registration_company").empty();
                            $('.select2-selection__rendered').text(res.data[0].name);
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
                $("#Registration_company").append("<option value=''>No results found. Please add company</option>");
            }
        });
    });

</script>