<div class="choose-profile">
<h2>Select Visitor Profile Type: </h2>
  
            <label for="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" >
                <img src="<?php echo Yii::app()->controller->assetsBase . '/images/corporate-visitor-icon.png'; ?>"/>
                Corporate
                <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" id="<?php echo Visitor::PROFILE_TYPE_CORPORATE; ?>" name="Visitor[profile_type]" />
            </label>
 
            <label for="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" >
                <img src="<?php echo Yii::app()->controller->assetsBase . '/images/vic-visitor-icon.png'; ?>"/>
                VIC
             <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_VIC; ?>" name="Visitor[profile_type]" />

            </label>
 

        
            <label for="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" >
                <img src="<?php echo Yii::app()->controller->assetsBase . '/images/asic-visitor-icon.png'; ?>"/>
                ASIC
             <input type="radio" value="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" id="<?php echo Visitor::PROFILE_TYPE_ASIC; ?>" name="Visitor[profile_type]" />

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
