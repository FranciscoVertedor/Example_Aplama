<?php

// uncomment the following to define a path alias
 Yii::setPathOfAlias('bootstrap',dirname(__FILE__).'/../extensions/bootstrap');
 Yii::setPathOfAlias('bootstrap',dirname(__FILE__).'/../extensions/yiiwheels');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
        'language'=>'es',
        'sourceLanguage'=>'es',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Aplama',
        'theme'=>'bootstrap',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
                'application.components.*',
                'bootstrap.helpers.*',
                'bootstrap.behaviors.*',
                'bootstrap.components.*',
                'bootstrap1.helpers.*',
                'bootstrap1.behaviors.*',
                'bootstrap1.components.*',
                'application.extensions.easyimage.EasyImage',
            ),
        'aliases' => array(
            'xupload'=>'application.extensions.xupload',
            'bootstrap'=>'application.extensions.bootstrap',
            'bootstrap1'=>'application.extensions.bootstrap1',
            'yiiwheels'=>'application.extensions.yiiwheels',
            
        ),
	'modules'=>array(
                'ycm'=>array(
                    'username'=>'francis',
                    'password'=>'francis',
                    'registerModels'=>array(
                        //'application.models.Blog', // one model
                        'application.models.*', // all models in folder
                    ),
                    'uploadCreate'=>true, // create upload folder automatically
                    'redactorUpload'=>true, // enable Redactor image upload
                    'analytics'=>array(
                        'trackingId'=>'',
                        'profileId'=>,
                        'accessToken'=>'{"access_token":"","token_type":"Bearer","expires_in":3600,"refresh_token":"","created":1400285762}',
                    ),
                ),
            'admin',
		// uncomment the following to enable the Gii tool
                /*'gii' => array(
                    'generatorPaths' => array('bootstrap.gii'),
                ),*/
                /*'gii'=>array(
                    'generatorPaths'=>array(
                         'bootstrap.gii',
                 ),
                ),*/
                 
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'AplamajuradO14-15',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),*/
             
		
	),

	// application components
	'components'=>array(
		'user'=>array( 
                            'allowAutoLogin'=>true, 
                    //array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
                ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'Eventos'=>'eventos/index',
				/*'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',*/
			),
		),
                
                'bootstrap'=>array(
                    'class'=>'application.extensions.bootstrap.components.TbApi'
                ),
                'bootstrap1'=>array(
                    'class'=>'application.extensions.bootstrap1.components.Bootstrap'
                ),
                'yiiwheels'=>array(
                    'class'=>'application.extensions.yiiwheels.YiiWheels'
                ),
                'easyImage' => array(
                    'class' => 'application.extensions.easyimage.EasyImage',
                 ),
                'swiftMailer' => array(
                    'class' => 'application.extensions.swiftMailer.SwiftMailer',
                ),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		'db'=>array(
                    /*'class'=>'system.db.CDbConnection',
                    'connectionString'=>'mysql:;dbname=',
                    'username'=>'',
                    'password'=>'',*/
                   'class'=>'system.db.CDbConnection',
		   'connectionString'=>'mysql:host=localhost;dbname=',
		   'username'=>'root',
		   'password'=>'',
                   'charset'=>'utf8',

		),

		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
                'uploads'=>'/uploads',
                'thumbSize'=>'80',
		'adminEmail'=>'@gmail.com',
	),

);
