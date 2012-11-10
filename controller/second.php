<?php

/**
 * 黑客游戏 第二关
 * second
 * @author paperen 2012-10-25
 */
class second extends HG_Controller
{

	private $db;

	function __construct() {
		parent::__construct();
		$this->db = HG_Arsenal::db_init( array('file' => 'sqlite:db/second.sqlite') );
	}

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}

	/**
	 * 首页 新闻列表
	 */
	public function index() {

		$news_data = $this->db->select( 'select * from news' );
		$this->data['news_data'] = $news_data;

		$this->set_pagetitle( __CLASS__ );

		$this->_footer();

		$this->hg_view->load( 'second_index', $this->data );
	}

	/**
	 * 文章详细
	 * @param int $id 文章ID
	 */
	public function view( $id ) {
		$id = str_replace( 'sqlite_master', 'tablename', urldecode( $id ) );
		$sql = stripslashes( "select * from news where id={$id}" );
		$news_data = $this->db->get_one( $sql );
		$this->data['news_data'] = $news_data;

		$this->set_pagetitle( __CLASS__ );

		$this->_footer();

		$this->hg_view->load( 'second_view', $this->data );
	}

	/**
	 * 管理后台 登陆表单
	 */
	public function admin() {
		if ( isset( $_POST['submit'] ) && $_POST['submit'] && HG_Arsenal::valid_token() ) {
			try {
				$username = isset( $_POST['username'] ) ? trim( $_POST['username'] ) : '';
				$password = isset( $_POST['password'] ) ? trim( $_POST['password'] ) : '';
				if ( empty( $username ) || empty( $password ) ) throw new Exception( '帐号或密码不能为空', 0 );

				$sql = "select zz as password from admin_admin_admin where y='{$username}'";
				$admin = $this->db->get_one( $sql );
				if ( empty( $admin ) ) throw new Exception( '帐号或密码错误', 0 );
				if ( $admin['password'] !== $password ) throw new Exception( '密码错误', -1 );

				// 设置第二关
				HG_Arsenal::set_hgsession( 'third' );
				$this->data['success'] = TRUE;
			} catch ( Exception $e ) {
				$this->data['error'] = $e->getMessage();
			}
		}

		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'second_admin', $this->data );
	}

	/**
	 * 初始化底部数据
	 */
	private function _footer() {
		$link_arr = HG_Arsenal::config_item( 'links' );
		$link_arr[] = array(
			'txt' => '管理后台',
			'url' => HG_Arsenal::base_url( "second/admin" ),
		);
		$link_arr = array_reverse( $link_arr );
		$this->data['links'] = $link_arr;
	}

}