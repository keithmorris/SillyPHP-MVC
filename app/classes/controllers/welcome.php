<?php 
	namespace Controllers;
	use Session;
	use Db;
	use View;

	defined('APPPATH') OR die('No direct access.');

	/**
	* 
	*/
	class Welcome
	{
		function __construct(){}

		public function action_index()
		{
			echo "action_index";
		}
		public function get_index($name = '', $name2 = '')
		{
			$data = array(
				'title' => 'Welcome to SillyPHP MVC',
				'heading' => "SillyPHP MVC",
				'subheading' => "Don't Use This"
			);
			View::render(BASEPATH.'views/welcome.php', $data);
		}

		public function post_save() {
			$db = Db::instance();
			$p = (object) $_POST;
			$id = $db->create('responses', array(
				'name' => $p->name,
				'email' => $p->email,
				'phone' => $p->phone,
				'guest_name' => $p->guest_name,
				'created_time' => null,
				
			))->id();
			redirect('thankyou');
		}
	}