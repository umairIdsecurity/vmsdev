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

$tenant = User::model()->findByPk($visitorModel->created_by);
if ($tenant) {
    $company = Company::model()->findByPk($tenant->company);
    if ($company) {
        $companyName = $company->name;
        $companyLogoId = $company->logo;
        $companyCode = $company->code;
    } else {
        throw new CHttpException(404, 'Company not found for this User.');
    }
} else {
    throw new CHttpException(404, 'Company not found for this User.');
}
// $company = Company::model()->findByPk($visitorModel->company);
// if ($company) {
//     $companyName = $company->name;
//     $companyLogoId = $company->logo;
//     $companyCode = $company->code;
// } else {
//     throw new CHttpException(404, 'Company not found for this User.');
// }

/*$companyLogo =  Photo::model()->getAbsolutePathOfImage(Photo::COMPANY_IMAGE, $tenant->company);

if ($companyLogo  == Photo::model()->defaultAbsoluteImage() ){
    $companyLogo = null;
}

$userPhoto = Photo::model()->getAbsolutePathOfImage(Photo::VISITOR_IMAGE,$model->visitor);

if ($userPhoto  == Photo::model()->defaultAbsoluteImage() ){
    $userPhoto = null;
}*/
$a = $model->card;
$card = CardGenerated::model()->findByPk($model->card);
if ($card) {
    $cardCode = $card->card_number;
} else {
    $cardCode = '';
    //throw new CHttpException(404, 'Card Number not found for this User.');
}
$visitorName = wordwrap($visitorName, 13, "\n", true);


/*
According to Savita
Corporate and Aviation Visitor Management System --- CAVMS-815
All VIC card should display Finish / check out date on the card printing.
*/
$dateExpiry = date("dMy", strtotime($model->date_check_out));

/*
$dateExpiry = date('dMy');
switch ($model->card_type) {
    case CardType::VIC_CARD_MULTIDAY:
    case CardType::SAME_DAY_VISITOR:
    case CardType::VIC_CARD_24HOURS:
        $dateExpiry = date("dMy", strtotime($model->date_check_out));
        break;
}
*/



$first_name = $visitorModel->first_name != "" ? $visitorModel->first_name : "N/A";
$last_name = $visitorModel->last_name != "" ? $visitorModel->last_name : "N/A";
//$cardCode = $cardCode != "" ? $cardCode : "N/A";

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
$labelWidth   = 54.0;
$labelHeight  = 85.5;
$imageWidth   = 31.0;
$imageHeight  = 42.0;
$imagePadLeft = 03.5;
$imagePadTop  = 03.5;
$footerHeight = 08.0;

$labelHeightPx = 415;
$labelWidthPx = 256;

$imageWidthPx   = ($imageWidth/$labelWidth) * $labelWidthPx;
$imageHeightPx  = ($imageHeight/$labelHeight) * $labelHeightPx;
$imagePadLeftPx = ($imagePadLeft/$labelWidth) * $labelWidthPx;
$imagePadTopPx  = ($imagePadTop/$labelHeight) * $labelHeightPx;
$footerHeightPx = ($footerHeight/$labelHeight) * $labelHeightPx;

