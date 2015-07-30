<?php
$session = new CHttpSession;
$company = Company::model()->findByPk($session['tenant']);
if(is_object($company) )
    $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
if(is_object($companyLafPreferences)) { 
?>
.actionForward,.update, #addCompanyLink {	 
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->action_forward_bg_color; ?>), to(<?php echo $companyLafPreferences->action_forward_bg_color2; ?>)) !important;
background: -moz-linear-gradient(center top , <?php echo $companyLafPreferences->action_forward_bg_color; ?>, <?php echo $companyLafPreferences->action_forward_bg_color2; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->action_forward_bg_color; ?>), to(<?php echo $companyLafPreferences->action_forward_bg_color2; ?>)) !important;
background: -ms-linear-gradient(top, <?php echo $companyLafPreferences->action_forward_bg_color; ?>, <?php echo $companyLafPreferences->action_forward_bg_color2; ?>) !important;

border:1px solid <?php echo $companyLafPreferences->action_forward_bg_color2; ?> !important;
color:<?php echo $companyLafPreferences->action_forward_font_color; ?> !important;
}
.actionForward:hover,.update:hover, #addCompanyLink:hover{
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->action_forward_hover_color; ?>), to(<?php echo $companyLafPreferences->action_forward_hover_color2; ?>)) !important;
background: -moz-linear-gradient(center top , <?php echo $companyLafPreferences->action_forward_hover_color; ?>, <?php echo $companyLafPreferences->action_forward_hover_color2; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->action_forward_hover_color; ?>), to(<?php echo $companyLafPreferences->action_forward_hover_color2; ?>)) !important;
background: -ms-linear-gradient(top, <?php echo $companyLafPreferences->action_forward_hover_color; ?>, <?php echo $companyLafPreferences->action_forward_hover_color2; ?>) !important;
color:<?php echo $companyLafPreferences->action_forward_hover_font_color; ?> !important;
border:1px solid <?php echo $companyLafPreferences->action_forward_hover_color2; ?> !important;
}
/* COMPLETE */
.complete:not([disabled]), .btn-success, #btnSubmit{	 
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->complete_bg_color; ?>), to(<?php echo $companyLafPreferences->complete_bg_color2; ?>)) !important;
background: -moz-linear-gradient(center top , <?php echo $companyLafPreferences->complete_bg_color; ?>, <?php echo $companyLafPreferences->complete_bg_color2; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->complete_bg_color; ?>), to(<?php echo $companyLafPreferences->complete_bg_color2; ?>)) !important;
background: -ms-linear-gradient(top, <?php echo $companyLafPreferences->complete_bg_color; ?>, <?php echo $companyLafPreferences->complete_bg_color2; ?>) !important;
border:1px solid <?php echo $companyLafPreferences->complete_bg_color2; ?> !important;
color:<?php echo $companyLafPreferences->complete_font_color; ?> !important;
}

.complete:hover:not([disabled]), .btn-success:hover, #btnSubmit:hover{
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->complete_hover_color; ?>), to(<?php echo $companyLafPreferences->complete_hover_color2; ?>)) !important;
background: -moz-linear-gradient(center top , <?php echo $companyLafPreferences->complete_hover_color; ?>, <?php echo $companyLafPreferences->complete_hover_color2; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->complete_hover_color; ?>), to(<?php echo $companyLafPreferences->complete_hover_color2; ?>)) !important;
background: -ms-linear-gradient(top, <?php echo $companyLafPreferences->complete_hover_color; ?>, <?php echo $companyLafPreferences->complete_hover_color2; ?>) !important;
color:<?php echo $companyLafPreferences->complete_hover_font_color; ?> !important;
border:1px solid <?php echo $companyLafPreferences->complete_hover_color2; ?> !important;
}

/* NEUTRAL*/

.visitor-findBtn,.delete,.host-findBtn,.neutral{
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->neutral_bg_color; ?>), to(<?php echo $companyLafPreferences->neutral_bg_color2; ?>)) !important;
background: -moz-linear-gradient(center top , <?php echo $companyLafPreferences->neutral_bg_color; ?>, <?php echo $companyLafPreferences->neutral_bg_color2; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->neutral_bg_color; ?>), to(<?php echo $companyLafPreferences->neutral_bg_color2; ?>)) !important;
background: -ms-linear-gradient(top, <?php echo $companyLafPreferences->neutral_bg_color; ?>, <?php echo $companyLafPreferences->neutral_bg_color2; ?>) !important;
border:1px solid <?php echo $companyLafPreferences->neutral_bg_color2; ?>  !important;
color:<?php echo $companyLafPreferences->neutral_font_color; ?> !important;
}

