<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<?php if( isset( $success ) && $success ) { ?>
	<div class="alert alert-success">
		<h4 class="alert-heading">恭喜，帐号密码正确</h4>
		<p>请稍等一会 自动进入下一关</p>
		<p class="loading-bar"></p>
		<script>setTimeout('window.location.href="<?php echo HG_Arsenal::base_url('second'); ?>"', 4000);</script>
	</div>
<?php } else { ?>
<div class="row">
	<div class="span3 sidebar">
		<h4>菜单</h4>
		<ul class="nav nav-tabs nav-stacked">
			<li><a href="<?php echo HG_Arsenal::base_url('fourth/sql'); ?>">SQL语句</a></li>
			<li><a href="<?php echo HG_Arsenal::base_url('fourth/file'); ?>">文件操作</a></li>
			<li><a href="<?php echo HG_Arsenal::base_url('fourth/server'); ?>" class="active">服务器管理</a></li>
		</ul>
	</div>
	<div class="span9">
		<?php if ( isset( $error ) && $error ) { ?>
			<h1>Authorization Required</h1>
			<p>This server could not verify that youare authorized to access the document requested.  Either you supplied the wrong credentials (e.g., bad password), or your browser doesn't understand how to supply the credentials required.</p>
			<p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p>
			<hr>
			<a href="<?php echo HG_Arsenal::base_url('fourth/server'); ?>" class="btn">重新填写</a>
		<?php } else { ?>
			<h3>Windows Security</h3>
			<p>The server g.blackbap.org at Silic Group HackGame 2012 requires a username and password.</p>
			<div class="alert alert-block">
				<p>Warning:This server is requesting that your username and password be sent in a insecure manner (basic authentication without a secure connection)</p>
			</div>
			<hr>
			<form action="" class="form-horizontal" method="post">
				<input type="hidden" name="submit" value="submit" />
				<div class="control-group">
					<label class="control-label" for="username">管理账号</label>
					<div class="controls"><input type="text" id="username" name="username" class="input-xlarge" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" /></div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">密码</label>
					<div class="controls"><input type="password" id="password" name="password" class="input-xlarge" /></div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">登陆</button>
				</div>
				<?php echo HG_Arsenal::get_token(); ?>
			</form>
		<?php } ?>
	</div>
</div>
<?php } ?>
<?php $this->load( 'footer' ); ?>