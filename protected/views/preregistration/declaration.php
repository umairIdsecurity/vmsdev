<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 3:04 PM
 */

?>
<div class="page-content">
    <h1 class="text-primary title">PREREGISTRATION FOR VISITOR IDENTIFICATION CARD (VIC)</h1>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'declaration-form',
        //'class'=>'declarations',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=> 'declarations'
        )
    ));
    ?>
        <?php echo $form->errorSummary($model); ?>
        <h3 class="text-primary">Declarations</h3>
        <h5>I agree by ticking the boxes below:</h5>

        <div class="form-group">
            <?php //echo $form->textField($model,'condition_1'); ?>
            <label class="checkbox">
            <?php echo $form->checkBox($model,'declaration1'); ?>
                <span class="checkbox-style"></span>I have read, understood and agree to abide by the information and conditions applicable to the holder of the Visitor Identification Card (VIC).
            </label>

            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration2'); ?>
                <span class="checkbox-style"></span>I have not previously been refused an ASIC or had one suspended or cancelled because of an adverse criminal record, or been issued with a VIC pass at Perth Airport for more than a total of 28 days in the previous 12 months (not including a VIC issued by Customs & Border Protection, or VICs issued prior to 21st November 2011).
            </label>

            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration3'); ?>
                <span class="checkbox-style"></span>I have read and understood <a href="<?=Yii::app()->createUrl("preregistration/privacypolicy")?>">Perth Airport’s privacy notice</a> on the collection and release of personal information.
            </label>

            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration4'); ?>
                <span class="checkbox-style"></span>I consent to Perth Airport using and disclosing my personal information in accordance with Perth Airport’s privacy notice.
            </label>

        </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/privacypolicy")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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