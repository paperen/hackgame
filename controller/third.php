<?php

/**
 * 黑客游戏 第三关
 * third
 * @author paperen 2012-10-28
 */
class third extends HG_Controller
{

	private $db;

	// 通关帐号与密码
	const ADMIN = 'post';
	const PASSWORD = 'injectionsql';

	function __construct() {
		parent::__construct();
	}

	function init_session() {
		HG_Arsenal::set_hgsession( __CLASS__ );
	}

	/**
	 * 首页
	 */
	public function index() {
		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'third_login', $this->data );
	}

	/**
	 * 普通用户登录
	 */
	public function user_login() {
		if ( isset( $_POST['is_submit'] ) && $_POST['is_submit'] && HG_Arsenal::valid_token() ) {
			try {
				$username = stripslashes( trim( $_POST['username'] ) );
				$password = trim( $_POST['password'] );
				if ( empty( $username ) || empty( $password ) ) throw new Exception( '用户名或密码为空', 0 );

				$password = md5( $password );
				$username = str_ireplace( 'sqlite_master', 'tablename', $username );

				// 单引号
				if ( $username == "'" ) throw new Exception( '单引号', -1 );

				// duplicate
				$pattern_duplicate = '/\' union select \d+ from \(select count\(\*\)\,concat\(floor\(rand\(0\)\*2\)\,\(select version\(\)\)\)a from information_schema\.tables group by a\)b\#/';
				if ( preg_match( $pattern_duplicate, $username ) ) {
					$sql = "SELECT * FROM admin_info WHERE user = '$username' AND password='$password' AND status='Y'";
					throw new Exception( $sql, -2 );
				}

				// post
				$pattern_post = '/\' union select \d+ from \(select count\(\*\)\,concat\(floor\(rand\(0\)\*2\)\,\(select user from admin_info\)\)a from information_schema\.tables group by a\)b\#/';
				if ( preg_match( $pattern_post, $username ) ) {
					$sql = "SELECT * FROM admin_info WHERE user = '$username' AND password='$password' AND status='Y'";
					throw new Exception( $sql, -3 );
				}

				// injectionsql
				$pattern_injectionsql = '/\' union select \d+ from \(select count\(\*\)\,concat\(floor\(rand\(0\)\*2\)\,\(select password from admin_info\)\)a from information_schema\.tables group by a\)b\#/';
				if ( preg_match( $pattern_injectionsql, $username ) ) {
					$sql = "SELECT * FROM admin_info WHERE user = '$username' AND password='$password' AND status='Y'";
					throw new Exception( $sql, -4 );
				}

				throw new Exception( '系统不可接受的字符', 1 );
			} catch ( Exception $e ) {
				$this->data['username'] = $username;
				$code = $e->getCode();
				$msg = $e->getMessage();
				switch ( $code ) {
					case 0:
						$err_msg = '用户名、密码不能为空';
						break;
					case -1:
						$err_msg = 'You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\' at line 1';
						break;
					case -2:
						$err_msg = $msg . "<br>Duplicate entry '15.1.34' for key 1";
						break;
					case -3:
						$err_msg = $msg . '<br><strong>post</strong>';
						break;
					case -4:
						$err_msg = $msg . '<br><strong>injectionsql
</strong>';
						break;
					default:
						$err_msg = '系统不可接受的字符';
				}
				$this->data['error'] = $err_msg;
			}
		}

		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'third_login', $this->data );
	}

	/**
	 * 管理员登录
	 */
	public function admin_login() {
		if ( isset( $_POST['is_submit'] ) && $_POST['is_submit'] && HG_Arsenal::valid_token() ) {
			try {
				$username = trim( $_POST['username'] );
				$password = trim( $_POST['password'] );
				if ( empty( $username ) || empty( $password ) ) throw new Exception( '用户名或密码为空', 0 );

				if ( $username !== self::ADMIN || $password !== self::PASSWORD ) throw new Exception( '帐号或密码为错误', -1 );

				// 设置第二关
				HG_Arsenal::set_hgsession( 'fourth' );
				$this->data['success'] = TRUE;
			} catch( Exception $e ) {
				$this->data['error'] = $e->getMessage();
			}
		}
		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'third_adminlogin', $this->data );
	}

}