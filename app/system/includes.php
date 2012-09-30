<?php defined('APPPATH') OR die('No direct access.');

/**
 * Core function to support recursively including PHP files.
 */
function glob_recursive( $pattern, $flags = 0 ) {
	$files = glob( $pattern, $flags );

	foreach ( glob( dirname( $pattern ).'/*', GLOB_ONLYDIR|GLOB_NOSORT ) as $dir ) {
		$files = array_merge( $files, glob_recursive( $dir.'/'.basename( $pattern ), $flags ) );
	}

	return $files;
}

/*
-----------------------------------------------------------
	CORE
-----------------------------------------------------------
*/
foreach (glob_recursive(SYSPATH.'core/*.php') as $file) {
	include $file;
}

/*
-----------------------------------------------------------
	Configs
-----------------------------------------------------------
*/
Config::load('sys_view', SYSPATH.'config/');
Config::load('config, routes, autoload');
Config::load(Config::get('autoload'));

/*
-----------------------------------------------------------
	Libraries
-----------------------------------------------------------
*/
foreach (glob_recursive(SYSPATH.'libraries/*.php') as $file) {
	include $file;
}
// user libraries
foreach (Config::get('libraries') as $file) {
	include APPPATH."lib/$file.php";
}

/*
-----------------------------------------------------------
	Classes
-----------------------------------------------------------
*/
foreach (glob_recursive(APPPATH.'classes/*.php') as $file) {
	include $file;
}
