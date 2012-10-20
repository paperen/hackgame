<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<h3>新闻列表</h3>
<table class="table">
	<thead>
		<tr>
			<th>标题</th>
			<th>片段</th>
			<th>发布人</th>
			<th>发布日期</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $news_data as $single ) { ?>
		<tr>
			<td><?php echo $single['title']; ?></td>
			<td><?php echo HG_Arsenal::gbk_substr($single['content'], 100); ?></td>
			<td><?php echo $single['author']; ?></td>
			<td><?php echo date('Y/m/d', $single['time']); ?></td>
			<td><a href="<?php echo HG_Arsenal::base_url("first/view/{$single['id']}"); ?>">详细</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php $this->load( 'footer' ); ?>