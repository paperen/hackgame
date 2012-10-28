<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<div class="row">
<?php if( isset( $success ) && $success ) { ?>
	<div class="alert alert-success">
		<h4 class="alert-heading">恭喜，帐号密码正确</h4>
		<p>请稍等一会 自动进入下一关</p>
		<p class="loading-bar"></p>
		<script>setTimeout('window.location.href="<?php echo HG_Arsenal::base_url('second'); ?>"', 4000);</script>
	</div>
<?php } else { ?>
	<div class="btn-group pull-right">
		<a href="<?php echo HG_Arsenal::base_url('third/user_login'); ?>" class="btn">普通用户登录</a>
		<a href="<?php echo HG_Arsenal::base_url('third/admin_login'); ?>" class="btn btn-danger active">管理员登录</a>
	</div>
	<form action="<?php echo HG_Arsenal::base_url('third/admin_login'); ?>" class="form-horizontal" method="post" id="login_form">
		<input type="hidden" name="is_submit" value="submit" />
		<h4>管理员登录</h4>
		<hr/>
		<?php if( isset( $error ) && $error ) { ?>
		<div class="alert alert-error">
			<h4 class="alert-heading">登录错误</h4>
			<ul>
				<li><?php echo $error; ?></li>
			</ul>
		</div>
		<?php } ?>
		<div class="control-group">
			<label class="control-label" for="username_admin">用户名</label>
			<div class="controls">
				<div class="input-append">
				<input type="text" id="username_admin" name="username" class="input-xxlarge" value="<?php echo isset( $adminname ) ? $adminname : ''; ?>" /><span class="add-on"><i class="icon-user"></i></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password_admin">密码</label>
			<div class="controls">
				<div class="input-append">
				<input type="password" id="password_admin" name="password" class="input-xxlarge" /><span class="add-on"><i class="icon-lock"></i></span>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success btn-login">登陆</button>
		</div>
		<?php echo HG_Arsenal::get_token(); ?>
	</form>
<?php } ?>
</div>
<?php $this->load( 'footer' ); ?>