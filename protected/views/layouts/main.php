<?php
$session = new CHttpSession;
Yii::app()->bootstrap->register();

$cs = Yii::app()->clientScript;

$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.uploadfile.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.form.js');


$user_role = $session['role'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sidebar.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/uploadfile.css" />
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/match.js" ></script>

        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/script-sidebar.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.uploadfile.min.js" ></script>
        <script  src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.form.js" ></script>


        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">
            <?php
            if (isset($_GET['viewFrom'])) {
                $viewFrom = $_GET['viewFrom'];
            } else {
                $viewFrom = '';
            }
            ?>
            <div id="header" <?php
            if ($viewFrom != '' || $this->id == 'userWorkstations') {
                echo "style='display:none'";
            }
            ?>>

                <div id="logo" <?php if ($this->id == "dashboard") {
                     echo "style='padding: 10px 106px !important;'";
                 } ?>><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/ids-logo.png')); ?></div>
                <article class="header_midbox">

                    <aside class="top_nav">
                        <ul id="tabs">
                            <li>
                                <a href="<?php echo Yii::app()->createUrl("/user/profile&id=" . $session['id']); ?>">
                                    <p>My Profile</p>
                                </a>
                            </li>
                            <li><a href="#">
                                    <p>Contact Support</p>
                                </a>
                            </li>
                            <?php
                            echo '<li><a href="' . Yii::app()->createUrl("/site/logout") . '"><p>Log Out</p></a></li>';
                            ?>
                        </ul>
                        <div class="clear"></div>
                        <a href="<?php echo Yii::app()->createUrl("/site/logout"); ?>">
                        </a>
                        <div class="clear"></div>
                    </aside>
                    <div class="clear"></div>
                    <nav class="navigation">
                        <ul id="tabs">
                            <li class="<?php echo ($this->id == "dashboard") ? "active" : "" ?>">
                                <a href="<?php echo Yii::app()->createUrl("/dashboard"); ?>">Dashboard</a>
                            </li>
<?php if ($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_AGENT_ADMIN || $session['role'] == Roles::ROLE_SUPERADMIN) { ?>
                                <li class="<?php echo ($this->id == "user" || $this->id == "visitor" || $this->id == "company" || $this->id == "workstation") ? "active" : "" ?>">
                                    <a href="<?php echo Yii::app()->createUrl("/user/admin"); ?>">Administration</a>
                                </li>
<?php } ?>
                            <li style=' float:right;'>
                                <a style="width:334px !important;text-align:right;">Logged in as <?php echo Yii::app()->user->name . ' - ' . User::model()->getUserRole($user_role); ?></a>
                            </li> 

                        </ul>

                    </nav>

                    <div class="clear"></div>

                </article>
            </div><!-- header -->

            <div class="wrapper" <?php
            if ($viewFrom != '') {
                echo "style='margin-left:180px'";
            }
            ?>>
<?php echo $content; ?>
            </div>
            <div class="clear"></div>
            <br><br>
                    <div id="footer" <?php
                         if ($viewFrom != '' || $this->id == 'userWorkstations') {
                             echo "style='display:none'";
                         }
                         ?>>
                        Copyright &copy; <?php echo date('Y'); ?> by <a href="http://idsecurity.com.au">Identity Security Pty Ltd </a>©.<br/>
                        All Rights Reserved.<br/>

                    </div><!-- footer -->

                    </div><!-- page -->

                    </body>
                    </html>
