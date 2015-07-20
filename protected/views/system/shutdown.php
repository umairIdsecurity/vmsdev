<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->controller->assetsBase . '/bootstrapSwitch/bootstrap-switch.css');
?>

<h1>Emergency Shut Down</h1>



<div style="display:inline-block;margin-top: 20px;">
    <span style="font-weight: bold;color: black;">Emergency shut down will disable all users from issuing visitors passes</span>
    <div class="switch switch-blue" style="margin-left: 500px;">
        <input type="radio" class="switch-input is_required_induction_radio" name="User[is_required_induction]" value="OFF" id="week" <?php if($shutdown->key_value == 'OFF') { ?> checked <?php } ?>>
        <label for="week" class="switch-label switch-label-off">OFF</label>
        <input type="radio" class="switch-input is_required_induction_radio" name="User[is_required_induction]" value="ON" id="month" <?php if($shutdown->key_value == 'ON') { ?> checked <?php } ?>>
        <label for="month" class="switch-label switch-label-on">ON</label>
        <span class="switch-selection"></span>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $(".is_required_induction_radio").click(function(){
            var value=$(this).val();
            if(value == 1){

            }else{
                ConfirmDialog('Are you sure you want to enable emergency shut down',value);
            }
        });
    });

    function ConfirmDialog(message,value){
        $('<div></div>').appendTo('body')
            .html('<div><h6>'+message+'?</h6></div>')
            .dialog({
                modal: true, title: 'Delete message', zIndex: 10000, autoOpen: true,
                width: 'auto', resizable: false,
                buttons: {
                    Yes: function () {
                        $(this).dialog("close");
                        setStatus('<?php echo System::$EMERGENCY_SHUTDOWN; ?>', value);
                    },
                    No: function () {
                        $(this).dialog("close");
                        document.getElementById("week").checked = true;
                    }
                },
                close: function (event, ui) {
                    document.getElementById("week").checked = true;
                    $(this).remove();
                }
            });
    };

    function setStatus(key_name,key_value){
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('system/shutdown'); ?>',
            //dataType: 'text',
            data: {key_name: key_name, key_value:key_value},
            success: function (r) {
                /*r = JSON.parse(r);
                if (r.success != 1) {
                    $('#file_grid_error').html(r.error);
                    $("#File-"+id).css('border-color','red');
                    $('#file_grid_error').fadeIn();
                } else {
                    $('#file_grid_error').fadeOut();
                    $.fn.yiiGridView.update("file-grid");
                }*/
            }
        });
    }

</script>