.visitor-findBtn:hover,.delete:hover,.host-findBtn:hover,.neutral:hover{
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->neutral_hover_color; ?>), to(<?php echo $companyLafPreferences->neutral_hover_color2; ?>)) !important;
background: -moz-linear-gradient(center top , <?php echo $companyLafPreferences->neutral_hover_color; ?>, <?php echo $companyLafPreferences->neutral_hover_color2; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
background: -webkit-gradient(linear, center top, center bottom, from(<?php echo $companyLafPreferences->neutral_hover_color; ?>), to(<?php echo $companyLafPreferences->neutral_hover_color2; ?>)) !important;
background: -ms-linear-gradient(top, <?php echo $companyLafPreferences->neutral_hover_color; ?>, <?php echo $companyLafPreferences->neutral_hover_color2; ?>) !important;
color:<?php echo $companyLafPreferences->neutral_hover_font_color; ?> !important;
border: 1px solid <?php echo $companyLafPreferences->neutral_hover_color2; ?>  !important;
}


/* NAVIGATION MENU*/

nav.navigation ul:after,nav.navigation ul {
background-color:<?php echo $companyLafPreferences->nav_bg_color; ?> !important;
}

nav.navigation ul li.active a
{
color:<?php echo $companyLafPreferences->nav_hover_font_color; ?> !important;
background:<?php echo $companyLafPreferences->nav_hover_color; ?> !important;
}

nav.navigation ul li a:hover, nav.navigation ul li.active:hover
{
background:<?php echo $companyLafPreferences->nav_hover_color; ?> !important;
color:<?php echo $companyLafPreferences->nav_hover_font_color; ?> !important;
}

nav.navigation ul li a{
color:<?php echo $companyLafPreferences->nav_font_color; ?> !important;
}

.top_nav ul li a {
color:<?php echo $companyLafPreferences->nav_bg_color; ?> !important;
}

.top_nav ul li a:hover {
color:<?php echo $companyLafPreferences->nav_hover_color; ?> !important;
}
/* SIDE MENU*/


.administrationMenu #cssmenu > ul > li > a { 
background: none repeat scroll 0 0 <?php echo $companyLafPreferences->sidemenu_bg_color; ?> !important;
color:<?php echo $companyLafPreferences->sidemenu_font_color; ?> !important;
}

.administrationMenu #cssmenu > ul > li > a:hover { 
background: none repeat scroll 0 0 <?php echo $companyLafPreferences->sidemenu_hover_color; ?> !important;
color:<?php echo $companyLafPreferences->sidemenu_hover_font_color; ?> !important;
}

/*headers*/

.wrapper h1,.visitor-title,.has-sub-sub span {
color:<?php echo $companyLafPreferences->sidemenu_font_color; ?> !important;
}

/*has sub icon*/
.customIcon-adminmenu{
background-color: <?php echo $companyLafPreferences->sidemenu_font_color; ?> !important;
}

/*PAGER*/

ul.yiiPager .selected a {
background-color:<?php echo $companyLafPreferences->nav_bg_color; ?> !important;
color:<?php echo $companyLafPreferences->nav_font_color; ?> !important;

}
ul.yiiPager a {
color:<?php echo $companyLafPreferences->nav_font_color; ?> !important;
border:<?php echo $companyLafPreferences->nav_font_color; ?> !important;
}

ul.yiiPager a:hover {
background-color:<?php echo $companyLafPreferences->nav_hover_color; ?> !important;
color:<?php echo $companyLafPreferences->nav_hover_font_color; ?> !important;
}

ul.yiiPager a:hover
{
border:solid 1px <?php echo $companyLafPreferences->nav_hover_color; ?> !important;
background-color: <?php echo $companyLafPreferences->nav_hover_color; ?> !important;
color:<?php echo $companyLafPreferences->nav_hover_font_color; ?> !important;
}

ul.yiiPager a:link, ul.yiiPager a:visited {
background-color:<?php echo $companyLafPreferences->nav_bg_color; ?> !important;
border:1px solid <?php echo $companyLafPreferences->nav_bg_color; ?> !important;
}

.pagination ul > li > a:hover,
.pagination ul > li > a:focus,
.pagination ul > .active > a,
.pagination ul > .active > span,
.pager li > a:hover,
.pager li > a:focus {
background-color:<?php echo $companyLafPreferences->nav_hover_color; ?> !important;
color:<?php echo $companyLafPreferences->nav_hover_font_color; ?> !important;
}


ul.yiiPager .selected a {
    background: none repeat scroll 0 0 <?php echo $companyLafPreferences->nav_hover_color; ?> !important;
    color:<?php echo $companyLafPreferences->nav_hover_font_color; ?> !important;
}

/*footer*/


#footer {
    border-top: 1px solid <?php echo $companyLafPreferences->nav_hover_color; ?> !important;
}

.grid-view th a.asc:after {
    border-bottom: 5px solid <?php echo $companyLafPreferences->nav_bg_color; ?> !important;
    }

    /*sort arrows*/
    
.asc div{
    border-color: <?php echo $companyLafPreferences->nav_bg_color; ?> transparent !important;
}

.desc div{
    border-color: <?php echo $companyLafPreferences->nav_bg_color; ?>  rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) !important;
}

.sidebarTitle{
background: none repeat scroll 0 0 <?php echo $companyLafPreferences->sidemenu_bg_color; ?> !important;
}
<?php 
} ?>