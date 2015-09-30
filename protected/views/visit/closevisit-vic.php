<input name="closeVisitForm" type="hidden" value="1"/>

<table class="detailsTable" style="font-size:12px;margin-top:15px;" id="logvisitTable">
    <?php if ($model->visit_status == VisitStatus::ACTIVE || $model->visit_status == VisitStatus::EXPIRED) { ?>
        <tr>
            <td>
                <strong style="color:#0088cc;">Status</strong>: 
                <?php if ($model->visit_status == VisitStatus::EXPIRED) { ?>
                    <span style="color:#ff0000!important; font-weight:bold"><?php echo VisitStatus::$VISIT_STATUS_LIST[$model->visit_status]; ?></span>
                <?php } else { ?>
                    <span style="color:#9BD62C!important; font-weight:bold"><?php echo VisitStatus::$VISIT_STATUS_LIST[$model->visit_status]; ?></span>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>

    <?php } ?>

    <tr>
        <td>Finish Time</td>
    </tr>
    <tr>
        <td>
            <?php  if( !is_null($model->finish_time) ) {
                
                $timeArr = explode(":", $model->finish_time );
                $hours = $timeArr[0]; $minutes = $timeArr[1];
              ?>
            
            <select class="time visit_time_in_hours_" id='Visit_time_check_out_hours' disabled style="width:70px;">
                <?php for ($i = 1; $i <= 24; $i++): ?>
                    <option value="<?= $i; ?>" <?= $hours == $i?"selected":"";?>><?= date("H", strtotime("$i:00")); ?></option>
                <?php endfor; ?>
            </select> :
            <select class='time visit_time_in_minutes_'  id='Visit_time_check_out_minutes' disabled style="width:70px;">
                <?php for ($i = 1; $i <= 60; $i++): ?>
                    <option value="<?= $i; ?>" <?= $minutes == $i?"selected":"";?>><?php
                        if ($i > 0 && $i < 10) {
                            echo '0' . $i;
                        } else {
                            echo $i;
                        };
                        ?></option>
                <?php endfor; ?>
            </select>
            <?php } ?>
        </td>
    </tr>

    <tr>
        <td>Finish Visit Date</td>
    </tr>
    <tr>
        <td>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="hidden"
                   value="<?php echo VisitStatus::CLOSED; ?>">


            <?php
            $model->finish_date = strtotime($model->date_check_out) > 0 ? date('d-m-Y', strtotime($model->date_check_out)) : date('d-m-Y');
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'finish_date',
                'htmlOptions' => array(
                    'size' => '10', // textField size
                    'maxlength' => '10', // textField maxlength
                    'placeholder' => 'dd-mm-yyyy',
                    'readOnly' => 'readOnly'
                ),
                'options' => array(
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
    <?php if (in_array($model->card_type, [CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY, CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_MANUAL])): ?>
    <tr>
        <td>Card Option</td>
    </tr>
    <tr>
        <td>
            <?php 
            $cardOptions = array('Returned' => 'Returned', 'Not Returned'=>'Not Returned',  'Lost/Stolen' => 'Lost/Stolen');
            if( $model->card_type == CardType::VIC_CARD_EXTENDED )
                $cardOptions = array('Returned' => 'Returned and Refunded', 'Not Returned'=>'Not Returned',  'Lost/Stolen' => 'Lost/Stolen');
                echo $closeVisitForm->dropDownList($model, 'card_option',$cardOptions)?>
        </td>
    </tr>
        <tr class="lost_stolen_fields">
        <?php if (!empty($model->card_lost_declaration_file)): ?>
            <td>Download Document</td>
        <?php else: ?>
            <td>Please complete sign and upload a declaration or police report or provide the police report number</td>
        <?php endif; ?>
        </tr>
        <tr class="lost_stolen_fields">
            <td>
                <?php 
                    if (!empty($model->card_lost_declaration_file)) {
                        $urlArr = explode('/', $model->card_lost_declaration_file);
                        $docName = $urlArr[count($urlArr) - 1];
                        echo CHtml::link($docName, $model->card_lost_declaration_file, ["style" => "padding-left:0px !important;"]);
                    } else {
                        echo $closeVisitForm->fileField($model, 'card_lost_declaration_file');
                    }
                ?>
                <br />
                <br />
                <?php echo $closeVisitForm->error($model, 'card_lost_declaration_file'); ?>
                <div style="display: none" id="card_lost_declaration_required" class="errorMessage">Please add card lost declaration file.</div>
            </td>
        </tr>

        <tr class="lost_stolen_fields">
            <td>&nbsp;</td>
        </tr>

        <tr class="lost_stolen_fields">
            <td>Police Report Number</td>
        </tr>
        <tr class="lost_stolen_fields">
            <td>
                <?php echo $closeVisitForm->textField($model, 'police_report_number')?>
                <br />
                <div style="display: none" id="police_number_required" class="errorMessage">Please enter police report number.</div>
            </td>
        </tr>
    <?php endif; ?>

    <tr><td>&nbsp;</td></tr>

    <tr><td>Date Card Returned/Lost</td></tr>
    <tr>
        <td>
            <?php
            $model->card_returned_date = strtotime($model->date_check_out) > 0 ? date('d-m-Y', strtotime($model->date_check_out)) : date('d-m-Y');
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

</table>

<script type="text/javascript">
    if ( $('#Visit_card_option').val() == 'Returned' || $('#Visit_card_option').val() == 'Not Returned' || $('#Visit_card_option').val() == 'Returned and Refunded' ) {
        $('.lost_stolen_fields').hide();
    } else {
        $('.lost_stolen_fields').show();
    }

    $('#Visit_card_option').on('change', function() {
        if ($(this).val() == 'Lost/Stolen') {
            $('.lost_stolen_fields').show();
        } else {
            $('.lost_stolen_fields').hide();
        }
    });
</script>