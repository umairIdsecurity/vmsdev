<br>


<table class="detailsTable" style="font-size:12px;" id="logvisitTable">
    <tr>
        <td>Date In</td>
    </tr>
    <tr>
        <td>
            <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="1" style="display:none;">
            <input name="Visit[time_check_in]" id="Visit_time_check_in" class="activatevisittimein" type="text" style="display:none;">
            <input type="text" value="<?php echo date("d-m-Y"); ?>" id='Visit_date_check_in' name="Visit[date_check_in]" disabled>
            <input type="text" style="display:none;" value="<?php
            if ($model->card_type == CardType::SAME_DAY_VISITOR) {
                echo date("d-m-Y");
            } else {
                echo $model->date_out;
            }
            ?>" id='Visit_date_check_out' 
                   name="Visit[date_check_out]" >
        </td>
    </tr>

    <tr>
        <td>Time In</td>
    </tr>
    <tr>
        <td>
            <select class="time visit_time_in_hours" id='Visit_time_in_hours' disabled style="width:70px;">
                <?php for ($i = 1; $i <= 24; $i++): ?>
                    <option value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
<?php endfor; ?>
            </select> :
            <select class='time visit_time_in_minutes'  id='Visit_time_in_minutes' disabled style="width:70px;">
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
</table>
<script>
    $(document).ready(function() {
        refreshTimeIn();

    });

    function refreshToCurrentTime() {
        var refresh = 1000; // Refresh rate in milli seconds
        mytime = setTimeout('refreshTimeIn()', refresh)
    }

    function refreshTimeIn() {

        var x = new Date();
        var currenttime = x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds();

        $(".visit_time_in_hours").val(x.getHours());
        $(".visit_time_in_minutes").val(x.getMinutes());
        $(".activatevisittimein").val(currenttime);
        tt = refreshToCurrentTime();
    }

</script>