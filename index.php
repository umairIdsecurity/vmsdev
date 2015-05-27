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

# if we've found a environment config file then use the values
if(file_exists(dirname(__FILE__).'/protected/config/environment.php')) {

    $environment_config=require(dirname(__FILE__).'/protected/config/environment.php');

    $config['components']['db']['connectionString'] = $environment_config['db']['connectionString'];
    $config['components']['db']['username'] = $environment_config['db']['username'];
    $config['components']['db']['password'] = $environment_config['db']['password'];
    $config['name'] = $environment_config['name'];


}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);



Yii::createWebApplication($config)->run();
