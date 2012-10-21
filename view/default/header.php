<?php if ( !defined( 'INRUN' ) ) exit();?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
		<title><?php echo $title; ?></title>
		<?php echo $this->css( 'bootstrap/css/bootstrap.min.css' ); ?>
		<?php echo $this->css( 'default.css' ); ?>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#"></a>
					<div class="nav-collapse collapse">
						<ul class="nav">
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container main">