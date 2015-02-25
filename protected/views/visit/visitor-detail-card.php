<?php
$session = new CHttpSession;
date_default_timezone_set('Asia/Manila');
$tenant = User::model()->findByPk($visitorModel->tenant);
?>
<?php
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

<div class="cardPhotoPreview">
    <?php if ($visitorModel->photo != '') { ?>
        <img id="photoPreview" style="height:165px;" src="<?php echo Yii::app()->request->baseUrl . "/" . Photo::model()->returnVisitorPhotoRelativePath($model->visitor) ?>">
    <?php } else { ?>
        <img id="photoPreview" src="" style="display:none;height:165px;"></img>
    <?php } ?>
</div>
<div id="cardDiv" style="background: url('../images/cardprint-new.png') no-repeat center top;background-size:220px 310px; height:305px;">

    <div style="position: relative; padding-top:180px;padding-left:30px;">
         <?php
        if ($tenant->company != '') {
            $companyLogoId = Company::model()->findByPk($tenant->company)->logo;

            if ($companyLogoId == "") {
                $companyLogo = 'images/nologoavailable.jpg';
            } else {
                $companyLogo = Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
            }
            ?>
        <img class='<?php if($model->visit_status != VisitStatus::ACTIVE){ echo "cardCompanyLogoPreregistered"; } else { echo "cardCompanyLogo"; } ?>' src="<?php
            echo Yii::app()->request->baseUrl . "/" . $companyLogo;
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

                            if ($model->date_out == '') {
                                $date1 = date('d M y');
                                echo date("d M y", strtotime($date1 . ' + 1 day'));
                                
                            } else {
                                // echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                                echo date("d M y", strtotime($model->date_out));
                            }
                        } else {
                            if ($model->date_out == '') {
                                $date2 = date('d M y');
                                echo date("d M y", strtotime($date2 . ' + 1 day'));
                            } else {
                                // echo Yii::app()->dateFormatter->format("d/MM/y", strtotime($model->date_out));
                                echo date("d M y", strtotime($model->date_out . ' + 1 day'));
                            }
                        }
                        ?></span>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="width:132px">
                    <?php echo $visitorModel->first_name . ' ' . $visitorModel->last_name; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="<?php if($model->visit_status != VisitStatus::ACTIVE){ echo 'display:none;'; }?>">
                    <?php
                    if ($tenant->company != '') {
                        $inc = 6 - (strlen($model->id));
                        $int_code = '';
                        for ($x = 1; $x <= $inc; $x++) {

                            $int_code .= "0";
                        }
                        echo Company::model()->findByPk($tenant->company)->code . $int_code . $model->id;
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
    <input type="button" class="editImageBtn" id="editImageBtn" value="Edit Photo" onclick = "document.getElementById('light').style.display = 'block';
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
        if ($model->card != NULL && $model->visit_status == VisitStatus::ACTIVE) {
            ?><input type="button" class="btn btn-info printCardBtn" value="Re-print Card" id="reprintCardBtn" onclick="regenerateCard()"/><?php
    } else {
        ?>
        <input type="button" class="btn btn-info printCardBtn" value="Print Card" id="printCardBtn" onclick="generateCard()"/>
        <?php
    }
    ?>
</div>
<input type="hidden" id="dummycardvalue" value="<?php echo $model->card; ?>"/>
<script>
    $(document).ready(function() {


        if (<?php echo $model->visit_status; ?> == '1' && $("#dummycardvalue").val() == '') { //1 is active
            document.getElementById('printCardBtn').disabled = false;

        } else if (<?php echo $model->visit_status; ?> != '1') {
            document.getElementById('printCardBtn').disabled = true;
            $("#printCardBtn").addClass("disabledButton");
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
        window.location = "index.php?r=visit/detail&id=<?php echo $_GET['id']; ?>";
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

