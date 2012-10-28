<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<div class="row">
	<div class="btn-group pull-right">
		<a href="<?php echo HG_Arsenal::base_url('third'); ?>" class="btn active">普通用户登录</a>
		<a href="<?php echo HG_Arsenal::base_url('third/admin_login'); ?>" class="btn btn-danger">管理员登录</a>
	</div>
	<div class="c"></div>
	<form action="<?php echo HG_Arsenal::base_url('third/user_login'); ?>" class="form-horizontal" method="post" id="login_form">
		<input type="hidden" name="is_submit" value="submit" />
		<h4>普通用户登录</h4>
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
			<label class="control-label" for="username">用户名</label>
			<div class="controls">
				<div class="input-append">
				<input type="text" id="username" name="username" class="input-xxlarge" value="<?php echo isset($username) ? $username : ''; ?>" /><span class="add-on"><i class="icon-user"></i></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">密码</label>
			<div class="controls">
				<div class="input-append">
				<input type="password" id="password" name="password" class="input-xxlarge" /><span class="add-on"><i class="icon-lock"></i></span>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary btn-login">登陆</button>
		</div>
		<?php echo HG_Arsenal::get_token(); ?>
	</form>
</div>
<?php $this->load( 'footer' ); ?>