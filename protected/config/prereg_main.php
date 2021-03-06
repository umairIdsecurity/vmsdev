<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/4/15
 * Time: 11:40 AM
 */

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
        'theme' => 'preregistration',
        'modules' => array(
            /*'gii' => array(
                'generatorPaths' => array(
                    'bootstrap.gii',
                ),
            ),*/
        ),
        // autoloading model and component classes
        'import' => array(
            'application.models.*',
            'application.components.*',
            'application.components.*',
            'application.extensions.*',
            'application.extensions.bootstrap.widgets.*',
            'application.service.impl.*',
            'application.service.*',
            'application.helpers.*',
            'application.models.preregistration.*',
            'application.extensions.yii-mail.*',
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

            'prereguser' => array(         // Webuser for the admin area (admin)
                'class'             => 'CWebUser',
                'allowAutoLogin' => true,
            ),
            'bootstrap' => array(
                'class' => 'bootstrap.components.Bootstrap'),
            // uncomment the following to enable URLs in path-format

            'urlManager' => array(
                'urlFormat' => 'path',
                'rules' => array(
                    '/<controller:preregistration>/<action:[0-9a-zA-Z_]*>'    =>
                        '<controller>/<action>',
                    //'preregistration/index'       => 'preregistration/index',
                ),
            ),
            'errorHandler' => array(
                // use 'site/error' action to display errors
                'errorAction' => 'preregistration/error',
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
    ),
    require(dirname(__FILE__).'/environment.php')
);
