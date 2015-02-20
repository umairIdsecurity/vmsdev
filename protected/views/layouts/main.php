<?php
$session = new CHttpSession;
Yii::app()->bootstrap->register();
$cs = Yii::app()->clientScript;

$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.uploadfile.min.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.form.js');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.imgareaselect.pack.js');


$userRole = $session['role'];
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
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/imgareaselect-default.css" />
        <?php
        $company = Company::model()->findByPk($session['company']);


        if ($company->company_laf_preferences != '') {
            $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
            ?>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . $companyLafPreferences->css_file_path; ?>" />

            <?php
        }
        ?>
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
                $isViewedFromModal = $_GET['viewFrom'];
            } else {
                $isViewedFromModal = '';
            }
            ?>
            <div id="header" <?php
            if ($isViewedFromModal != '' || $this->id == 'userWorkstations' || $this->action->id == 'findvisitor' || $this->action->id == 'findhost' || $this->action->id == 'print') {
                echo "style='display:none'";
            }
            ?>>
                <article class="header_midbox">
                    <div id="logo" >
                        <?php
                        if ($company->logo != '') {
                            echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/'.Photo::model()->returnLogoPhotoRelative($company->logo)));
                        } else {
                            echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/companylogohere.png'));
                        }
                        ?>
                    </div>
                    <aside class="top_nav">
                        <ul id="tabs">
                            <li>
                                <a href="<?php echo Yii::app()->createUrl("/user/profile&id=" . $session['id']); ?>">
                                    <p>My Profile</p>
                                </a>
                            </li>
                            <li><a href="<?php echo Yii::app()->createUrl("/dashboard/contactsupport"); ?>">
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
                            <li class="<?php echo ($session['lastPage'] == 'dashboard' || $this->id == "dashboard" || (($session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_AGENT_OPERATOR || $session['role'] == Roles::ROLE_STAFFMEMBER) && ($this->id == "visitor" || $this->action->id == 'evacuationReport'))) ? "active" : "" ?>">
                                <?php
                                if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
                                    ?>
                                    <a href="<?php echo Yii::app()->createUrl("/dashboard/viewmyvisitors"); ?>">Dashboard</a>
                                    <?php
                                } elseif ($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_AGENT_ADMIN) {
                                    ?>
                                    <a href="<?php echo Yii::app()->createUrl("/dashboard/admindashboard"); ?>">Dashboard</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?php echo Yii::app()->createUrl("/dashboard"); ?>">Dashboard</a>
                                    <?php
                                }
                                ?>
                            </li>
                            <li class="<?php echo ($this->action->id == "view" && $this->id == 'visit') ? "active" : "" ?>">
                                <a href="<?php echo Yii::app()->createUrl("/visit/view"); ?>">Visitor Records</a>
                            </li>
<?php if ($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_AGENT_ADMIN || $session['role'] == Roles::ROLE_SUPERADMIN) { ?>
                                <li class="<?php echo ($session['lastPage'] != 'dashboard' && ($this->action->id == "admin" || ($this->id == 'visit' && $this->action->id != 'view') || $this->id == "user" || $this->id == "visitor" || $this->id == "company" || $this->id == "workstation" || $this->id == "visitReason" || $this->id == "companyLafPreferences")) ? "active" : "" ?>">
                                    <a href="<?php echo Yii::app()->createUrl("/user/admin"); ?>">Administration</a>
                                </li>
<?php } ?>
                            <li style=' float:right;'>
                                <a style="width:334px !important;text-align:right;">Logged in as <?php echo Yii::app()->user->name . ' - ' . User::model()->getUserRole($userRole); ?></a>
                            </li> 

                        </ul>

                    </nav>

                    <div class="clear"></div>

                </article>
            </div><!-- header -->

            <div class="wrapper" <?php
            if ($isViewedFromModal != '') {
                echo "style='margin-left:180px'";
            }
            ?>>
<?php echo $content; ?>
            </div>
            <div class="clear"></div>
            <br><br>
                    <div id="footer" <?php
                         if ($isViewedFromModal != '' || $this->id == 'userWorkstations' || $this->action->id == 'findvisitor' || $this->action->id == 'findhost' || $this->action->id == 'print') {
                             echo "style='display:none'";
                         }
                         ?>>
                        Copyright &copy; <?php echo date('Y'); ?> by <a href="http://idsecurity.com.au">Identity Security Pty Ltd </a>©.<br/>
                        All Rights Reserved.<br/>

                    </div><!-- footer -->

                    </div><!-- page -->

                    </body>
                    </html>
