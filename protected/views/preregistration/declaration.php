<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 3:04 PM
 */

?>
<div class="page-content">

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


        <h3 class="text-primary">Declarations</h3>

        <h5>I agree by ticking the boxes below:</h5>

        <div class="form-group">

            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration2'); ?>
                <span class="checkbox-style"></span>I have not previously been either refused an ASIC that was suspended or cancelled because of an adverse criminal record, or been issued with a VIC pass at Perth Airport for more than a total of 28 days in the previous 12 months (not including a VIC issued by Customs & Border Protection, or VICs issued prior to 21st November 2011).
            </label>


            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration1'); ?>
                <span class="checkbox-style"></span>I have read, understood and agree to abide by the information and conditions applicable to the holder of the Visitor Identification Card (VIC).
            </label>
        </div>


        <?php   if($model->hasErrors('declaration1'))
                {
                   echo $form->error($model,'declaration1'); 
                }
                elseif($model->hasErrors('declaration2')) {
                    echo $form->error($model,'declaration2'); 
                }else{
                    echo $form->error($model,'declaration4'); 
                }

        ?>

        <br>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="pull-left">
                        <a href="<?=Yii::app()->createUrl("preregistration/privacyPolicy")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                    </div>
                    <div class="pull-right">
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'class' => 'btn btn-primary btn-next'
                            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
                    </div>
                </div>
            </div>
        </div>  


    <?php $this->endWidget(); ?>
</div>