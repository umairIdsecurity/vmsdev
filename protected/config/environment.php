<?php

if (strpos($_SERVER['SERVER_NAME'],'vmsuitest-win') !== false) {
    return array(
        'name' => 'Visitor Management System ',
        'components' => array(
            'db' => array(
                'connectionString' => 'sqlsrv:Server=WIN-B0G2LAH6145\SQLEXPRESS; Database=vms',
                'username' => 'sa',
                'password' => 'vmsP@sswordroot',
                'class' => 'CDbConnection',
                'charset' => 'utf8'
            )
        )
    );
} else {
    return array(
        'name' => 'Visitor Management System ',
        'components' => array(
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=vms',
                'username' => 'user_vms',
                'password' => 'HFz7c9dHrmPqwNGr',
            )
        )
    );
}
?>
