<?php

$timeIn = explode(":", '00:00:00');
if ($model->time_in != '') {
    $timeIn = explode(":", $model->time_in);
}


?>

<style type="text/css">
.middleLabels{margin-top:16px;}
</style>

<div class="page-content">
    
    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <span>Please select the time and date of your visit</span>


    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'visit-details-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' =>
            array(
                'class' => 'form-log-visit',
            ),

        )); ?>


    <div class="row">
        <div class="col-sm-4 text-center">
            <a href="#"><img src="<?=Yii::app()->theme->baseUrl?>/images/vic24h.png" alt="Vic24h"></a>
        </div>
        <div class="col-sm-8">
            <div class="">
                  <div class="row">
                    <div class="col-sm-3">Date of Visit</div>
                    <div class="col-sm-6">
                        <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model'       => $model,
                                'attribute'   => 'date_in',
                                'htmlOptions' => array(
                                    'placeholder' => 'DD-MM-YYYY',
                                    'class'=>'form-control input-sm from_date',
                                ),
                            ));
                        ?>
                    </div>
                    <div class="col-sm-3"><span class="glyphicon glyphicon-calendar"></span></div>
                  </div>
            </div>

            <div class="">
                <div class="row"><div class="col-sm-12">&nbsp;</div></div>
            </div>    

            <div class="">
                <div class="row">
                    <div class="col-sm-3">Time In</div>
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-xs-6">
                            <select class="form-control input-sm" name='Visit[time_in_hours]' id='Visit_time_in_hours' >
                                <?php for ($i = 1; $i <= 24; $i++): ?>
                                    <option 
                                    <?php
                                    if ($timeIn[0] == $i) {
                                        echo " selected ";
                                    }
                                    ?>
                                        value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
                                    <?php endfor; ?>
                            </select> 
                        </div>
                        <div class="col-xs-4">
                            <select class='form-control input-sm' name='Visit[time_in_minutes]' id='Visit_time_in_minutes'>
                                <?php for ($i = 0; $i <= 59; $i++): ?>
                                    <option 
                                    <?php
                                    if ($timeIn[1] == $i) {
                                        echo " selected ";
                                    }
                                    ?>
                                        value="<?= $i; ?>"><?php
                                            if ($i >= 0 && $i < 10) {
                                                echo '0' . $i;
                                            } else {
                                                echo $i;
                                            };
                                            ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                      </div>                
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>


    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>


    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/uploadPhoto")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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

<script type="text/javascript">
        $(document).ready(function(){
            $('#Visit_date_in').datepicker({
                minDate: '+1',
                changeYear: true,
                changeMonth: true,
                dateFormat: 'dd-mm-yy'
            });
        });
</script>