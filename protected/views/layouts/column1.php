<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content" style="margin-left:-10px;<?php if ($this->action->id == 'profile' || $this->id=='password' || $this->id=='dashboard') {
    echo 'margin-left:30px;width:94.5%';
} ?>">
<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>