<?php defined('APPPATH') OR die('No direct access.');

function baseurl($path = '', $full = false)
{
	if (!$full) {
		$base = str_replace( basename( $_SERVER['SCRIPT_NAME'] ), '', $_SERVER['SCRIPT_NAME'] );
	} else {
		$base = BASEURL;
	}
	return $base.$path;
}

function redirect($uri = '', $method = 'location', $http_response_code = 302)
{
	if ( ! preg_match('#^https?://#i', $uri))
	{
		$uri = baseurl($uri, true);
	}

	switch($method)
	{
		case 'refresh'	: header("Refresh:0;url=".$uri);
			break;
		default			: header("Location: ".$uri, TRUE, $http_response_code);
			break;
	}
	exit;
}