<div class="choose-profile">
   
    <h1>Select Visitor Profile Type</h1>
   <?php if( CHelper::get_allowed_module() != "AVMS") { ?>
    <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" id="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" name="Visitor[profile_type]" />
    <label class="corplabel000" for="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" >
        <p class="corp">Corporate</p>
    </label>
   <?php } if( CHelper::get_allowed_module() != "CVMS") {  ?>
    <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" name="Visitor[profile_type]" />
    <label class="viclabel000" for="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" >
        <p class="vic">VIC</p>
    </label>

    <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" name="Visitor[profile_type]" />
    <label class="viclabel000" for="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" >
        <p class="asic">ASIC</p>
    </label>
   <?php } ?>
</div>
<script>
    $(document).ready(function() {
        var profileTypeSelector = 'input:radio[name="Visitor[profile_type]"]';

        <?php $profileType = isset($_GET['profile_type']) ? $_GET['profile_type'] : $model->profile_type; ?>
            $(profileTypeSelector).filter('[value="<?php echo $profileType; ?>"]').attr('checked', true);

            <?php if ($this->action->id == 'update') {
                if ($profileType == Visitor::PROFILE_TYPE_CORPORATE)
                {
                    ?>  $('.viclabel000').css('display','none'); <?php
                } else {
                    ?>  $('.corplabel000').css('display','none'); <?php
                }
            ?>
        <?php } ?>

        $(profileTypeSelector).change(function() {
            <?php if (Yii::app()->controller->action->id == 'addvisitor'): ?>
                $(location).attr('href', 'index.php?r=visitor/addvisitor&profile_type=' + $(profileTypeSelector).filter(':checked').val());
            <?php else: ?>
                $(location).attr('href', 'index.php?r=visitor/update&id=<?php echo $_GET["id"]; ?>&profile_type=' + $(profileTypeSelector).filter(':checked').val() + '&vms=' + '<?php echo Yii::app()->request->getParam('vms'); ?>');
            <?php endif; ?>
       });
    });
</script>
