<?php

class first extends HG_Controller
{

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}

	public function index() {
		$db = HG_Arsenal::db_init( 'sqlite:db/first.sqlite' );
		print_r( $db->select( 'select * from news' ) );
	}

}