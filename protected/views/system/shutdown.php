<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->controller->assetsBase . '/bootstrapSwitch/bootstrap-switch.css');
?>

<h1>Emergency Shut Down</h1>

<div id="shutdown_error" class="errorMessage" style="text-transform: none;margin-top: 20px; height: auto ;display:none">Couldn't delete files.</div>

<div style="display:inline-block;margin-top: 20px; width: 87%">
    <span style="font-weight: bold;color: black;">Emergency shut down will disable all users from issuing visitor passes</span>
    <div class="switch switch-blue" style="float: right">
        <input type="radio" class="switch-input is_required_induction_radio" name="emergency_shutdown" value="<?php echo System::OFF ?>" id="OFF" <?php if($shutdown->key_value == System::OFF) { ?> checked <?php } ?>>
        <label for="OFF" class="switch-label switch-label-off">OFF</label>
        <input type="radio" class="switch-input is_required_induction_radio" name="emergency_shutdown" value="<?php echo System::ON ?>" id="ON" <?php if($shutdown->key_value == System::ON) { ?> checked <?php } ?>>
        <label for="ON" class="switch-label switch-label-on">ON</label>
        <span class="switch-selection"></span>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $(".is_required_induction_radio").click(function(){
            var value=$(this).val();
            if(value == '<?php echo System::ON ?>'){
                ConfirmDialog('Are you sure you want to enable emergency shut down',value);
            }else{
                setStatus('<?php echo System::$EMERGENCY_SHUTDOWN; ?>', value);
            }
        });
    });

    function ConfirmDialog(message,value){
        $('<div></div>').appendTo('body')
            .html('<div><h6>'+message+'?</h6></div>')
            .dialog({
                modal: true, title: 'Emergency Shut Down', zIndex: 10000, autoOpen: true,
                width: 'auto', resizable: false,
                buttons: {
                    Yes: function () {
                        $(this).dialog("close");
                        setStatus('<?php echo System::$EMERGENCY_SHUTDOWN; ?>', value);
                    },
                    No: function () {
                        $(this).dialog("close");
                        if(value == '<?php echo System::ON ?>')
                            document.getElementById("OFF").checked = true;
                        else
                            document.getElementById("ON").checked = true;
                    }
                },
                close: function (event, ui) {
                    if($(".is_required_induction_radio").val() == '<?php echo System::ON ?>')
                        document.getElementById("OFF").checked = true;
                    else
                        document.getElementById("ON").checked = true;
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
                r = JSON.parse(r);
                if (r.success != 1) {
                    if(key_value == '<?php echo System::ON ?>')
                        document.getElementById("OFF").checked = true;
                    else
                        document.getElementById("ON").checked = true;
                    $('#shutdown_error').html(r.error);
                    $('#shutdown_error').fadeIn();
                }else{
                    $('#shutdown_error').fadeOut();
                }
            }
        });
    }

</script>