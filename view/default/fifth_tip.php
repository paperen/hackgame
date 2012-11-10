<?php if ( !defined( 'INRUN' ) ) exit();?>
<?php $this->load( 'header' ); ?>
<div class="row">
	<div class="btn-group pull-right">
		<a href="<?php echo HG_Arsenal::base_url('fifth'); ?>" class="btn"><i class="icon-arrow-left"></i> 返回</a>
	</div>
	<div class="alert alert-info alert-block">
		<h4 class="alert-heading">闯关提示</h4>
		<p>
			<pre>
if($userfile!=""){
$allowed_types=array('jpg','gif','png','jpeg','bmp');
#正则表达式匹配出上传文件的扩展名
preg_match('|\.(\w+)$|', $userfile,$ext);
#print_r($ext);
$ext = strtolower($ext[1]);
#判断是否在被允许的扩展名里
if(!in_array($ext, $allowed_types)){
	// 闯关失败
}
}
			</pre>
		</p>
	</div>
</div>
<?php $this->load( 'footer' ); ?>