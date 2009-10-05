<?php
// contact to member
// $Id: reception.php,v 1.12 2009/10/05 06:00:15 nobu Exp $

include "../../mainfile.php";
include "functions.php";

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL.'/user.php', 3, _NOPERM);
    exit;
}

$myts =& MyTextSanitizer::getInstance();
$id= isset($_GET['form'])?intval($_GET['form']):0;
$isadmin = $xoopsUser->isAdmin($xoopsModule->getVar('mid'));
if ($isadmin) $cond = "1";
else {
    $cond = '(priuid='.$xoopsUser->getVar('uid').
	' OR cgroup IN ('.join(',', $xoopsUser->getGroups()).'))';
}

if ($id) $cond .= ' AND formid='.$id;

$res = $xoopsDB->query("SELECT f.*,count(msgid) nmsg,max(m.mtime) ltime
 FROM ".FORMS." f LEFT JOIN ".CCMES." m ON fidref=formid AND status<>".$xoopsDB->quoteString(_STATUS_DEL)."
 WHERE $cond GROUP BY formid");

if (!$res || $xoopsDB->getRowsNum($res)==0) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}

$breadcrumbs = new XoopsBreadcrumbs();
$breadcrumbs->set(_MD_CCENTER_RECEPTION, "reception.php");

if ($xoopsDB->getRowsNum($res)>1) {
    include XOOPS_ROOT_PATH."/header.php";
    $xoopsOption['template_main'] = "ccenter_reception.html";
    $breadcrumbs->assign();
    $forms = array();
    $member_handler =& xoops_gethandler('member');
    $groups = $member_handler->getGroupList(new Criteria('groupid', XOOPS_GROUP_ANONYMOUS, '!='));
    while ($form=$xoopsDB->fetchArray($res)) {
	$form['title'] = htmlspecialchars($form['title']);
	$form['ltime'] = $form['ltime']?formatTimestamp($form['ltime']):"";
	if ($form['priuid']) {
	    if ($form['priuid']<0) {
		$form['contact'] = '['.$groups[-$form['priuid']].']';
	    } else {
		$form['contact'] = xoops_getLinkedUnameFromId($form['priuid']);
	    }
	} elseif ($form['cgroup']) {
	    $form['contact'] = '['.$groups[$form['cgroup']].']';
	} else {
	    $form['contact'] = _MD_CONTACT_NOTYET;
	}
	$forms[] = $form;
    }
    $xoopsTpl->assign('forms', $forms);
    include XOOPS_ROOT_PATH."/footer.php";
    exit;
}


// check access permition
$form = $xoopsDB->fetchArray($res);
if (!cc_check_perm($form)) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}

include XOOPS_ROOT_PATH."/header.php";

$xoopsOption['template_main'] = "ccenter_reception.html";

$id = $form['formid'];
$items = get_form_attribute($form['defs']);
$breadcrumbs->set(htmlspecialchars($form['title']), "reception.php?formid=$id");
$breadcrumbs->assign();

$start = isset($_GET['start'])?intval($_GET['start']):0;
if ($form['custom']) {
    $reg = array('/\\[desc\\](.*)\\[\/desc\\]/sU', '/<form[^>]*>(.*)<\\/form[^>]*>/sU', '/{CHECK_SCRIPT}/');
    $rep = array('\\1', '', '');
    $form['action'] = '';
    $form['description'] = preg_replace($reg, $rep, custom_template($form, $items));
} else {
    $form['description'] = $myts->displayTarea($form['description']);
}
$form['mdate'] = formatTimestamp($form['mtime']);
foreach ($items as $k=>$item) {
    if (empty($item['label'])) unset($items[$k]);
}
$max_cols = 3;
$form['items'] = array_slice($items, 0, $max_cols);
$n = $mpos = -1;
foreach ($form['items'] as $item) {
    $n++;
    if ($item['type'] == 'mail') {
	$mpos = $n;
	$mlab = $item['name'];
	break;
    }
}

include_once XOOPS_ROOT_PATH.'/class/pagenav.php';

$cond = "fidref=$id AND status<>".$xoopsDB->quoteString(_STATUS_DEL);
$res = $xoopsDB->query('SELECT count(*) FROM '.CCMES." WHERE $cond");
list($count) = $xoopsDB->fetchRow($res);
$max = $xoopsModuleConfig['max_lists'];
$args = preg_replace('/start=\\d+/', '', $_SERVER['QUERY_STRING']);
$nav = new XoopsPageNav($count, $max, $start, "start", $args);
$xoopsTpl->assign('pagenav', $count>$max?$nav->renderNav():"");

if ($form['priuid'] < 0 && !$isadmin) {
    $cond .= " AND touid=".$xoopsUser->getVar('uid');
    $form['description'] = str_replace('{TO_NAME}', $xoopsUser->getVar('name'), $form['description']);
}

$xoopsTpl->assign('form', $form);

$res = $xoopsDB->query('SELECT * FROM '.CCMES." WHERE $cond ORDER BY msgid DESC", $max, $start);
$xoopsTpl->assign('export_range', $export_range);

$mlist = array();
while ($data = $xoopsDB->fetchArray($res)) {
    $values = unserialize_text($data['body']);
    if ($mpos>=0 && !isset($values[$mlab])) {
	array_splice($values, $mpos, 0, array($data['email']));
    }
    $data['values'] = array_slice($values, 0, $max_cols);
    $data['uname'] = $xoopsUser->getUnameFromId($data['uid']);
    $data['mdate'] = formatTimestamp($data['mtime']);
    $data['cdate'] = formatTimestamp($data['ctime']);
    $data['stat'] = $msg_status[$data['status']];
    $mlist[] = $data;
}

$xoopsTpl->assign('mlist', $mlist);

include XOOPS_ROOT_PATH."/footer.php";
?>
