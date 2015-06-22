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

            <?php echo $form->textField($model,'username',
                array(
                    'placeholder' => 'Username or Email',
                    'class'=>'form-control input-lg',
                    'data-validate-input'
                )); ?>
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
</div>