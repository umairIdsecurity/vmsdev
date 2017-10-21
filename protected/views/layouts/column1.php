<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content" style="margin-left:-10px;<?php
     if ($this->action->id == 'profile' || $this->id == 'password' || $this->id == 'dashboard' || ($this->action->id == 'view' && $this->id == 'visit')  ) {
         echo 'margin-left:25px;width:94.9%';
     } elseif($this->id =='userWorkstations' || $this->action->id=='findvisitor' || $this->action->id == 'findhost' || $this->action->id == 'print'){
         echo 'border:1px solid white;min-height:0 !important;';
     }
     ?>" <?php
    if ($this->action->id == 'print') {
        echo "class='overflowxvisible'";
    }
    ?>>
<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>