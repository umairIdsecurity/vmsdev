<?php
$session = new CHttpSession;
Yii::app()->bootstrap->register();
$cs = Yii::app()->clientScript;

//$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/jquery.uploadfile.min.js');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/jquery.maskedinput.min.js');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/jquery.form.js');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/jquery.imgareaselect.pack.js');
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/MaxLength.min.js');


$userRole = $session['role'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <meta Http-Equiv="Cache-Control" Content="no-cache"/>
        <meta Http-Equiv="Pragma" Content="no-cache"/>
        <meta Http-Equiv="Expires" Content="0"/>
        <meta Http-Equiv="Pragma-directive: no-cache"/>
        <meta Http-Equiv="Cache-directive: no-cache"/>
        <link rel="shortcut icon" href="<?php echo Yii::app()->controller->assetsBase; ?>/images/menu-icons-dashboard.png" type="image/x-icon"/>

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/sidebar.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/uploadfile.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/imgareaselect-default.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->controller->assetsBase; ?>/css/gridview.css" />
        <?php
        //$session['tenant'] = $session['id'];

        $company = Company::model()->findByPk($session['tenant']);

        if (isset($company->company_laf_preferences) && $company->company_laf_preferences != '') {
            $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
            ?>
            <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . $companyLafPreferences->css_file_path; ?>" />-->
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . "/index.php?r=companyLafPreferences/css"; ?>" />

            <?php
        }
        ?>
        <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/jquery.min.js" ></script>
        <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/angular.min.js" ></script>
        <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/match.js" ></script>
        <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/script-sidebar.js" ></script>
        <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/jquery.uploadfile.min.js" ></script>
        <script  src="<?php echo Yii::app()->controller->assetsBase; ?>/js/jquery.form.js" ></script>


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
                           $id = $company->logo;
                            $photo = Photo::model()->findByPk($id);
                            if( $id == 1  || !is_object($photo) || is_null($photo->db_image)){
                                ?><img id='photoPreview' style="height: 65px !important; width:130px !important;" src="<?php echo Yii::app()->controller->assetsBase . '/images/companylogohere1.png'; ?>"/><?php
                            } else {
                                 ?><img id='photoPreview' style="height: 65px;width:130px !important;" src="data:image/<?php echo pathinfo($photo->filename, PATHINFO_EXTENSION); ?>;base64,<?php echo $photo->db_image; ?>"/><?php
                            }?>

                    </div>
                    <aside class="top_nav">
                        <ul id="icons">


                            <li class="profile">
                                <a title="profile" href="<?php echo Yii::app()->createUrl("/user/profile&id=" . $session['id']); ?>">
                                    My Profile
                                </a>
                            </li>

                            <li class="open-folder">
                                <a style="display:block; width: 40px;height: 40px;" title="Upload File" href="<?php echo Yii::app()->createUrl("/uploadFile"); ?>"><span class="glyphicon glyphicons-folder-open"></span></a>
                            </li>

                            <li class="help">
                                <a title="help" href="<?php echo Yii::app()->createUrl("/dashboard/helpdesk"); ?>">
                                    Help
                                </a>
                            </li>

                            <li class="notifications dropdown">
                                <a title="notifications" href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php $notifications = CHelper::get_unread_notifications();
                                       if($notifications) 
                                          echo '  <div class="notification-count"> '. count($notifications).'</div>';
                                ?></a>
                                <?php echo $this->renderPartial("//notifications/notification_menu", array('notifications'=>$notifications), false, false); ?>
                            </li>
 

                            <li class="support"><a title="support" href="<?php echo Yii::app()->createUrl("/dashboard/contactsupport"); ?>">
                                    Contact Support
                                </a>
                            </li>
                            
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
                                } elseif (in_array($session['role'], array(Roles::ROLE_ADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_OPERATOR, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_ISSUING_BODY_ADMIN))) {
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
                                <a href="<?php echo Yii::app()->createUrl("/visit/view"); ?>">Visit History</a>
                            </li>

                            <li class="<?php echo ($session['lastPage'] != 'dashboard' && ($this->action->id == "admin" || ($this->id == 'visit' && $this->action->id != 'view') || $this->id == "user" || $this->id == "visitor" || $this->id == "company" || $this->id == "workstation" || $this->id == "visitReason" || $this->id == "companyLafPreferences")) ? "active" : "" ?>">
                                <?php if (in_array($session['role'], array(Roles::ROLE_ADMIN,Roles::ROLE_AGENT_ADMIN,Roles::ROLE_SUPERADMIN,Roles::ROLE_AGENT_AIRPORT_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN))) {
                                ?>
                                <!--<a href="<?php /*echo Yii::app()->createUrl("/user/admin&vms=".strtolower(CHelper::get_allowed_module())); */?>">Administration</a>-->
                                <a href="<?php echo Yii::app()->createUrl("/user/admin&vms=cvms"); ?>">Administration</a>
                                <?php }else{ ?>
                                    <p style="width:230px;"></p>
                                <?php } ?>
                            </li>

                            <li class="loggedin-as">
                               Logged in as <?php echo User::model()->getUserRole($userRole); ?>
                            </li>

                            <li class="logout">
                                <?php echo '<a href="' . Yii::app()->createUrl("/site/logout") . '">Log Out</a>'; ?>
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
                        <?php echo Yii::app()->name ?> - Copyright &copy; <?php echo date('Y'); ?> by <a href="http://idsecurity.com.au">Identity Security Pty Ltd </a>©.<br/>
                        All Rights Reserved.<br/>

                    </div><!-- footer -->

                    </div><!-- page -->
<div style="display: none;">
<?php
    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
        'name' => 'AutoGenerateJqueryUI'
    ));
?>
</div>
</body>
</html>
