<?php defined('APPPATH') OR die('No direct access.');


function load_rendered_php_file($path, $vars = array())
{
	extract($vars);
	ob_start();
	include $path;
	$rendered = ob_get_contents();
	ob_end_clean();	
	return $rendered;
}