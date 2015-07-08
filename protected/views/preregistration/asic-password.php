<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 7/7/15
 * Time: 7:05 PM
 */
?>

<div class="page-content">


    <?php

    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'asic-pass-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true
        )
    ));
    ?>

    <div class="form-create-login">
        <h1 class="text-primary title">Add Password</h1>
        <div class="form-group">
            <?php echo $form->passwordField($model, 'password', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Password' , 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->passwordField($model, 'password_repeat', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Repeat password' , 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'password_repeat'); ?>
        </div>

        <div class="form-group">
            <?php echo CHtml::submitButton('Save',array('class'=>'btn btn-primary btn-next')); ?>
        </div>

    </div>


    <?php $this->endWidget(); ?>
</div>