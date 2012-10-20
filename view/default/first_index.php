<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<h3>新闻列表</h3>
<table class="table">
	<thead>
		<tr>
			<th width="20%">标题</th>
			<th width="50%">片段</th>
			<th width="10%">发布人</th>
			<th>发布日期</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $news_data as $single ) { ?>
		<tr>
			<td><a href="<?php echo HG_Arsenal::base_url("first/view/?id={$single['id']}"); ?>"><?php echo $single['title']; ?></a></td>
			<td><?php echo HG_Arsenal::gbk_substr($single['content'], 100); ?></td>
			<td><?php echo $single['author']; ?></td>
			<td><?php echo date('Y/m/d', $single['time']); ?></td>
			<td><a href="<?php echo HG_Arsenal::base_url("first/view/?id={$single['id']}"); ?>">详细</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<!-- first_footer -->
<hr>
<ul class="first_footer unstyled">
	<?php foreach( $links as $single ) { ?>
	<li><a href="<?php echo HG_Arsenal::addhttp( $single['url'] ); ?>"><?php echo $single['txt']; ?></a></li>
	<?php } ?>
</ul>
<!-- first_footer -->
<?php $this->load( 'footer' ); ?>