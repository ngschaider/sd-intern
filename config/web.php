<?php

use kartik\datecontrol\Module;
use kartik\widgets\DateTimePicker;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
	'id' => 'sd-intern',
	"name" => "S&D - Management",
	"layout" => "default",
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm' => '@vendor/npm-asset',
	],
	"modules" => [
		"datecontrol" => [
			"class" => "\kartik\datecontrol\Module",
			"displaySettings" => [
				Module::FORMAT_DATE => "php:d.m.Y",
				Module::FORMAT_TIME => "php:H:i",
				Module::FORMAT_DATETIME => "php:d.m.Y H:i",
			],
			"saveSettings" => [
				Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
				Module::FORMAT_TIME => 'php:H:i:s',
				Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
			],

			'displayTimezone' => 'Asia/Kolkata',
			'saveTimezone' => 'UTC',

			// automatically use kartik\widgets for each of the above formats
			'autoWidget' => true,

			// default settings for each widget from kartik\widgets used when autoWidget is true
			'autoWidgetSettings' => [
				Module::FORMAT_DATE => ['type' => 2, 'pluginOptions' => ['autoclose' => true]], // example
				Module::FORMAT_DATETIME => ['type' => 2, 'pluginOptions' => ['autoclose' => true]], // setup if needed
				Module::FORMAT_TIME => ['type' => 2, 'pluginOptions' => ['autoclose' => true]], // setup if needed
			],

			"ajaxConversion" => true,
		],
	],
	'components' => [
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => '72noQmoUsyLOnK3YNFnA8U2XAUvczYRQ',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => $db,
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
	],
	'params' => $params,
];

if(YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ["*"],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ["*"],
	];
}

return $config;
