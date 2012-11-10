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
		$db_config = array(
			'dbhost' => 'localhost',
			'dbuser' => 'root',
			'dbpw' => 'root',
			'dbname' => 'hackgame',
			'pconnect' => FALSE,
			'charset' => 'utf8',
			'prefix' => '',
		);
		$this->db = HG_Arsenal::db_init( $db_config, 'mysql' );
	}

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}

	/**
	 * 首页
	 */
	public function index() {
		if ( isset( $_POST['is_submit'] ) && $_POST['is_submit'] && HG_Arsenal::valid_token() ) {
			$this->_submit();
		}
		$this->set_pagetitle( __CLASS__ );

		$this->_create_userfile();

		$this->hg_view->load( 'fifth_form', $this->data );
	}

	private function _create_userfile() {
		$this->data['userfile'] = ( DEBUG ) ? 'adwd.php;jdd.jpg' : substr( md5( time() ), -10 ) . '.jpg';
	}

	/**
	 * 数据提交
	 */
	private function _submit() {
		$post_data = $this->_form_data();
		$this->data['post_data'] = $post_data;
		try {
			if ( empty( $post_data['nickname'] ) ) throw new Exception( '请填写昵称', 0 );
			if ( empty( $post_data['email'] ) ) throw new Exception( '请通讯邮箱', 0 );
			if ( !HG_Arsenal::valid_email( $post_data['email'] ) ) throw new Exception( '邮箱格式错误', 0 );
			if ( empty( $post_data['context'] ) ) throw new Exception( '请填写闯关感言', 0 );

			// validation
			$userfile = $post_data['userfile'];
			$pattern = '/\w+\.php\;\w+\.[jpg|jpeg|gif|png|bmp]/';
			if ( !preg_match( $pattern, $userfile ) ) throw new Exception( $post_data['userfile'], -1 );

			$insert_data = array(
				'nickname' => $post_data['nickname'],
				'email' => $post_data['email'],
				'context' => $post_data['context'],
				'addtime' => time(),
				'ip' => isset( $_SERVER['REMOTE_ADDR'] ) ? ip2long( $_SERVER['REMOTE_ADDR'] ) : 0,
			);
			$this->db->insert( 'winner', $insert_data );

			// 设置通关
			HG_Arsenal::set_hgsession( 'pass' );
			$this->data['success'] = TRUE;
		} catch ( Exception $e ) {
			$err_msg = $e->getMessage();
			$this->data['error'] = $err_msg;
		}
	}

	private function _form_data() {
		$post_data = array(
			'nickname' => trim( $_POST['nickname'] ),
			'email' => trim( $_POST['email'] ),
			'context' => trim( $_POST['context'] ),
			'userfile' => $_POST['userfile'],
		);
		return $post_data;
	}

	public function tip() {
		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'fifth_tip', $this->data );
	}

}