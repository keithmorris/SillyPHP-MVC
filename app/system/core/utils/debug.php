<?php defined('APPPATH') OR die('No direct access.');

function dd( $obj ) {
	echo '<pre>';
	print_r( $obj );
	echo '</pre>';
	die();
}