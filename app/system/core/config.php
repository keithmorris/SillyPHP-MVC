<?php 
defined('APPPATH') OR die('No direct access.');
/**
* 
*/
class Config
{
	protected static $_instance;
	protected static $_config_path;
	protected static $_configs;


	public function __construct()
	{
	   $this->_config_path = APPPATH . 'config/';
	   $this->_configs = new stdClass;
	}

	public static function load($configs, $path = null)
	{
		$instance = self::getInstance();	

		$path = ($path) ? $path : $instance->_config_path;

		if (is_string($configs)) {
			$configs = explode(',', str_replace(' ', '', $configs));
		}
		foreach ($configs as $config) {
			if (file_exists($path.ENVIRONMENT.'/'.$config.'.php')) {
				$file = $path.ENVIRONMENT.'/'.$config.'.php';
			} else {
				$file = $path.$config.'.php';
			}
			$instance->_configs->$config = include $file;
		}
	}

	public static function get($key = null)
	{
		$instance = self::getInstance();
		if(!$key)
			return self::getAll();
		if(property_exists($instance->_configs, $key)) {
			return $instance->_configs->$key;
		} else {
			return null;
		}
	}

	public static function getAll()
	{
		$instance = self::getInstance();
		return $instance->_configs;
	}
/*
-----------------------------------------------------------
	Private and Protected Methods
-----------------------------------------------------------
*/
	protected static function getInstance()
	{
		if (!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;		
	}
}