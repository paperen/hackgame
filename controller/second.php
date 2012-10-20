<?php

class second extends HG_Controller
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
	 * 首页 新闻列表
	 */
	public function index() {

	}

}