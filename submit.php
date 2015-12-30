<?PHP
/**
 * common.php
 * 咨询提交
 */

//发布咨询
function zixun(){
	global $_SGLOBAL;
	checkauth();   //验证登陆
	
	$op=req('op');
	$db = MysqliDb::getInstance();
	
	if($op=='add'){

		$setarr = array(
			'uid' => $_SGLOBAL['uid'],
			'dateline' => $_SGLOBAL['timestamp']
		);
		$setarr['subject'] = req('subject');
		$setarr['message'] = req('message');
		if($setarr['subject']&&$setarr['message']){
			$id = $db->insert('zixun', $setarr);   //插入数据
			if ($id){
				showjson('do_success', 0, array("zid"=>$id));
			}
			showjson('submit_zixun_error');
		}
		showjson('subject_or_message_can_not_empty');
	}
	elseif($op=='del'){
		$zid=req('zid', 0);
		if(empty($zid)){
			showjson('non_normal_operation');
		}
		$db->where('zid', $zid);
		if($_SGLOBAL['usertype']==1){ //是否管理员
			
		}else{
			$db->where('uid', $_SGLOBAL['uid']);
		}
		$result=$db->delete('zixun');   //删除咨询
		if($result) {
			$db->where('zid', $zid);
			$db->delete('comment');  //删除对应的评论
			showjson('do_success',0);
		}
		else{
			showjson('zixun_not_exist');
		}
	}
	showjson('error_submit');
}
//评论咨询
function comment(){
	global $_SGLOBAL;
	checkauth();   //验证登陆
	
	$op=req('op');
	
	$db = MysqliDb::getInstance();
	if($op=='add'){

		$setarr = array('uid' => $_SGLOBAL['uid']);
		$setarr['message'] = req('message');
		$setarr['zid'] =req('zid',0);
		if($setarr['message']&&$setarr['zid']){
			$id = $db->insert('comment', $setarr);   //插入数据
			if ($id){
				showjson('do_success', 0, array("cid"=>$id));
			}
			showjson('submit_comment_error');
		}
		showjson('zid_or_message_can_not_empty');
	}
	elseif($op=='del'){
		$cid=req('cid', 0);
		if(empty($cid)){
			showjson('non_normal_operation');
		}
		$db->where('cid', $cid);
		if($_SGLOBAL['usertype']==1){ //是否管理员
			
		}else{
			$db->where('uid', $_SGLOBAL['uid']);
		}
		$result=$db->delete('comment');   //删除评论
		if($result) {
			showjson('do_success',0);
		}
		showjson('comment_not_exist');
	}
}