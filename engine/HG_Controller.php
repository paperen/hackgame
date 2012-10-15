<?php

/**
 * controller 基类
 */
abstract class HG_Controller
{

	abstract function init_session();

	function __construct() {
		$loaded_engine = HG_Arsenal::get_engine();
		foreach ( $loaded_engine as $k => $v ) {
			$k = strtolower( $k );
			$this->$k = & $v;
		}
	}

}

?>