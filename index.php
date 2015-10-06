<?php
#63342888
//set defaul timezone for all website
date_default_timezone_set("Australia/Perth");

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);


require_once($yii);

if( (isset($_SERVER['HTTP_HOST']) && substr($_SERVER['HTTP_HOST'],0,5) =='vmspr' ) ||
    (isset($_SERVER["HTTP_APPLICATION_ENV"]) && $_SERVER["HTTP_APPLICATION_ENV"]=='prereg')
    ){

    $config = require(dirname(__FILE__) . '/protected/config/prereg_main.php');


}
else{

    #read in main.php
    if (isset($_GET['r']))
        $config = require(dirname(__FILE__) . '/protected/config/main.php');
    else
        $config = require(dirname(__FILE__) . '/protected/config/api_main.php');



}


// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//$config = require(dirname(__FILE__) . '/protected/config/prereg_main.php');

Yii::createWebApplication($config)->run();


