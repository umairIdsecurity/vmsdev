<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('helpers', 'helpers');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
    array(
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        'name' => 'Visitor Management System v<version_number>',

        // set target language to be Australian
        'language' => 'en-AU',

        // set source language to be Australian
        'sourceLanguage' => 'en-AU',

        // preloading 'log' component
        'preload' => array('log', 'foundation'),
        'theme' => 'bootstrap',
        'modules' => array(
        /* 'gii' => array(
          'generatorPaths' => array(
          'bootstrap.gii',
          ),
          ), */
        ),
        // autoloading model and component classes
        'import' => array(
            'application.models.*',
            'application.components.*',
            'application.components.*',
            'application.extensions.bootstrap.widgets.*',
            'application.service.impl.*',
            'application.service.*',
            'application.helpers.*'
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
                'loginUrl' => array('site/login'),
                'authTimeout' => 1800, // 30 Minutes
            ),
            'bootstrap' => array(
                'class' => 'bootstrap.components.Bootstrap'),
            // uncomment the following to enable URLs in path-format
            'urlManager' => array(
                'urlFormat' => 'path',
                'rules' => array(
                    'authorization/admin'       => 'api/authorization/admin',
                    'companies'                 => 'api/companies/index',
                    'companies/<id:\d+>'        => 'api/companies/index',
                    'admin/<email>'             => 'api/admin/index',
                    'admin/logout/<email>'      => 'api/admin/logout',
                    'host/search'               => "api/host/search",
                    'host/<email>'              => 'api/host/index',
                    'visit'                     => 'api/visit/index',
                    'visit/<visitID:\+d>'       => 'api/visit/index',
                    'visitor'                   => 'api/visitor/index',
                    'visitor/<email>'           => 'api/visitor/index',
                    'visit/<visit>/file/'        => 'api/visit/file',
                    array('api/authorization/preflight', 'pattern'=>'/authorization/preflight', 'verb'=>'OPTIONS'),
                ),
            ),
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
                    ),
                // uncomment the following to show log messages on web pages
                /* array(
                  'class'=>'CWebLogRoute',
                  ), */
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
    ),
    require(dirname(__FILE__).'/environment.php')
);
