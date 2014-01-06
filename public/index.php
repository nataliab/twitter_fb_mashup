<?php
set_include_path ( get_include_path () . PATH_SEPARATOR . __DIR__ . '/../src' );
define ( 'APPLICATION_PATH', realpath ( __DIR__ . '/../' ) );
chdir ( APPLICATION_PATH );


if (is_dir ( __DIR__ . '/vendor/ZendServerGateway' )) {
	$zsModsPath = __DIR__ . '/vendor/';
} elseif (getenv ( 'ZEND_SERVER_MODULES_PATH' )) {
	$zsModsPath = getenv ( 'ZEND_SERVER_MODULES_PATH' );
} elseif (function_exists( 'zend_deployment_library_path' ) && zend_deployment_library_path ( 'Zend Server Gateway' )) {
	$zsModsPath = zend_deployment_library_path ( 'Zend Server Gateway' );
} elseif (get_cfg_var ( 'zend_server_modules_path' )) {
	$zsModsPath = get_cfg_var ( 'zend_server_modules_path' );
}

if (! isset ( $zsModsPath )) {
	header ( 'HTTP/1.0 500 Internal Server Error' );
	echo 'The Zend Server environment was not set up correctly, please ensure ZF2_PATH and ZEND_SERVER_MODULES_PATH are correctly setup.';
	exit ( 1 );
}

require __DIR__ . '/../vendor/autoload.php';

Zend\Loader\AutoloaderFactory::factory ( array (
		'Zend\Loader\StandardAutoloader' => array (
				'autoregister_zf' => true,
				'fallback_autoloader' => true
		)
) );

$appConfig = require 'config/application.config.php';
$appConfig ['module_listener_options'] ['module_paths'] [] = $zsModsPath;

Zend\Mvc\Application::init ( $appConfig )->run ();
