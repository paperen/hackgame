<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<ul>
	<?php foreach( $news_data as $single ) { ?>
	<li><?php echo $single['title']; ?></li>
	<?php } ?>
</ul>
<?php $this->load( 'footer' ); ?>