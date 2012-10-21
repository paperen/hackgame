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
	<a href="<?php echo HG_Arsenal::base_url('first'); ?>" class="btn pull-right">返回列表</a>
	<h3>请输入帐号与密码</h3>
	<hr>
	<?php if( isset( $error ) && $error ) { ?>
	<div class="alert alert-error">
		<ul>
			<li><?php echo $error; ?></li>
		</ul>
	</div>
	<?php } ?>
	<form action="" class="form-horizontal" method="post">
		<input type="hidden" name="submit" value="submit" />
		<div class="control-group">
			<label class="control-label" for="username">管理账号</label>
			<div class="controls"><input type="text" id="username" name="username" class="input-xxlarge" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" /></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">密码</label>
			<div class="controls"><input type="password" id="password" name="password" class="input-xxlarge" /></div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success">登陆</button>
		</div>
		<?php echo HG_Arsenal::get_token(); ?>
	</form>
<?php } ?>
<?php $this->load( 'footer' ); ?>