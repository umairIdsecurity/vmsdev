<table style="margin-left:70px;width:120px;margin-top:10px;">
    <tr style="text-align: center;">
        <td>
            <label for="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" >
                <img src="<?php echo Yii::app()->controller->assetsBase . '/images/ico1.jpg'; ?>"/>
                Corp
            </label>
        </td>
        <td>
            <label for="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" >
                <img src="<?php echo Yii::app()->controller->assetsBase . '/images/ico3.jpg'; ?>"/>
                VIC
            </label>
        </td>
        <td>
            <label for="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" >
                <img src="<?php echo Yii::app()->controller->assetsBase . '/images/ico2.jpg'; ?>"/>
                ASIC
            </label>
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">
            <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" id="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" name="Visitor[profile_type]" />
        </td>
        <td style="text-align:center;">
            <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" name="Visitor[profile_type]" />
        </td>
        <td style="text-align:center;">
            <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" name="Visitor[profile_type]" />
        </td>
    </tr>
</table>

<script>
    $(document).ready(function() {
        var profileTypeSelector = 'input:radio[name="Visitor[profile_type]"]';

        <?php $profileType = isset($_GET['profile_type']) ? $_GET['profile_type'] : $model->profile_type; ?>
        $(profileTypeSelector).filter('[value="<?php echo $profileType; ?>"]').attr('checked', true);

        <?php if ($this->action->id == 'update') { ?>
            $(profileTypeSelector).attr('disabled',true);
        <?php } ?>

        $(profileTypeSelector).change(function() {
            $(location).attr('href', 'index.php?r=visitor/addvisitor&profile_type=' + $(profileTypeSelector).filter(':checked').val());
       });
    });
</script>
