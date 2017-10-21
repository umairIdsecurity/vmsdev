<div class="cardPhotoPreview" style="height:0px; margin-left: 15px;">
    <?php if ($visitor->photo != '') {
                $data = Photo::visitor()->returnVisitorPhotoRelativePath($visitor->visitor);
                $my_image = '';
                if(!empty($data['db_image'])){
                    $my_image = "data:image;base64," . $data['db_image'];
                }else{
                    $my_image = $data['relative_path'];
                }
        ?>
 
        <img id="photoPreview2" src="<?php echo $my_image; ?>" class="photo_visitor">
    <?php } else { ?>
        <img id="photoPreview2" src="" style="display:none;" class="photo_visitor">
    <?php } ?>
        
</div>
<?php
$vstr = Visitor::visitor()->findByPk($visitor->visitor);

?>

<?php
    $bgcolor = "";
    if($visitor->card_type > CardType::CONTRACTOR_VISITOR) {
        $bgcolor = CardGenerated::VIC_CARD_COLOR;
        $this->renderPartial("_card_detail",['bgcolor' => $bgcolor,'visitor' => $visitor,'visitor' => $visitor]);
    } else {
        $bgcolor = CardGenerated::CORPORATE_CARD_COLOR;
        $this->renderPartial("_card-corporate",['bgcolor' => $bgcolor,'visitor' => $visitor,'visitor' => $visitor]);
    }
?>

<div id="Visitor_photo_em" class="errorMessage" style="display: none;">Please upload a profile image.</div>

<?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>


<?php if ($visitor->photo != '') : ?>
<input type="button" class="btn editImageBtn actionForward" id="editImageBtn" style="margin-bottom: 2px!important;" value="Edit Photo" onclick = "document.getElementById('light').style.display = 'block';
                document.getElementById('fade').style.display = 'block'"/>
<?php endif; ?>

<div style="display:<?php echo $session['role'] == Roles::ROLE_STAFFMEMBER ? 'none' : 'block'; ?>">
    <?php $cardDetail = CardGenerated::visitor()->findAllByAttributes(array('visitor_id' => $visitor->visitor)); ?>
</div>
<div style="clear: both;"></div>

<div class="dropdown" style="margin-left: 21px; text-align: left;">
<?php if (in_array($visitor->card_type, [CardType::SAME_DAY_VISITOR, CardType::MULTI_DAY_VISITOR, CardType::CONTRACTOR_VISITOR, cardType::MANUAL_VISITOR, CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_24HOURS, CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY]) && $visitor->visit_status ==VisitStatus::ACTIVE): ?>

    <button class="btn btn-info printCardBtn dropdown-toggle actionForward" style="width:205px !important; margin-top: 4px; margin-right: 0px; margin-left: 0px !important;" type="button" id="menu1" data-toggle="dropdown">Print Card
        <span class="caret pull-right"></span></button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	<?php if($visitor->card_type != CardType::VIC_CARD_24HOURS) :?>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $visitor->id, 'type' => 1)) ?>">Print On Standard Printer</a></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $visitor->id, 'type' => 2)) ?>">Print On Card Printer</a></li>
		<?php endif;?>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $visitor->id, 'type' => 3)) ?>">Bleed Through Label</a></li>
    </ul>
<?php elseif (in_array($visitor->card_type, [CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_24HOURS]) && $visitor->visit_status == VisitStatus::AUTOCLOSED): ?>
    <button class="btn btn-info printCardBtn dropdown-toggle actionForward" style="width:205px !important; margin-top: 4px; margin-right: 0px; margin-left: 0px !important;" type="button" id="menu1" data-toggle="dropdown">Print Card
        <span class="caret pull-right"></span></button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $visitor->id, 'type' => 2)) ?>">Reprint Card</a>
            </li>
        </ul>
<?php else: ?>
    <button class="btn btn-info printCardBtn dropdown-toggle actionForward" disabled="disabled" style="width:205px !important; margin-top: 4px; margin-right: 0px; margin-left: 0px !important;" type="button" id="menu1" data-toggle="dropdown">Print Card<span class="caret pull-right"></span>
    </button>
<?php endif; ?>
</div>