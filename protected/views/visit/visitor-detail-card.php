<?php
$session = new CHttpSession;

$session['count'] = 1;
//date_default_timezone_set('Asia/Manila'); remove hard code
$tenant = User::model()->findByPk($visitorModel->tenant);
$photoForm = $this->beginWidget('CActiveForm', array(
    'id' => 'update-photo-form',
    'action' => Yii::app()->createUrl('/visitor/update&id=' . $model->visitor . '&view=1'),
    'htmlOptions' => array("name" => "update-visitor-form"),
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form, data, hasError){
                                sendPhoto();
                                }'
    ),
        ));
?>
<input type="text" value="<?php echo $visitorModel->photo; ?>" name="Visitor[photo]" id="Visitor_photo">
<?php echo "<br>" . $photoForm->error($visitorModel, 'photo'); ?>
<input type="submit" id="submitBtnPhoto">
<?php $this->endWidget(); ?>

<div class="cardPhotoPreview" style="height:0px; margin-left: 15px;">
    <?php if ($visitorModel->photo != '') { ?>
        <img id="photoPreview" src="<?php echo Photo::model()->returnVisitorPhotoRelativePath($model->visitor) ?>">
    <?php } else { ?>
        <img id="photoPreview" src="" style="display:none;"></img>
    <?php } ?>
</div>
<?php
$vstr = Visitor::model()->findByPk($model->visitor);
if ($vstr->profile_type == "CORPORATE") {
    $bgcolor = CardGenerated::CORPORATE_CARD_COLOR;
}/* elseif ($vstr->profile_type == "ASIC") {
    $bgcolor = CardGenerated::ASIC_CARD_COLOR;
} */elseif ($vstr->profile_type == "VIC" || $vstr->profile_type == "ASIC") {
     $bgcolor = CardGenerated::VIC_CARD_COLOR;
}
?>
<?php $this->renderPartial("_card_detail",array('bgcolor'=>$bgcolor,'model'=>$model,'visitorModel'=>$visitorModel));?>
<?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
<?php if ($visitorModel->photo != '') { ?>
<input type="button" class="btn editImageBtn actionForward" id="editImageBtn" style="  margin-bottom: 2px!important;" value="Edit Photo" onclick = "document.getElementById('light').style.display = 'block';
                document.getElementById('fade').style.display = 'block'"/>
       <?php } ?>
<div
<?php
if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
    echo "style='display:none'";
}
?>
    >
        <?php
        $cardDetail = CardGenerated::model()->findAllByAttributes(array(
            'visitor_id' => $model->visitor
        ));
        ?>
</div>
<div class="dropdown">
<?php if (in_array($model->card_type, [CardType::SAME_DAY_VISITOR, CardType::MULTI_DAY_VISITOR, CardType::CONTRACTOR_VISITOR, CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_24HOURS, CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY]) && $model->visit_status ==VisitStatus::ACTIVE): ?>

    <button class="complete btn btn-info printCardBtn dropdown-toggle" style="width:205px !important; margin-top: 4px; margin-right: 80px;" type="button" id="menu1" data-toggle="dropdown">Print Card
        <span class="caret pull-right"></span></button>
    <ul class="dropdown-menu" style="left: 62px;" role="menu" aria-labelledby="menu1">
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 1)) ?>">Print On Standard Printer</a></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 2)) ?>">Print On Card Printer</a></li>
        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 3)) ?>">Rewritable Print Card</a></li>
    </ul>
<?php elseif (in_array($model->card_type, [CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY, CardType::VIC_CARD_24HOURS]) && $model->visit_status == VisitStatus::AUTOCLOSED && $model->finish_date == date('Y-m-d')): ?>
    <button class="complete btn btn-info printCardBtn dropdown-toggle" style="width:205px !important; margin-top: 4px; margin-right: 80px;" type="button" id="menu1" data-toggle="dropdown">Print Card
        <span class="caret pull-right"></span></button>
        <ul class="dropdown-menu" style="left: 62px;" role="menu" aria-labelledby="menu1">
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint', array('id' => $model->id, 'type' => 2)) ?>">Reprint Card</a>
            </li>
        </ul>
<?php else: ?>
    <button class="complete btn btn-info printCardBtn dropdown-toggle" disabled="disabled" style="width:205px !important; margin-top: 4px; margin-right: 80px;" type="button" id="menu1" data-toggle="dropdown">Print Card<span class="caret pull-right"></span>
    </button>
<?php endif; ?>
</div>
<?php if ($model->visit_status != VisitStatus::SAVED): ?>
<div style="margin-top: 10px;margin-right: 69px;">
<?php
$companyName = isset($visitCount['companyName']) ? $visitCount['companyName'] : '';
$totalCompanyVisit = (isset($visitCount['totalVisits']) && !empty($visitCount['totalVisits'])) ? ($visitCount['totalVisits'] < 0) ? 0 : $visitCount['totalVisits'] : '0';
$remainingDays = (isset($visitCount['remainingDays']) && $visitCount['remainingDays'] <= 28) ? ($visitCount['remainingDays'] < 0) ? '0' : $visitCount['remainingDays'] : '28';
?>
    Total Visits at <?php echo $companyName; ?>: <?php echo $totalCompanyVisit; ?></br>
    <!-- Total Visits to All Companies: <?php // echo $visitCount['allVisitsByVisitor'];           ?> -->
    <?php if ($visitorModel->profile_type == Visitor::PROFILE_TYPE_VIC) { ?>
        Remaining Days: <?php echo $remainingDays; ?>
    <?php } ?>
