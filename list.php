<?php
// show message list
// $Id: list.php,v 1.1 2007/02/23 05:27:28 nobu Exp $

include "../../mainfile.php";
include "functions.php";

$myts =& MyTextSanitizer::getInstance();
$xoopsOption['template_main'] = "ccenter_list.html";
$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL.'/user.php', 3, _NOPERM);
    exit;
}

include XOOPS_ROOT_PATH."/header.php";

// query from login user
if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
    if (isset($_GET['uid'])) $uid = intval($_GET['uid']);
}
$cond =  " AND NOT status IN ('x', 'f')";
if (isset($_GET['form'])) {
    $cond .= " AND formid=".intval($_GET['form']);
}
$res = $xoopsDB->query("SELECT m.*, title FROM ".MESSAGE." m,".FORMS." WHERE uid=$uid $cond AND fidref=formid ORDER BY status,mtime");

$list = array();
while ($data = $xoopsDB->fetchArray($res)) {
    $list[] = message_entry($data);
}
$xoopsTpl->assign('is_list', true);
$xoopsTpl->assign('list', $list);

$res = $xoopsDB->query("SELECT m.*, title FROM ".MESSAGE." m,".FORMS." WHERE touid=$uid $cond AND fidref=formid ORDER BY status,mtime");
$qlist = array();
while ($data = $xoopsDB->fetchArray($res)) {
    $qlist[] = message_entry($data);
}
$xoopsTpl->assign('qlist', $qlist);

include XOOPS_ROOT_PATH."/footer.php";
?>