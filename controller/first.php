<?php

class first extends HG_Controller
{

	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = HG_Arsenal::db_init( 'sqlite:db/first.sqlite' );
	}

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}
	
	public function index() {
		$data = array();
		$news_data = $this->db->select( 'select * from news' );
		$data['news_data'] = $news_data;
		$data['title'] = '[第一关]';
		$this->hg_view->load( 'lvl1_index', $data );
	}

}