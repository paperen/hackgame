<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<?php if( empty( $news_data ) ) { ?>
	<div class="alert alert-info alert-block">
		<h4 class="alert-heading">什么都没有找到 有可能是以下情况</h4>
		<ul>
			<li>ID不存在</li>
			<li>数据表不存在错误</li>
			<li>字段数不匹配</li>
		</ul>
	</div>
	<p><a href="<?php echo HG_Arsenal::base_url('first'); ?>" class="btn">返回列表</a></p>
<?php } else { ?>
	<a href="<?php echo HG_Arsenal::base_url('first'); ?>" class="btn pull-right">返回列表</a>
	<h3><?php echo $news_data['title']; ?></h3>
	<ul class="unstyled">
		<li>发布人 <?php echo $news_data['author']; ?></li>
		<li>发布日期 <?php echo date('Y/m/d', $news_data['time']); ?></li>
	</ul>
	<hr>
	<div class="content"><?php echo $news_data['content']; ?></div>
<?php } ?>
<!-- first_footer -->
<hr>
<ul class="first_footer unstyled">
	<?php foreach( $links as $single ) { ?>
	<li><a href="<?php echo HG_Arsenal::addhttp( $single['url'] ); ?>"><?php echo $single['txt']; ?></a></li>
	<?php } ?>
</ul>
<!-- first_footer -->
<?php $this->load( 'footer' ); ?>