<?php

/**
 * arsenal 军火库
 */
class HG_Arsenal
{

	static $_loaded_class;

	static public function addhttp( $url ) {
		return ( false === strpos( $url, 'http://' ) ) ? 'http://' . $url : $url;
	}

	/**
	 * UChome加解密函数
	 * @param string $string 明文/密文
	 * @param string $operation DECODE解密/ENCODE加密
	 * @param string $key 密钥
	 * @param int $expiry 超时？
	 * @return string
	 */
	static public function authcode( $string, $operation = 'DECODE', $key = '', $expiry = 0 ) {
		$ckey_length = 4;
		$key = md5( $key ? $key : HG_KEY  );
		$keya = md5( substr( $key, 0, 16 ) );
		$keyb = md5( substr( $key, 16, 16 ) );
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr( $string, 0, $ckey_length ) : substr( md5( microtime() ), -$ckey_length )) : '';

		$cryptkey = $keya . md5( $keya . $keyc );
		$key_length = strlen( $cryptkey );

		$string = $operation == 'DECODE' ? base64_decode( substr( $string, $ckey_length ) ) : sprintf( '%010d', $expiry ? $expiry + time() : 0  ) . substr( md5( $string . $keyb ), 0, 16 ) . $string;
		$string_length = strlen( $string );

		$result = '';
		$box = range( 0, 255 );

		$rndkey = array( );
		for ( $i = 0; $i <= 255; $i++ ) {
			$rndkey[$i] = ord( $cryptkey[$i % $key_length] );
		}

