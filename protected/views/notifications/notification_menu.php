<?php 
$session = new CHttpSession;
$company = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}
if (isset($companyLafPreferences) && !empty($companyLafPreferences)) {
?> 
<style>
     .notification-dropdown li > h4 {
     padding: 6px 12px;
     color:#fff;
     background: <?php echo $companyLafPreferences->nav_hover_color;?>;
     margin: 0px !important;
     font-size:15px;
 } 
</style>    
<?php } ?>
<ul class="dropdown-menu notification-dropdown">
    <li> <h4> Notifications </h4></li>
     <?php 
           if($notifications) 
            foreach($notifications as $key => $notify ) {
     ?>   <li><a class="notification-a" href="<?php echo Yii::app()->createUrl("/notifications/view/id/{$notify->id}"); ?>" style="font-weight:bold !important;"> <?php echo substr($notify->subject,0, 35) ?>... 
                <span> <br> <?php echo $notify->notification_type?> <br> <?php echo $notify->date_created?> </span>  
               </a>
          </li>
     <?php  } else { ?>
         <li style="padding:5px 10px !important; color:#ccc"> Nothing New </li>
     <?php } ?>                                                                             
    <li><a class="notification-a" href="<?php echo Yii::app()->createUrl("/notifications/index"); ?>" class="center">View All </a></li>
</ul>