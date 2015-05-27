<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

$mainConfigArray = include dirname(__FILE__).DIRECTORY_SEPARATOR.'main.php';


return CMap::mergeArray(
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'Cron Application',
        // preloading 'log' component
        'preload' => array('log'),
        'import' => $mainConfigArray['import'],

        // application components
        'components' => array(
            'ePdf' => array(
                'class' => 'ext.yii-pdf.EYiiPdf',
                'params' => array(
                    'HTML2PDF' => array(
                        'librarySourcePath' => 'application.vendor.html2pdf.*',
                        'classFile' => 'html2pdf.class.php',
                    ),
                ),
            ),
            'foundation' => array("class" => "ext.foundation.components.Foundation"),
            'widgetFactory' => array(
                'widgets' => array(
                    'CGridView' => array(
                        'cssFile' => '/css/gridview.css'
                    ),
                ),
            ),
            'user' => array(
                // enable cookie-based authentication
                'allowAutoLogin' => true,
            ),
            'bootstrap' => array(
                'class' => 'bootstrap.components.Bootstrap'),
            // uncomment the following to enable URLs in path-format
            /*
              'urlManager'=>array(
              'urlFormat'=>'path',
              'rules'=>array(
              '<controller:\w+>/<id:\d+>'=>'<controller>/view',
              '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
              '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
              ),
              ),
             */
            'db' => $mainConfigArray['components']['db'],

            'errorHandler' => array(
                // use 'site/error' action to display errors
                'errorAction' => 'site/error',
            ),
            'log' => array(
                'class' => 'CLogRouter',
                'routes' => array(
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'profile,console',
                        'logFile' => 'console.profile_db.log',
                        'categories' => 'system.db.CDbCommand.query'
                    ),
                    array(
                        'class' => 'CFileLogRoute',
                        'levels' => 'trace',
                        'logFile' => 'trace.log',
                        'categories' => 'system.*'
                    )
                        // uncomment the following to show log messages on web pages
                /*
                  array(
                  'class'=>'CWebLogRoute',
                  ), */
                ),
            ),
        ),
    ),
    require(dirname(__FILE__).'/environment.php')
);
