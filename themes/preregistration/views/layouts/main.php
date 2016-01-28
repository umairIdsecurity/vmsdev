<?php
$session = new CHttpSession;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="" />
    <meta name="description" content="description" />
    <meta name="keywords" content="keywords"/>
    <link rel="shortcut icon" href="<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-dashboard.png" type="image/x-icon"/>

    <style type="text/css">
.top_nav
{
    float: right;
    /*margin-right: -27px !important;*/
    margin-top: -53px !important;
}
.top_nav ul
{
    list-style:none;
    float:right;
    margin: 0;
    padding: 0;
}
.top_nav ul li
{
    float:left;
    color:#000;
    font-size:14px;
    padding:0 3px;
}
.top_nav ul li:last-child
{
    border-right:none;
}

.top_nav ul li img
{
    float:left;
    width:14px;
}
.top_nav ul li a
{
    text-decoration:none;
    color:#000;
}
.top_nav ul li a:hover
{
    color:#9BD62C;
}

.top_nav .profile{
    padding: 0 ;
}


.open-folder a span{
    height: 38px;
    line-height: 38px;
    display: block;
    padding: 0 10px;
    color: #666666;
}
.glyphicons-folder-open:before {
    content: "\e118";
    font-size: 18px;
    vertical-align: sub;
}

.glyphicons-refresh:before {
    content: "\e031";
    font-size: 18px;
    vertical-align: sub;
}

.top_nav .profile a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-profile.png') no-repeat center center;
    text-indent: -9999px;
}

.top_nav .notifications a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-notifications.png') no-repeat center center;

}
.notifications .notification-count {
     padding:0px 6px;
     float:right;
     border:1px solid red;
     border-radius: 10px;
     background: red;
     font-size:10px;
     color:#fff !important;

}
.top_nav .support a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-support.png') no-repeat center center;
    text-indent: -9999px;
}



.top_nav .help a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-help.png') no-repeat center center;
    text-indent: -9999px;
}

.top_nav .logout a{
    display: block;
    height: 40px;
    width: 40px;
    background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-logout.png') no-repeat center center;
    text-indent: -9999px;
}

.standardLogo 
{
    /*margin: 7px 0 0;*/
    /*padding: 0;*/
    margin-left:50%;margin-top:9%;
    width: 70px;
}

.standardLogo img {
    width: 100%;
}

.mobileLogo{
    display: none;       
}
.mobileLogo img{
    width: 100%; 
}

.group-2{
    padding: 0 0 0 35px !important;
}

.responsiveTitle{
    font-size:28px;
}

.fixedMargin{
    margin-left:209px;
}
@media screen and (min-width: 300px)  and (max-width: 640px) {
    .text-sizeWhere{
        margin-left:10px;
    }
    .fixedMargin{
        margin-left:0;
    }
    .responsiveTitle{
        font-size: 18px;
        line-height: 22px;
    }
    .responsiveH3{
        font-size: 16px;
        line-height: 22px;
    }
    .mobileLogo{
        display: block;
        padding: 15px 0 0 !important;
        width: 75px;
        margin-left: auto;
        margin-right: auto;
    }
    .standardLogo{
        display: none;       
    }
    .tableFont{
        font-size: 10px;
    }
}

@media screen and (min-width: 640px)  and (max-width: 1024px) {
    .responsiveTitle{
        font-size: 21px;
        line-height: 22px;
    }
    .responsiveH3{
        font-size: 19px;
        line-height: 22px;
    }
}

