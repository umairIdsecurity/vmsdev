<?php

    return array(
        'name' => 'Visitor Management System ',
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
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=vms',
                'username' => 'user_vms',
                'password' => 'HFz7c9dHrmPqwNGr',
            ),
            'mail'=>array(
                'class' => 'ext.yii-mail.YiiMail',
                'transportType' => 'smtp',
                'transportOptions' => array(
                    'host' => 'webcloud49.au.syrahost.com',
                    'username' => "test.mailer@identitysecurity.com.au",
                    'password' =>"~Mailer01",
                    'port' => '465',
                    'encryption'=>'ssl',
                ),
                'viewPath' => 'application.views.mail',
                'logging' => true,
                'dryRun' => false,
            ),
        ),
        'params' => array(
            //'on_premises_airport_code' => 'MBW',
            'vmsAddress' => 'http://vmsdev.identitysecurity.info'
        )
    );
    
 ?>