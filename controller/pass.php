<?php

/**
 * 黑客游戏 通关提示
 * pass
 * @author paperen 2012-11-10
 */
class pass extends HG_Controller
{

	private $db;

	function __construct() {
		parent::__construct();
	}

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}

	/**
	 *
	 */
	public function index() {
		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'pass_index', $this->data );
	}

	public function restart() {
		HG_Arsenal::clear_hgsession();
		$redirect_url = HG_Arsenal::base_url('first');
		header("location:$redirect_url");
	}

}