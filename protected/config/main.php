<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('helpers','helpers');


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$result = CMap::mergeArray(
        array(
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
            'name' => 'Visitor Management System v<version_number>',
            // preloading 'log' component
            'preload' => array('log', 'foundation'),
            'theme' => 'bootstrap',

            // set target language to be Australian
            'language' => 'en-AU',
            
            //'timeZone' => date_default_timezone_get(),
            
            // set source language to be Australian
            'sourceLanguage' => 'en-AU',

            'modules' => array(
            'gii' => array(
              'generatorPaths' => array(
              'bootstrap.gii',
              ),
              ),
            ),
            // autoloading model and component classes
            'import' => array(
                'application.models.*',
                'application.components.*',
                'application.components.*',
                'application.extensions.bootstrap.widgets.*',
                'application.service.impl.*',
                'application.service.*',
                'application.helpers.*',
                'application.extensions.*',
                'application.extensions.EHttpClient.*',
                'application.extensions.yii-mail.*',
                'application.models.preregistration.*',
            ),
            'modules' => array(
                // uncomment the following to enable the Gii tool
                'api',
                'gii' => array(
                    'class' => 'system.gii.GiiModule',
                    'password' => '12345',
                    // If removed, Gii defaults to localhost only. Edit carefully to taste.
                    'ipFilters' => array('127.0.0.1', '::1'),
                ),
            ),
            // application components
            'components' => array(
                /* 'session' => array (
                  'class'=> 'CDbHttpSession',
                  'connectionID' => 'db',
                  'sessionTableName' => 'yiisession',
                  'timeout' => 10,
                  'autoStart'=>false
                  ),
                 */
                'mail'=>array(
                    'class' => 'ext.yii-mail.YiiMail',
                    'transportType' => 'smtp',
                    'transportOptions' => array(
                        'host' => 'smtp.gmail.com',
                        'username' => 'vmsnotify@gmail.com',
                        'password' => 'vms12345',
                        'port' => '465',
                        'encryption'=>'tls',
                    ),
                    'viewPath' => 'application.views.mail',
                ),
                'ePdf' => array(
                    'class' => 'ext.yii-pdf.EYiiPdf',
                    'params' => array(
                        'mpdf' => array(
                            'librarySourcePath' => 'application.vendors.mpdf.*',
                            'constants' => array(
                                '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                            ),
                            'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                        /* 'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                          'mode'              => '', //  This parameter specifies the mode of the new document.
                          'format'            => 'A4', // format A4, A5, ...
                          'default_font_size' => 0, // Sets the default document font size in points (pt)
                          'default_font'      => '', // Sets the default font-family for the new document.
                          'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                          'mgr'               => 15, // margin_right
                          'mgt'               => 16, // margin_top
                          'mgb'               => 16, // margin_bottom
                          'mgh'               => 9, // margin_header
                          'mgf'               => 9, // margin_footer
                          'orientation'       => 'P', // landscape or portrait orientation
                          ) */
                        ),
                        'HTML2PDF' => array(
                            'librarySourcePath' => 'application.vendor.html2pdf.*',
                            'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
//                        'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
//                          'orientation' => 'P', // landscape or portrait orientation
//                          'format'      => 'A4', // format A4, A5, ...
//                          'language'    => 'en', // language: fr, en, it ...
//                          'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
//                          'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
//                          'marges'      => array(0, 0, 0, 0), // margins by default, in order (left, top, right, bottom)
//                          ),
                        )
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
                    'loginUrl' => array('site/login'),
                    'authTimeout' => 1800, // 30 Minutes
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
                'db' => array(
                    'connectionString' => 'mysql:host=localhost;dbname=vms',
                    'username' => 'user_vms',
                    'password' => 'HFz7c9dHrmPqwNGr',
                    'charset' => 'utf8',
                    'enableParamLogging' => true,
                    'enableProfiling' => true,
                ),
                'errorHandler' => array(
                    // use 'site/error' action to display errors
                    'errorAction' => 'site/error',
                ),
                'excel' => array(
                    'class' => 'application.extensions.PHPExcel',
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
                            'levels' => 'error, warning',
                            'logFile' => 'trace.log',
                            'categories' => 'system.*'
                        ),
                    // uncomment the following to show log messages on web pages
                      /*array(
                      'class'=>'CWebLogRoute',
                      ),*/
                    ),
                ),
            ),
            // application-level parameters that can be accessed
            // using Yii::app()->params['paramName']
            'params' => array(
                // this is used in contact page
                'photo_unique_filename' => 'test',
                'mandrillApiKey' => '49tRGdzmJDhovnkkygttuQ',
            ),
                ), require(dirname(__FILE__) . '/environment.php')
);

return $result;
