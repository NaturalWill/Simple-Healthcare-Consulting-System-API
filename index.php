<?PHP
require_once ('common.php'); //引入公共文件

$do=req('do');
$ac=req('ac');

//允许的方法
$acs = array('user', 'submit', 'view');
if(empty($ac) || !in_array($ac, $acs)) {
	showjson('error_ac');
}
include_once(S_ROOT.$ac.'.php');
if(function_exists($do)){
	call_user_func($do);
}
showjson('error_do');
?>