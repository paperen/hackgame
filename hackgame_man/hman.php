<?php

/**
 *
 * HackGame2 后台管理
 * 新黑客游戏第二版
 * 策划 Smart Cool(blog.blackbap.org/space.php?uid=2)
 * 界面与代码 Paperen(iamlze.cn)
 *
 * 2011/02/06
 *
 */

define('INADMIN', true);
define('INRUN', true);

if( !include('../config.php') ) exit('config文件丢失');

define('HM_ROOT', ROOT . 'hackgame_man/');

require( ENGINE . 'HG_Arsenal.php' );

if ( !get_magic_quotes_gpc() ) {
    $_GET = HG_Arsenal::saddslashes( $_GET );
    $_POST = HG_Arsenal::saddslashes( $_POST );
    $_SESSION = HG_Arsenal::saddslashes( $_SESSION );
}

$ac = isset( $_GET['ac'] ) ? $_GET['ac'] : 'home';

$_GLOBALS = array();

if ( !HG_Arsenal::is_Admin() ) {
    $ac = 'login';
} else {
    if ( HAS_DB ) {
        //mysql数据库支持
        if ( @include( ROOT . 'db_config.php' ) ) {
            if ( 'mysql' == HAS_DB && @include( ENGINE . 'Class_mysql.php' ) ) {
                $_GLOBALS['db'] = new db_mysql();
                $_GLOBALS['db']->connect(DB_HOST, DB_USER, DB_PWD, DB_NAME, 0, CHARSET, DB_PERFIX);
            }
            //sqlite支持
            if ( 'sqlite' == HAS_DB && @include( ENGINE . 'Class_sqlite.php' ) ) {
                $_GLOBALS['db'] = new db_sqlite();
                $_GLOBALS['db']->connect(DB_FILE, DB_PERFIX);
            }
        }
    }
}

require( HM_ROOT . "action/hman_$ac.php" );

?>