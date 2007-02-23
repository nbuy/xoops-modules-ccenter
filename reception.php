<?php
// contact to member
// $Id: reception.php,v 1.1 2007/02/23 05:27:28 nobu Exp $

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
 FROM ".FORMS." f LEFT JOIN ".MESSAGE." m ON fidref=formid WHERE $cond
 GROUP BY formid");

if (!$res || $xoopsDB->getRowsNum($res)==0) {
    redirect_header('index.php', 3, _NOPERM);
    exit;
}

if ($xoopsDB->getRowsNum($res)>1) {
    include XOOPS_ROOT_PATH."/header.php";
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
if ($form['custom']) {
    $reg = array('/\\[desc\\](.*)\\[\/desc\\]/s', '/<form[^>]*>(.*)<\\/form[^>]*>/s', '/{CHECK_SCRIPT}/');
    $rep = array('\\1', '', '');
    $form['description'] = preg_replace($reg, $rep, $form['description']);
} else {
    $form['description'] = $myts->displayTarea($form['description']);
}
$form['mdate'] = formatTimestamp($form['mtime']);
$items = get_form_attribute($form['defs']);
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

$res = $xoopsDB->query('SELECT count(*) FROM '.MESSAGE." WHERE fidref=$id");
list($count) = $xoopsDB->fetchRow($res);
$max = 20;
$start = isset($_GET['start'])?intval($_GET['start']):0;
$args = preg_replace('/start=\\d+/', '', $_SERVER['QUERY_STRING']);
$nav = new XoopsPageNav($count, $max, $start, "start", $args);
$xoopsTpl->assign('pagenav', $count>$max?$nav->renderNav():"");
$res = $xoopsDB->query('SELECT * FROM '.MESSAGE." WHERE fidref=$id ORDER BY msgid DESC", $max, $start);

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