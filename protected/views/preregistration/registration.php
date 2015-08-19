<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/14/15
 * Time: 9:34 PM
 */

?>

<div class="page-content">

    <h1 class="text-primary title">CREATE LOGIN</h1>
    <div class="bg-gray-lighter form-info">Please select your account type.</div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'preregistration-form',
        'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    <div class="form-create-login">
        <div class="form-group">
            <div class="radio">
                <label>
                    <?php echo $form->radioButton($model,'account_type',array('value'=>'VIC','uncheckValue'=>null, 'checked'=>true)); ?>
                    <span class="radio-style"></span>
                    VIC applicant
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php echo $form->radioButton($model,'account_type',array('value'=>'CORPORATE','uncheckValue'=>null)); ?>
                    <span class="radio-style"></span>
                    Company preregistering multiple VIC applicants
                </label>
            </div>
            <div class="radio">
                <label>
                    <?php echo $form->radioButton($model,'account_type',array('value'=>'ASIC','uncheckValue'=>null)); ?>
                    <span class="radio-style"></span>
                    ASIC sponsor
                </label>
            </div>
        </div>


        <div class="form-group">
            <span class="glyphicon glyphicon-user"></span>

            <?php   echo $form->textField($model,'username',
                                            array(
                                                'placeholder' => 'Username or Email',
                                                'class'=>'form-control input-lg',
                                                'data-validate-input'
                                            )
                    ); 
            ?>
            <?php echo $form->error($model,'username'); ?>
        </div>

        <div class="form-group">
            <span class="glyphicon glyphicon-user"></span>

            <?php echo $form->textField($model,'username_repeat',
                array(
                    'placeholder' => 'Repeat Username or Email',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>
            <?php echo $form->error($model,'username_repeat'); ?>
        </div>

        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>

            <?php echo $form->passwordField($model,'password',
                array(
                    'placeholder' => 'Password',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>

            <?php echo $form->passwordField($model,'password_repeat',
                array(
                    'placeholder' => 'Repeat Password',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>
            <?php echo $form->error($model,'password_repeat'); ?>
        </div>
    </div>
    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/declaration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-7 col-md-1 col-sm-1 col-xs-1">
            <?php
            echo CHtml::tag('button', array(
                'type'=>'submit',
                'class' => 'btn btn-primary btn-next'
            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>

        </div>
    </div>

    <?php $this->endWidget(); ?>

<!-- <a class="btn btn-launch" href="javascript:;" data-toggle="modal" data-target="#loginModal"> Launch Login Modal Popup</a>
 -->

<!-- ************************************** -->

<!-- -Login Modal -->
<?php //if(isset($model)): ?>

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

                                    <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-block bt-login')); ?>
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
<?php //endif; ?>

<!-- ************************************** -->

<script type="text/javascript">
    $(document).ready(function(){
        $("#CreateLogin_username").blur(function(){
            var email = $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?php echo Yii::app()->createUrl('preregistration/checkEmailIfUnique?email=" + email + "');?>",
                dataType: 'json',
                data: email,
                success: function (r) {
                    $.each(r.data, function (index, value) {
                        if (value.isTaken == 1) { //if taken
                            $("#loginModal").modal({
                                show : true,
                                keyboard: false,
                                backdrop: 'static'
                            });
                            $("#login_fail").show();
                        }
                    });
                }
            });

        });
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
    background: #27ae60;
    color: #fff;
}

.login-modal-header .modal-title {
    color: #fff;
}

.login-modal-header .close {
    color: #fff;
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
</style>
</div>