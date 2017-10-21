<?php
$tenant = Company::model()->findByPk(Yii::app()->user->tenant);
if ($tenant) {
    //$company = Company::model()->findByPk($tenant->company);
    $company = $tenant;
    if ($company) {
        $companyName = $company->name;
        $companyLogoId = $company->logo;
        $companyCode = $company->code;
    } else {
        $companyName = "N/A";
        $companyLogoId = "N/A";
        $companyCode = "N/A";
    }

    // $companyLogo = Photo::model()->returnCompanyPhotoRelativePath($tenant->company);
    //$userPhoto = Photo::model()->returnVisitorPhotoRelativePath($visitor->id);

    $id = @is_null($company->logo)?1:$company->logo;

    $photo = Photo::model()->findByPk($id);
    if( $id == 1  || !is_object($photo) || is_null($photo->db_image)){
        $companyLogo = Yii::app()->controller->assetsBase . '/images/companylogohere1.png';
    } else {
         $companyLogo = 'data:image/'.pathinfo($photo->filename, PATHINFO_EXTENSION).';base64,'.$photo->db_image;
    }
} else {
    throw new CHttpException(404, 'Company not found for this User...');
}
?>
<?php 
 

?>

    <div class="corporate-card">
        <div class="card-header">
            <div class="box-visitor-image"></div>
        </div>

        <div class="card-container">
            <p class="date-check-in"><?php  //echo date('dMy', strtotime($model->date_check_in));?></p>
            <?php 
                // echo "<pre>";
                // print_r($min);
                // echo "</pre>";
                // Yii::app()->end();
                $temp = new DateTime('3000-12-12'); 
            ?>
            <!--<p class="card-info"><?php //echo ($visitor->first_name != "")?$visitor->first_name." ".$visitor->last_name:"N/A"?><br>-->
            <span class="tenant-code"><?php echo ($companyCode != "")?$companyCode:"N/A"?></span><br>
            <?php //if(!empty($expiry_date)){?> 
                <?php if($min == $temp) :?>
                <span class="card-info induction-card" >I</span>
                <span class="card-info">N/A</span><br>
            <?php endif;?>
            <?php if($min != $temp) :?>
                <?php  $expiry_date = strtotime($min); ?>
                <span class="card-info induction-card" style="margin-left:5px; margin-right:99px;" >I</span>
                <span class="nearest" style="margin-left:-78px;"><?php echo date('d', $expiry_date); ?>&nbsp;</span>
                <span class="nearest"><?php echo date('M', $expiry_date); ?>&nbsp;</span>
                <span class="nearest"><?php echo date('y', $expiry_date); ?></span><br/> 
            <?php endif; ?>    
            <?php //}?> 
            <span class="card-info name"><?php echo ($visitor->first_name != "")?$visitor->first_name:"N/A"?></span><br>
            <span class="card-info name"><?php echo ($visitor->last_name != "")?$visitor->last_name:"N/A"?></span><br>			 
            <span class="card-info name"><?php echo ($visitor->card_number != "")?$companyCode.' '.$visitor->card_number:"N/A"?></span><br>
                        
        </div>
        <div class="card-footer">
            <div class="logo-company"><img src="<?= $companyLogo?>"></div>
            <div class="full-name" style="word-break: break-word;width: 118px;overflow: hidden;">
                <div class="first-name"><?//=$host_first_name?></div>
                <div class="last-name"><?//=$host_last_name?></div>
				
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

        .nearest {
            font-size: 30px; 
            margin-top: -20px;
            text-transform: uppercase;
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
        .card-container {
            font-size:25px;
            font-weight:bold;
            line-height:24.9px;
            margin:0 0 3px 0;
        }
        .card-info {
            text-align:center; 
            line-height:20px; 
             margin:10px 0 0 5px; 
             color:#000;
             font-size: 25px;
        }
        
        .box-visitor-image {
            width:152px;
            height:206px;
            background:#fff;
           /*border: 1px solid #000000;*/
            margin-left:13px;
            margin-top:12px;
        }

        .induction-card {
            font-size: 40px; 
            margin-left: -79px;
            margin-right: 63px;
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

        .name {
            font-size: 16px
        }

        .card-container {
            text-align:center; 
            line-height:20px;  
             color:#000;
             font-size: 16px;

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

        .expiry_date {
            font-size: 30px; 
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
            margin-left: 20px !important;
        }
        #visitorDetailDiv .ajax-file-upload-error {
            margin:0 0 0 31px !important;
            position: relative !important;
        }
        #visitorDetailDiv .editImageBtn {
            float: left;
            margin-left: 20px !important;
            position: relative;
            z-index: 1;
        }
        #Visitor_photo_em.errorMessage {
            width: 260px !important;
        }
		
		
    </style>