		for ( $j = $i = 0; $i < 256; $i++ ) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for ( $a = $j = $i = 0; $i < $string_length; $i++ ) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr( ord( $string[$i] ) ^ ($box[($box[$a] + $box[$j]) % 256]) );
		}

		if ( $operation == 'DECODE' ) {
			if ( (substr( $result, 0, 10 ) == 0 || substr( $result, 0, 10 ) - time() > 0) && substr( $result, 10, 16 ) == substr( md5( substr( $result, 26 ) . $keyb ), 0, 16 ) ) {
				return substr( $result, 26 );
			} else {
				return '';
			}
		} else {
			return $keyc . str_replace( '=', '', base64_encode( $result ) );
		}
	}

	static public function isAjax() {
		if ( isset( $_POST['isajax'] ) && isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) return true;
		return false;
	}

	static public function decode_url() {
		$args = '';
		if ( isset( $_GET[HG_GET] ) ) $args = html_entity_decode( self::authcode( str_replace( ' ', '+', $_GET[HG_GET] ), 'DECODE' ) );
		if ( empty( $args ) ) return array( );
		$res = array( );
		$args = ( strpos( $args, '&' ) !== FALSE ) ? explode( '&', $args ) : $args;
		if ( is_array( $args ) ) {
			foreach ( $args as $arg ) {
				list($key, $data) = explode( '=', $arg );
				$res[$key] = $data;
			}
		} else {
			list($key, $data) = explode( '=', $args );
			$res[$key] = $data;
		}
		return $res;
	}

	static public function get_hgsession() {
		$args = '';
		if ( isset( $_SESSION[HG_SESSIONKEY] ) ) $args = html_entity_decode( self::authcode( str_replace( ' ', '+', $_SESSION[HG_SESSIONKEY] ), 'DECODE' ) );
		$res = array( );
		$args = ( strpos( $args, '&' ) ) ? explode( '&', $args ) : $args;
		if ( is_array( $args ) ) {
			foreach ( $args as $arg ) {
				list($key, $data) = explode( '=', $arg );
				$res[$key] = $data;
			}
		}
		return $res;
	}

	static public function set_hgsession( $op ) {
		$hg_setting =& self::load_engine( 'HG_Setting' );
		$lvlkey = isset( $hg_setting->lvlsession[$op] ) ? $hg_setting->lvlsession[$op] : array_shift( $hg_setting->lvlsession );
		$tmp = '';
		$nowses_data = self::get_hgsession();
		$nowses_data[HG_SESSIONOP] = $op;
		$nowses_data[HG_SESSIONOPKEY] = $lvlkey;

		/** 记录开始时间 */
		if ( !isset( $nowses_data[HG_SESSIONSTART] ) ) $nowses_data[HG_SESSIONSTART] = time();
		foreach ( $nowses_data as $k => $val )
			$tmp .= $k . '=' . $val . '&';
		$tmp = self::authcode( htmlspecialchars( substr( $tmp, 0, -1 ) ), 'ENCODE' );
		$_SESSION[HG_SESSIONKEY] = $tmp;
	}

	static public function add_hgsession( $key, $val ) {
		$nowses_data = self::getsession();
		$nowses_data[$key] = $val;
		self::update_hgsession( $nowses_data );
	}

	static public function clear_hgsession() {
		$_SESSION[HG_SESSIONKEY] = '';
	}

	static public function update_hgsession( $ses_data ) {
		$tmp = '';
		foreach ( $ses_data as $k => $val )
			$tmp .= $k . '=' . $val . '&';
		$tmp = substr( $tmp, 0, -1 );
		$tmp = self::authcode( htmlspecialchars( $tmp ), 'ENCODE' );
		$_SESSION[HG_SESSIONKEY] = $tmp;
	}

	static public function create_authkey( $str ) {
		$ses_datas = self::getsession();
		$ses_datas[HG_SESSIONAUTHKEY] = strtoupper( $str );
		$tmp = '';
		foreach ( $ses_datas as $k => $val )
			$tmp .= $k . '=' . $val . '&';
		$tmp = substr( $tmp, 0, -1 );
		$tmp = self::authcode( htmlspecialchars( $tmp ), 'ENCODE' );
		$_SESSION[HG_SESSIONKEY] = $tmp;
		return strtoupper( $str );
	}

	static public function code_authkey( $extra = '' ) {
		return md5( $extra . time() );
	}

	static public function get_authkey() {
		$ses_datas = self::getsession();
		return isset( $ses_datas[HG_SESSIONAUTHKEY] ) ? $ses_datas[HG_SESSIONAUTHKEY] : '';
	}

	static public function encode_url( $args, $base = '' ) {
		$tmp = '';
		if ( is_array( $args ) ) {
			foreach ( $args as $k => $val )
				$tmp .= $k . '=' . $val . '&';
			$tmp = substr( $tmp, 0, -1 );
		} else {
			$tmp = $args;
		}
		$tmp = self::authcode( htmlspecialchars( $tmp ), 'ENCODE' );
		return $base . '?' . HG_GET . '=' . $tmp;
	}

	/**
	 * deep_addslashes
	 * @param mixed $string
	 * @return mixed
	 */
	static public function saddslashes( $string ) {
		if ( !is_array( $string ) ) return addslashes( $string );
		foreach ( $string as $key => $val )
			$string[$key] = self::saddslashes( $val );
		return $string;
	}

	static public function dheader( $url ) {
		@ob_end_clean();
		header( "location:$url" );
		exit();
	}

	static public function format_lvltime( $timestamp ) {
		$h = date( 'H', $timestamp );
		$m = date( 'i', $timestamp );
		$s = date( 's', $timestamp );
		$ret = '';
		if ( '00' != $h ) $ret .= "<b class=\"stress\">$h</b> <small>h</small> ";
		if ( '00' != $m ) $ret .= "<b class=\"stress\">$m</b> <small>m</small> ";
		if ( '00' != $s ) $ret .= "<b class=\"stress\">$s</b> <small>s</small> ";
		return $ret;
	}

	static public function get_clientIP() {
		if ( getenv( 'HTTP_CLIENT_IP' ) ) {
			$onlineip = getenv( 'HTTP_CLIENT_IP' );
		} elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
			$onlineip = getenv( 'HTTP_X_FORWARDED_FOR' );
		} elseif ( getenv( 'REMOTE_ADDR' ) ) {
			$onlineip = getenv( 'REMOTE_ADDR' );
		} else {
			$onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
		}
		return $onlineip;
	}

	static public function is_email( $str ) {
		return eregi( '^[-_A-Za-z0-9.\u4E00-\u9FA5]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$', $str );
	}

	static public function cache_write( $name, $var, $values ) {
		$cachefile = ROOT . 'data/' . $name . '.php';
		$cachetext = "<?php\r\n" . "if(!defined('INRUN')) exit();\r\n" . '$' . $var . '=' . self::arrayeval( $values ) . "\r\n?>";
		if ( !self::swritefile( $cachefile, $cachetext, 'w+' ) ) {
			return false;
		}
	}

	static public function arrayeval( $array, $level = 0 ) {
		$space = '';
		for ( $i = 0; $i <= $level; $i++ ) {
			$space .= "\t";
		}
		$evaluate = "Array\n$space(\n";
		$comma = $space;
		foreach ( $array as $key => $val ) {
			$key = is_string( $key ) ? '\'' . addcslashes( $key, '\'\\' ) . '\'' : $key;
			$val = !is_array( $val ) && (!preg_match( "/^\-?\d+$/", $val ) || strlen( $val ) > 12 || substr( $val, 0, 1 ) == '0') ? '\'' . addcslashes( $val, '\'\\' ) . '\'' : $val;
			if ( is_array( $val ) ) {
				$evaluate .= "$comma$key => " . self::arrayeval( $val, $level + 1 );
			} else {
				$evaluate .= "$comma$key => $val";
			}
			$comma = ",\n$space";
		}
		$evaluate .= "\n$space)";
		return $evaluate;
	}

	static public function swritefile( $filename, $writetext, $openmod='w' ) {
		$fp = @fopen( $filename, $openmod );
		if ( $fp ) {
			flock( $fp, 2 );
			fwrite( $fp, $writetext );
			fclose( $fp );
			return true;
		} else {
			return false;
		}
	}

	static public function is_Admin() {
		if ( !isset( $_SESSION[HG_ADMINKEY] ) ) return false;
		if ( $_SESSION[HG_ADMINKEY] != HG_ADMINVAL ) return false;
		return true;
	}

	static public function create_adminauth() {
		$auth = strtoupper( substr( md5( time() ), 0, 5 ) );
		$_SESSION[HG_ADMINAUTHKEY] = $auth;
		return $auth;
	}

	static public function set_adminsession( $val ) {
		$_SESSION[HG_ADMINKEY] = $val;
	}

	static public function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array( ) ) {
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&d=$d&r=$r";
		if ( $img ) {
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}

	static public function sscandir( $dir ) {
		$files = scandir( $dir );
		$result = array( );
		foreach ( $files as $k => $filename ) {
			if ( '.' == $filename || '..' == $filename ) continue;
			$result[] = $filename;
		}
		return $result;
	}

	static public function get_winnerdata( $files ) {
		$winner_datas = array( );
		foreach ( $files as $k => $file ) {
			@include( ROOT . 'data/' . WINNER_DIRECTORY . '/' . $file );
			$winner_datas[] = isset( $record ) ? $record : '';
		}
		return $winner_datas;
	}

	static public function clear_adminsession() {
		$_SESSION[HG_ADMINKEY] = '';
	}

	static public function &load_engine( $classname, $folder = 'engine' ) {
		if ( isset( self::$_loaded_class[$classname] ) ) return self::$_loaded_class[$classname];
		if ( $folder ) $folder .= DIRECTORY_SEPARATOR;
		$classfile = ROOT . $folder . "{$classname}.php";
		if ( !file_exists( $classfile ) ) exit( "{$classfile} 不存在" );
		require( $classfile );
		self::$_loaded_class[$classname] = new $classname();
		return self::$_loaded_class[$classname];
	}

	static public function get_engine() {
		return self::$_loaded_class;
	}

	static public function &init_db( $db_config ) {
		$db_class = 'Class_' . DB_TYPE;
		$db_class_file = $db_class . '.php';
		if ( !file_exists( $db_class_file ) ) exit( "{$db_class}数据库操作类文件不存在" );
		require( ENGINE . $db_class_file );
		$db = new $db_class();
		$db->connect( $db_config );
		return $db;
	}

	static public function level_url( $index = 1 ) {
		$hg_setting = & self::load_engine( 'HG_Setting' );
		$lvlsession = array_keys( $hg_setting->lvlsession );
		$lvlkey = isset( $lvlsession[$index] ) ? $lvlsession[$index] : $lvlsession[0];
		return self::url( $lvlkey );
	}

	static public function url( $c, $m = 'index', $paras = array( ) ) {
		$hg_setting = & self::load_engine( 'HG_Setting' );
		$site_url = trim( $hg_setting->siteurl, '/' ) . '/';
		$paras = array_merge( array(
			HG_CONTROLLER_SIGN => $c,
			HG_METHOD_SIGN => $m,
				), $paras );
		return $site_url . '?' . http_build_query( $paras );
	}

	static public function db_init( $db_file = '' ) {
		$hg_setting = & self::load_engine( 'HG_Setting' );
		$db_type = $hg_setting->db_type;
		$db_class = "DB_" . strtolower( $db_type );
		$db =& self::load_engine( $db_class );
		$db_config = $hg_setting->db_config;
		if ( $db_file ) $db_config['file'] = $db_file;
		$db->connect( $db_config );
		return $db;
	}

	/**
	 * 文本截取
	 * @param string $str 中文文本
	 * @param int $length 截取长度
	 * @return string 截取后的文本
	 */
	static public function gbk_substr( $string, $length, $from = 0 )
	{
		$string = strip_tags( $string );
		if ( $length == 0 )
		{
			return $string;
		}
		else
		{
			return preg_replace( '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' .
							'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $length . '}).*#s', '$1', $string );
		}
	}

	static public function config_item( $key ) {
		$hg_setting = self::load_engine('HG_Setting');
		return $hg_setting->$key;
	}

	static public function page_title( $key = '' ) {
		$hg_setting = self::load_engine( 'HG_Setting' );
		$title_arr = $hg_setting->title;
		return ( $key && isset( $title_arr[$key] ) ) ? $title_arr[$key] . ' ' . $hg_setting->sitename : $hg_setting->sitename;
	}

	static public function base_url( $uri = '' ) {
		$hg_setting = self::load_engine( 'HG_Setting' );
		$siteurl = $hg_setting->siteurl;
		return trim( $siteurl, '/' ) . '/' . $uri;
	}

	static public function get_token() {
		$token = md5( time() );
		$_SESSION[HG_SESSIONAUTHKEY] = $token;
		return "<input type=\"hidden\" name=\"token\" value=\"{$token}\" />";
	}

	static public function valid_token() {
		if ( DEBUG ) return TRUE;
		$session_token = isset( $_SESSION[HG_SESSIONAUTHKEY] ) ? $_SESSION[HG_SESSIONAUTHKEY] : '';
		if ( empty( $session_token ) ) return FALSE;
		$post_token = isset( $_POST['token'] ) ? $_POST['token'] : '';
		if ( empty( $post_token ) ) return FALSE;
		$_SESSION[HG_SESSIONAUTHKEY] = '';
		return ( $session_token === $post_token );
	}

}

?>
