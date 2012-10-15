<?php if(!defined('INRUN')) exit(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->charset; ?>" />
<title><?php echo $this->title; ?></title>
<meta name="keywords" content="<?php echo $this->keywords; ?>"/>
<meta name="description" content="<?php echo $this->description; ?>"/>
<?php $this->import( 'default', 'css' ); ?>
<?php $this->import( 'script_jquery', 'js' ); ?>
<?php $this->import( 'script_engine', 'js' ); ?>
<?php $this->import( 'script_share', 'js' ); ?>
</head>

<body>
<!-- header -->
<div class="header bg">
	<div class="inner">
    	<a href="<?php echo $this->siteurl; ?>" class="logo"></a>
        <a href="javascript:void(0);" class="share" title="分享到" id="switch_share"></a>
        <ul class="share_inner" id="share_box">
        	<li><a href="javascript:void(0);" class="icon sina_icon" id="share_sina"></a></li>
            <li><a href="javascript:void(0);" class="icon renren_icon" id="share_renren"></a></li>
            <li><a href="javascript:void(0);" class="icon tengxun_icon" id="share_qq"></a></li>
            <li><a href="javascript:void(0);" class="icon douban_icon" id="share_douban"></a></li>
            <li><a href="javascript:void(0);" class="icon twitter_icon" id="share_twitter"></a></li>
        </ul>
        <div class="c"></div>
    </div>
</div>
<!-- header -->
<!-- main -->
<div class="main">
	<div class="inner">