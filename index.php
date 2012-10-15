<?php

/**
 *
 * HackGame3
 * 新黑客游戏第二版
 * 策划 Smart Cool(blog.blackbap.org/space.php?uid=2)
 * 界面与代码 Paperen(iamlze.cn)
 *
 * 2011/02/06
 *
 */

define('INRUN', true);

if( !include('config.php') ) exit('config文件丢失');

require( ENGINE . 'HG_Core.php' );
HG_Core::prepare();
HG_Core::run();

?>