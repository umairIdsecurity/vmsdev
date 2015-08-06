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

            $account=Yii::app()->user->getState('account');

            $vt = '';

            if($account == 'CORPORATE'){
                $vt = Yii::app()->db->createCommand()
                        ->select("t.id,t.name") 
                        ->from("visitor_type t")
                        ->where('t.module = "CVMS" and t.is_deleted =0')
                        ->queryAll();
                //$vt = VisitorType::model()->findAll('module = :m', [':m' => "CVMS"]);
            }else{
                $vt = Yii::app()->db->createCommand()
                        ->select("t.id,t.name") 
                        ->from("visitor_type t")
                        ->where('t.module = "AVMS" and t.is_deleted =0')
                        ->queryAll();
                //$vt = VisitorType::model()->findAll('module = :m', [':m' => "AVMS"]);
            }

            $list=CHtml::listData($vt,'id','name');

            echo $form->dropDownList($model,'visitor_type',
                $list,
                array(
                    'class'=>'form-control input-lg' ,
                    'empty' => 'Select Visitor Type')
            );

            ?>
            <?php echo $form->error($model, 'visitor_type'); ?>
        </div>
        <div class="form-group">
            <?php

            $vr = Yii::app()->db->createCommand()
                        ->select("t.id,t.reason") 
                        ->from("visit_reason t")
                        ->where('t.is_deleted =0')
                        ->queryAll();
            //$vr=VisitReason::model()->findAll();

            $list=CHtml::listData($vr,'id','reason');

            $other = array('other'=>'other');

            echo $form->dropDownList($model,'reason',
                $list + $other,
                array(
                    'class'=>'form-control input-lg' ,
                    'empty' => 'Select Visit Reason')
            );

            ?>
            <?php echo $form->error($model, 'reason'); ?>

        </div>

        <div class="form-group" id="other-reason">
            <?php echo $form->textField($model, 'other_reason', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Other Reason' ,'class'=>'form-control input-lg')); ?>

            <?php echo $form->error($model, 'other_reason'); ?>
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

<script>
    $(document).ready(function() {
        //alert('hello'); other-reason
        $('#other-reason').hide();
        $('#Visit_reason').change(function(e){
            if ($('#Visit_reason').val() == 'other'){
                //alert('hello');
                $('#other-reason').show();
            }else{
                $('#other-reason').hide();
            }
        });
    });
</script>