<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<link rel="stylesheet" href="<?php echo baseurl('assets/css/reset.css'); ?>">
	<link rel="stylesheet" href="<?php echo baseurl('assets/css/text.css'); ?>">
	<link rel="stylesheet" href="<?php echo baseurl('assets/css/960_12_col.css'); ?>">
	<link rel="stylesheet" href="<?php echo baseurl('assets/css/style.css'); ?>">
</head>
<body>
	<div class="container_12 shadow">
		<header class="grid_12">
			<h1><?php echo $heading; ?></h1>
			<h2><?php echo $subheading; ?></h2>
		</header>
		<div class="grid_12 banner">
			<img src="<?php echo baseurl('assets/images/silly.jpg'); ?>" alt="">
		</div>
		<div class="grid_12 content">
			<p>
				Welcome to the SillyPHP MVC Framework. This is the Welcome View which is called from the Welcome controller which is set in the Routes file: <code>app/config/routes.php</code>
			</p>
			<p>
				I built this framework in a couple of days simply as an exercise to gain a greater understanding building an MVC framework from the ground up. There are still lots of inefficiencies here and I really would not recommend using this in any production sense that is expecting a ton of traffic as it has not been thoroughly tested.
			</p>
			<p>
				However, as the system is not overly complex, you may find it useful to dig through if you're new to MVC frameworks to learn a bit about how they can be put together.
			</p>		
		</div>
		<div class="grid_4 callout">
			<h3>Not Complete</h3>
			<p>
				I would not in any sense call this complete as it is a work in progress and meant more for educational purposes
			</p>
		</div>
		<div class="grid_4 callout">
			<h3>Not Efficient</h3>
			<p>
				For the Core, Controller and Model classes, the framework greedily loads EVERYTHING at app startup instead of lazily loading them.
			</p>
		</div>
		<div class="grid_4 callout">
			<h3>Not Perfect</h3>
			<p>
				Duh.
			</p>
		</div>
		<footer class="grid_12">
			&copy;<?php echo date('Y'); ?> Keith Morris
		</footer>
	</div>
</body>
</html>