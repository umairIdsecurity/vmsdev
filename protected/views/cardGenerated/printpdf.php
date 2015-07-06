<?php
if (array_key_exists($model->card_type, CardType::$CARD_TYPE_LIST)) {
    $cardType = !empty($model->card_type) ? CardType::$CARD_TYPE_LIST[$model->card_type] : NULL;
}

$visitorName = ($visitorModel->first_name) ? $visitorModel->first_name : "" . ' ' . ($visitorModel->last_name) ? $visitorModel->last_name : "";
if (strlen($visitorModel->first_name . ' ' . $visitorModel->last_name) > 32) {
    $first_name = explode(' ', $visitorModel->first_name);
    $last_name = explode(' ', $visitorModel->last_name);
    $visitorName = $first_name[0] . ' ' . $last_name[0];
} else {
    $visitorName = $visitorModel->first_name . ' ' . $visitorModel->last_name;
}

$tenant = User::model()->findByPk($visitorModel->tenant);
if ($tenant) {
    $company = Company::model()->findByPk($tenant->company);
    if ($company) {
        $companyName = $company->name;
        $companyLogoId = $company->logo;
        $companyCode = $company->code;
    } else {
        $companyName = "N/A";
        $companyLogoId = "N/A";
        $companyCode = "N/A";
    }

    $companyLogo =  Photo::model()->getAbsolutePathOfImage(Photo::COMPANY_IMAGE,$tenant->company);
    $userPhoto = Photo::model()->getAbsolutePathOfImage(Photo::VISITOR_IMAGE,$model->visitor);
   
} else {
    throw new CHttpException(404, 'Company not found for this User.');
}
$card = CardGenerated::model()->findByPk($model->card);
if ($card) {
    $cardCode = $card->card_number;
} else {
    $cardCode = '';
    //throw new CHttpException(404, 'Card Number not found for this User.');
}
$visitorName = wordwrap($visitorName, 13, "\n", true);

$dateExpiry = date('dMy');
if ($model->card_type != CardType::SAME_DAY_VISITOR) {
    $dateExpiry = date("dMy", strtotime($model->date_out));
}

if ($model->date_check_out != null) {
    $dateExpiry = date("dMy", strtotime($model->date_check_out));
}

//if ($model->time_check_out && $model->card_type == CardType::VIC_CARD_24HOURS && $model->visit_status == VisitStatus::ACTIVE) {
//$dateExpiry.="<br>" . substr($model->time_check_out, 0, -3);
//}

if ($visitorModel->profile_type === 'CORPORATE') {
    $bgcolor = CardGenerated::CORPORATE_CARD_COLOR;
} elseif ($visitorModel->profile_type === "VIC") {
    $bgcolor = CardGenerated::VIC_CARD_COLOR;
} elseif ($visitorModel->profile_type === "ASIC") {
    $bgcolor = CardGenerated::ASIC_CARD_COLOR;
}
$backText = NULL;
if ($model->card_type != CardType::VIC_CARD_MANUAL) {
    $cardtext = CardType::model()->findByPk($model->card_type);
    if ($cardtext) {
        if ($cardtext->back_text != NULL) {
            $backText = $cardtext->back_text;
        } else {
            $backText = NULL;
        }
    } else {
        $backText = NULL;
    }
}

