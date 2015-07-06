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
    $cardCode = 'N/A';
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

    $host = User::model()->findByPk($model->host);
    $host_first_name = $host->first_name;
    $host_last_name = $host->last_name;
}
if($model->card_type ==  CardType::CONTRACTOR_VISITOR){
    $vertical_image = "http://".$_SERVER['HTTP_HOST'].Yii::app()->getBaseUrl()."/images/contractor.png";
}else{
    $vertical_image = "http://".$_SERVER['HTTP_HOST'].Yii::app()->getBaseUrl()."/images/visitor.png";
}




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
                <div style="float:left;width:256px; border:1px solid #000; height:410px;">
                    <table>
                        <tr>
                            <td>
                                <div
                                    style="float:left; width:100px; height:133px; background:#fff; margin-left:15px; margin-top:13px;">
                                    <img border="0" style="width:100px; height:133px;"
                                         src="<?=$userPhoto;?>">
                                </div>
                            </td>
                            <td>
                                <div
                                    style="width: 60px; float: right; font-weight:bold;height: 205px;  margin-top: 11px;   margin-left: 11px;">
                                    <img src="<?= $vertical_image?>"></div>
                            </td>
                        </tr>
                    </table>

                    <div style="text-align:left; line-height:20px; margin:10px 0 0 14px; color:#000;">
                        <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $dateExpiry ?></p>

                        <p style="font-size:25px; font-weight:bold; line-height:24.9px; margin:0 0 3px 0;"><?=($visitorModel->first_name)?$visitorModel->first_name:"N/A"?>
                            <?=($visitorModel->last_name)?$visitorModel->last_name:"N/A"?><br>
                            <?=$cardCode?></p>
                    </div>
                    <table style="  margin-top: 25px;padding: 5px;">
                        <tr>
                            <td>
                                <img style="height:35px; width: 130px;"
                                     src="<?=$companyLogo?>">
                            </td>
                            <td>
                                <div
                                    style="height:38px; margin-left:10px; margin-top:2px; font-weight:bold;">
                                    <?=($host_first_name)?$host_first_name:"N/A"?> <br>  <?=($host_last_name)?$host_last_name:"N/A"?>
                                </div>
                            </td>
                        </tr>
                    </table>

                </div>
            </td>
            <td>
                <div style="float:left;width:256px; border:1px solid #000; height:410px;">
                    <div style="font-size: 20px;  margin-top: 12px;  padding: 5px;text-align: center;"><?=$backText?>
                    </div>
                </div>
            </td>

        </tr>
    </table>
<?php } else if ($type == 2) {
    ?>
                <div style="float:left;width:258px; border:1px solid #000; height:415px;">
                    <table>
                        <tr>
                            <td>
                                <div
                                    style="float:left; width:100px; height:133px; background:#fff; margin-left:15px; margin-top:13px;">
                                    <img border="0" style="width:100px; height:133px;"
                                         src="<?=$userPhoto;?>">
                                </div>
                            </td>
                            <td>
                                <div
                                    style="width: 60px; float: right; font-weight:bold;height: 205px;  margin-top: 11px;   margin-left: 11px;">
                                    <img src="<?= $vertical_image?>"></div>
                            </td>
                        </tr>
                    </table>

                    <div style="text-align:left; line-height:20px; margin:10px 0 0 14px; color:#000;">
                        <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $dateExpiry ?></p>

                        <p style="font-size:25px; font-weight:bold; line-height:24.9px; margin:0 0 3px 0;"><?=($visitorModel->first_name)?$visitorModel->first_name:"N/A"?>
                            <?=($visitorModel->last_name)?$visitorModel->last_name:"N/A"?><br>
                            <?=$cardCode?></p>
                    </div>
                    <table style="  margin-top: 22px;padding: 5px;">
                        <tr>
                            <td>
                                <img style="height:35px; width: 130px;"
                                     src="<?=$companyLogo?>">
                            </td>
                            <td>
                                <div
                                    style="height:38px; margin-left:10px; margin-top:2px; font-weight:bold; padding: 5px;">
                                    <?=($host_first_name)?$host_first_name:"N/A"?> <br>  <?=($host_last_name)?$host_last_name:"N/A"?>
                                </div>
                            </td>
                        </tr>
                    </table>

                </div>
                <div style="float:left;width:258px; border:1px solid #000; height:410px;">
                    <div style="font-size: 20px;  margin-top: 12px;  padding: 5px;text-align: center;"><?=$backText?>
                    </div>
                </div>
<?php
} elseif ($type == 3) {?>
    <div style="float:left;width:258px; border:1px solid #000; height:415px;">
        <table>
            <tr>
                <td>
                    <div
                        style="float:left; width:100px; height:133px; background:#fff; margin-left:15px; margin-top:13px;">
                        <img border="0" style="width:100px; height:133px;"
                             src="<?=$userPhoto;?>">
                    </div>
                </td>
                <td>
                    <div
                        style="width: 60px; float: right; font-weight:bold;height: 205px;  margin-top: 11px;   margin-left: 11px;">
                        <img src="<?= $vertical_image?>"></div>
                </td>
            </tr>
        </table>

        <div style="text-align:left; line-height:20px; margin:10px 0 0 14px; color:#000;">
            <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?= $dateExpiry ?></p>

            <p style="font-size:25px; font-weight:bold; line-height:24.9px; margin:0 0 3px 0;"><?=($visitorModel->first_name)?$visitorModel->first_name:"N/A"?>
                <?=($visitorModel->last_name)?$visitorModel->last_name:"N/A"?><br>
                <?=$cardCode?></p>
        </div>
        <table style="  margin-top: 22px;padding: 5px;">
            <tr>
                <td>
                    <img style="height:35px; width: 130px;"
                         src="<?=$companyLogo?>">
                </td>
                <td>
                    <div
                        style="height:38px; margin-left:10px; margin-top:2px; font-weight:bold;">
                        <?=($host_first_name)?$host_first_name:"N/A"?> <br>  <?=($host_last_name)?$host_last_name:"N/A"?>
                    </div>
                </td>
            </tr>
        </table>

    </div>
    <div style="float:left;width:258px; border:1px solid #000; height:410px;">
        <div style="font-size: 20px;  margin-top: 12px;  padding: 5px;text-align: center;"><?=$backText?>
        </div>
    </div>
<?php }
?>



</body>
</html>
