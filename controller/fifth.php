<?php

/**
 * 黑客游戏 第五关
 * fifth
 * @author paperen 2012-10-28
 */
class fifth extends HG_Controller
{

	private $db;

	function __construct() {
		parent::__construct();
		$this->db = HG_Arsenal::db_init( 'sqlite:db/second.sqlite' );
	}

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}

	/**
	 * 首页
	 */
	public function index() {
		echo 5;
	}

}