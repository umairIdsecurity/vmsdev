<table class="detailsTable" style="font-size:12px;margin-top:15px;" id="logvisitTable">
    <?php if ($model->visit_status == VisitStatus::ACTIVE || $model->visit_status == VisitStatus::EXPIRED) { ?>
        <tr>
            <td>
                <strong style="color:#0088cc;">Status</strong>: <span style="color:#9BD62C!important; font-weight:bold"><?php echo VisitStatus::$VISIT_STATUS_LIST[$model->visit_status]; ?></span>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>

    <?php } ?>

    <tr>
        <td>Check Out Date</td>
    </tr>
    <tr>
        <td>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="<?php echo VisitStatus::CLOSED; ?>" style="display:none;">
            <input name="Visit[time_check_out]" id="Visit_time_check_out" class="timeout" type="text" style="display:none;">
            <input type="text" value="<?php echo isset($model->date_check_out) ? date('d-m-Y', strtotime($model->date_check_out)) : date("d-m-Y"); ?>" id='Visit_date_check_out1' name="Visit[date_check_out1]" readonly>
        </td>
    </tr>
    <tr>
        <td>Check Out Time</td>
    </tr>
    <tr>
        <td>
            <select class="time visit_time_in_hours" id='Visit_time_check_out_hours' disabled style="width:70px;">
                <?php for ($i = 1; $i <= 24; $i++): ?>
                    <option value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
                <?php endfor; ?>
            </select> :
            <select class='time visit_time_in_minutes'  id='Visit_time_check_out_minutes' disabled style="width:70px;">
                <?php for ($i = 1; $i <= 60; $i++): ?>
                    <option value="<?= $i; ?>"><?php
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

    <?php if ($model->card_type == CardType::CONTRACTOR_VISITOR) { ?>

        <tr>
            <td>Card Returned Date</td>
        </tr>
        <tr>
            <td>
                <?php
                if (empty($model->card_returned_date)) {
                    $model->card_returned_date = date('d-m-Y');
                }
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'card_returned_date',
                    'htmlOptions' => array(
                        'size' => '10', // textField size
                        'maxlength' => '10', // textField maxlength
                        'placeholder' => 'dd-mm-yyyy',
                        'readOnly' => 'readOnly'
                    ),
                    'options' => array(
                        'dateFormat' => 'dd-mm-yy',
                        'showOn' => "button",
                        'buttonImage' => Yii::app()->controller->assetsBase . "/images/calendar.png",
                        'buttonImageOnly' => true,
                        'minDate' => "0",
                        'dateFormat' => "dd-mm-yy",
                    )
                ));
                ?>
            </td>
        </tr>
    <?php } // end if - contractor card type  ?>

</table>
