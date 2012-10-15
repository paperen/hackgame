<?php

/**
 * arsenal 军火库
 */

class HG_Arsenal
{
    static public function addhttp( $url ) {
        return ( false === strpos( $url , 'http://') ) ? 'http://' . $url : $url;
    }
    /**
     * UChome加解密函数
     * @param string $string 明文/密文
     * @param string $operation DECODE解密/ENCODE加密
     * @param string $key 密钥
     * @param int $expiry 超时？
     * @return string
     */
    static public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : HG_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
	} else {
            return $keyc.str_replace('=', '', base64_encode($result));
	}
    }
    static public function isAjax() {
        if ( isset( $_POST['isajax'] ) && isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) return true;
        return false;
    }
    static public function getargs() {
        $args = '';
        if ( isset( $_GET[HG_GET] ) ) $args = html_entity_decode( self::authcode(str_replace(' ', '+', $_GET[HG_GET]), 'DECODE') );
        if ( empty( $args ) ) return array();
        $res = array();
        $args = ( strpos($args, '&') ) ? explode('&', $args) : $args;
        if ( is_array( $args ) ) {
            foreach( $args as $arg ) {
                list($key, $data) = explode('=', $arg);
                $res[$key] = $data;
            }
        } else {
            list($key, $data) = explode('=', $args);
            $res[$key] = $data;
        }
        return $res;
    }
    static public function getsession() {
        $args = '';
        if ( isset( $_SESSION[HG_SESSIONKEY] ) ) $args = html_entity_decode( self::authcode(str_replace(' ', '+', $_SESSION[HG_SESSIONKEY]), 'DECODE') );
        $res = array();
        $args = ( strpos( $args, '&' ) ) ? explode('&', $args) : $args;
        if ( is_array( $args ) ) {
            foreach( $args as $arg ) {
                list($key, $data) = explode('=', $arg);
                $res[$key] = $data;
            }
        }
        return $res;
    }
    static public function sethgsession( $op, $lvlkey, $isstart = false ) {
        $tmp = '';
        $nowses_data = self::getsession();
        if ( $nowses_data ) {
            $nowses_data[HG_SESSIONOP] = $op;
            $nowses_data[HG_SESSIONOPKEY] = $lvlkey;
            if ( $isstart ) {
                /** 记录开始时间 */
                $nowses_data[HG_SESSIONSTART] = time();
            } else {
                /** 记录过关时间 */
                $nowses_data[$op] = time();
            }
            foreach( $nowses_data as $k => $val ) $tmp .= $k . '='. $val . '&';
            $tmp = substr($tmp, 0, -1);
        } else {
            $tmp = HG_SESSIONOP . '=' . $op . '&' . HG_SESSIONOPKEY . '=' . $lvlkey;
            if ( $isstart ) {
                /** 记录开始时间 */
                $tmp .= '&' . HG_SESSIONSTART . '=' . time();
            } else {
                /** 记录过关时间 */
                $tmp .= '&' . $op . '=' . time();
            }
        }
        $tmp = self::authcode(htmlspecialchars( $tmp ), 'ENCODE');
        $_SESSION[HG_SESSIONKEY] = $tmp;
    }
    static public function addhgsession( $key, $val ) {
        $nowses_data = self::getsession();
        $nowses_data[$key] = $val;
        self::recordhgsession( $nowses_data );
    }
    static public function recordhgsession( $ses_data ) {
        $tmp = '';
        foreach( $ses_data as $k => $val ) $tmp .= $k . '='. $val . '&';
        $tmp = substr($tmp, 0, -1);
        $tmp = self::authcode(htmlspecialchars( $tmp ), 'ENCODE');
        $_SESSION[HG_SESSIONKEY] = $tmp;
    }
    static public function create_authkey( $str ) {
        $ses_datas = self::getsession();
        $ses_datas[HG_SESSIONAUTHKEY] = strtoupper( $str );
        $tmp = '';
        foreach( $ses_datas as $k => $val ) $tmp .= $k . '='. $val . '&';
        $tmp = substr($tmp, 0, -1);
        $tmp = self::authcode(htmlspecialchars( $tmp ), 'ENCODE');
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
    static public function gethgurl( $args, $to = '/' ) {
        $tmp = '';
        if ( is_array( $args ) ) {
            foreach( $args as $k => $val ) $tmp .= $k . '='. $val . '&';
            $tmp = substr($tmp, 0, -1);
        } else {
            $tmp = $args;
        }
        $tmp = self::authcode(htmlspecialchars( $tmp ), 'ENCODE');
        return $to . '?' . HG_GET . '=' . $tmp;
    }
    /**
     * deep_addslashes
     * @param mixed $string
     * @return mixed
     */
    static public function saddslashes( $string ) {
        if(!is_array($string)) return addslashes($string);
        foreach($string as $key => $val) $string[$key] = self::saddslashes($val);
        return $string;
    }
    static public function dheader( $url ) {
        @ob_end_clean();
        header("location:$url");
        exit();
    }
    static public function format_lvltime( $timestamp ) {
        $h = date('H', $timestamp);
        $m = date('i', $timestamp);
        $s = date('s', $timestamp);
        $ret = '';
        if ( '00' != $h ) $ret .= "<b class=\"stress\">$h</b> <small>h</small> ";
        if ( '00' != $m ) $ret .= "<b class=\"stress\">$m</b> <small>m</small> ";
        if ( '00' != $s ) $ret .= "<b class=\"stress\">$s</b> <small>s</small> ";
        return $ret;
    }
    static public function get_clientIP() {
        if( getenv('HTTP_CLIENT_IP') ) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif( getenv('HTTP_X_FORWARDED_FOR') ) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif( getenv('REMOTE_ADDR') ) {
            $onlineip = getenv('REMOTE_ADDR');
        } else {
            $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
        }
        return $onlineip;
    }
    static public function is_email( $str ) {
        return eregi('^[-_A-Za-z0-9.\u4E00-\u9FA5]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$', $str);
    }
    static public function cache_write($name, $var, $values) {
        $cachefile = ROOT.'data/'.$name.'.php';
        $cachetext = "<?php\r\n"."if(!defined('INRUN')) exit();\r\n".'$'.$var.'='.self::arrayeval($values)."\r\n?>";
        if (!self::swritefile($cachefile, $cachetext, 'w+')) {
            return false;
        }
    }
    static public function arrayeval($array, $level = 0) {
        $space = '';
        for($i = 0; $i <= $level; $i++) {
            $space .= "\t";
        }
        $evaluate = "Array\n$space(\n";
        $comma = $space;
        foreach($array as $key => $val) {
            $key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
            $val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12 || substr($val, 0, 1)=='0') ? '\''.addcslashes($val, '\'\\').'\'' : $val;
            if(is_array($val)) {
                    $evaluate .= "$comma$key => ".self::arrayeval($val, $level + 1);
            } else {
                    $evaluate .= "$comma$key => $val";
            }
            $comma = ",\n$space";
        }
        $evaluate .= "\n$space)";
        return $evaluate;
    }
    static public function swritefile($filename, $writetext, $openmod='w') {
        $fp = @fopen($filename, $openmod);
        if($fp) {
            flock($fp, 2);
            fwrite($fp, $writetext);
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }
}

?>
