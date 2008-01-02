<?php
// Display contact form in block
// $Id: ccenter_block_form.php,v 1.1 2008/01/02 10:00:37 nobu Exp $

global $xoopsConfig;

$moddir = dirname(dirname(__FILE__));
$lang = $xoopsConfig['language'];
$main = "$moddir/language/$lang/main.php";
if (!file_exists($main)) $main = "$moddir/language/english/main.php";
include_once $main;
include_once "$moddir/functions.php";

function b_ccenter_form_show($options) {
    global $xoopsUser, $xoopsDB;
    $cond = "active";
    if (is_object($xoopsUser)) {
	$conds = array();
	foreach ($xoopsUser->getGroups() as $gid) {
	    $conds[] = "grpperm LIKE '%|$gid|%'";
	}
	if ($conds) $cond .= " AND (".join(' OR ', $conds).")";
    } else {
	$cond .= " AND grpperm LIKE '%|".XOOPS_GROUP_ANONYMOUS."|%'";
    }
    if (!empty($options[0])) $cond .= ' AND formid='.intval($options[0]);
    $res = $xoopsDB->query("SELECT * FROM ".FORMS." WHERE $cond ORDER BY weight,formid");
    if (!$res || $xoopsDB->getRowsNum($res)==0) return array();
    $form = $xoopsDB->fetchArray($res);
    $myts =& MyTextSanitizer::getInstance();
    $items = get_form_attribute($form['defs']);
    assign_form_widgets($items);
    $form['items'] =& $items;
    $form['action'] = XOOPS_URL.'/modules/'.basename(dirname(dirname(__FILE__))).'/index.php?form='.$form['formid'];

    set_checkvalue($form);

    if ($form['custom']) {
	$out = custom_template($form, $items, false);
    } else {
	$form['description'] = $myts->displayTarea($form['description']);
	$tpl = new XoopsTpl();
	$tpl->assign('form', $form);
	$tpl->assign('op', 'confirm');
	$out = $tpl->fetch('db:ccenter_form.html');
    }
    return array('content'=>$out);
}

function b_ccenter_form_edit($options) {
    global $xoopsConfig, $msg_status;
    $id = intval($options[0]);
    $ln = "<div><b>"._BL_CCENTER_FORMS_ID."</b> <input name='options[0]' value='$id' size='4'/></div>\n";
    return $ln;
}
?>