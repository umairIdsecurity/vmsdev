<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/4/15
 * Time: 3:31 PM
 */

?>

<div class="page-content">
    <h1 class="text-primary title">PREREGISTRATION FOR VISITOR IDENTIFICATION CARD (VIC)</h1>

        <?php
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'entry-point-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                //'class'=>'form-select-gate'
            )
        ));
        ?>


<br><br><br>

    <div class="">

        <div class="" style="float: left">
            <h3 class="" style="margin-top:11px">Where will you be collecting your VIC?</h3>
        </div>
       
        <div class="form-group" style="float: left">

            <?php

            $ws=Workstation::model()->findAll();

            $list=CHtml::listData($ws,'id','name');

            echo $form->dropDownList($model,'entrypoint',
                $list,
                array(
                    'class'=>'form-control input-lg',
                    'style'=>'width:500px;margin-left:70px',
                    'empty' => 'Select a workstation')
            );

            ?>

        </div>

        <br><br><br>

        <div class="">
            <?php echo $form->errorSummary($model); ?>
        </div>
         
    </div>

    <br>
    
    <div class="text-center icon-info" style="margin-left:55px">
        <a href="#" data-toggle-class data-show-hide=".sms-info" ><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;(VIC) What is this?</a>
    </div>
     <br>
    <div class="hidden sms-info" style="margin-left:202px">
        <span class="btn-close" data-closet-toggle-class="hidden" data-object=".sms-info">close</span>
        <h3>What is a Visitor Identification Card (VIC)?</h3>
        <p>A VIC is an identification card visitors must wear when they are in a secure zone of a security controlled airport. VICs permit temporary access to non-frequent visitors to an airport. If a person is a frequent visitor to an airport they should consider applying for an Aviation Security Identification Card (ASIC).</p>
    </div>



    <div class="row next-prev-btns">
        <div class="col-md-1">
            <!--<a href="" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>-->
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-8 col-md-1">
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

