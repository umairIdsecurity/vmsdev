
<div class="page-content">
    <h3 class="text-primary title">Company Information</h3>

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

                    <div class="row form-group" id="addCompanyDiv">
                         <div class="col-md-8">
                            <?php
                                /*$this->widget('application.extensions.select2.Select2', array(
                                        'model' => $model,
                                        'attribute' => 'company',
                                        'items' => CHtml::listData(Company::model()->find('is_deleted=0','id', 'name')),
                                        'selectedItems' => array(), // Items to be selected as default
                                        'placeHolder' => 'Please select a company',        
                                ));*/
                            ?>
                            <?php //echo $form->error($model,'company'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Company</a>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($companyModel, 'user_first_name', array('maxlength' => 50, 'placeholder' => 'First Name', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($companyModel, 'user_first_name'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($companyModel, 'user_last_name', array('maxlength' => 50, 'placeholder' => 'Last Name', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($companyModel, 'user_last_name'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($companyModel, 'user_email', array('maxlength' => 50, 'placeholder' => 'Email Address', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($companyModel, 'user_email'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($companyModel, 'user_contact_number', array('maxlength' => 50, 'placeholder' => 'Contact Number', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($companyModel, 'user_contact_number'); ?>
                        </div>    
                    </div>

                </div>
            </div>
        </div>
    </div>        

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/registration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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
    <!-- - Login Model Ends Here -->


<!-- ************************************** -->
    <!-- ************************************************ -->

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

                    if (data == 0)
                    {
                        console.log("No data: " + data);
                    }
                    else
                    {
                        $("#Registration_company").append(data.dropDown);
                        $('.select2-selection__rendered').text(data.compName);
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