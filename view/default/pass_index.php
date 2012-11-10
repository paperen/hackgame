<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<div class="span5 offset3 pass">
	<div class="alert alert-success">
		<h4 class="alert-heading">恭喜 所有关卡都已经完成</h4>
	</div>
	<hr>
	<div class="paoxiao"></div>
	<hr>
	<a class="btn btn-success" href="<?php echo HG_Arsenal::base_url("pass/restart"); ?>"><i class="icon-repeat icon-white"></i> 重新开始</a>
</div>
<?php $this->load( 'footer' ); ?>