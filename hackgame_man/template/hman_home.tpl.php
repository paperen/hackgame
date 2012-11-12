<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HG_ADMIN HOME</title>
<link rel="stylesheet" media="screen" href="css/admin.css" />
</head>

<body>

<div class="header auto">
	<h2>HackGame ADMIN</h2>
	<ul class="nav">
    	<li><a href="?ac=logout">注销</a></li>
    </ul>
    <div class="c"></div>
</div>

<div class="main auto">
	<div class="float_left container winner_list">
    	<h4>通关人记录 <b><?php echo $winner_total; ?></b></h4>
        <?php if( $winner_total ) { ?>
			<?php foreach($winner_record as $k => $record) { ?>
            <div class="each">
                <img src="<?php echo HG_Arsenal::get_gravatar($record['email'], 50); ?>" title="gravatar" alt="<?php echo $record['username']; ?>" class="gravatar" />
                <p>游戏开始时间 <?php echo date('Y/m/d H:i:s', $record['start']); ?></p>
                <p>总使用时间 <?php echo HG_Arsenal::format_lvltime($record['end'] - $record['start']); ?></p>
                <p>昵称 <?php echo $record['username']; ?></p>
                <p>邮箱 <?php echo $record['email']; ?></p>
                <p>ICQ <?php echo $record['icq']; ?></p>
                <p>IP <?php echo long2ip($record['ip']); ?></p>
                <p class="msg">
                    <?php echo $record['message']; ?>
                </p>
            </div>
            <?php } ?>
            <?php if( HAS_DB && isset($_GLOBALS['db']) && $_GLOBALS['db'] ){ ?>
                <?php if( $total_page > 1 ) { ?>
                <ul class="page">
                    <?php for($i=1;$i<=$total_page;$i++){ ?>
                    <li><a href="?ac=home&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php } ?>
                </ul>
                <div class="c"></div>
                <?php } ?>
            <?php } ?>
        <?php } else { ?>
        	<h4>没有任何通关记录</h4>
        <?php } ?>
    </div>
    <div class="float_right sidebar">
    	<div class="each top5">
        	<h4>最快通关TOP 5</h4>
        	<?php
            	if( HAS_DB && isset($_GLOBALS['db']) && $_GLOBALS['db'] ){
					foreach($winner_top5 as $k => $topdata) {
			?>
            <ul>
            	<li>
                	<span class="headline"><b>NO.<?php echo $k+1; ?></b> <?php echo HG_Arsenal::format_lvltime($topdata['end'] - $topdata['start']); ?></span>
                    <?php echo $topdata['username']; ?> <small>&lt;<?php echo $topdata['email']; ?>&gt;</small>
                </li>
            </ul>
            <?php
					}
            	} else {
			?>
            <ul>
            	<li><b>该功能需要数据库的支持才能使用</b></li>
            </ul>
            <?php } ?>
        </div>
    </div>
    <div class="c"></div>
</div>

<div class="footer auto">
	<!-- footer only -->
    paperen@gmail.com
</div>

</body>
</html>