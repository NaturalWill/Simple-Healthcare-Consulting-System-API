<?PHP
/**
 * view.php
 * 咨询查看
 */
 
//列出咨询
function listzx(){
	$start = req('start',0);
	$perpage = req('perpage',0);
	if($start<0) $start=0;
	if(empty($perpage))	$perpage = 10;
	$db = MysqliDb::getInstance();
	$stats = $db->getOne ("comment", "count(*) as cnt");
	$data=array();
	$data['total'] = $stats['cnt'];
	$list = $db->rawQuery("SELECT z.*, u.username FROM zixun z LEFT JOIN users u ON z.uid=u.uid ORDER BY z.dateline DESC LIMIT $start,$perpage");
	$data['count'] = $db->count;
	$data['list'] = $list;
	if ($db->count >= 0){
		showjson('do_success', 0, array("zixun"=>$data));
	}
	showjson('list_error');
}
//显示咨询内容
function showzx(){
	$zid = req('zid');
	$start = req('start',0);
	$perpage = req('perpage',0);
	if($start<0) $start=0;
	if(empty($perpage))	$perpage = 30;
	if(empty($zid))	showjson('zid_not_exist');
	
	$db = MysqliDb::getInstance();

	$data = $db->rawQueryOne ("SELECT z.*, u.username FROM zixun z LEFT JOIN users u ON z.uid=u.uid WHERE z.zid='$zid'");
	
	if ($db->count > 0){
		$db->where ("zid", $zid);
		$stats = $db->getOne ("comment", "count(*) as cnt");
		$data['total'] = $stats['cnt'];
		
		//if($start>=$data['total']) $start=0;
		$comment = $db->rawQuery("SELECT c.*,s.username FROM comment c LEFT JOIN users s ON c.uid=s.uid WHERE c.zid='$zid' ORDER BY c.cid LIMIT $start,$perpage");
		$data['count']=$db->count;
		$data['comment']=$comment ;
		showjson('do_success', 0, array("zixun"=>$data));
	}
	showjson('show_error');
}
?>