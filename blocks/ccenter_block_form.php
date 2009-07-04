<?php
// Display contact form in block
// $Id: ccenter_block_form.php,v 1.5 2009/07/04 05:24:38 nobu Exp $

global $xoopsConfig;

$moddir = dirname(dirname(__FILE__));
$lang = $xoopsConfig['language'];
$main = "$moddir/language/$lang/main.php";
if (!file_exists($main)) $main = "$moddir/language/english/main.php";
include_once $main;
include_once "$moddir/functions.php";

function b_ccenter_form_show($options) {
    global $xoopsUser, $xoopsDB, $xoopsTpl;
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
    $form['action'] = 'index.php?form='.$form['formid'];
    $template = render_form($form, 'form');
    return array('content'=>$xoopsTpl->fetch('db:'.$template));
}

function b_ccenter_form_edit($options) {
    global $xoopsConfig, $msg_status, $xoopsDB;
    $oid = intval($options[0]);
    $ln = "<div><b>"._BL_CCENTER_FORMS_ID."</b> ".
	"<select name='options[0]'>\n<option value='0'>".
	_BL_CCENTER_FORMS_FIRST."</option>\n";
    $res = $xoopsDB->query("SELECT formid,title FROM ".FORMS." WHERE active ORDER BY weight,formid");
    while (list($id, $title)=$xoopsDB->fetchRow($res)) {
	$ck = ($id==$oid)?" selected='selected'":"";
	$ln .= "<option value='$id'$ck>".htmlspecialchars($title)."</option>";
    }
    $ln .= "</select>\n";
    return $ln;
}
?>