.viewportDiv{
    background: #6cf none repeat scroll 0 0;
    bottom: 20%;
    position: absolute;
    width: 100%;
}


    </style>

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/jquery.min.js" ></script>
    <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/jquery.form.js" ></script>

    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/libs.js"></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <div class="container-fluid" style=" height: 100%;">
            <div class="row"><div class="col-sm-12 col-xs-12">&nbsp;</div></div>
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <!-- ******************************************************************** -->
                    <aside class="top_nav" style="margin-top:0px !important">
                        <ul id="icons">
                            <?php if(is_null(Yii::app()->user->id) || empty(Yii::app()->user->id)) {?>
                                <li class="group-2"><a class="make-underline text-size" style="color:#428BCA;font-weight: bold" href="<?php echo Yii::app()->params['vmsAddress']; ?>">Login to AVMS</a></li>
                                <li class="group-2"><a class="make-underline text-size" style="color:#428BCA;font-weight: bold" href="<?php echo Yii::app()->createUrl('preregistration/registration'); ?>">Create Login</a></li>
                            <?php } ?> 
                            <?php if(!is_null(Yii::app()->user->id) && !empty(Yii::app()->user->id)) {?>
                                    <li class="profile">
                                        <a title="profile" href="<?php echo Yii::app()->createUrl('preregistration/profile?id=' . $session['id']); ?>">
                                            My Profile
                                        </a>
                                    </li>
                                    <li class="notifications dropdown">
                                        <a title="notifications" href="<?php echo Yii::app()->createUrl('preregistration/notifications'); ?>" class="dropdown-toggle" data-toggle="dropdown"> 
                                            <?php $notifications = CHelper::get_unread_visitors_notifications();
                                               if($notifications) 
                                                  echo '  <div class="notification-count"> '. count($notifications).'</div>';
                                        ?></a>
                                    </li>
                                    <li class="help">
                                        <a title="help" href="<?php echo Yii::app()->createUrl('preregistration/helpdesk'); ?>">
                                            Help
                                        </a>
                                    </li>
                                    <li class="logout">
                                        <a title="logout" href="<?php echo Yii::app()->createUrl('preregistration/logout'); ?>">
                                            <span class="glyphicon glyphicon-log-out"></span>
                                        </a>
                                    </li>
                            <?php
                                  }
                            ?>
                        </ul>
                    </aside>
                    <!-- ******************************************************************** -->
                </div>
                <div class="col-sm-2"></div>
            </div>

            <div class="row">
                
                <div class="col-sm-2">
                    <div class="standardLogo">
                        <?php if(is_null(Yii::app()->user->id) || empty(Yii::app()->user->id)) {?>
                            <a href="<?php echo Yii::app()->createUrl('preregistration'); ?>">
                        <?php } else{ ?>
                            <a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>">
                        <?php } ?>
                                <?php if(isset($session['tenant'])){
                                    $imageSource = Company::model()->getCurrentTenantImageSource();
                                    ?>
                                    <img src="<?php echo $imageSource ?>" style="width: 70px" alt="Pre registration"/>
                                <?php } else { ?>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" style="width: 60px" alt="Pre registration"/> 
                                <?php } ?>
                            </a>
                    </div>

                    <div class="mobileLogo">
                        <?php if(is_null(Yii::app()->user->id) || empty(Yii::app()->user->id)) {?>
                            <a href="<?php echo Yii::app()->createUrl('preregistration'); ?>">
                        <?php } else{ ?>
                            <a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>">
                        <?php } ?>
                                <?php if(isset($session['tenant'])){?>
                                    <img src="<?php echo $imageSource ?>"  alt="Pre registration"/>
                                <?php } else { ?>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" alt="Pre registration"/> 
                                <?php } ?>
                        </a>
                    </div>

                </div>

                <div class="col-sm-8" style="<?php if(isset($session['stepTitle'])){echo 'border-bottom: 3px solid #eee';}?>">
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <h2 class="text-primary title responsiveTitle"><?= $session['stepTitle'] ?></h2>
                            <h6 class="text-primary title">
                                <?php if(isset($session['step1Subtitle'])&&($session['step1Subtitle']!="")){echo $session['step1Subtitle'];}?>
                                <?php if(isset($session['step2Subtitle'])&&($session['step2Subtitle']!="")){echo $session['step2Subtitle'];}?>
                                <?php if(isset($session['step3Subtitle'])&&($session['step3Subtitle']!="")){echo $session['step3Subtitle'];}?>
                                <?php if(isset($session['step4Subtitle'])&&($session['step4Subtitle']!="")){echo $session['step4Subtitle'];}?>
                                <?php if(isset($session['step5Subtitle'])&&($session['step5Subtitle']!="")){echo $session['step5Subtitle'];}?>
                                <?php if(isset($session['step6Subtitle'])&&($session['step6Subtitle']!="")){echo $session['step6Subtitle'];}?>
                                <?php if(isset($session['step7Subtitle'])&&($session['step7Subtitle']!="")){echo $session['step7Subtitle'];}?>
                                <?php if(isset($session['step8Subtitle'])&&($session['step8Subtitle']!="")){echo $session['step8Subtitle'];}?>
                            </h6>
                        </div>

                    </div>    
                </div>

                <div class="col-sm-2"></div>

            </div>    



            <div class="row" style="height:100%;">
                <div class="col-sm-2"></div>
                <div class="col-sm-8"  style="height:100%;">
                    <?php echo $content; ?>
                </div>
                <div class="col-sm-2"></div>
            </div>

            

        </div>

        

        <!-- for developer -->
        <!--<script src="<?php /*echo Yii::app()->theme->baseUrl; */?>/js/libs.js"></script>-->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.download.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/plugins.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"></script>

        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/custom.js"></script>
    </body>
</html>

