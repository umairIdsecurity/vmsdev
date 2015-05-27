<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);


require_once($yii);

#read in main.php
if (isset($_GET['r']))
    $config = require(dirname(__FILE__) . '/protected/config/main.php');
else
    $config = require(dirname(__FILE__) . '/protected/config/api_main.php');


// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);



Yii::createWebApplication($config)->run();
