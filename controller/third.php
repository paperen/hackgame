<?php

class third extends HG_Controller
{

	private $db;

	function __construct() {
		parent::__construct();
		$this->db = HG_Arsenal::db_init( 'sqlite:db/first.sqlite' );
	}

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}

	/**
	 * 首页
	 */
	public function index() {
		echo 'third';
	}

}