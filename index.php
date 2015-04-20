<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yii.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

#read in main.php
$config=require(dirname(__FILE__).'/protected/config/main.php');

# if we've found a environment config file then use the values
if(file_exists(dirname(__FILE__).'/protected/config/environment.php')) {

    $environment_config=require(dirname(__FILE__).'/protected/config/environment.php');

    $config['components']['db']['connectionString'] = $environment_config['db']['connectionString'];
    $config['components']['db']['username'] = $environment_config['db']['username'];
    $config['components']['db']['password'] = $environment_config['db']['password'];
    $config['name'] = $environment_config['name'];

    if(in_array($environment_config['environment'],['dev','test'])){
        // remove the following lines when in production mode
        defined('YII_DEBUG') or define('YII_DEBUG',true);

    }

}




Yii::createWebApplication($config)->run();
