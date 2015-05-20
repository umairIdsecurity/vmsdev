<div class="choose-profile">
<h1>Select Visitor Profile Type</h1>
  
            <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" id="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" name="Visitor[profile_type]" />
            <label for="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" >
                <p class="corp">Corporate</p>
            </label>
 
            <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" name="Visitor[profile_type]" />
            <label for="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" >
                <p class="vic">VIC</p>
            </label>
 
            <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" name="Visitor[profile_type]" />
            <label for="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" >
                <p class="asic">ASIC</p>
            </label>
 
</div>
            
        
       
        
      
      


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
