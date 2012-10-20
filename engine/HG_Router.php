<?php

/*
 * HG_Router
 * 路由类
 */

class HG_Router
{

	/**
	 * 当前控制器
	 * @var string
	 */
	private $_controller;

	/**
	 * 当前方法
	 * @var string
	 */
	private $_method;

	/**
	 * 其他参数
	 * @var string
	 */
	private $_args;
	private $_controller_sign;
	private $_method_sign;
	private $_session_level_key;
	private $_session_level_keymap;

	/**
	 * HG_Setting
	 * @var object
	 */
	private $_hg_setting;

	/**
	 * 构造函数
	 * @param HG_Setting $hg_setting
	 */
	function __construct() {
		$this->_controller_sign = HG_CONTROLLER_SIGN;
		$this->_method_sign = HG_METHOD_SIGN;
		$this->_session_level_key = HG_SESSIONKEY;
	}

	public function init( $hg_setting ) {
		$this->_hg_setting = & $hg_setting;
		$this->_session_level_keymap = $this->_hg_setting->lvlsession;
	}

	/**
	 * 分析URL
	 */
	public function parse() {
		$path_info = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : '';
		if ( $path_info ) {
			$path_info_arr = explode( '/', trim( $path_info, '/' ) );
			if ( count( $path_info_arr ) ) $this->_controller = array_shift( $path_info_arr );
			if ( count( $path_info_arr ) ) $this->_method = array_shift( $path_info_arr );
		}

		$parse_url_arr = parse_url( $_SERVER['REQUEST_URI'] );
		if ( isset( $parse_url_arr['query'] ) ) {
			if ( HG_ENCODE_ON ) {
				$get_arr = HG_Arsenal::decode_url();
			} else {
				parse_str( $parse_url_arr['query'], $get_arr );
			}
			$this->_args = array_values( $get_arr );
			$_GET = $get_arr;
		}
		$this->_set_default();

		// 根据session初始化当前的关卡
		$this->_init_level();

		// 验证关卡正确性
		$this->_check_level();
	}

	private function _init_level() {
		if ( !isset( $_SESSION[$this->_session_level_key] ) ) return;
		$session_level_val = $_SESSION[$this->_session_level_key];
		$session_level_map = array_flip( $this->_session_level_keymap );
		if ( isset( $session_level_map[$session_level_val] ) ) $this->_controller = $session_level_map[$session_level_val];
	}

	private function _check_level() {
		$all_level = array_keys( $this->_session_level_keymap );
		if ( !in_array( $this->_controller, $all_level ) ) $this->_controller = 'welcome';
	}

	/**
	 * 设置默认控制器与方法
	 */
	private function _set_default() {
		if ( empty( $this->_controller ) ) $this->_controller = $this->_hg_setting->default_controller;
		if ( empty( $this->_method ) ) {
			$this->_method = $this->_hg_setting->default_method;
		} else {
			if ( strcasecmp( substr( $this->_method, 0, 1 ), '_' ) === 0 ) $this->_method = $this->_hg_setting->default_method;
		}
	}

	public function get_controller() {
		return $this->_controller;
	}

	public function get_method() {
		return $this->_method;
	}

	public function get_args() {
		return $this->_args;
	}

}

?>