<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/8/15
 * Time: 6:00 PM
 */

?>
<div class="page-content">

    <h1 class="text-primary title">CREATE LOGIN</h1>
    <div class="bg-gray-lighter form-info">Please select your account type.</div>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'prereg-login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>"form-create-login"
        )
    )); ?>

        <div class="form-group">
            <div class="radio">
                <label>
                    <input type="radio" name="options" value="option1" checked>
                    <span class="radio-style"></span>
                    VIC applicant
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="options"  value="option2">
                    <span class="radio-style"></span>
                    Company preregistering multiple VIC applicants
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="options" value="option3">
                    <span class="radio-style"></span>
                    ASIC sponsor
                </label>
            </div>
        </div>
        <div class="form-group">
            <span class="glyphicon glyphicon-user"></span>

            <?php echo $form->textField($model,'username',
                array(
                    'placeholder' => 'Username or Email',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>

        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>

            <?php echo $form->passwordField($model,'password',
                array(
                    'placeholder' => 'Password',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>
        </div>
    
    <?php echo CHtml::submitButton('Login',array('class'=>'btn btn-primary btn-next')); ?>
    <?php $this->endWidget(); ?>
</div>
