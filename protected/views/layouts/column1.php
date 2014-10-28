<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content" style="margin-left:-10px;<?php
     if ($this->action->id == 'profile' || $this->id == 'password' || $this->id == 'dashboard' ) {
         echo 'margin-left:25px;width:94.9%';
     }elseif($this->id =='userWorkstations' || $this->action->id=='findvisitor' || $this->action->id == 'findhost' ){
         echo 'border:1px solid white;';
     }
     ?>">
<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>