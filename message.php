<?php
// show messages file
// $Id: message.php,v 1.14 2008/01/27 09:49:34 nobu Exp $

include "../../mainfile.php";
include "functions.php";

$myts =& MyTextSanitizer::getInstance();
$xoopsOption['template_main'] = "ccenter_message.html";
$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
$isadmin = $uid && $xoopsUser->isAdmin($xoopsModule->getVar('mid'));

$msgid = intval($_GET['id']);

if (isset($_GET['p'])) {
    $_SESSION['onepass'] = $myts->stripSlashesGPC($_GET['p']);
}
$pass = empty($_SESSION['onepass'])?"":$_SESSION['onepass'];

$cond = " AND status<>'x'";
if (!$isadmin) {
    if (is_object($xoopsUser)) {
        $cond .= " AND (cgroup IN (".join(',', $xoopsUser->getGroups()).") OR touid=$uid OR uid=$uid)";
    } else {
        $cond .= " AND onepass=".$xoopsDB->quoteString($pass);
    }
}
$res = $xoopsDB->query("SELECT m.*, title, cgroup, defs FROM ".CCMES." m,".FORMS." WHERE msgid=$msgid $cond AND fidref=formid");
if (!$res || $xoopsDB->getRowsNum($res)==0) {
    redirect_header("index.php", 3, _NOPERM);
    exit;
}
$data = $xoopsDB->fetchArray($res);
if (!cc_check_perm($data)) {
    redirect_header(XOOPS_URL.'/user.php', 3, _NOPERM);
    exit;
}
// referer
if ($uid && $uid == $data['touid'] && $data['status']=='-') {
    change_message_status($msgid, $uid, 'a');
    $data['status'] = 'a';
}

include XOOPS_ROOT_PATH."/header.php";

$breadcrumbs = new XoopsBreadcrumbs(_MD_CCENTER_RECEPTION, 'reception.php');

$vals = unserialize_text($data['body']);
$add = $pass?"p=".urlencode($pass):"";
$to_uname = XoopsUser::getUnameFromId($data['touid']);
$items = get_form_attribute($data['defs']);
$values=array();
foreach ($vals as $key=>$val) {
    if (isset($items[$key])) $key = $items[$key]['label'];
    if (preg_match('/^file=(.+)$/', $val, $d)) {
	$val = cc_attach_image($data['msgid'], $d[1], false, $add);
    } else {
	$val = $myts->displayTarea($val);
    }
    $values[$key] = $val;
}
$data['comment'] = $myts->displayTarea($data['comment']);
$isadmin = $uid && $xoopsUser->isAdmin($xoopsModule->getVar('mid'));
$title = $data['title'];
list($lab) = array_keys($values);
$breadcrumbs->set($title, "index.php?form=".$data['fidref']);
$breadcrumbs->set($lab.': '.$values[$lab], "message.php?id=".$data['msgid']);
$breadcrumbs->assign();
$xoopsTpl->assign(
    array('subject'=>$title,
	  'sender'=>xoops_getLinkedUnameFromId($data['uid']),
	  'sendto'=>$data['touid']?xoops_getLinkedUnameFromId($data['touid']):_MD_CONTACT_NOTYET,
	  'cdate'=>formatTimestamp($data['ctime']),
	  'mdate'=>myTimestamp($data['mtime'], 'l', _MD_TIME_UNIT),
	  'data'=> $data,
	  'items'=>$values,
	  'status'=>$msg_status[$data['status']],
	  'is_eval'=>is_cc_evaluate($msgid, $uid, $pass),
	  'is_mine'=>$data['touid']==$uid,
	  'is_getmine'=>$data['touid']==0 && $uid && in_array($data['cgroup'], $xoopsUser->getGroups()),
	  'own_status'=>array_slice($msg_status, 1, $isadmin?4:3),
	  'xoops_pagetitle'=> htmlspecialchars($xoopsModule->getVar('name')." | ".$data['title']),
	));


include XOOPS_ROOT_PATH.'/include/comment_view.php';

include XOOPS_ROOT_PATH."/footer.php";
?>