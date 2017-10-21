<?php
$session = new CHttpSession;
?>

<div class="page-content">

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <h5 class="text-size text-sizeWhere">Please select your User Preference</h5>
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'preregistration-form',
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-create-login">
                <div class="">
                    <div class="radio">
                        <label class="text-size">
                            <?php echo $form->radioButton($model,'account_type',array('value'=>'VIC','uncheckValue'=>null, 'checked'=>true)); ?>
                            <span class="radio-style"></span>
                            VIC Applicant
                        </label>
                    </div>
                    <!-- changed on 24/10/2016 -->
                    <!--<div class="radio">
                        <label class="text-size">
                            <?php //echo $form->radioButton($model,'account_type',array('value'=>'ASIC','uncheckValue'=>null)); ?>
                            <span class="radio-style"></span>
                            ASIC Sponsor
                        </label>
                    </div>

                   <!-- <div class="radio">
                        <label class="text-size">
                            <?php //echo $form->radioButton($model,'account_type',array('value'=>'CORPORATE','uncheckValue'=>null)); ?>
                            <span class="radio-style"></span>
                            Company Administrator (multiple VIC's or ASIC's)
                        </label>
                    </div>-->
                </div>

                <div class="row">
                    <div class="col-sm-7" style="position: relative;margin-bottom:8px">
                        <span class="glyphicon glyphicon-user" style="position: absolute; padding: 7px"></span>
                        <?php   echo $form->textField($model,'username',array('style'=>'padding-left: 27px','placeholder' => 'Username or Email','class'=>'form-control input-sm','data-validate-input')); ?>
                        <?php echo $form->error($model,'username'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-7" style="position: relative;margin-bottom:8px">
                        <span class="glyphicon glyphicon-user" style="position: absolute; padding: 7px"></span>
                        <?php   echo $form->textField($model,'username_repeat',array('style'=>'padding-left: 27px','placeholder' => 'Repeat Username or Email Address','class'=>'form-control input-sm','data-validate-input')); ?>
                        <?php echo $form->error($model,'username_repeat'); ?>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-sm-7" style="position: relative;margin-bottom:8px">
                        <span class="glyphicon glyphicon-asterisk" style="position: absolute; padding: 7px"></span>
                        <?php   echo $form->passwordField($model,'password',array('style'=>'padding-left: 27px','placeholder' => 'Password','class'=>'form-control input-sm','data-validate-input')); ?>
                        <?php echo $form->error($model,'password'); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-7" style="position: relative;margin-bottom:8px">
                        <span class="glyphicon glyphicon-asterisk" style="position: absolute; padding: 7px"></span>
                        <?php   echo $form->passwordField($model,'password_repeat',array('style'=>'padding-left: 27px','placeholder' => 'Repeat Password','class'=>'form-control input-sm','data-validate-input')); ?>
                        <?php echo $form->error($model,'password_repeat'); ?>
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
    
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/index")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <?php
                        echo CHtml::tag('button', array(
                            'type'=>'submit',
                            'id' => 'btnSubmit',
                            'class' => 'btn btn-primary btn-next'
                        ),  'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                    ?>
                </div>
            </div>
        </div>
    </div>             



    <?php $this->endWidget(); ?>

</div>

<!-- <a class="btn btn-launch" href="javascript:;" data-toggle="modal" data-target="#loginModal"> Launch Login Modal Popup</a>
 -->

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
                                <span id="login_fail" class="response_error" style="color:red;display: none;">Username already exists. Please login</span>
                                
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

<script type="text/javascript">
    $(document).ready(function(){

        
        <?php 
            //if he has not created a login, but email is present serve this page as reset password 
            //and donot ask for login as he has no password
            if(isset($session['visitor_id']) && $session['visitor_id'] != ""){
                $model = Registration::model()->findByPk($session['visitor_id']);
                if(!isset($model->password) || ($model->password =="") || ($model->password == null))
        {?>
                    $("#CreateLogin_username").val("<?php echo $model->email; ?>");
                    return;

        <?php
               }
            }
        ?>

        $("#CreateLogin_username").blur(function(e){
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
                        $("#login_fail").show();
                    }
                }
            });
        });
        //when submit button is clicked check for already registered email
        $("#preregistration-form").submit(function(e){
            var email = $("#CreateLogin_username").val();var repeatEmail = $("#CreateLogin_username_repeat").val();var password = $("#CreateLogin_password").val();var repeatPassword = $("#CreateLogin_password_repeat").val();
            if(email != "" && repeatEmail != "" && email == repeatEmail && password !="" && repeatPassword !="" && password == repeatPassword)
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
                            $("#login_fail").show();
                        }else{
                            $("#preregistration-form").submit();
                            $("#preregistration-form").unbind("submit");
                        }
                    }
                });
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
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

</style>
