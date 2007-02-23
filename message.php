<?php
// show messages file
// $Id: message.php,v 1.1 2007/02/23 05:27:28 nobu Exp $

include "../../mainfile.php";
include "functions.php";

$myts =& MyTextSanitizer::getInstance();
$xoopsOption['template_main'] = "ccenter_message.html";
$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;

$msgid = intval($_GET['id']);
$res = $xoopsDB->query("SELECT m.*, title FROM ".MESSAGE." m,".FORMS." WHERE msgid=$msgid AND status<>'x' AND fidref=formid");
if (!$res || $xoopsDB->getRowsNum($res)==0) {
    redirect_header("message.php", 3, _NOPERM);
    exit;
}
$data = $xoopsDB->fetchArray($res);
if (!check_perm($data)) {
    redirect_header(XOOPS_URL.'/user.php', 3, _NOPERM);
    exit;
}
// referer
$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
if ($uid && $uid == $data['touid'] && $data['status']=='-') {
    $xoopsDB->queryF("UPDATE ".MESSAGE." SET status='a' WHERE msgid=".$msgid);
    $data['status'] = 'a';
}

include XOOPS_ROOT_PATH."/header.php";

$vals = unserialize_text($data['body']);
$pass = isset($_GET['p'])?$myts->stripSlashesGPC($_GET['p']):"";
$add = $pass?"p=".$pass:"";
$to_uname = XoopsUser::getUnameFromId($data['touid']);
$items=array();
foreach ($vals as $key=>$val) {
    if (preg_match('/^file=(\w.+)$/', $val, $d)) {
	$val = attach_image($data['msgid'], $d[1], false, $add);
    } else {
	$val = $myts->displayTarea($val);
    }
    $items[$key] = $val;
}
$data['comment'] = $myts->displayTarea($data['comment']);
$xoopsTpl->assign(
    array('subject'=>$data['title'],
	  'sender'=>xoops_getLinkedUnameFromId($data['uid']),
	  'sendto'=>$data['touid']?xoops_getLinkedUnameFromId($data['touid']):_MD_CONTACT_NOTYET,
	  'mdate'=>formatTimestamp($data['mtime']),
	  'data'=> $data,
	  'items'=>$items,
	  'status'=>$msg_status[$data['status']],
	  'is_eval'=>is_evaluate($msgid, $uid, $pass),
	  'is_mine'=>$data['touid']==$uid,
	  'own_status'=>array_slice($msg_status, 1, 3),
	));

include XOOPS_ROOT_PATH.'/include/comment_view.php';

include XOOPS_ROOT_PATH."/footer.php";
?>