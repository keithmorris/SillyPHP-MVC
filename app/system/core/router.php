<?php 
defined( 'APPPATH' ) or die( 'No direct access.' );

/**
 * Written by Dan Sosedoff
 * url: http://blog.sosedoff.com/2009/09/20/rails-like-php-url-router/
 * 
 * Adapted by Keith Morris
 */

class Router {
	public $request_uri;
	public $routes;
	public $controller, $controller_name;
	public $action, $id;
	public $params;
	public $route_found = false;
	public $defaults;

	public function __construct() {

    	$uri = $_SERVER['REQUEST_URI'];
    	$dir = dirname($_SERVER['SCRIPT_NAME']);
    	$dir = str_replace('/', '\/', $dir);
    	$request = preg_replace('/'.$dir.'/', '', $uri, 1);
    	if(substr($request, 0, 1) != '/') $request = '/'.$request;

		$pos = strpos( $request, '?' );
		if ( $pos ) $request = substr( $request, 0, $pos );

		$this->request_uri = $request;
		$this->routes = array();
		$this->defaults = array(
			'controller' => ROUTER_DEFAULT_CONTROLLER,
			'action' => ROUTER_DEFAULT_ACTION,
		);
	}

	public function map( $rule, $target=array(), $conditions=array() ) {
		$this->routes[$rule] = new Route( $rule, $this->request_uri, $target, $conditions );
	}

	public function default_routes() {
		$this->map( '/:controller' );
		$this->map( '/:controller/:action' );
		$this->map( '/:controller/:action/:id' );
	}

	public function set_defaults($controller, $action)
	{
		$this->defaults['controller'] = $controller;
		$this->defaults['action'] = $action;
	}

	private function set_route( $route ) {
		$this->route_found = true;
		$params = $route->params;
		$this->controller = !empty($params['controller']) ? $params['controller'] : null; unset( $params['controller'] );
		$this->action = !empty($params['action']) ? $params['action'] : null; unset( $params['action'] );
		$this->id = !empty($params['id']) ? $params['id'] : null;
		$this->params = array_merge( $params, $_GET );

		if ( empty( $this->controller ) ) $this->controller = $this->defaults['controller'];
		if ( empty( $this->action ) ) $this->action = $this->defaults['action'];
		if ( empty( $this->id ) ) $this->id = null;

		$w = explode( '_', $this->controller );
		foreach ( $w as $k => $v ) $w[$k] = ucfirst( $v );
		$this->controller_name = implode( '', $w );
	}

	public function execute() {
		foreach ( $this->routes as $route ) {
			if ( $route->is_matched ) {
				$this->set_route( $route );
				break;
			}
		}
	}
}

class Route {
	public $is_matched = false;
	public $params;
	public $url;
	private $conditions;

	function __construct( $url, $request_uri, $target, $conditions ) {
		$this->url = $url;
		$this->params = array();
		$this->conditions = $conditions;
		$p_names = array(); $p_values = array();

		preg_match_all( '@:([\w]+)@', $url, $p_names, PREG_PATTERN_ORDER );
		$p_names = $p_names[0];

		$url_regex = preg_replace_callback( '@:[\w]+@', array( $this, 'regex_url' ), $url );
		$url_regex .= '/?';

		if ( preg_match( '@^' . $url_regex . '$@', $request_uri, $p_values ) ) {
			array_shift( $p_values );
			foreach ( $p_names as $index => $value ) $this->params[substr( $value, 1 )] = urldecode( $p_values[$index] );
			foreach ( $target as $key => $value ) $this->params[$key] = $value;
			$this->is_matched = true;
		}

		unset( $p_names ); unset( $p_values );
	}

	function regex_url( $matches ) {
		$key = str_replace( ':', '', $matches[0] );
		if ($key == 'any') {
			return '(.*)';
		}
		else if ( array_key_exists( $key, $this->conditions ) ) {
			return '('.$this->conditions[$key].')';
		}
		else {
			return '([a-zA-Z0-9_\+\-%]+)';
		}
	}
}

/*
-----------------------------------------------------------
	Setup Example
-----------------------------------------------------------

$r = new Router(); // create router instance 
 
$r->map('/', array('controller' => 'home')); // main page will call controller "Home" with method "index()"
$r->map('/login', array('controller' => 'auth', 'action' => 'login'));
$r->map('/logout', array('controller' => 'auth', 'action' => 'logout'));
$r->map('/signup', array('controller' => 'auth', 'action' => 'signup'));
$r->map('/profile/:action', array('controller' => 'profile')); // will call controller "Profile" with dynamic method ":action()"
$r->map('/users/:id', array('controller' => 'users'), array('id' => '[\d]{1,8}')); // define filters for the url parameters
 
$r->default_routes();
$r->execute();
*/

/*
-----------------------------------------------------------
	Usage Example
-----------------------------------------------------------
$router = new Router();
// ... some configs ...
$controller = $router->controller; // will return name as it appears in url, ex: 'user_images'
$controller = $router->controller_name; // will return processed name of controller
// for example, if class name in url is 'user_images', then 'controller_name' var will be UserImages
$router->action;
$router->id; // if parameter :id presents
$router->params; // array(...)
$router->route_matched; // true - if route found, false - if not
*/