</div>
<input type="hidden" id="dummycardvalue" value="<?php echo $model->card; ?>"/>
<input type="hidden" id="remaining_day" value="<?php echo $remainingDays; ?>">
<?php endif; ?>
<form method="post" id="workstationForm" action="<?php echo Yii::app()->createUrl('visit/detail', array('id' => $model->id)); ?>">
    <div style="margin: 10px 0px 0px 19px; text-align: left;">
        <?php
        if ($asic) {
            array_pop(Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_VIC]);
            echo CHtml::dropDownList('Visitor[visitor_card_status]', $visitorModel->visitor_card_status, Visitor::$VISITOR_CARD_TYPE_LIST[Visitor::PROFILE_TYPE_VIC], ['empty' => 'Select Card Status']);
            echo "<br />";
        }

        $workstationList = CHtml::listData(Utils::populateWorkstation(), 'id', 'name');
        foreach ($workstationList as $key => $item) {
            $workstationResults[$key] = 'Workstation: ' . $item;
        }

        echo CHtml::dropDownList('Visit[workstation]', $model->workstation, $workstationResults, ['empty' => 'Select Workstation']);
        echo "<br />";

        if ($asic) {
            echo CHtml::dropDownList('Visit[visitor_type]', $model->visitor_type, VisitorType::model()->returnVisitorTypes());
            echo "<br />";
            $reasons = CHtml::listData(VisitReason::model()->findAll(), 'id', 'reason');
            foreach ($reasons as $key => $item) {
                $results[$key] = 'Reason: ' . $item;
            }
            echo CHtml::dropDownList('Visit[reason]', $model->reason, $results);
            echo "<br />";
            $cardTypes = CHtml::listData(CardType::model()->findAll(), 'id', 'name');
            foreach ($cardTypes as $key => $item) {
                if (in_array($key, CardType::$CORPORATE_CARD_TYPE_LIST)) {
                    $cardTypeResults[$key] = 'Card Type: ' . $item;
                }
            }
            echo CHtml::dropDownList('Visit[card_type]', $model->card_type, $cardTypeResults);

        }
        ?>
        
    </div>
</form>

<script>
    $(document).ready(function () {
<?php if ($asic) { ?>
            // remove Denied card status
            $("#visitor_card_status option[value='5']").remove();
<?php } ?>

        if (<?php echo $model->visit_status; ?> == '1' && $("#dummycardvalue").val() == '' && '<?php echo $model->card; ?>' != '') { //1 is active
            $('#printCardBtn').disabled = false;

        }
        else if ('<?php echo $model->card; ?>' != '') {
            if (<?php echo $model->visit_status; ?> != '1') {
                $('#printCardBtn').disabled = true;
                $("#printCardBtn").addClass("disabledButton");
            }
        }

        $('#photoCropPreview').imgAreaSelect({
            handles: true,
            onSelectEnd: function (img, selection) {
                $("#cropPhotoBtn").show();
                $("#x1").val(selection.x1);
                $("#x2").val(selection.x2);
                $("#y1").val(selection.y1);
                $("#y2").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });
        $("#cropPhotoBtn").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/AjaxCrop'); ?>',
                data: {
                    x1: $("#x1").val(),
                    x2: $("#x2").val(),
                    y1: $("#y1").val(),
                    y2: $("#y2").val(),
                    width: $("#width").val(),
                    height: $("#height").val(),
                    imageUrl: $('#photoCropPreview').attr('src').substring(1, $('#photoCropPreview').attr('src').length),
                    photoId: $('#Visitor_photo').val()
                },
                dataType: 'json',
                success: function (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function (r) {

                            $.each(r.data, function (index, value) {
                                document.getElementById('photoPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                                document.getElementById('photoCropPreview').src = "<?php echo Yii::app()->request->baseUrl . '/' ?>" + value.relative_path;
                            });
                        }
                    });

                    $("#closeCropPhoto").click();
                    var ias = $('#photoCropPreview').imgAreaSelect({instance: true});
                    ias.cancelSelection();
                }
            });
        });
    });

    function uploadImage() {
        $("#image").click();
        return false;
    }

    function generateCard() {
        //change modal url to pass visit id
        var url = 'index.php?r=cardGenerated/print&id=<?php echo $model->id; ?>';
        window.open(url, '_blank');
    }

    function regenerateCard() {
        //change modal url to pass visit id
        var url = 'index.php?r=cardGenerated/reprint&id=<?php echo $model->id; ?>';
        window.open(url, '_blank');
    }

    function sendPhoto() {

        var form = $("#update-photo-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("/visitor/update&id=" . $visitorModel->id . "&view=1")); ?>",
            data: form,
            success: function (data) {
                $("#photoPreview").show();
            },
        });

    }

    $(document).ready(function () {
        //blink("#printCardBtn", -1, 1000);
    });
    function blink(elem, times, speed) {
        if (times > 0 || times < 0) {
            if ($(elem).hasClass("blink"))
                $(elem).removeClass("blink");
            else
                $(elem).addClass("blink");
        }

        clearTimeout(function () {
            blink(elem, times, speed);
        });

        if (times > 0 || times < 0) {
            setTimeout(function () {
                blink(elem, times, speed);
            }, speed);
            times -= .5;
        }
    }

    function populateVisitWorkstation(value) {
        $("#Visit_workstation").val(value.value);
    }
</script>
<!--POP UP FOR CROP PHOTO -->

<div id="light" class="white_content">
    <img id="photoCropPreview" width="500px" height="500px" src="<?php echo Photo::model()->returnVisitorPhotoRelativePath($model->visitor) ?>">

</div>
<div id="fade" class="black_overlay">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
        <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
</div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>

<input type="hidden" id="visitorOriginalValue" value="<?php echo $visitorModel->photo; ?>"/>
