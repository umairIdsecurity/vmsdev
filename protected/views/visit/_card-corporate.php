<?php
$tenant = User::model()->findByPk($visitorModel->created_by);
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

    $companyLogo = Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
    $userPhoto = Photo::model()->returnVisitorPhotoRelativePath($model->visitor);
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

$host = User::model()->findByPk($model->host);

if (isset($host)) {
    $host_first_name = $host->first_name;
    $host_last_name = $host->last_name;
} else {
    $host_first_name = '';
    $host_last_name = '';
}

?>

    <div style="float:left;width:256px; border:1px solid #000; height:410px;">
        <div style="display: inline-flex;">
            <div style="width:150px; height:205px; background:#fff; margin-left:15px; margin-top:13px;"></div>
            <?php if ($model->card_type == CardType::CONTRACTOR_VISITOR) {
                echo "<div style='width: 74px;height: 210px; margin-left: 50px; float: left;font-size: 28px; font-weight: bold;  color: black; margin-top: 17px;transform: rotate(90deg);transform-origin: left top 0;'>CONTRACTOR</div>";
            } else {
                echo "<div style='width: 74px;height: 210px; margin-left: 50px; float: left;font-size: 47px; font-weight: bold;  color: black; margin-top: 23px;transform: rotate(90deg);transform-origin: left top 0;'>VISITOR</div>";
            } ?>

        </div>

        <div style="text-align:left; line-height:20px; margin:10px 0 0 14px; color:#000;">
            <p style="font-size:25px; font-weight:bold; margin:0 0 10px 0;"><?php  echo date('dMy', strtotime($model->date_check_in));?></p>

            <p style="font-size:25px; font-weight:bold; line-height:24.9px; margin:0 0 3px 0;"><?php echo ($visitorModel->first_name != "")?$visitorModel->first_name." ".$visitorModel->last_name:"N/A"?><br>
                <?php echo ($cardCode== "")?"N/A":$cardCode; ?></p></p>
        </div>
        <div style="width:256px; height:48.7px; margin-top:30px; ">
            <div style="width:69px;  height:38px; margin-left:15px; margin-top:2px; display:inline-block;"><img border="0" style="height:34px !important;width: 120px;  margin-left: -35px;
  margin-bottom: 19px;" src="<?= $companyLogo?>"></div>
            <div style="height:38px; margin-left:19px;padding-right:15px;  margin-top:2px;   float: right;   display:inline-block; font-weight:bolder;"><?=$host_first_name?> <br>
                <?=$host_last_name?>
            </div>
        </div>
    <style>
        #photoPreview {
            height: 206px;
            width: 152px;
        }

        .ajax-file-upload {
            position: static;
            margin-left: -150px !important;
            margin-top: 22px !important;
        }

        .editImageBtn {
            margin-top: 4px !important;
        }

        .printCardBtn {
            margin-left: 26px !important;
        }

        #visitorInformationCssMenu {
            height: 868px !important;
        }

    </style>