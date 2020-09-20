<?php

// This is the main Web application configuration. Any writable
// application properties can be configured here.
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Ovatu PHP Code Test',

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components' => array(
		'db' => array(
			'connectionString' => 'sqlite:protected/data/beers.db',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'appendParams'=>false,
			'rules'=>array(
				'<_c>/<_a>'=>'<_c>/<_a>',
			),
		),
	),
);
