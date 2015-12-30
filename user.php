<?php
/**
 * common.php
 * 用户操作
 */

//注册用户
function register(){
	$data = array();
	$data['username'] = req('username');
	$data['password'] = req('password');
	if($data['username'] && $data['password']){
		$db = MysqliDb::getInstance();
		$data['usertype'] = 0;
		$id = $db->insert ('users', $data);
		if($id) showjson('do_success', 0);
		showjson('username_exist');
	}
	showjson('register_error');
}
//验证用户名密码
function login(){
	$password = req('password');
	$username = req('username');
	$db = MysqliDb::getInstance();
	if($password && $username) {
		$db->where('username', $username);
		if($user = $db->getOne('users')) {
			if($user['password'] == $password) {
				$auth = authcode("$user[password]\t$user[uid]", 'ENCODE');
				showjson('do_success', 0, array("auth"=>rawurlencode($auth)));
			}
			showjson('password_error');
		}
	}
	showjson('login_error');
}
