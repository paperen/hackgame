<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<div class="row">
<?php if( isset( $success ) && $success ) { ?>
	<div class="alert alert-success">
		<h4 class="alert-heading">恭喜，闯关成功</h4>
		<p>请稍等一会 自动进入下一关</p>
		<p class="loading-bar"></p>
		<script>setTimeout('window.location.href="<?php echo HG_Arsenal::base_url('pass'); ?>"', 4000);</script>
	</div>
<?php } else { ?>
	<div class="btn-group pull-right">
		<a href="<?php echo HG_Arsenal::base_url('fifth/tip'); ?>" class="btn"><i class="icon-thumbs-up"></i> 闯关提示</a>
	</div>
	<form action="<?php echo HG_Arsenal::base_url('fifth'); ?>" class="form-horizontal" method="post" id="submit_form" enctype="multipart/form-data">
		<input type="hidden" name="is_submit" value="submit" />
		<?php if( isset( $error ) && $error ) { ?>
		<div class="alert alert-error">
			<h4 class="alert-heading">闯关错误</h4>
			<ul>
				<li><?php echo $error; ?></li>
			</ul>
		</div>
		<?php } ?>
		<div class="control-group">
			<label class="control-label" for="nickname">昵称</label>
			<div class="controls">
				<div class="input-append">
				<input type="text" id="nickname" name="nickname" class="input-xxlarge" value="<?php echo isset($post_data['nickname']) ? $post_data['nickname'] : ''; ?>" /><span class="add-on"><i class="icon-user"></i></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">通讯邮箱</label>
			<div class="controls">
				<div class="input-append">
				<input type="text" id="email" name="email" class="input-xxlarge" value="<?php echo isset($post_data['email']) ? $post_data['email'] : ''; ?>" /><span class="add-on"><i class="icon-envelope"></i></span>
				</div>
			</div>
		</div>
		<!-- important -->
		<input type="hidden" name="userfile" value="<?php echo $userfile; ?>" />
		<!-- important -->
		<div class="control-group">
			<label class="control-label" for="pic">图片</label>
			<div class="controls">
				<div class="input-append">
				<input type="file" name="pic" id="pic" />
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="context">闯关感言</label>
			<div class="controls">
				<textarea rows="5" class="input-xxlarge" name="context" id="context"><?php echo isset($post_data['context']) ? $post_data['context'] : ''; ?></textarea>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success btn-login">提交</button>
		</div>
		<?php echo HG_Arsenal::get_token(); ?>
	</form>
<?php } ?>
</div>
<?php $this->load( 'footer' ); ?>