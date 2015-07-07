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

$company = Company::model()->findByPk($visitorModel->company);
if ($company) {
    $companyName = $company->name;
    $companyLogoId = $company->logo;
    $companyCode = $company->code;
} else {
    throw new CHttpException(404, 'Company not found for this User.');
}

$companyLogo =  Photo::model()->getAbsolutePathOfImage(Photo::COMPANY_IMAGE, $visitorModel->company);

if ($companyLogo  == Photo::model()->defaultAbsoluteImage() ){
    $companyLogo = null;
}

$userPhoto = Photo::model()->getAbsolutePathOfImage(Photo::VISITOR_IMAGE,$model->visitor);

if ($userPhoto  == Photo::model()->defaultAbsoluteImage() ){
    $userPhoto = null;
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
switch ($model->card_type) {
    case CardType::SAME_DAY_VISITOR:
    case CardType::VIC_CARD_24HOURS:
        $dateExpiry = date("dMy", strtotime($model->date_check_out));
        break;
    default:
        break;
}

$first_name = $visitorModel->first_name != "" ? $visitorModel->first_name : "N/A";
$last_name = $visitorModel->last_name != "" ? $visitorModel->last_name : "N/A";
$cardCode = $cardCode != "" ? $cardCode : "N/A";

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
<style>
    .card-print {
        width:256px;
        border:1px solid #000;
        height:405px;
        border-radius:20px;
        background:<?= $bgcolor; ?>;
        position: relative;
        float: left;
    }

    .card-print .img-visitor {
        width:135px;
        height:180px;
        background:#fff;
        margin-left:15px;
        margin-top:13px;
        border:1px solid #000;
    }
    .card-print .img-visitor img {
        width:135px;
        height:180px;
        border: none;
    }

    .card-date-text {
        font-size: 30px;
        font-weight: bold;
        text-align: left;
        margin-bottom: 8px;
        margin-left: 5px;
        line-height: 32px;
        margin-top: 3px;
    }

    .card-date-text span {
        margin-top:-8px;
        font-size: 60px;
        vertical-align: top;
    }

    .card-info {
        text-align:center; line-height:20px;  margin:10px 0 0 5px; color:#000;
    }

    .card-visit-info {
        font-size:22px;
        width:256px;
        float:left;
        font-weight:bold;
        line-height:24px;
        margin:5px 0 3px 0;
        text-transform: capitalize;
    }
    .card-visit-info .last-name {
        text-transform: uppercase;
    }

    .text-cmp {
        font-size:25px;
        font-weight:bold;
        margin:0 0 10px 0;
    }
    .card-footer{
        background:#fff;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
        width:258px; height:40px;
        padding-top: 8px;
        position: absolute;
        bottom: 1px; left: 1px;
    }
    .card-footer .img-logo {
        width:69px;
        height:30px;
        margin-left:15px;
        margin-top:2px;
        display:inline-block;
    }
    .img-logo img {
        width: auto;
        height: 30px;
    }
    .card-text {
        width:256px;
        border:1px solid #000;
        height:410px;
        border-radius:20px;
        background:#fff;
        float: left;
    }

    .card-text-content {
        font-size: 20px;
        padding: 10px;
        text-align: center;
    }

    .card-style-3  .card-print {
        background-color: #FFFFFF;
    }
</style>
<body style="font-family:Arial, sans-serif;">
<div class="card-style-<?=$type?>">
    <?php
    if($type == 1) {
        ?>
        <table>
            <tbody>
                <tr>
                    <td>
                        <!--Box 1-->
                        <div class="card-print">
                            <div class="img-visitor">
                                <?=$userPhoto ? "<img src=\"{$userPhoto}\">":"";?>
                            </div>
                            <div class="card-info">
                                <p class="text-cmp"><?= $companyCode; ?></p>
                                <p class="card-date-text">
                                    <span><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?> </span><?= $dateExpiry ?>
                                </p>
                                <p class="card-visit-info">
                                    <span class="first-name"><?=$first_name ?></span><br/>
                                    <span class="last-name"><?=$last_name ?></span><br/>
                                    <span class="card-code"><?= $cardCode ?></span>
                                </p>
                            </div>
                            <div class="card-footer">
                                <?php
                                if($companyLogo) {
                                    ?>
                                    <div class="img-logo">
                                        <img src="<?= $companyLogo; ?>">
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <!--Box 2-->
                        <div class="card-text">
                            <div class="card-text-content"><?= $backText ?></div>
                        </div>
                    </td>
                </tr>
            </tbody>

        </table>
    <?php
    } else {
        ?>
        <!--Box 1-->
        <div class="card-print">
            <div class="img-visitor">
                <?=$userPhoto ? "<img src=\"{$userPhoto}\">":"";?>
            </div>
            <div class="card-info">
                <p class="text-cmp"><?= $companyCode; ?></p>
                <p class="card-date-text">
                    <span><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?> </span><?= $dateExpiry ?>
                </p>
                <p class="card-visit-info">
                    <span class="first-name"><?=$first_name ?></span><br/>
                    <span class="last-name"><?=$last_name ?></span><br/>
                    <span class="card-code"><?= $cardCode ?></span>
                </p>
            </div>

            <div class="card-footer">
                <?php
                if($companyLogo) {
                ?>
                    <div class="img-logo">
                        <img src="<?= $companyLogo; ?>">
                    </div>
                <?php
                }
                ?>
            </div>

        </div>
        <!--Box 2-->
        <div class="card-text">
            <div class="card-text-content"><?= $backText ?></div>
        </div>
    <?php
    }
    ?>

</div>

</body>
</html>
