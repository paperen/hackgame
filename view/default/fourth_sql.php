<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<div class="row">
	<div class="span3 sidebar">
		<h4>菜单</h4>
		<ul class="nav nav-tabs nav-stacked">
			<li><a href="<?php echo HG_Arsenal::base_url('fourth/sql'); ?>" class="active">SQL语句</a></li>
			<li><a href="<?php echo HG_Arsenal::base_url('fourth/file'); ?>">文件操作</a></li>
			<li><a href="<?php echo HG_Arsenal::base_url('fourth/server'); ?>">服务器管理</a></li>
		</ul>
	</div>
	<div class="span9">
		<h3>输入SQL</h3>
		<form action="<?php echo HG_Arsenal::base_url('fourth/sql'); ?>" class="form-search" method="post">
			<input type="hidden" name="submit" value="submit" />
			<input placeholder="SQL" type="text" class="input-xxlarge search-query" name="sql" value="<?php echo isset( $sql ) ? $sql : ''; ?>">
			<button type="submit" class="btn btn-success">执行</button>
			<?php echo HG_Arsenal::get_token(); ?>
		</form>
		<?php if( isset( $result ) && $result ) { ?>
		<h3>执行结果</h3>
		<div class="alert alert-block<?php if( isset( $success ) && $success ){ ?> alert-success<?php } else { ?> alert-error<?php } ?>">
			<p><?php echo $result; ?></p>
		</div>
		<?php } ?>
	</div>
</div>
<?php $this->load( 'footer' ); ?>