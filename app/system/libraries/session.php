<?php defined('APPPATH') OR die('No direct access.');
/**
* Session Class
*/
class Session
{
	protected static $instance;
	protected static $session;
	protected static $session_flash;

	function __construct()
	{
		session_start();
		$this->setupSessionVars();
	}

	public static function get($key = null)
	{
		self::getInstance();
		if (empty($key))
			return self::$session;		
		return (!empty(self::$session[$key])) ? self::$session[$key] : null ;
	}

	public static function set($key, $value)
	{
		self::getInstance();
		$_SESSION[SESSION_KEY][$key] = self::$session[$key] = $value;
	}

	public static function get_flash($key = null)
	{
		if (empty($key))
			return self::$session_flash;		
		self::getInstance();
		return (!empty(self::$session_flash[$key])) ? self::$session_flash[$key] : null ;
				
	}

	public static function set_flash($key, $value)
	{
		self::getInstance();
		$_SESSION[SESSION_FLASH_KEY][$key] = self::$session_flash[$key] = $value;
	}

	public static function keep_flash($key)
	{
		self::getInstance();
		$_SESSION[SESSION_FLASH_KEY][$key] = (!empty(self::$session_flash[$key])) ? self::$session_flash[$key] : null ;
	}
	
	public static function getInstance()
	{
		if(self::$instance)
			return self::$instance;
		return self::$instance = new self();
	}	
/*
-----------------------------------------------------------
	Private and Protected
-----------------------------------------------------------
*/
	protected function setupSessionVars()
	{
		if(!empty($_SESSION[SESSION_KEY]))
		{
			self::$session = $_SESSION[SESSION_KEY];
		}
		else 
		{
			self::$session = $_SESSION[SESSION_KEY] = array();
		}
		if(!empty($_SESSION[SESSION_FLASH_KEY]))
		{
			self::$session_flash = $_SESSION[SESSION_FLASH_KEY];
			$_SESSION['session_flash_data'] = array();
		}
		else 
		{
			self::$session_flash = $_SESSION[SESSION_FLASH_KEY] = array();
		}
	}
}