<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'timeZone' => 'Asia/Calcutta',
    'name' => 'Kpws',
    'theme' => 'rapid_theme',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.views.*',
        'application.extension.*',
        'application.modules.rights.*',
		'application.modules.formbuilder.models.*',
        'application.modules.rights.components.*',
        'application.controllers.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
		'formbuilder',
        'rights' => array(
            'superuserName' => 'Admin', // Name of the role with super user privileges.
            'authenticatedName' => 'Authenticated', // Name of the authenticated user role. 
            'userClass' => 'UserDetails', // Model Name
            'userIdColumn' => 'ud_refid', // Name of the user id column in the database. 
            'userNameColumn' => 'ud_username', // Name of the user name column in the database. 
            'enableBizRule' => true, // Whether to enable authorization item business rules.
            'enableBizRuleData' => false, // Whether to enable data for business rules. 
            'displayDescription' => true, // Whether to use item description instead of name. 
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages. 
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages. 
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested. 
            'layout' => 'rights.views.layouts.main', // Layout to use for displaying Rights. 
            'appLayout' => 'application.views.layouts.main', // Application layout. 
            'cssFile' => 'rights.css', // Style sheet file to use for Rights. 
            'install' => false, // Whether to enable installer. 
            //            'install' => true, // Whether to install rights. 
            'debug' => false, // Whether to enable debug mode. 
        ),
    ),
    // application components
    'components' => array(
        'filerecord'=>array('class'=>'Filerecord'),
		'downloadtemplates'=>array('class'=>'Downloadtemplates'),
        'user' => array(
            'class' => 'RWebUser',
            // enable cookie-based authentication
            'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
            'allowAutoLogin' => true,
            'authTimeout' => 1800,

        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => FALSE,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
            ),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'authitem',
            'itemChildTable' => 'authitemchild',
            'assignmentTable' => 'authassignment',
            'rightsTable' => 'rights',
            'defaultRoles'=>array('Authenticated', 'Guest'),
        ),
        'Audit' => array('class' => 'AuditLog'),
        'localtime' => array(
            'class' => 'LocalTime',
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

        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // use 'site/error' action to display error
            //'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                  array(
                  'class'=>'CWebLogRoute',
                  ),
                 */
            ),
        ),
        'Smtpmail' => array(
            'class' => 'application.extensions.smtpmail.PHPMailer',
            'Host' => 'smtp.rapidcareitservices.com',
            'Mailer' => 'smtp',
            'Sender_name' => 'Kpws',
            'Username' => 'pravinkumars@rapidcareitservices.com',
            'Password' => 'Pravin120993',
//            'Port' => 1025,
            'SMTPAuth' => true,
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'DataFolder_web' => 'http://' . $_SERVER['SERVER_NAME'] . '/perigon/branches/phase1/cdata/',
        'DataFolder' => BASE_PATH . '/cdata/',
        'PhantomPath' => BASE_PATH . '/protected/extensions/phantomjs/bin/phantomjs.exe ',
        'Pagination' => array('1' => '1', '5' => '5', '10' => '10', '20' => '20', '50' => '50', '100' => '100'),
        'dateformat'=>array("YYYY-MM-DD","MMM	dd,	YYYY","dd-MMM-YY","MMDDYYYY","MMDDYY","DDMMYYYY","DDMMYY",
            "yy mm dd","yyyy mm dd","dd mmm yy","DDD, MMM DD, YYYY","MM/DD/YYYY","MM-DD-YYYY","MM.DD.YYYY","MM/DD/YY",
            "MM-DD-YY","MM.DD.YY","DD/MM/YYYY","DD-MM-YYYY","DD.MM.YYYY","DD/MM/YY","DD-MM-YY","DD.MM.YY"),
        //'sessionTimeoutSeconds'=>10,
    ),
);
