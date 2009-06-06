<?php
// show message list
// $Id: charge.php,v 1.3 2009/06/06 03:28:04 nobu Exp $

include "../../mainfile.php";
include "functions.php";
include_once XOOPS_ROOT_PATH.'/class/pagenav.php';

$myts =& MyTextSanitizer::getInstance();
$xoopsOption['template_main'] = "ccenter_charge.html";
$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL.'/user.php', 3, _NOPERM);
    exit;
}

include XOOPS_ROOT_PATH."/header.php";

// query from login user
if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) {
    if (isset($_GET['touid'])) $uid = intval($_GET['touid']);
}

$labels=array('mtime'=>_MD_MODDATE, 'formid'=>_MD_CONTACT_FORM,
	      'uid'=>_MD_CONTACT_FROM, 'status'=>_CC_STATUS);
$orders=array('mtime'=>'ASC', 'formid'=>'ASC', 'uid'=>'ASC', 'status'=>'ASC',
	      'stat'=>'- a', 'orders'=>array('status','mtime'));

$listctrl = new ListCtrl('charge', $orders);

$cond = " AND ".$listctrl->sqlcondition();

if (isset($_GET['form'])) {
    $cond .= " AND formid=".intval($_GET['form']);
}

$sqlx = "FROM ".CCMES." m,".FORMS." WHERE touid=$uid $cond AND fidref=formid";

$res = $xoopsDB->query("SELECT count(msgid) $sqlx");
list($total) = $xoopsDB->fetchRow($res);

$max = $xoopsModuleConfig['max_lists'];
$start = isset($_GET['start'])?intval($_GET['start']):0;

$nav = new XoopsPageNav($total, $max, $start, "start");
$xoopsTpl->assign('pagenav', $nav->renderNav());
$xoopsTpl->assign('statctrl', $listctrl->renderStat());
$xoopsTpl->assign('total', $total);
$xoopsTpl->assign('xoops_pagetitle', htmlspecialchars($xoopsModule->getVar('name')." - "._MD_CCENTER_CHARGE));
$xoopsTpl->assign('labels', $listctrl->getLabels($labels));

$res = $xoopsDB->query("SELECT m.*, title $sqlx ".$listctrl->sqlorder(), $max, $start);

$qlist = array();
while ($data = $xoopsDB->fetchArray($res)) {
    $qlist[] = cc_message_entry($data);
}
$xoopsTpl->assign('qlist', $qlist);

include XOOPS_ROOT_PATH."/footer.php";
?>