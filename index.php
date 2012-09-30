<?php
// phpinfo();
// die();
// Define Environments
$environments = array(
	'local'       => array('local.'),
	'development' => array('dev.', 'ne3.'),
	'staging'     => array('stage.'),
	'preview'     => array('preview.'),
);

$server_name = $_SERVER['SERVER_NAME'];

foreach($environments AS $key => $envs)
{
	foreach ($envs as $env) 
	{
		if(stristr($server_name, $env))
		{
			define('ENVIRONMENT', $key);
			break;
		}
	}
}

if(!defined('ENVIRONMENT')) define('ENVIRONMENT', 'production');

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'local':
		case 'development':
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
		break;
	
		case 'staging':
		case 'preview':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}

define( 'BASEPATH', dirname($_SERVER['SCRIPT_FILENAME']).'/' );
define( 'APPPATH', BASEPATH.'app/' );
define( 'SYSPATH', APPPATH.'system/' );

define( 'BASEURL', call_user_func(function(){
	$u = isset( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) !== 'off' ? 'https' : 'http';
	$u .= '://'. $_SERVER['HTTP_HOST'];
	$u .= str_replace( basename( $_SERVER['SCRIPT_NAME'] ), '', $_SERVER['SCRIPT_NAME'] );
	return $u;
}) );

/*
-----------------------------------------------------------
	Start it all up!
-----------------------------------------------------------
*/
include SYSPATH . 'bootstrap.php';
	