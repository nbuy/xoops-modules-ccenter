<?php
// show message list
// $Id: list.php,v 1.5 2009/10/05 06:00:15 nobu Exp $

include "../../mainfile.php";
include "functions.php";
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';

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

$labels=array('mtime'=>_MD_POSTDATE, 'formid'=>_MD_CONTACT_FORM,
	      'touid'=>_MD_CONTACT_FROM, 'status'=>_CC_STATUS);
$orders=array('mtime'=>'ASC', 'formid'=>'ASC', 'touid'=>'ASC', 'status'=>'ASC',
	      'orders'=>array('mtime'));

$listctrl = new ListCtrl('mylist', $orders);

$cond = " AND ".$listctrl->sqlcondition();

if (isset($_GET['form'])) {
    $cond .= " AND formid=".intval($_GET['form']);
}

$sqlx = "FROM ".CCMES." m,".FORMS." WHERE uid=$uid $cond AND fidref=formid";

$res = $xoopsDB->query("SELECT count(msgid) $sqlx");
list($total) = $xoopsDB->fetchRow($res);
$max = $xoopsModuleConfig['max_lists'];
$start = isset($_GET['start'])?intval($_GET['start']):0;

$nav = new XoopsPageNav($total, $max, $start, "start");
$xoopsTpl->assign('pagenav', $total>$max?$nav->renderNav():"");
$xoopsTpl->assign('statctrl', $listctrl->renderStat());
$xoopsTpl->assign('total', $total);
$xoopsTpl->assign('xoops_pagetitle', htmlspecialchars($xoopsModule->getVar('name')." - "._MD_CCENTER_QUERY));
$xoopsTpl->assign('labels', $listctrl->getLabels($labels));

$res = $xoopsDB->query("SELECT m.*, title $sqlx ".$listctrl->sqlorder(), $max, $start);

$list = array();

while ($data = $xoopsDB->fetchArray($res)) {
    $list[] = cc_message_entry($data);
}
$xoopsTpl->assign('list', $list);

include XOOPS_ROOT_PATH."/footer.php";
?>