<?php

/*
 * 核心处理器
 */

class HG_Core
{

	/**
	 * prepare for run
	 */
	static function prepare() {

		// 加载军火库
		require( ENGINE . 'HG_Arsenal.php' );

		if ( DEBUG ) {
			error_reporting( -1 );
		} else {
			error_reporting( 0 );
		}

		if ( HG_ENCODE_ON ) {
			$_GET = HG_Arsenal::getargs();
		}

		if ( !get_magic_quotes_gpc() ) {
			$_GET = HG_Arsenal::saddslashes( $_GET );
			$_POST = HG_Arsenal::saddslashes( $_POST );
			$_SESSION = HG_Arsenal::saddslashes( $_SESSION );
		}
	}

	// go go go
	static function run() {
		// 设置类
		$hg_setting = HG_Arsenal::load_engine( 'HG_Setting' );
		//isajax
		if ( HG_Arsenal::isAjax() ) $hg_setting->isajax = true;

		// router类
		$hg_router = HG_Arsenal::load_engine( 'HG_Router' );
		$hg_router->init( $hg_setting );
		$hg_router->parse();

		// 视图类
		$hg_view = HG_Arsenal::load_engine( 'HG_View' );
		$hg_view->set_skin( $hg_setting->skin );

		// 加载控制器
		require( ENGINE . 'HG_Controller.php' );
		$controller = self::get_controller();
		if ( empty( $controller ) ) $controller = $hg_router->get_controller();
		if ( empty( $controller ) ) $controller = $hg_setting->default_controller;
		$controller_file = CONTROLLER . $controller . '.php';
		if ( !file_exists( $controller_file ) ) exit( "{$controller}控制器丢失" );

		require( $controller_file );
		if ( !class_exists( $controller ) ) exit( "{$controller}控制器没有定义" );
		$method = $hg_router->get_method();
		$controller_methods = get_class_methods( $controller );
		if ( !in_array( $method, $controller_methods ) ) $method = $hg_setting->default_method;

		$controller_instance = new $controller();
		$controller_instance->init_session();
		call_user_func_array( array( &$controller_instance, $method ), $hg_router->get_args() );
	}
	
	static function get_controller() {
		$hg_session = HG_Arsenal::get_hgsession();
		$op = isset( $hg_session[HG_SESSIONOP] ) ? $hg_session[HG_SESSIONOP] : '';
		$key = isset( $hg_session[HG_SESSIONOPKEY] ) ? $hg_session[HG_SESSIONOPKEY] : '';
		if ( empty( $op ) || empty( $key ) ) return NULL;
		
		$hg_setting = HG_Arsenal::load_engine( 'HG_Setting' );
		$lvl_session = $hg_setting->lvlsession;
		if ( !isset( $lvl_session[$op] ) || $key != $lvl_session[$op] ) {
			HG_Arsenal::clear_hgsession();
			return NULL;
		}
		return $op;
	}

}

?>