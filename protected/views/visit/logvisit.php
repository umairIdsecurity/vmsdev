<br>
<?php
$time_in = explode(":", $model->time_in);

$logform = $this->beginWidget('CActiveForm', array(
    'id' => 'update-log-visit-form',
    'htmlOptions' => array("name" => "update-log-visit-form"),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    sendVisitForm("update-log-visit-form");
                                }
                                }'
    ),
        ));
?>
<table class="detailsTable" style="font-size:12px;" id="logvisitTable">
    <tr>
        <td>Date In</td>
    </tr>
    <tr>
        <td><?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date_in',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                ),
                'value'=>date('mm/dd/Y'),
                'options' => array(
                    'dateFormat' => 'mm/dd/yy',
                )
            ));
            ?>
        </td>
    </tr>
    <tr>
        <td>Date Out</td>
    </tr>
    <tr>
        <td><?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date_out',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                ),
                'options' => array(
                    'dateFormat' => 'mm/dd/yy',
                )
            ));
            ?>
        </td>
    </tr>
    <tr>
        <td>Time In</td>
    </tr>
    <tr>
        <td>
            <select class="time" name='Visit[time_in_hours]' id='Visit_time_in_hours'>
                <?php for ($i = 1; $i <= 24; $i++): ?>
                    <option 
                        <?php 
                        if($time_in[0] == $i){
                            echo " selected ";
                        }
                        ?>
                        value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
                <?php endfor; ?>
            </select> :
            <select class='time' name='Visit[time_in_minutes]' id='Visit_time_in_minutes'>
                <?php for ($i = 1; $i <= 60; $i++): ?>
                    <option 
                        <?php 
                        if($time_in[1] == $i){
                            echo " selected ";
                        }
                        ?>
                        value="<?= $i; ?>"><?php
                if ($i > 0 && $i < 10) {
                    echo '0' . $i;
                } else {
                    echo $i;
                };
                    ?></option>
                    <?php endfor; ?>
            </select>
        </td>
    </tr>
</table>
<?php echo $logform->error($model, 'date_in'); ?>
<input type='submit' value='Update'/>
<?php $this->endWidget(); ?>