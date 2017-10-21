<?php
// if (array_key_exists($model->card_type, CardType::$CARD_TYPE_LIST)) {
//     $cardType = !empty($model->card_type) ? CardType::$CARD_TYPE_LIST[$model->card_type] : NULL;
// }

$visitorName = ($model->first_name) ? $model->first_name : "" . ' ' . ($model->last_name) ? $model->last_name : "";

if (strlen($model->first_name . ' ' . $model->last_name) > 32) {
    $first_name = explode(' ', $model->first_name);
    $last_name = explode(' ', $model->last_name);
    $visitorName = $first_name[0] . ' ' . $last_name[0];
} else {
    $visitorName = $model->first_name . ' ' . $model->last_name;
}

$tenant = Company::model()->findByPk($model->tenant);

if ($tenant) {
    //$company = Company::model()->findByPk($tenant->company);
    $company = $tenant;
    if ($company) {
        $companyName = $company->name;
        $companyLogoId = $company->logo;
        $companyCode = $company->code;
    } else {
        throw new CHttpException(404, 'Company not found for this User.....');
    }
} else {
    throw new CHttpException(404, 'Company not found for this User....');
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

// $a = $model->card;
// $card = CardGenerated::model()->findByPk($model->card);

// if ($card) {
//     $cardCode = $card->card_number;
// } else {
//     $cardCode = '';
//     //throw new CHttpException(404, 'Card Number not found for this User.');
// }
$visitorName = wordwrap($visitorName, 13, "\n", true);



/*
According to Savita
Corporate and Aviation Visitor Management System --- CAVMS-815
All VIC card should display Finish / check out date on the card printing.
*/
//$dateExpiry = date("dMy", strtotime($model->date_check_out));


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



$first_name = $model->first_name != "" ? $model->first_name : "N/A";
$last_name = $model->last_name != "" ? $model->last_name : "N/A";

//$cardCode = $cardCode != "" ? $cardCode : "N/A";

//if ($model->time_check_out && $model->card_type == CardType::VIC_CARD_24HOURS && $model->visit_status == VisitStatus::ACTIVE) {
//$dateExpiry.="<br>" . substr($model->time_check_out, 0, -3);
//}
/**
 * Card Background color based on the visit type
 */
//if($model->card_type > CardType::CONTRACTOR_VISITOR )
   $bgcolor = CardGenerated::CORPORATE_CARD_COLOR;
// else  
//    $bgcolor = CardGenerated::CORPORATE_CARD_COLOR;

$backText = NULL;
//if ($model->card_type != CardType::VIC_CARD_MANUAL && $model->card_type != CardType::VIC_CARD_24HOURS) {
	$Criteria = new CDbCriteria();
	//$Criteria->condition = "card_id=".$model->card_type." and tenant_id=".$model->tenant;
    
    $Criteria->condition = "card_id="." and tenant_id=".$model->tenant;
    //$cardtext = CardType::model()->findByPk($model->card_type);
	// $cardtext= TenantCardType::model()->find($Criteria);
    // if ($cardtext) {
    //     if ($cardtext->back_text != NULL) {
    //         $backText = $cardtext->back_text;
    //     } else {
    //         $backText = NULL;
    //     }
    // } else {
    //     $backText = NULL;
    // }
//}

$labelWidth   = 54.0;
$labelHeight  = 85.5;
$imageWidth   = 31.0;
$imageHeight  = 42.0;
$imagePadLeft = 03.5;
$imagePadTop  = 03.5;
$footerHeight = 08.0;

$labelHeightPx = 415;
$labelWidthPx = 258;

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
        border:1px solid #000;
        border-radius:22px;
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
        /*border:1px solid #000;*/ /*because of https://ids-jira.atlassian.net/browse/CAVMS-779*/

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
        margin:0 0 1px 0;
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
      
        background:#fff;
        border-bottom-right-radius: 22px;
        border-bottom-left-radius: 22px;
        width:<?php echo $labelWidthPx; ?>px;
        height:<?php echo $footerHeightPx; ?>px;
        padding-top: 6px;
        position: absolute;
        bottom:1px; 
		left: 1px;
    }
    .card-footer .img-logo {
       
        width:<?php echo $labelWidthPx-13; ?>px;
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
        width:240px;
        height:<?php echo $labelHeightPx; ?>px;
        border:1px solid #000;
        border-radius:20px;
        background:#fff;
        float: left;
    }

    .card-text-content {
        font-size: 20px;
        
        text-align: center;
    }
    /*because of https://ids-jira.atlassian.net/browse/CAVMS-779*/
    .card-text2 {
        /*width:256px;*/
        /*width:230px;
        height:<?php echo $labelHeightPx; ?>px;
        border:1px solid #000;
        border-radius:20px;
        background:#fff;
        float: left;*/
        width:256px;
        height:<?php echo $labelHeightPx; ?>px;
        border:1px solid #000;
        border-radius:20px;
        background:#fff;
        float: left;
    }
    /*because of https://ids-jira.atlassian.net/browse/CAVMS-779*/
    .card-text-content2 {
        /*font-size: 20px;
        padding: 15px !important;
        text-align: center;*/
        font-size: 20px;
        padding: 10px !important;
        text-align: center;
    }
    .card-style-3  .card-print {
        background-color: #FFFFFF;
    }

    .nearest {
        font-size: 30px; 
        margin-top: -20px;
        text-transform: uppercase;
    }

    .day {
        margin-left: 15px;
    }

    .first-name,
    .last-name {
        margin-top: 0px;
    }

    .card_induction {
        font-size: 40px;
        margin-top: -25px;
        margin-left: -20px;
    }
