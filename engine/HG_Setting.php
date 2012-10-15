<?php

/**
 * setting 设置引擎
 */
class HG_Setting
{

	private $_settings;

	function __get( $name ) {
		return isset( $this->_settings[$name] ) ? $this->_settings[$name] : '';
	}

	function __set( $name, $value ) {
		$this->_settings[$name] = $value;
	}

	function __construct() {
		if ( !@include_once( ROOT . 'data/basic.php' ) ) echo 'data_basic文件丢失';
		$this->_settings = $settings;
	}
}