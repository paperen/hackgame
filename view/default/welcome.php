<?php if ( !defined( 'INRUN' ) ) exit();?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<?php echo $this->css( 'bootstrap/css/bootstrap.min.css' ); ?>
		<?php echo $this->css( 'welcome.css' ); ?>
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
		<div class="container">
			<div class="span2 offset4 welcome">
				<span class="logo"></span>
				<a href="<?php echo HG_Arsenal::base_url('first'); ?>" class="btn btn-danger">开始游戏</a>
			</div>
		</div>
	</body>
</html>