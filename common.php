<?php

/**
 * common.php
 * 公共文件
 */

require_once ('MysqliDb.php'); //引入mysql操作类
require_once ('config.php'); //引入配置文件
//程序目录
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);

$_SGLOBAL = array();
//时间
$mtime = explode(' ', microtime());
$_SGLOBAL['timestamp'] = $mtime[1];
$_SGLOBAL['supe_starttime'] = $_SGLOBAL['timestamp'] + $mtime[0];

$_REQUEST['auth'] = rawurldecode(req('auth'));

$db = new MysqliDb($_DBCONFIG); //连接数据库

//获取$_GET或$_POST数据
function req($arg,$default=''){
  return empty($_REQUEST[$arg])?$default:$_REQUEST[$arg];
}

//字符串解密加密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;	// 随机密钥长度 取值 0-32;
				// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
				// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
				// 当此值为 0 时，则不产生随机密钥

	$key = md5($key ? $key : UC_KEY);
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

//判断当前用户登录状态
function checkauth() {
	global $_SGLOBAL;
	$auth = req('auth');
	if($auth) {
		$db = MysqliDb::getInstance();
		@list($password, $uid) = explode("\t", authcode($auth, 'DECODE'));
		$_SGLOBAL['uid'] = intval($uid);
		if($password && $_SGLOBAL['uid']) {
			$db->where('uid', $_SGLOBAL['uid']);
			if($user = $db->getOne('users')) {
				if($user['password'] == $password) {
					$_SGLOBAL['usertype'] = $user['usertype'];					
					$_SGLOBAL['username'] = $user['username'];
					return;
				}
			}
		}
	}
	showjson('to_login');
}


/**
 * 返回json数据
 * @param string  $code 错误代码，0代表正确，1代表错误
 * @param string  $message 错误信息
 * @param string  $data json数据
 */
function showjson($message, $code=1, $data=array()){
	ob_clean();	
	$r = array();
	$r['code'] = $code;
	$r['msg'] = $message;
	$r['data'] = $data;
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-Type: text/json;'); 
	echo json_encode($r);
	exit();
}

?>