</style>
<body style="font-family:Arial, sans-serif;">
<div class="card-style-<?=$type?>">
   
        <!--Box 1-->
        <div class="card-print">
            <div class="img-visitor">
								<?php  
                                    if(isset($userPhotoModel->db_image) && !empty($userPhotoModel->db_image))
                                    {
                                        $imageSrc = "data:image/png;base64,".$userPhotoModel->db_image; 
                                        echo '<img src="'.$imageSrc.'"/>';
                                    }
									//  elseif($model->card_type == CardType::VIC_CARD_SAMEDATE ){
                                    //     echo '<div><p style=" text-align:center;font-size:26px;">&nbsp;&nbsp;PHOTO IS NOT REQUIRED</p></div>';
                                    // }
									else
									{
										 $noImage='http://kaley.identitysecurity.info/uploads/induction/portrait_box.png';
										 echo '<img src="'.$noImage.'"/>';
									}
                                    
                                    //echo $userPhoto ? "<img src=\"{$userPhoto}\">":"";
                                ?>
								<div style="position:absolute; margin-left:185px; margin-top:25px;">
								<?php if($model->profile_type=="ASIC") {?>
								<img width="50" height="50" src='http://localhost:8080/vmsdev/uploads/induction/asic-visitor-icon.png' /><br><br>
								<?php } ?>
								<?php if($drugIcon==1) {?>
								<img width="50" height="50" src='http://localhost:8080/vmsdev/uploads/induction/dd.png' /><br><br>
								<?php } ?>
								<?php if($driveIcon==1) {?>
								<img width="50" height="50" src='http://localhost:8080/vmsdev/uploads/induction/asd.png' /><br><br>
								<?php } ?>
								<?php if($airIcon==1) {?>
								<img width="50" height="50" src='http://localhost:8080/vmsdev/uploads/induction/as.png' />
								<?php } ?>
								</div> 
								
            </div>
			
            <div class="card-info">
                <p class="text-cmp"><?= $companyCode; ?></p>
                <p class="card-date-text">
                     <br><span style="font-size:16px; margin-left:53px; margin-top: 4px"></span>
                </p>
                
                <?php 
                    $expiry_date = strtotime($min);
                ?>

                <p class="card-visit-info">
                    <span class="card_induction">I</span>
                    <span class="nearest day"><?php echo date('d', $expiry_date); ?>&nbsp;</span>
                    <span class="nearest month"><?php echo date('M', $expiry_date); ?>&nbsp;</span>
                    <span class="nearest year"><?php echo date('y', $expiry_date) ?></span><br/> 
                    <span class="first-name"><?=$first_name ?></span><br/>
                    <span class="last-name"><?=$last_name ?></span><br/>
                    <span class="card-number"><?php echo $companyCode.' '.$model->card_number ; ?></span> 
					
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
                                        echo '<div class="img-logo"><img src="'.$CompImageSrc1.'"/></div>';
                                    }
                                ?>
            </div>

        </div>
        
   

</div>

</body>
</html>