//die;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
    </head>

    <body style="font-family:Arial, sans-serif;">
        <!--Demo 1 Start-->
        <?php if ($type == 1) { ?>
            <table>
                <tr>
                    <td>
                        <div style="float:left; width:256px; border:1px solid #000; height:405px; border-radius:20px; background:<?= $bgcolor; ?>;">
                            <div style="width:150px; height:200px; background:#fff; margin-left:15px; margin-top:13px;">
                                <img border="0" style="width:150px; height:200px;" src="<?= $userPhoto; ?>">
                            </div>
                            <div style=" text-align:center; line-height:20px;  margin:10px 0 0 5px; color:#000;">
                                <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $companyCode; ?></p>

                                <strong style="font-size: 40px;font-weight: bold; text-align: left; width: 100%; float: left; margin-bottom: 13px; margin-left: 5px; line-height: 32px; margin-top: 3px;">
                                    <span style=" margin-top:-8px; font-size: 60px; vertical-align: top; "><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?></span>
                                    <?= $dateExpiry ?>
                                </strong>
                                <p style="font-size:25px; width:256px; float:left; display: inline-block;  font-weight:bold; line-height:20.9px; margin:5px 0 3px 0;">
                                    <?= strtoupper(($visitorModel->first_name != "") ? $visitorModel->first_name : "N/A") ?><br>
                                    <?= strtoupper(($visitorModel->last_name != "") ? $visitorModel->last_name : "N/A") ?><br>
                                    <?= strtoupper(($cardCode != "") ? $cardCode : "N/A") ?></p>
                            </div>
                            <div style="background:#fff; border-bottom-right-radius: 20px;border-bottom-left-radius: 20px; width:260px; height:48.7px;">
                                <div style="width:69px;  height:30px; margin-left:15px; margin-top:2px; display:inline-block;">
                                    <img border="0" style="height:30x; width:100%;" src="<?= $companyLogo; ?>">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style=" float:left; width:256px; border:1px solid #000; height:410px; border-radius:20px; background:#fff;">
                            <div style="font-size: 20px; padding: 10px; text-align: center;"><?= $backText ?></div>
                        </div>
                    </td>

                </tr>
            </table>
        <?php } else if ($type == 2) {
            ?>
            <div style="width:100%; float:left;">
                <!--Box 1-->
                <div style="float:left; width:256px; border:1px solid #000; height:405px; border-radius:20px; background:<?= $bgcolor; ?>;">
                    <div style="width:100px; height:150px; background:#fff; margin-left:15px; margin-top:13px; border:1px solid #000;">
                        <img border="0" style="width:100px; height:150px;" src="<?= $userPhoto; ?>">
                    </div>
                    <div style=" text-align:center; line-height:20px;  margin:10px 0 0 5px; color:#000;">
                        <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $companyCode; ?></p>

                        <strong style="font-size: 40px;font-weight: bold; text-align: left; width: 100%; float: left; margin-bottom: 13px; margin-left: 5px; line-height: 32px; margin-top: 3px;">
                            <span style=" margin-top:-8px; font-size: 60px; vertical-align: top; "><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?></span>
                            <?= $dateExpiry ?>
                        </strong>
                        <p style="font-size:25px; width:256px; float:left; display: inline-block;  font-weight:bold; line-height:20.9px; margin:5px 0 3px 0;">
                            <?= strtoupper(($visitorModel->first_name != "") ? $visitorModel->first_name : "N/A") ?><br>
                            <?= strtoupper(($visitorModel->last_name != "") ? $visitorModel->last_name : "N/A") ?><br>
                            <?= strtoupper(($cardCode != "") ? $cardCode : "N/A") ?></p>
                    </div>
                    <div style="background:#fff; border-bottom-right-radius: 20px;border-bottom-left-radius: 20px; width:260px; height:48.7px;">
                        <div style="width:69px;  height:30px; margin-left:15px; margin-top:2px; display:inline-block; border:1px solid #000;">
                            <img border="1" style="height:30x; width:100%;" src="<?= $companyLogo; ?>">
                        </div>
                    </div>
                </div>
                <!--Box 2-->
                <div style=" float:left; width:256px; border:1px solid #000; height:410px; border-radius:20px; background:#fff;">
                    <div style="font-size: 20px; padding: 10px; text-align: center;"><?= $backText ?></div>
                </div>
            </div>
            <?php
        } elseif ($type == 3) {?>
             <div style="width:100%; float:left;">
                <!--Box 1-->
                <div style="float:left; width:256px; border:1px solid #000; height:405px; border-radius:20px;">
                    <div style="width:150px; height:200px; background:#fff; margin-left:15px; margin-top:13px; border:1px solid #000;">
                        <img border="0" style="width:150px; height:200px;" src="<?= $userPhoto; ?>">
                    </div>
                    <div style=" text-align:center; line-height:20px;  margin:10px 0 0 5px; color:#000;">
                        <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $companyCode; ?></p>

                        <strong style="font-size: 40px;font-weight: bold; text-align: left; width: 100%; float: left; margin-bottom: 13px; margin-left: 5px; line-height: 32px; margin-top: 3px;">
                            <span style=" margin-top:-8px; font-size: 60px; vertical-align: top; "><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?></span>
                            <?= $dateExpiry ?>
                        </strong>
                        <p style="font-size:25px; width:256px; float:left; display: inline-block;  font-weight:bold; line-height:20.9px; margin:5px 0 3px 0;">
                            <?= strtoupper(($visitorModel->first_name != "") ? $visitorModel->first_name : "N/A") ?><br>
                            <?= strtoupper(($visitorModel->last_name != "") ? $visitorModel->last_name : "N/A") ?><br>
                            <?= strtoupper(($cardCode != "") ? $cardCode : "N/A") ?></p>
                    </div>
                    <div style="background:#fff; border-bottom-right-radius: 20px;border-bottom-left-radius: 20px; width:260px; height:48.7px;">
                        <div style="width:69px;  height:30px; margin-left:15px; margin-top:2px; display:inline-block; border:1px solid #000;">
                            <img border="1" style="height:30x; width:100%;" src="<?= $companyLogo; ?>">
                        </div>
                    </div>
                </div>
                <!--Box 2-->
                <div style=" float:left; width:256px; border:1px solid #000; height:410px; border-radius:20px; background:#fff;">
                    <div style="font-size: 20px; padding: 10px; text-align: center;"><?= $backText ?></div>
                </div>
            </div>
        <?php }
        ?>



    </body>
</html>
