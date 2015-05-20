<?php
$session = new CHttpSession;

$session['count'] = 1;
date_default_timezone_set('Asia/Manila');
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

<div class="cardPhotoPreview" style="height:0px;">
    <?php if ($visitorModel->photo != '') { ?>
        <img id="photoPreview" style="height:165px;" src="<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($model->visitor) ?>">
    <?php } else { ?>
        <img id="photoPreview" src="" style="display:none;height:165px;"></img>
    <?php } ?>
</div>
<div id="cardDiv" style="background-size:220px 310px; height:305px;">

    <div style="position: relative; padding-top:180px;padding-left:30px;">
        <?php
        if ($tenant->company != '') {
            $companyLogoId = Company::model()->findByPk($tenant->company)->logo;

            if ($companyLogoId == "") {
                $companyLogo = Yii::app()->controller->assetsBase . "/" . 'images/companylogohere.png';
            } else {
                $companyLogo = Yii::app()->request->baseUrl . "/" . Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
            }
            ?>
            <img class='<?php
            if ($model->visit_status != VisitStatus::ACTIVE) {
                echo "cardCompanyLogoPreregistered";
            } else {
                echo "cardCompanyLogo";
            }
            ?>' src="<?php
                 echo $companyLogo;
                 ?>" style="<?php
                 if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false) {
                     ?>margin-left:42px;<?php
                 }
                 ?>"/>
                 <?php
             }
             ?>
        <table class="" style="width:100%;margin-left:100px;" id="cardDetailsTable">
            <tr>
                <td>
                    <?php
                    if ($tenant->company != '') {
                        echo Company::model()->findByPk($tenant->company)->code;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><span class="cardDateText"><?php
                        if ($model->card_type == CardType::SAME_DAY_VISITOR) {
                            if ($model->date_check_out == '') {
                                $date1 = date('d M y');
                                echo date("d M y", strtotime($date1));
                            } else {
                                // echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                                echo date("d M y", strtotime($model->date_check_out));
                            }
                        } else {
                            if ($model->date_check_out == '') {
                                $date2 = date('d M y');
                                echo date("d M y", strtotime($date2 . ' + 1 day'));
                            } else {
                                // echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                                echo date("d M y", strtotime($model->date_check_out . ' + 1 day'));
                            }
                        }
                        ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:132px">
                        <?php
                            if (strlen($visitorModel->first_name . ' ' . $visitorModel->last_name) > 48) {
                                $first_name = explode(' ', $visitorModel->first_name);
                                $last_name = explode(' ', $visitorModel->last_name);
                                echo $first_name[0] . ' ' . $last_name[0];
                            } else {
                                echo $visitorModel->first_name . ' ' . $visitorModel->last_name;
                            } ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="<?php
                    if ($model->visit_status != VisitStatus::ACTIVE) {
                        echo 'display:none;';
                    }
                    ?>">
                              <?php
                              if($model->card !=''){
                                  echo CardGenerated::model()->findByPk($model->card)->card_number;
                              }
                              ?>
                    </span>
                </td>
            </tr>
        </table>


    </div>

</div>
<?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
<?php if ($visitorModel->photo != '') { ?>
    <input type="button" class="btn editImageBtn actionForward" id="editImageBtn" value="Edit Photo" onclick = "document.getElementById('light').style.display = 'block';
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
        <button class="complete btn btn-info printCardBtn dropdown-toggle" style="width:205px !important" type="button" id="menu1" data-toggle="dropdown">Print Card
    <span class="caret pull-right"></span></button>
        <ul class="dropdown-menu" style="left: 62px;" role="menu" aria-labelledby="menu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint',array('id'=>$model->id,'type'=>1)) ?>">Print On Standard Printer</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint',array('id'=>$model->id,'type'=>2)) ?>">Print On Card Printer</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo yii::app()->createAbsoluteUrl('cardGenerated/pdfprint',array('id'=>$model->id,'type'=>3)) ?>">Rewritable Print Card</a></li>
    </ul>
  </div>
    
<div>
       Total Visits at <?php echo $visitModel['companyName']; ?>: <?php echo $visitModel['companyVisitsByVisitor']; ?></br>
       <!-- Total Visits to All Companies: <?php // echo $visitModel['allVisitsByVisitor']; ?> -->
</div>
<input type="hidden" id="dummycardvalue" value="<?php echo $model->card; ?>"/>

<form method="post" id="workstationForm">
<div style="margin: 10px 0px 0px 60px; text-align: left;">
    <select id="workstation" onchange="populateVisitWorkstation(this)">
        <?php
        if ($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR) {
            echo '';
        } else {
            echo '<option value="">Select workstation</option>';
        }
        ?>

        <?php
        $workstationList = Utils::populateWorkstation();
        foreach ($workstationList as $key => $value) {
            ?>
            <option value="<?php echo $value->id; ?>" <?php
            if (isset($model->workstation) && $value->id == $model->workstation) {
                echo 'selected';
            }
            ?>><?php echo $value->name; ?></option>
        <?php
        }
        ?>
    </select>
    <br/>
    <input type="submit" class="complete" id="submitWorkStationForm" value="Update">

</div>
</form>

<script>
    $(document).ready(function() {


        if (<?php echo $model->visit_status; ?> == '1' && $("#dummycardvalue").val() == '' && '<?php echo $model->card; ?>' != '') { //1 is active
            document.getElementById('printCardBtn').disabled = false;

        }
        else if ('<?php echo $model->card; ?>' != ''){
            if (<?php echo $model->visit_status; ?> != '1') {
                document.getElementById('printCardBtn').disabled = true;
                $("#printCardBtn").addClass("disabledButton");
            }
        }

        $('#photoCropPreview').imgAreaSelect({
            handles: true,
            onSelectEnd: function(img, selection) {
                $("#cropPhotoBtn").show();
                $("#x1").val(selection.x1);
                $("#x2").val(selection.x2);
                $("#y1").val(selection.y1);
                $("#y2").val(selection.y2);
                $("#width").val(selection.width);
                $("#height").val(selection.height);
            }
        });
        $("#cropPhotoBtn").click(function(e) {
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
                success: function(r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl('photo/GetPathOfCompanyLogo&id='); ?>' + $('#Visitor_photo').val(),
                        dataType: 'json',
                        success: function(r) {

                            $.each(r.data, function(index, value) {
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
            success: function(data) {
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

</script>
<!--POP UP FOR CROP PHOTO -->

<div id="light" class="white_content">
    <div style="text-align:right;">
        <input type="button" class="btn btn-success" id="cropPhotoBtn" value="Crop" style="">
        <input type="button" id="closeCropPhoto" onclick="document.getElementById('light').style.display = 'none';
                document.getElementById('fade').style.display = 'none'" value="x" class="btn btn-danger">
    </div>
    <br>
    <img id="photoCropPreview" src="<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($model->visitor) ?>">

</div>
<div id="fade" class="black_overlay"></div>

<input type="hidden" id="x1"/>
<input type="hidden" id="x2"/>
<input type="hidden" id="y1"/>
<input type="hidden" id="y2"/>
<input type="hidden" id="width"/>
<input type="hidden" id="height"/>

<input type="hidden" id="visitorOriginalValue" value="<?php echo $visitorModel->photo; ?>"/>
