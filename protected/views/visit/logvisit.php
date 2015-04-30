
<br>
<?php
$timeIn = explode(":", '00:00:00');
if ($model->time_in != '') {
    $timeIn = explode(":", $model->time_in);
}
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
                                    $("#Visit_date_out").attr("disabled", true);
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
                    'readonly' => 'readonly',
                ),
                'value' => date('mm/dd/Y'),
                'options' => array(
                    'dateFormat' => 'mm/dd/yy',
                    'onClose' => 'js:function(selectedDate) { $("#Visit_date_in").datepicker("option", "minDate", selectedDate); }',
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
                    'disabled' => 'disabled',
                    'readonly' => 'readonly',
                ),
                'options' => array(
                    'dateFormat' => 'mm/dd/yy',
                    'onClose' => 'js:function(selectedDate) { $("#Visit_date_out").datepicker("option", "maxDate", selectedDate); }',
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
            <select class="time" name='Visit[time_in_hours]' id='Visit_time_in_hours' >
                <?php for ($i = 1; $i <= 24; $i++): ?>
                    <option 
                    <?php
                    if ($timeIn[0] == $i) {
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
                    if ($timeIn[1] == $i) {
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

<input type='text' id='currentCardTypeValueOfEditedUser' value='<?php echo $model->card_type; ?>' style='display:none;'>
<script>
    $(document).ready(function() {

        $('#Visit_date_in').on('change', function(e) {
            assignValuesForProposedDateOutDependingOnCardType();
        });

        function assignValuesForProposedDateOutDependingOnCardType() {
            if ($("#currentCardTypeValueOfEditedUser").val() == 1) { //if card type is same visitor
                $("#Visit_date_out").val($("#Visit_date_in").val());
            } else {
                $("#Visit_date_out").attr("disabled", false);
            }
        }

        $("#Visit_date_in").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase;?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Date From",
            dateFormat: "yy-mm-dd",
            onClose: function(selectedDate) {
                $("#Visit_date_out").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#Visit_date_out").datepicker({
            changeMonth: true,
            changeYear: true,
            showOn: "button",
            buttonImage: "<?php echo Yii::app()->controller->assetsBase;?>/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select Date From",
            dateFormat: "yy-mm-dd",
            onClose: function(selectedDate) {
                $("#Visit_date_in").datepicker("option", "maxDate", selectedDate);
            }
        });
        
        $('#update-log-visit-form').bind('submit', function() {
            $(this).find('#Visit_date_out').removeAttr('disabled');
        });

    });
</script>