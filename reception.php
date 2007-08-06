<?php
// contact to member
// $Id: reception.php,v 1.5 2007/08/06 13:54:27 nobu Exp $

include "../../mainfile.php";
include "functions.php";

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL.'/user.php', 3, _NOPERM);
    exit;
}

$myts =& MyTextSanitizer::getInstance();
$id= isset($_GET['form'])?intval($_GET['form']):0;

if ($xoopsUser->isAdmin($xoopsModule->getVar('mid'))) $cond = "1";
else {
    $cond = '(priuid='.$xoopsUser->getVar('uid').
	' OR cgroup IN ('.join(',', $xoopsUser->getGroups()).'))';
}

if ($id) $cond .= ' AND formid='.$id;

$res = $xoopsDB->query("SELECT f.*,count(msgid) nmsg,max(m.mtime) ltime
 FROM ".FORMS." f LEFT JOIN ".MESSAGE." m ON fidref=formid AND status<>'x'
 WHERE $cond GROUP BY formid");

if (!$res || $xoopsDB->getRowsNum($res)==0) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}

$breadcrumbs = new XoopsBreadcrumbs();
$breadcrumbs->set(_MD_CCENTER_RECEPTION, "reception.php");

if ($xoopsDB->getRowsNum($res)>1) {
    include XOOPS_ROOT_PATH."/header.php";
    echo "<h2>"._MD_CCENTER_RECEPTION."</h2>\n";
    $breadcrumbs->assign();
    if ($xoopsDB->getRowsNum($res)) {
	echo "<ul>\n";
	while ($form=$xoopsDB->fetchArray($res)) {
	    echo "<li><a href='?form=".$form['formid']."'>".htmlspecialchars($form['title'])."</a> (".$form['nmsg'].") ".($form['ltime']?formatTimestamp($form['ltime']):'')."</li>\n";
	}
	echo "</ul>\n";
    }
    include XOOPS_ROOT_PATH."/footer.php";
    exit;
}


include XOOPS_ROOT_PATH."/header.php";

$xoopsOption['template_main'] = "ccenter_reception.html";

$form = $xoopsDB->fetchArray($res);
$id = $form['formid'];
$items = get_form_attribute($form['defs']);
$breadcrumbs->set(htmlspecialchars($form['title']), "reception.php?formid=$id");
$breadcrumbs->assign();

$start = isset($_GET['start'])?intval($_GET['start']):0;
if ($form['custom']) {
    $reg = array('/\\[desc\\](.*)\\[\/desc\\]/sU', '/<form[^>]*>(.*)<\\/form[^>]*>/sU', '/{CHECK_SCRIPT}/');
    $rep = array('\\1', '', '');
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
	break;
    }
}
$xoopsTpl->assign('form', $form);

include_once XOOPS_ROOT_PATH.'/class/pagenav.php';

$cond = "fidref=$id AND status<>'x'";
$res = $xoopsDB->query('SELECT count(*) FROM '.MESSAGE." WHERE $cond");
list($count) = $xoopsDB->fetchRow($res);
$max = $xoopsModuleConfig['max_lists'];
$args = preg_replace('/start=\\d+/', '', $_SERVER['QUERY_STRING']);
$nav = new XoopsPageNav($count, $max, $start, "start", $args);
$xoopsTpl->assign('pagenav', $count>$max?$nav->renderNav():"");

$res = $xoopsDB->query('SELECT * FROM '.MESSAGE." WHERE $cond ORDER BY msgid DESC", $max, $start);

$mlist = array();
while ($data = $xoopsDB->fetchArray($res)) {
    $values = unserialize_text($data['body']);
    if ($mpos>=0) {
	array_splice($values, $mpos, 0, array($data['email']));
    }
    $data['values'] = array_slice($values, 0, $max_cols);
    $data['uname'] = $xoopsUser->getUnameFromId($data['uid']);
    $data['mdate'] = formatTimestamp($data['mtime']);
    $data['stat'] = $msg_status[$data['status']];
    $mlist[] = $data;
}

$xoopsTpl->assign('mlist', $mlist);

include XOOPS_ROOT_PATH."/footer.php";
?>