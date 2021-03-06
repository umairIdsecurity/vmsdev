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
        <td>Check Out Date</td>
    </tr>
    <tr>
        <td>
            <?php
            // added Temporary ASIC card type
            if (in_array($model->card_type, [CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_MANUAL, CardType::VIC_CARD_MULTIDAY, CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_24HOURS,CardType::TEMPORARY_ASIC])) {
                switch ($model->card_type) {
                    case CardType::VIC_CARD_24HOURS:
                        $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in . '+ 1 day'));
                        $model->time_check_out = $model->time_check_in; //check out time should same as check in time
                        break;
                    case CardType::VIC_CARD_EXTENDED:
                    case CardType::VIC_CARD_MULTIDAY:
                       if($model->visit_status == VisitStatus::CLOSED){
                            $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in . '+ 1 day'));
                            $model->time_check_out = $model->time_check_in; //check out time should same as check in time
                        }else{
                            $model->date_check_out = date('d-m-Y', strtotime($model->date_check_in . '+ 8 day'));
                            $model->time_check_out = "23:59:59"; //check out time should be midnight
                        }
                        break;
                    default: /*CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_MANUAL*/
                        $model->time_check_out = "23:59:59"; //check out time should be midnight
                        $model->date_check_out = $model->date_check_in;
                        break;
                }
            }?>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="<?php echo VisitStatus::CLOSED; ?>" style="display:none;">
<!--            <input name="Visit[time_check_out]" id="Visit_time_check_out" class="timeout" type="text" style="display:none;">-->
            <input type="text" value="<?php echo $model->date_check_out;//echo isset($model->date_check_out) ? date('d-m-Y', strtotime($model->date_check_out)) : date("d-m-Y"); ?>" id='Visit_date_check_out1' name="Visit[date_check_out1]" readonly>
        </td>
    </tr>
    <tr>
        <td>Check Out Time</td>
    </tr>
    <tr>
        <td>
            <?php echo $closeVisitForm->timeField($model,'finish_time',[]) ?>
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
                $closeVisitForm->dateField($model,'card_returned_date',[]);
                ?>
            </td>
        </tr>
    <?php } // end if - contractor card type  ?>

</table>
