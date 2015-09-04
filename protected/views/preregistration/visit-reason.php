<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/19/15
 * Time: 10:06 AM
 */

?>
<div class="page-content">
    
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'preregistration-form',
        //'enableAjaxValidation' => true,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <div class="row">

        <div class="col-xs-3">
            <div class="form-group text-primary">Reason for Visit</div>
            <div class="form-group">
                <?php
                $account=(isset(Yii::app()->user->account_type)) ? Yii::app()->user->account_type : "";
                $vt = '';
                if($account == 'CORPORATE'){
                    $vt = Yii::app()->db->createCommand()
                            ->select("t.id,t.name") 
                            ->from("visitor_type t")
                            ->where('t.module = "CVMS" and t.is_deleted =0')
                            ->queryAll();
                    //$vt = VisitorType::model()->findAll('module = :m', [':m' => "CVMS"]);
                }elseif(($account == 'VIC') || ($account == 'ASIC')){
                    $vt = Yii::app()->db->createCommand()
                            ->select("t.id,t.name") 
                            ->from("visitor_type t")
                            ->where('t.module = "AVMS" and t.is_deleted =0')
                            ->queryAll();
                    //$vt = VisitorType::model()->findAll('module = :m', [':m' => "AVMS"]);
                }else{
                    $vt = Yii::app()->db->createCommand()
                            ->select("t.id,t.name") 
                            ->from("visitor_type t")
                            ->where("t.is_deleted =0")
                            ->queryAll();
                    //$vt = VisitorType::model()->findAll('module = :m', [':m' => "AVMS"]);
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
                        'class'=>'form-control input-sm' ,
                        'empty' => 'Select Visit Reason')
                );

                ?>
                <?php echo $form->error($model, 'reason'); ?>

            </div>

            <div class="form-group" id="other-reason">
                <?php echo $form->textField($model, 'other_reason', array('maxlength' => 50, 'placeholder' => 'Other Reason' ,'class'=>'form-control input-sm')); ?>

                <?php echo $form->error($model, 'other_reason'); ?>
            </div>
        </div>    

        <div class="col-xs-1"></div>

        <div class="col-xs-3">
            <div class="form-group text-primary">Company Information</div>


            <div class="form-group" id="addCompanyDiv">
                <?php
                    echo $form->dropDownList($companyModel, 'name', CHtml::listData(Company::model()->findAll('is_deleted=0'),'id', 'name'), array('prompt' => 'Select Company' , 'class'=>'form-control input-sm'));
                ?>
                <?php echo $form->error($companyModel,'name'); ?>
            </div>
            <div class="form-group">
                <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Company</a>
            </div>


            <div class="form-group" id="addCompanyDiv">
                <?php
                    echo $form->dropDownList($model, 'host', CHtml::listData(Visitor::model()->findAll("profile_type='ASIC' and is_deleted=0"),'id', 'first_name'), array('prompt' => 'Select Company Contact' , 'class'=>'form-control input-sm'));
                ?>
                <?php echo $form->error($model,'host'); ?>
            </div>
            <div class="form-group">
                <a style="float: left;" href="#addCompanyModal" role="button" data-toggle="modal" class="btn btn-primary">Add Contact</a>
            </div>

        </div>
    </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/personalDetails")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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