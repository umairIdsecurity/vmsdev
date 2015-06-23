<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/19/15
 * Time: 10:06 AM
 */

?>
<div class="page-content">
    <h1 class="text-primary title">REASON FOR VISIT</h1>
    <div class="bg-gray-lighter form-info">Please provide a reason for this visit.</div>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'preregistration-form',
        //'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    <div class="form-create-login">
        <div class="form-group">
            <?php

            $vt=VisitorType::model()->findAll();

            $list=CHtml::listData($vt,'id','name');

            echo $form->dropDownList($model,'visitor_type',
                $list,
                array(
                    'class'=>'form-control input-lg' ,
                    'empty' => 'Select a Visitor Type')
            );

            ?>
            <?php echo $form->error($model, 'visitor_type'); ?>
        </div>
        <div class="form-group">
            <?php

            $vr=VisitReason::model()->findAll();

            $list=CHtml::listData($vr,'id','reason');

            //$other = array('other'=>'other');

            echo $form->dropDownList($model,'reason',
                $list,
                array(
                    'class'=>'form-control input-lg' ,
                    'empty' => 'Select a Reason')
            );

            ?>
            <?php echo $form->error($model, 'reason'); ?>

        </div>
        <div class="form-group">

            <?php

            /*$company=Company::model()->findAll();

            $list=CHtml::listData($company,'id','name');

            echo $form->dropDownList($model,'company',
                $list,
                array(
                    'class'=>'form-control input-lg' ,
                    'empty' => 'Select a Company')
            );*/

            ?>
            <?php //echo $form->error($model, 'company'); ?>

        </div>
        <div class="form-group">
            <?php echo $form->textField($companyModel, 'name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Company Name' ,'class'=>'form-control input-lg')); ?>

            <?php echo $form->error($companyModel, 'name'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->textField($companyModel, 'contact', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Jane Schimdt' ,'class'=>'form-control input-lg')); ?>

            <?php echo $form->error($companyModel, 'contact'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($companyModel, 'email_address', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'jane.schimdt@company.com' ,'class'=>'form-control input-lg')); ?>

            <?php echo $form->error($companyModel, 'email_address'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($companyModel, 'mobile_number', array('size' => 50, 'maxlength' => 50, 'placeholder' => '+63512345678' ,'class'=>'form-control input-lg')); ?>

            <?php echo $form->error($companyModel, 'mobile_number'); ?>

        </div>

    </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/confirmDetails")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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