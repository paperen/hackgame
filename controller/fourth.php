<?php

/**
 * 黑客游戏 第四关
 * fourth
 * @author paperen 2012-10-28
 */
class fourth extends HG_Controller
{

	private $db;

	const SQL = 'select @@datadir';
	const SQLCLUE = '/home/www/mysql/data';
	private $_file_arr = array(
		'/etc/passwd' => '<ul>
			<li>root:x:0:0:root:/root:/bin/bash</li>
			<li>daemon:x:1:1:daemon:/usr/sbin:/bin/sh</li>
			<li>bin:x:2:2:bin:/bin:/bin/sh</li>
			<li>sys:x:3:3:sys:/dev:/bin/sh</li>
			<li>sync:x:4:65534:sync:/bin:/bin/sync</li>
			<li>apache:x:48:80:apache:/home/www/apache: /bin/bash</li></ul>',
		'/home/www/htdocs/.htaccess' => '<h4>AuthType Basic</h4><p>AuthName "Silic Group HackGame 2012"</p><p>AuthUserFile .htpasswd</p><p>Require valid-user</p>',
		'/home/www/htdocs/.htpasswd' => '<p># E58F8BE5AD90E59089E794B0</p><p>Tomoko:44h15nPjBuVCs</p>',
	);
	const USERNAME = 'Tomoko';
	const PASSWORD = 'Yoshida';

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
		$this->sql();
	}

	/**
	 * 执行SQL
	 */
	public function sql() {
		if ( isset( $_POST['submit'] ) && $_POST['submit'] && HG_Arsenal::valid_token() ) {
			try {
				$sql = isset( $_POST['sql'] ) ? trim( $_POST['sql'] ) : '';
				$this->data['sql'] = $sql;
				// sql为空
				if ( empty( $sql ) ) throw new Exception( 'SQL为空', 0 );

				// sql不符合
				if ( $sql !== self::SQL ) throw new Exception( '您的语句似乎对本关闯关没什么用处', -1 );

				$this->data['success'] = TRUE;
				$this->data['result'] = self::SQLCLUE;
			} catch( Exception $e ) {
				$this->data['result'] = $e->getMessage();
			}
		}
		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'fourth_sql', $this->data );
	}

	/**
	 * file操作
	 */
	public function file() {
		if ( isset( $_POST['submit'] ) && $_POST['submit'] && HG_Arsenal::valid_token() ) {
			try {
				$file = isset( $_POST['file'] ) ? trim( $_POST['file'] ) : '';
				$this->data['file'] = $file;
				// sql为空
				if ( empty( $file ) ) throw new Exception( '文件输入为空', 0 );

				// file不符合设计之中
				$valid_file_keys = array_keys( $this->_file_arr );
				if ( !in_array( $file, $valid_file_keys ) ) throw new Exception( '此文件的读取对您闯关帮助不大', -1 );

				$this->data['success'] = TRUE;
				$this->data['result'] = $this->_file_arr[$file];
			} catch( Exception $e ) {
				$this->data['result'] = $e->getMessage();
			}
		}
		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'fourth_file', $this->data );
	}

	/**
	 * 服务器管理
	 */
	public function server() {
		if ( isset( $_POST['submit'] ) && $_POST['submit'] && HG_Arsenal::valid_token() ) {
			try {
				$username = isset( $_POST['username'] ) ? $_POST['username'] : '';
				$password = $_POST['password'];
				if ( empty( $username ) || empty( $password ) ) throw new Exception( '帐号或密码不能为空', 0 );

				if ( $username !== self::USERNAME || $password !== self::PASSWORD ) throw new Exception( '帐号或密码错误', -1 );

				// 设置第二关
				HG_Arsenal::set_hgsession( 'fifth' );
				$this->data['success'] = TRUE;
			} catch( Exception $e ) {
				$this->data['error'] = $e->getMessage();
			}
		}

		$this->set_pagetitle( __CLASS__ );

		$this->hg_view->load( 'fourth_server', $this->data );
	}
}