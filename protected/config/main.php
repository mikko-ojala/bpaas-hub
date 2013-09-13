<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'BPaaS-HUB',

	// preloading 'log' component
	'preload'=>array('log', 'bootstrap',),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	        'application.modules.user.models.*',
	        'application.modules.user.components.*',
	        'application.modules.rights.*',
		'application.modules.rights.components.*',			
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'hubadmin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array('bootstrap.gii'),
		),
		'user'=>array(
			'tableUsers' => 'users',
			'tableProfiles' => 'profiles',
			'tableProfileFields' => 'profiles_fields',
			# encrypting method (php hash function)
			'hash' => 'md5',

			# send activation email
			'sendActivationMail' => true,

			# allow access for non-activated users
			'loginNotActiv' => false,
				
				# activate user on registration (only sendActivationMail = false)
			'activeAfterRegister' => false,

			# automatically login from registration
			'autoLogin' => true,

			# registration path
			'registrationUrl' => array('/user/registration'),

			# recovery password path
			'recoveryUrl' => array('/user/recovery'),

			# login form path
			'loginUrl' => array('/user/login'),

			# page after login
			'returnUrl' => array('/user/profile'),

			# page after logout
			'returnLogoutUrl' => array('/user/login'),
		),
		'rights'=>array(
			'install'=>false,
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,	
			'class'=>'RWebUser',
			'loginUrl'=>array('/user/login'),
		),
		'bootstrap'=> array(
			'class' => 'ext.bootstrap.components.Bootstrap',
			'responsiveCss'=>True
		),
		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
			'defaultRoles'=>array('Authenticated', 'Guest'),
		),
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
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bpaashub',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'hubadmin',
			'charset' => 'utf8',
			'enableProfiling' => true,
			'enableParamLogging' => true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		 'log'=>array(
	        'class'=>'CLogRouter',
	        'routes'=>array(            
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error',
						'categories'=>'system.*',
					),				
	            array(
	                'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
	                'ipFilters'=>array('127.0.0.1'),
	            ),
	        ),
	    ),
		/*'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(f

				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',					
				),
				// uncomment the following to show log messages on web pages
				
				/*array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),*/
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'hubadmin@pbaashub.com',
	),
);