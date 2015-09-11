<?php
$session = new CHttpSession;
?>
<div class="page-content">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'preregistration-form',
        //'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="row">

        <div class="col-xs-3">
            <div class="form-group text-primary">Reason for Visit</div>
            <div class="form-group">
                <?php
                $account=(isset(Yii::app()->user->account_type)) ? Yii::app()->user->account_type : "";
                $vt = '';
                if($account == 'CORPORATE'){
                    $vt = Yii::app()->db->createCommand()
                            ->select("t.id,t.name") 
                            ->from("visitor_type t")
                            ->where('t.module = "CVMS" and t.is_deleted =0')
                            ->queryAll();
                    //$vt = VisitorType::model()->findAll('module = :m', [':m' => "CVMS"]);
                }elseif(($account == 'VIC') || ($account == 'ASIC')){
                    $vt = Yii::app()->db->createCommand()
                            ->select("t.id,t.name") 
                            ->from("visitor_type t")
                            ->where('t.module = "AVMS" and t.is_deleted =0')
                            ->queryAll();
                    //$vt = VisitorType::model()->findAll('module = :m', [':m' => "AVMS"]);
                }else{
                    $vt = Yii::app()->db->createCommand()
                            ->select("t.id,t.name") 
                            ->from("visitor_type t")
                            ->where("t.is_deleted =0")
                            ->queryAll();
                    //$vt = VisitorType::model()->findAll('module = :m', [':m' => "AVMS"]);
                }

                $list=CHtml::listData($vt,'id','name');

                echo $form->dropDownList($model,'visitor_type',
                    $list,
                    array(
                        'class'=>'form-control input-sm' ,
                        'empty' => 'Select Visitor Type')
                );

                ?>
                <?php echo $form->error($model, 'visitor_type'); ?>
            </div>
            <div class="form-group">
                <?php

                $vr = Yii::app()->db->createCommand()
                            ->select("t.id,t.reason") 
                            ->from("visit_reason t")
                            ->where('t.is_deleted =0')
                            ->queryAll();
                //$vr=VisitReason::model()->findAll();

                $list=CHtml::listData($vr,'id','reason');

                $other = array('other'=>'other');

                echo $form->dropDownList($model,'reason',
                    $list + $other,
                    array(
                        'class'=>'form-control input-sm' ,
                        'empty' => 'Select Visit Reason')
                );

                ?>
                <?php echo $form->error($model, 'reason'); ?>

            </div>

            <div class="form-group" id="other-reason">
                <?php echo $form->textField($model, 'other_reason', array('maxlength' => 50, 'placeholder' => 'Other Reason' ,'class'=>'form-control input-sm')); ?>

                <?php echo $form->error($model, 'other_reason'); ?>
            </div>
        </div>    

        <div class="col-xs-1"></div>

        <div class="col-xs-3">
            <div class="form-group text-primary">Company Information</div>


            <div class="form-group" id="addCompanyDiv">

                <?php
                    $visitor = Registration::model()->findByPk($session['visitor_id']);

                    if(isset($visitor->tenant)){
                        echo $form->dropDownList($companyModel, 'name', CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-sm'));
                    }
                    else
                    {
                        echo $form->dropDownList($companyModel,'name',array(''=>'Select Company'),array('class'=>'form-control input-sm'));
                    }
                    
                ?>
                <?php echo $form->error($companyModel,'name'); ?>
            </div>
            <div class="form-group">
                <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Company</a>
            </div>


            <div class="form-group" id="addCompanyContactDiv">
                <select id="companyContact" class="form-control input-sm">
                    <option value="">Select Company Contact</option>
                </select>

                <div style="display:none" id="companyContactError" class="errorMessage">Please select Company Contact</div>

                <?php
                    //echo $form->dropDownList($model,'host', array(''=>'Select Company'), array('prompt' => 'Select Company Contact' , 'class'=>'form-control input-sm'));
                ?>
                <?php //echo $form->error($model,'host'); ?>
            </div>
            <div class="form-group">
                <a style="float: left;" href="#addCompanyContactModal" role="button" data-toggle="modal" class="btn btn-primary">Add Contact</a>
            </div>

        </div>
    </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/personalDetails")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-7 col-md-1 col-sm-1 col-xs-1">
            <?php
            echo CHtml::tag('button', array(
                'type'=>'submit',
                "id" => 'nextBtn',
                'class' => 'btn btn-primary btn-next'
            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>

        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

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
                                        <?php
                                            $visitor = Registration::model()->findByPk($session['visitor_id']);

                                            if(isset($visitor->tenant)){
                                                echo $form->dropDownList($companyModel, 'name', CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-lg'));
                                            }
                                            else
                                            {
                                                echo $form->dropDownList($companyModel,'name',array(''=>'Select Company'),array('class'=>'form-control input-sm'));
                                            }
                                        ?>
                                    </div>
                                    <?php echo $form->error($companyModel,'name',array('style' =>'float:left')); ?>
                                </div>

                                    <div class="form-group">
                                        
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


                                    <?php echo CHtml::Button('Add',array('id'=>'addCompanyContactBtn','class'=>'btn btn-block bt-login')); ?>
                                    
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
    $(document).ready(function() {
        
        $('#other-reason').hide();
        $('#Visit_reason').change(function(e){
            if ($('#Visit_reason').val() == 'other'){
                $('#other-reason').show();
            }else{
                $('#other-reason').hide();
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
                        $("#Company_name").append(data.dropDown);
                        $("#companyContact").empty();
                        $("#companyContact").append("<option value=''>Select Company Contact</option>");
                        $.each(data.contacts,function(index,element) {
                            $("#companyContact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
                        }); 
                        $("#addCompanyModal").modal('hide');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
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
                            $("#companyContact").append("<option value=''>Select Company Contact</option>");
                            $.each(res.data,function(index,element) {
                                $("#companyContact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
                            }); 
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }else{
                $("#companyContact").empty();
                $("#companyContact").append("<option value=''>Select Company Contact</option>");
            }
        });

        $("#addCompanyContactBtn").click(function(event){
            var data=$("#companyContact-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('company/addCompanyContactPreg');?>",
                data: data,
                success: function (data) {
                    
                    console.log(data);
                    var data = JSON.parse(data);

                    if (data.decision == 0)
                    {
                        console.log("errors got");
                    }
                    else
                    {
                        var contactCompany = data.contactCompany;
                        $("#Company_name").append("<option selected='selected' value='"+contactCompany.id+"'>"+contactCompany.name+"</option>");
                        $("#companyContact").append(data.dropDown);
                        $("#addCompanyContactModal").modal('hide');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });


        /*$("#nextBtn").click(function(e){
            var companyContactVal = $("#companyContact").val();
            alert(companyContactVal);
            if(companyContactVal == ""){
                $("#companyContactError").show();
                return false;
            }else{
                $("#companyContactError").hide();
            } 
        });*/
    });
</script>