<?php defined('APPPATH') OR die('No direct access.');
/**
 *
 */
class Silly {
	protected static $instance;
	protected static $router;
	protected static $db;

	function __construct() {
		$this->setupDb();
		$this->router = new Router();
		$this->setupRoutes();
		$this->processRoute();
	}

	public static function go()
	{
		self::getInstance();
	}

	public static function getInstance()
	{
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
/*
-----------------------------------------------------------
	Protected and Private Methods
-----------------------------------------------------------
*/
	protected function setupDb()
	{
		$config = (object) Config::get('db');
		// dd($config);

        Db::config('driver'  , $config->driver);
        Db::config('host'    , $config->host);
        Db::config('database', $config->database);
        Db::config('user'    , $config->user);
        Db::config('pass'    , $config->pass);

        if(Config::getAll()->config['use_database'])
			$this->db = Db::instance();

	}
	protected function setupRoutes()
	{
		$router = $this->router;
		$routes = Config::get('routes');

		foreach ($routes as $routeKey => $routeValue) {

			if ($routeKey == ROUTER_DEFAULTS) {
				$router->set_defaults($routeValue['controller'], $routeValue['action']);
			} else {
				$target = array();
				$conditions = array();
				if (!empty($routeValue['controller'])) {
					$target['controller'] = $routeValue['controller'];
				}
				if (!empty($routeValue['action'])) {
					$target['action'] = $routeValue['action'];
				}
				if (!empty($routeValue['conditions'])) {
					$conditions = $routeValue['conditions'];
				}
				//$rule, $target=array(), $conditions=array()
				$router->map($routeKey, $target, $conditions);
			}
		}
		$router->default_routes();
	}

	protected function processRoute()
	{
		$r = $this->router;
		$r->execute();
		// dd($r);
		$controller = 'Controllers\\'.$r->controller_name;
		$action = $r->action;
		$params = (empty($r->params['any'])) ? $r->params : explode('/', $r->params['any']);
		$method = strtolower($_SERVER['REQUEST_METHOD']);

		if (class_exists($controller)) {
			$obj = new $controller();
			if (method_exists($obj, $method.'_'.$action)) {
				call_user_func_array(array($obj, $method.'_'.$action), $params);
			} else if(method_exists($obj, 'action_'.$action)) {
				call_user_func_array(array($obj, 'action_'.$action), $params);
			} else {
				$this->show_404();
			}			
		} else {
			$this->show_404();
		}
	}
	
	protected function show_404()
	{
		$route = (object) Config::getAll()->routes[ERROR_404_ROUTE];
		$controller = 'Controllers\\'.$route->controller;
		$obj = new $controller();
		call_user_func(array($obj, 'action_'.$route->action));
	}
}
