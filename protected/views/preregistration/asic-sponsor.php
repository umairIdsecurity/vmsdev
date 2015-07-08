<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/24/15
 * Time: 2:59 AM
 */
?>
<div class="page-content">
    <h1 class="text-primary title">ADD / FIND ASIC SPONSOR</h1>

    <?php

    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'add-asic-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true
        ),
        'htmlOptions'=>array(
        'class'=> 'declarations'
    )
    ));
    ?>

    <div class="form-create-login">

        <div class="form-group">
            <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'first_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name' , 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'last_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'asic_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'ASIC no.', 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'asic_no'); ?>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'       => $model,
                    'attribute'   => 'asic_expiry',
                    'options'     => array(
                        'dateFormat' => 'dd-mm-yy',
                    ),
                    'htmlOptions' => array(
                        'size'        => '0',
                        'maxlength'   => '10',
                        'placeholder' => 'Expiry',
                        'class' => 'form-control input-lg'
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'asic_expiry'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Mobile Number', 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'contact_number'); ?>

        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Email', 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'email'); ?>

        </div>
        <div class="form-group">
            <label class="checkbox">
                <?php echo $form->checkBox($model,'is_asic_verification'); ?>
                <span class="checkbox-style"></span>
                <a class="btn btn-sm btn-success" href="">
                    Request ASIC Sponsor Verification
                </a>
            </label>
            <?php echo $form->error($model,'is_asic_verification'); ?>
        </div>

    </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/visitReason")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-9 col-sm-offset-9 col-xs-offset-8 col-md-1 col-sm-1 col-xs-1">

            <a href="" class="btn btn-primary btn-next">
                SKIP
                <span class="glyphicon glyphicon-chevron-right"></span>

            </a>
        </div>

        <div class="col-md-1 col-sm-1 col-xs-1">
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