
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


                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'first_name', array('maxlength' => 50, 'placeholder' => 'First Name', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'first_name'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'last_name', array('maxlength' => 50, 'placeholder' => 'Last Name', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'last_name'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'email', array('maxlength' => 50, 'placeholder' => 'Email Address', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>    
                    </div>

                    <div class="row form-group">
                        <div class="col-md-8">
                            <?php echo $form->textField($model, 'contact_number', array('maxlength' => 50, 'placeholder' => 'Contact Number', 'class'=>'form-control input-sm')); ?>
                            <?php echo $form->error($model, 'contact_number'); ?>
                        </div>    
                    </div>

                </div>
            </div>
        </div>
    </div>        

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/registration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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


</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">
    $(document).ready(function() {
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