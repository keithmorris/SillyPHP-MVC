<?php 
defined('APPPATH') OR die('No direct access.');

/**
* 
*/
class View
{
	function __construct()
	{
		
	}

	public static function get($path, $vars = null)
	{
		return self::getFile($path, $vars);
	}

	public static function getFile($path, $vars = null)
	{
		if(is_array($vars)) extract($vars);
		ob_start();
		include $path;
		$rendered = ob_get_contents();
		ob_end_clean();	
		return $rendered;
	}

	public static function render($path, $vars = null, $headers = array())
	{
		self::renderFile($path, $vars, $headers);
	}

	public static function renderFile($path, $vars = null, $headers = array())
	{
		self::setupHeaders($headers);
		echo self::getFile($path, $vars);
	}
/*
-----------------------------------------------------------
	Private and Protected
-----------------------------------------------------------
*/
	protected static function setupHeaders($headers)
	{
		$config = Config::get('sys_view');
		$headers = array_merge($default_headers = $config['default_headers'], $headers);
		foreach ($headers as $header) {
			$header = (object) $header;
			$string = $header->string;
			$replace = (isset($header->replace) && $header->replace === false) ? false : true ;
			if (!empty($header->code)) {
				header($string, $replace, $header->code);
			} else {
				header($string, $replace);
			}
		}
	}

}