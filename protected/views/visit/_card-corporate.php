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

    <div class="corporate-card">
        <div class="card-header">
            <div class="box-visitor-image"></div>
            <?php if ($model->card_type == CardType::CONTRACTOR_VISITOR) {
                echo '<div class="card-text">CONTRACTOR</div>';
            } else {
                echo '<div class="card-text card-text-visitor">VISITOR</div>';
            } ?>
        </div>

        <div class="card-container">
            <p class="date-check-in"><?php  echo date('dMy', strtotime($model->date_check_in));?></p>

            <p class="card-info"><?php echo ($visitorModel->first_name != "")?$visitorModel->first_name." ".$visitorModel->last_name:"N/A"?><br>
                <?php echo ($cardCode== "")?"N/A":$cardCode; ?></p>
        </div>
        <div class="card-footer">
            <div class="logo-company"><img src="<?= $companyLogo?>"></div>
            <div class="full-name">
                <div class="first-name"><?=$host_first_name?></div>
                <div class="last-name"><?=$host_last_name?></div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
    <style>
        .corporate-card {
            width:256px;
            border:1px solid #000;
            height:410px;
            border-radius: 20px;
            box-sizing: border-box;
            position: relative;
        }
        .card-header {
            display: inline-flex;
            height: 236px;
        }
        .card-container {
            text-align:left;
            line-height:20px;
            margin:10px 0 0 14px;
            color:#000;
        }
        .card-container .date-check-in{
            font-size:25px; font-weight:bold; margin:0 0 10px 0;
        }
        .card-container .card-info{
            font-size:25px;
            font-weight:bold;
            line-height:24.9px;
            margin:0 0 3px 0;
        }
        .box-visitor-image {
            width:152px;
            height:206px;
            background:#fff;
            border: 1px solid #000000;
            margin-left:13px;
            margin-top:12px;
        }
        .card-text {
            width: 74px;
            height: 210px;
            margin-left: 50px;
            float: left;
            font-size: 28px;
            font-weight: bold;
            color: black;
            margin-top: 17px;
            transform: rotate(90deg);
            transform-origin: left top 0;
        }

        .card-text.card-text-visitor {
            font-size: 47px;
            margin-top: 23px;
        }
        .card-footer {
            width:254px;
            height:48px;
            position: absolute;
            background-color: #ffffff;
            border-radius: 0 0 20px 20px;
            z-index: 1;
            bottom: 0;
            left: 0;
        }
        .card-footer .logo-company {
            margin:8px 0 0 20px;
            float: left;
            width: 100px;
            text-align: left;
        }
        .card-footer .logo-company img {
            height:34px !important;
            width: auto;
        }
        .card-footer .full-name {
            height:38px;
            padding-right:15px;
            margin-top:2px;
            float: right;
            font-weight:bolder;
        }

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
        #visitorDetailDiv .ajax-upload-dragdrop{
            float: left !important;
            margin: 0 0 10px !important;
            display: block;
        }

        #visitorDetailDiv .ajax-file-upload{
            display: block;
            margin-left: 31px !important;
        }
        #visitorDetailDiv .ajax-file-upload-error {
            margin:0 0 0 31px !important;
            position: relative !important;
        }
        #visitorDetailDiv .editImageBtn {
            float: left;
            margin-left: 31px !important;
            position: relative;
            z-index: 1;
        }
    </style>