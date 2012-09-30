<?php defined( 'APPPATH' ) or die( 'No direct access.' );

return array(
	ROUTER_DEFAULTS => array(
		'controller' => 'Welcome',
		'action' => 'index',
	),
	ERROR_404_ROUTE => array(
		'controller' => 'Error404',
		'action' => 'index',
	),
	'/' => array(
		'controller' => 'Welcome',
		'action' => 'index',
	),
	'/save' => array(
		'controller' => 'Home',
		'action' => 'save',
	),
	// '/users/:id' => array(
	// 	'controller' => 'users',
	// 	'action' => 'index',
	// 	'conditions' => array(
	// 		'id' => '[\d]{1,8}', 
	// 	)
	// ),
	'/:controller/:action/:any' => array(
		'conditions' => array(
			// 'path' => '(.*)',
		),
	),
);