$fontScale = 2;


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
        width:<?php echo $labelWidthPx; ?>px;
        height:<?php echo $labelHeightPx; ?>px;
        /*border:1px solid #000;*/
        border-radius:20px;
        background:<?= $bgcolor; ?>;
        position: relative;
        float: left;
    }

    .card-print .img-visitor {
        width:<?php echo $imageWidthPx; ?>px;
        height:<?php echo $imageHeightPx; ?>px;
        background:#fff;
        margin-left:<?php echo $imagePadLeftPx; ?>px;
        margin-top:<?php echo $imagePadTopPx; ?>px;
        border:1px solid #000;

    }
    .card-print .img-visitor img {
        width:<?php echo $imageWidthPx; ?>px;
        height:<?php echo $imageHeightPx; ?>px;
        border: none;
    }

    .card-date-text {
        /*font-size: 30px;
        font-weight: bold;
        text-align: left;
        margin-bottom: 8px;
        margin-left: 5px;
        line-height: 32px;
        margin-top: 3px;*/
        font-size: <?php echo 15*$fontScale ?>px;
        font-weight: bold;
        text-align: left;
        margin-bottom: 0px;
        margin-left: 5px;
        line-height: <?php echo 11*$fontScale ?>px;
        margin-top: 0px;
    }

    .card-date-text span {
        /*margin-top:-8px;
        font-size: 60px;
        vertical-align: top;*/
        margin-top:0px;
        font-size: <?php echo 30*$fontScale ?>px;
        vertical-align: top;
    }

    .card-info {
        text-align:center; line-height:20px;  margin:10px 0 0 5px; color:#000;
    }

    .card-visit-info {
        /*font-size:22px;
        width:256px;
        float:left;
        font-weight:bold;
        line-height:24px;
        margin:5px 0 3px 0;
        text-transform: capitalize;*/
        font-size:<?php echo 10*$fontScale ?>px;
        width:205px;
        float:left;
        font-weight:bold;
        line-height:<?php echo 11*$fontScale ?>px;
        margin:2px 0 1px 0;
        text-transform: capitalize;
    }
    .card-visit-info .last-name {
        text-transform: uppercase;
    }

    .text-cmp {
        /*font-size:25px;
        font-weight:bold;
        margin:0 0 10px 0;*/
        font-size:<?php echo 10*$fontScale ?>px;
        font-weight:bold;
        margin:0;
    }
    .card-footer{
        /*background:#fff;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
        width:258px; height:40px;
        padding-top: 8px;
        position: absolute;
        bottom: 1px; left: 1px;*/
        background:#fff;
        border-bottom-right-radius: 20px;
        border-bottom-left-radius: 20px;
        width:<?php echo $labelWidthPx; ?>px;
        height:<?php echo $footerHeightPx; ?>px;
        padding-top: 6px;
        position: absolute;
        bottom: 1px; left: 1px;
    }
    .card-footer .img-logo {
        /*width:69px;
        height:30px;
        margin-left:15px;
        margin-top:2px;
        display:inline-block;*/
        width:<?php echo $labelWidthPx; ?>px;
        height:<?php echo $footerHeightPx; ?>px;
        margin-left:15px;
        margin-top:2px;
        display:inline-block;
        

    }
    .img-logo img {
        width: auto;
        height: 30px;
    }
    .card-text {
        /*width:256px;*/
        width:205px;
        /*height:405px;*/
        height:325px;
        border:1px solid #000;
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
                                <?php  
                                    if(isset($userPhotoModel->db_image) && !empty($userPhotoModel->db_image))
                                    {
                                        $imageSrc = "data:image/png;base64,".$userPhotoModel->db_image; 
                                        echo '<img src="'.$imageSrc.'"/>';
                                    }
                                    else{
                                        echo '';
                                    }
                                    //echo $userPhoto ? "<img src=\"{$userPhoto}\">":"";
                                ?>
                            </div>
                            <div class="card-info">
                                <p class="text-cmp"><?= $companyCode; ?></p>
                                <p class="card-date-text">
                                    <span><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?> </span><?= $dateExpiry ?>
                                </p>
                                <p class="card-visit-info">
                                    <span class="first-name"><?=$first_name ?></span><br/>
                                    <span class="last-name"><?=$last_name ?></span><br/>
                                    <span class="card-code"><?= $cardCode.XXX ?></span>
                                </p>
                            </div>
                            <div class="card-footer">
                                <?php
                                //if($companyLogo) {
                                ?>
                                    <!-- <div class="img-logo">
                                        <img src="<?php //echo $companyLogo; ?>">
                                    </div> -->
                                <?php
                                //}
                                ?>


                                <?php 
                                    if(isset($companyPhotoModel->db_image) && !empty($companyPhotoModel->db_image))
                                    {
                                        $CompImageSrc1 = "data:image/png;base64,".$companyPhotoModel->db_image;
                                        echo '<div class="img-logo"><img src="'.$CompImageSrc1.'"/></div> ';
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
                <?php  
                                    if(isset($userPhotoModel->db_image) && !empty($userPhotoModel->db_image))
                                    {
                                        $imageSrc = "data:image/png;base64,".$userPhotoModel->db_image; 
                                        echo '<img src="'.$imageSrc.'"/>';
                                    }
                                    else{
                                        echo '';
                                    }
                                    //echo $userPhoto ? "<img src=\"{$userPhoto}\">":"";
                                ?>
            </div>
            <div class="card-info">
                <p class="text-cmp"><?= $companyCode; ?></p>
                <p class="card-date-text">
                    <span><?php echo($model->card_type == CardType::CONTRACTOR_VISITOR) ? 'C' : 'V'; ?> </span><?= $dateExpiry ?>
                     <br><span style="font-size:16px; margin-left:53px; margin-top: 4px"> <?php if($model->card_type == CardType::VIC_CARD_24HOURS && $model->time_check_in != "00:00:00") echo substr($model->time_check_in, 0, 5); ?></span>
                </p>
                <p class="card-visit-info">
                    <span class="first-name"><?=$first_name ?></span><br/>
                    <span class="last-name"><?=$last_name ?></span><br/>
                    <span class="card-code"><?= $cardCode ?></span>
                </p>
            </div>

            <div class="card-footer">
                <?php
                //if($companyLogo) {
                ?>
                    <!-- <div class="img-logo">
                        <img src="<?php //echo $companyLogo; ?>">
                    </div> -->
                <?php
                //}
                ?>

                <?php 
                                    if(isset($companyPhotoModel->db_image) && !empty($companyPhotoModel->db_image))
                                    {
                                        $CompImageSrc1 = "data:image/png;base64,".$companyPhotoModel->db_image;
                                        echo '<div class="img-logo"><img src="'.$CompImageSrc1.'"/></div> ';
                                    }
                                ?>
            </div>

        </div>
        <?php if($backText != ''){ ?>
        <!--Box 2-->
        <div class="card-text">
            <div class="card-text-content"><?= $backText ?></div>
        </div>
        <?php } ?>
    <?php
    }
    ?>

</div>

</body>
</html>
