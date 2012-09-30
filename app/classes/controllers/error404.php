<?php 
namespace Controllers;
use View;
use Config;
defined('APPPATH') OR die('No direct access.');
/**
* 
*/
class Error404
{

	public function action_index()
	{
		$headers = array(
			array(
				'string' => '"Status: 404 Not Found"',
				'replace' => true,
				'code' => 404,
			),
		);

		View::render(Config::getAll()->config['error_404_page'], null, $headers);

	}
}