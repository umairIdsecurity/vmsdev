<?php

    return array(
        'name' => 'Visitor Management System ',
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=vms',
                'username' => 'user_vms',
                'password' => 'HFz7c9dHrmPqwNGr',
            )
        ),
        'params' => array(
            //'on_premises_airport_code' => 'MBW',
            'vmsAddress' => 'https://vmsprdev.identitysecurity.info'
        )
    );
    
 ?>