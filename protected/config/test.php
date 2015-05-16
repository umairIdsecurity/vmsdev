<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),

	array(
        'import' => 'ext.wunit.*',
		'components'=>array(
            'wunit' => array(
                'class' => 'WUnit'
            ),
			/*'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),*/
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
		),
	)
);
