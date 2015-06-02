<?php 
$session = new CHttpSession;
$company = Company::model()->findByPk($session['company']);
if (isset($company) && !empty($company)) {
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
}

if (isset($companyLafPreferences)) {
?> 
<style>
    /***** Example custom styling *****/
.myLabel {
    padding: 7px 15px !important;
    color:  <?php echo $companyLafPreferences->neutral_font_color;?> !important;
    border: <?php echo $companyLafPreferences->neutral_bg_color?>;
    border-radius: 4px;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background: <?php echo $companyLafPreferences->neutral_bg_color?> !important;
    display: inline-block;
    }
.myLabel:hover {
    background: <?php echo $companyLafPreferences->neutral_hover_color?> !important;
    color: <?php echo $companyLafPreferences->neutral_hover_font_color?> !important;
}
 
.myLabel :invalid + span {
    color: <?php echo $companyLafPreferences->neutral_font_color;?>;
}
.myLabel :valid + span {
    color: <?php echo $companyLafPreferences->neutral_font_color;?>;
}

.completeButton {
    padding: 7px 15px !important;
    color:  <?php echo $companyLafPreferences->complete_font_color;?> !important;
    border: <?php echo $companyLafPreferences->complete_bg_color?> !important;
    border-radius: 4px;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background: <?php echo $companyLafPreferences->complete_bg_color?> !important;
    display: inline-block;
}
.completeButton:hover {
    background: <?php echo $companyLafPreferences->complete_hover_color?> !important;
    color: <?php echo $companyLafPreferences->complete_hover_font_color?> !important;
}
</style>
<?php } ?>