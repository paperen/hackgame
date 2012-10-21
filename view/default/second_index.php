<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<h3>提示列表</h3>
<table class="table">
	<thead>
		<tr>
			<th width="20%">标题</th>
			<th width="60%">片段</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $news_data as $single ) { ?>
		<tr>
			<td><a href="<?php echo HG_Arsenal::base_url("second/view/?id={$single['id']}"); ?>"><?php echo $single['title']; ?></a></td>
			<td><?php echo HG_Arsenal::gbk_substr($single['content'], 200); ?></td>
			<td><a href="<?php echo HG_Arsenal::base_url("second/view/?id={$single['id']}"); ?>">详细</a></td>
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