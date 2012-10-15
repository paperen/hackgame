<?php

session_start();

define( 'ROOT', str_replace( '\\', DIRECTORY_SEPARATOR, dirname( __FILE__ ) ) . DIRECTORY_SEPARATOR );
define( 'ENGINE', ROOT . 'engine' . DIRECTORY_SEPARATOR );
define( 'CONTROLLER', ROOT . 'controller' . DIRECTORY_SEPARATOR );
define( 'VIEW', ROOT . 'view' . DIRECTORY_SEPARATOR );

//调试模式
define( 'DEBUG', true );

//数据库支持
define( 'DB_TYPE', 'sqlite' );

/** 开启GET参数加密 */
define( 'HG_ENCODE_ON', 0 );
/** GET参数标记 */
define( 'HG_GET', 'op' );
/** 密钥 */
define( 'HG_KEY', 'utYS4re=1' );

/** winner数据记录在data目录哪个文件夹下 */
define( 'WINNER_DIRECTORY', 'winner' );

/** SESSIONKEY */
define( 'HG_SESSIONKEY', 'hackgame3_key' );
define( 'HG_SESSIONOP', 'op' );
define( 'HG_SESSIONOPKEY', 'key' );
define( 'HG_SESSIONSTART', 's' );
define( 'HG_SESSIONAUTHKEY', 'auth' );
/** ADMIN */
define( 'HG_ADMINAUTHKEY', 'hackgame3_adminauth' );
define( 'HG_ADMINKEY', 'hackgame3_admin' );
define( 'HG_ADMINVAL', '7Ysrts2srPS' );
/** 后台登陆帐号密码 */
define( 'HG_ADMINACOUNT', 'hman' );
define( 'HG_ADMINPWD', 'hman_92581' );

// GET参数控制器标识符
define( 'HG_CONTROLLER_SIGN', 'c' );
// GET参数方法标识符
define( 'HG_METHOD_SIGN', 'm' );
?>