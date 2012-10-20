<?php

/**
 * controller 基类
 */
abstract class HG_Controller
{

	abstract function init_session();

	// 放入视图数据
	public $data = array();

	function __construct() {
		$loaded_engine = HG_Arsenal::get_engine();
		foreach ( $loaded_engine as $k => $v ) {
			$k = strtolower( $k );
			$this->$k = & $v;
		}
	}

	/**
	 * 设置页面标题
	 * @param string $key 标题键值
	 */
	public function set_pagetitle( $key = '' ) {
		$this->data['title'] = HG_Arsenal::page_title( $key );
	}

}

?>