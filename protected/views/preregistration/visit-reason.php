<?php
    $session = new CHttpSession;
    //this is because to ensure the CAVMS-1144 and CAVMS-1092
    $tenant = '';
    if(isset(Yii::app()->user->tenant) && (Yii::app()->user->tenant != "")){
        $tenant = Yii::app()->user->tenant;
    }
    else
    {
        $tenant = (isset($session['tenant']) && ($session['tenant'] != "")) ? $session['tenant'] : '';
    }

?>

<style type="text/css">
    .select2{
        width:100% !important;
    }
</style>

<div class="page-content">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'preregistration-form',
        //'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row">
        <div class="col-sm-4">
            <h4 class="text-primary subheading-size">Reason for Visit</h4>
            <div class="form-group">
                <?php
                    $account=(isset(Yii::app()->user->account_type)) ? Yii::app()->user->account_type : "";
                    $vt ='';$vr='';
                    if($account == 'CORPORATE'){
                        if($tenant != ""){
                            $vt=VisitorType::model()->findAll('is_deleted=0 and module = "CVMS" and tenant = '.$tenant);
                            $vr=VisitReason::model()->findAll('is_deleted=0 and module = "cvms" and tenant = '.$tenant);
                        }else{
                            $vt=VisitorType::model()->findAll('is_deleted=0 and module = "CVMS"');
                            $vr=VisitReason::model()->findAll('is_deleted=0 and module = "cvms"');
                        }
                        
                    }elseif(($account == 'VIC') || ($account == 'ASIC')){
                        if($tenant != ""){
                            $vt=VisitorType::model()->findAll('is_deleted=0 and module = "AVMS" and tenant = '.$tenant);
                            $vr=VisitReason::model()->findAll('is_deleted=0 and module = "avms" and tenant = '.$tenant);
                        }else{
                            $vt=VisitorType::model()->findAll('is_deleted=0 and module = "AVMS"');
                            $vr=VisitReason::model()->findAll('is_deleted=0 and module = "avms"');
                        }                   
                    }else{
                        if($tenant != ""){
                            $vt=VisitorType::model()->findAll('is_deleted=0 and tenant = '.$tenant);
                            $vr=VisitReason::model()->findAll('is_deleted=0 and tenant = '.$tenant);
                        }else{
                            $vt=VisitorType::model()->findAll('is_deleted=0');
                            $vr=VisitReason::model()->findAll('is_deleted=0');
                        } 
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
                    $list=CHtml::listData($vr,'id','reason');
                    $other = array('Null'=>'other');
                    echo $form->dropDownList($model,'reason',
                        $list + $other,
                        array(
                            'class'=>'form-control input-sm' ,
                            'empty' => 'Select Reason for Visit')
                    );
                ?>
                <?php echo $form->error($model, 'reason'); ?>
            </div>

            <div class="form-group" id="other-reason">
                <?php echo $form->textField($model, 'other_reason', array('maxlength' => 50, 'placeholder' => 'Other Reason' ,'class'=>'form-control input-sm')); ?>

                <div style="display:none" id="otherReasonError" class="errorMessage">Please complete Other Reason</div>

                <?php //echo $form->error($model, 'other_reason'); ?>
            </div>
        </div>    

        <div class="col-sm-1"></div>

        <div class="col-sm-4">
            <h4 class="text-primary subheading-size">Company Information</h4>
            <div class="form-group" id="addCompanyDiv">
                <?php
                $visitor = Registration::model()->findByPk(Yii::app()->user->id);
                if(isset($visitor->tenant) && ($visitor->tenant != "")){
                    $this->widget('application.extensions.select2.Select2', array(
                        'model' => $companyModel,
                        'attribute' => 'name',
                        'items' => CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'),
                        'placeHolder' => 'Select Company',
                    ));
                }else{
                    if($tenant != "")
                    {
                        $this->widget('application.extensions.select2.Select2', array(
                            'model' => $companyModel,
                            'attribute' => 'name',
                            'items' => CHtml::listData(Company::model()->findAll('is_deleted=0 and tenant = '.$tenant), 'id', 'name'),
                            'placeHolder' => 'Select Company',
                        ));
                    }else{
                        $this->widget('application.extensions.select2.Select2', array(
                            'model' => $companyModel,
                            'attribute' => 'name',
                            'items' => CHtml::listData(Company::model()->findAll('is_deleted=0'), 'id', 'name'),
                            'placeHolder' => 'Select Company',
                        ));
                    } 
                }
                ?>
                <?php echo $form->error($companyModel,'name'); ?>
            </div>
            <div class="form-group">
                <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Company</a>
            </div>


            <div class="form-group" id="addCompanyContactDiv" style="display:none">
                <select id="companyContact" class="form-control input-sm">
                    <option value="">Select Company Contact</option>
                </select>

                <div style="display:none" id="companyContactError" class="errorMessage">Please complete Company Contact</div>

                <?php
                    //echo $form->dropDownList($model,'host', array(''=>'Select Company'), array('prompt' => 'Select Company Contact' , 'class'=>'form-control input-sm'));
                ?>
                <?php //echo $form->error($model,'host'); ?>
                <!-- </div> -->
                <div class="form-group"> </div>
                <a style="float: left;" href="#addCompanyContactModal" role="button" data-toggle="modal" class="btn btn-primary" id="addCompanyContactModalBtn">Add Contact</a>
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
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    


    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/personalDetails")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <?php
                        echo CHtml::tag('button', array(
                            'type'=>'submit',
                            "id" => 'nextBtn',
                            'class' => 'btn btn-primary btn-next'
                        ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                    ?>
                </div>
            </div>
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
                                        <div class="errorMessage" id="companyNameErr" style="display:none;float:left"></div>
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
                                            <div class="errorMessage" id="companyFirstnameErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_last_name', array('class'=>'form-control input-lg','placeholder'=>'Last Name')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyLastnameErr" style="display:none;float:left"></div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_email', array('class'=>'form-control input-lg','placeholder'=>'Email Address')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyEmailErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_contact_number', array('class'=>'form-control input-lg','placeholder'=>'Contact Number')); ?>
                                            </div>
                                            <div class="errorMessage" id="companyContactNumberErr" style="display:none;float:left"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button class="btn neutral" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <?php echo CHtml::Button('Add',array('id'=>'addCompanyBtn','class'=>'btn neutral')); ?>
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

                                            <input id="companyPlaceholder" type="text" class='form-control input-lg' placeholder='Company' disabled='disabled'/>
                                        <?php
                                            echo $form->hiddenField($companyModel,'name',array('class'=>'companyHiddenField'));
                                            /*$visitor = Registration::model()->findByPk($session['visitor_id']);

                                            if(isset($visitor->tenant)){
                                                echo $form->dropDownList($companyModel, 'name', CHtml::listData(Registration::model()->findAllCompanyByTenant($visitor->tenant), 'id', 'name'), array('prompt' => 'Select Company', 'class'=>'form-control input-lg'));
                                            }
                                            else
                                            {
                                                echo $form->dropDownList($companyModel,'name',array(''=>'Select Company'),array('class'=>'form-control input-lg'));
                                            }*/
                                        ?>
                                    </div>
                                    <?php echo $form->error($companyModel,'name',array('style' =>'float:left')); ?>
                                </div>

                                    <div class="form-group">
                                        
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group" style="float:left">
                                            <a class="btn btn-default" href="javascript:;" role="button" id="addContact">+</a> Add Company Contact
                                            <input type="hidden" id="is_user_field_contact" name="is_user_field_contact" value="0">
                                        </div>
                                    </div>

                                    <div style="display:none" id="contactDiv">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_first_name', array('class'=>'form-control input-lg','placeholder'=>'First Name')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_first_name',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactFirstnameErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_last_name', array('class'=>'form-control input-lg','placeholder'=>'Last Name')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_last_name',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactLastnameErr" style="display:none;float:left"></div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_email', array('class'=>'form-control input-lg','placeholder'=>'Email Address')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_email',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactEmailErr" style="display:none;float:left"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                                <?php echo $form->textField($companyModel, 'user_contact_number', array('class'=>'form-control input-lg','placeholder'=>'Contact Number')); ?>
                                            </div>
                                            <?php //echo $form->error($companyModel,'user_contact_number',array('style' =>'float:left')); ?>
                                            <div class="errorMessage" id="companyContactContactNumberErr" style="display:none;float:left"></div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn neutral" data-dismiss="modal" aria-hidden="true">Close</button>
                                        <?php echo CHtml::Button('Add',array('id'=>'addCompanyContactBtn','class'=>'btn neutral')); ?>
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
    <!-- - Add Company Contact Modal Ends Here -->
<!-- ************************************** -->
<!-- ************************************************ -->

<script>
    $(document).ready(function() {
        
        $('#other-reason').hide();
        $('#Visit_reason').change(function(e){
            if ($('#Visit_reason').val() == 'Null'){
                $('#other-reason').show();
            }else{
                $('#other-reason').hide();
            }
        });

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

        $("#addContact").click(function(event){
            event.preventDefault();
            var is_user_field_contact = parseInt($("#is_user_field_contact").val());
            if(is_user_field_contact == 1)
            {
                $("#contactDiv").hide();
                $('#is_user_field_contact').val("0");
            }
            else{
                $("#contactDiv").show();
                $('#is_user_field_contact').val("1");
            }
        });
        
        $("#addCompanyBtn").click(function(event)
        {
            
            $("#compDiv").show();

            var data=$("#company-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('company/addCompany');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.decision == 0)
                    {
                        if(data.errors){//console.log(data.errors);
                            if(data.errors.name)
                            {
                                if($('#Company_name').val() == ""){
                                    if($('#companyNameErr').is(':empty')){
                                        $("#companyNameErr").append("<p>"+data.errors.name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyNameErr").empty().hide();
                            }

                            if(data.errors.user_first_name)
                            {
                                if($('#Company_user_first_name').val() == ""){
                                    if($('#companyFirstnameErr').is(':empty')){
                                        $("#companyFirstnameErr").append("<p>"+data.errors.user_first_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyFirstnameErr").empty().hide();
                            }

                            if(data.errors.user_last_name)
                            {
                                if($('#Company_user_last_name').val() == ""){
                                    if($('#companyLastnameErr').is(':empty')){
                                        $("#companyLastnameErr").append("<p>"+data.errors.user_last_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyLastnameErr").empty().hide();
                            }

                            if(data.errors.user_email)
                            {
                                if($('#Company_user_email').val() == ""){
                                    $("#companyEmailErr").empty();
                                    
                                        $("#companyEmailErr").append("<p>"+data.errors.user_email+"</p>").show();
                                    
                                }
                            }else{
                                $("#companyEmailErr").empty().hide();
                            }

                            if(data.errors.email_address)
                            {
                                $("#companyEmailErr").empty();
                                $("#companyEmailErr").append("<p>Email id already exists.</p>").show();
                                
                            }

                            if(data.errors.user_contact_number)
                            {
                                if($('#Company_user_contact_number').val() == ""){
                                    if($('#companyContactNumberErr').is(':empty')){
                                        $("#companyContactNumberErr").append("<p>"+data.errors.user_contact_number+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactNumberErr").empty().hide();
                            }
                        }
                    }
                    else
                    {
                        $("#Company_name").append(data.dropDown);
                        $('.select2-selection__rendered').text(data.compName);
                        $("#companyContact").empty();
                        $.each(data.contacts,function(index,element) {
                            $("#companyContact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
                        }); 
                        $("#addCompanyContactDiv").show();
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
                            $.each(res.data,function(index,element) {
                                $("#companyContact").append("<option value='"+element.id+"'>"+element.first_name+" "+element.last_name+"</option>");
                            }); 
                        }
                        $("#addCompanyContactDiv").show();

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }else{
                $("#companyContact").empty();
                $("#companyContact").append("<option value=''>Select Company Contact</option>");
                $("#addCompanyContactDiv").hide();
            }
        });

        $("#addCompanyContactBtn").click(function(event){
            
            $("#contactDiv").show();

            var data=$("#companyContact-form").serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('company/addCompanyContactPreg');?>",
                data: data,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.decision == 0)
                    {
                        if(data.errors){//console.log(data.errors);
                            if(data.errors.user_first_name)
                            {
                                if($('#Company_user_first_name').val() == ""){
                                    if($('#companyContactFirstnameErr').is(':empty')){
                                        $("#companyContactFirstnameErr").append("<p>"+data.errors.user_first_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactFirstnameErr").empty().hide();
                            }

                            if(data.errors.user_last_name)
                            {
                                if($('#Company_user_last_name').val() == ""){
                                    if($('#companyContactLastnameErr').is(':empty')){
                                        $("#companyContactLastnameErr").append("<p>"+data.errors.user_last_name+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactLastnameErr").empty().hide();
                            }

                            if(data.errors.user_email)
                            {
                                if($('#Company_user_email').val() == ""){
                                    if($('#companyContactEmailErr').is(':empty')){
                                        $("#companyContactEmailErr").append("<p>"+data.errors.user_email+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactEmailErr").empty().hide();
                            }

                            if(data.errors.user_contact_number)
                            {
                                if($('#Company_user_contact_number').val() == ""){
                                    if($('#companyContactContactNumberErr').is(':empty')){
                                        $("#companyContactContactNumberErr").append("<p>"+data.errors.user_contact_number+"</p>").show();
                                    }
                                }
                            }else{
                                $("#companyContactContactNumberErr").empty().hide();
                            }
                        }
                    }
                    else
                    {
                        var contactCompany = data.contactCompany;
                        $("#companyContact").append(data.dropDown);
                        $("#addCompanyContactModal").modal('hide');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
        
        

        $("#addCompanyContactModalBtn").click(function(e){
            var companyId = $("#Company_name :selected").val();
            var companyName = $("#Company_name :selected").text();
            
            $("#companyPlaceholder").val(companyName);
            $(".companyHiddenField").val(companyId);

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

        $("#nextBtn").click(function(e){
            var reason = $("#Visit_reason").val();
            var otherReason = $("#Visit_other_reason").val();
            
            if(reason == "other" && otherReason == ""){
                $("#otherReasonError").show();
                e.preventDefault();
            }else{
                $("#otherReasonError").hide();
            } 
        });

    });
</script>