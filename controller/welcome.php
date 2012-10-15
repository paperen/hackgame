<?php

/**
 * welcome控制器
 */
class welcome extends HG_Controller
{

	function init_session() {
		// nothing
	}

	public function index() {
		$data = array();
		$data['next_lvl_url'] = HG_Arsenal::level_url(1);
		$this->hg_view->load( 'welcome', $data );
	}

}