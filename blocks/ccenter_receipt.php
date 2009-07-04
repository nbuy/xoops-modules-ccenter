<?php
// Person receipt blocks
// $Id: ccenter_receipt.php,v 1.4 2009/07/04 05:24:38 nobu Exp $

global $xoopsConfig;

$moddir = dirname(dirname(__FILE__));
$lang = $xoopsConfig['language'];
$main = "$moddir/language/$lang/main.php";
if (!file_exists($main)) $main = "$moddir/language/english/main.php";
include_once $main;
include_once "$moddir/functions.php";

function b_ccenter_receipt_show($options) {
    global $xoopsDB, $xoopsUser, $msg_status;
    if (!is_object($xoopsUser)) return null;
    $uid = $xoopsUser->getVar('uid');
    $max = array_shift($options);
    $order = array_shift($options);
    foreach ($options as $v) {
	$s[] = "'$v'";
    }
    $cond =  " AND status IN (".join(',', $s).")";
    $order = $order=='asc'?'asc':'desc';
    $res = $xoopsDB->query("SELECT msgid, m.mtime, uid, status, title
  FROM ".$xoopsDB->prefix('ccenter_message')." m,
    ".$xoopsDB->prefix('ccenter_form')." WHERE (priuid=$uid OR priuid=0) $cond
   AND fidref=formid ORDER BY status,m.mtime $order", $max);
    if (!$res || $xoopsDB->getRowsNum($res)==0) return null;
    $list = array();
    while ($data = $xoopsDB->fetchArray($res)) {
	$data['mdate'] = formatTimestamp($data['mtime'], _BL_CCENTER_DATE_FMT);
	$data['uname'] = $xoopsUser->getUnameFromId($data['uid']);
	$data['statstr'] = $msg_status[$data['status']];
	$list[] = $data;
    }
    $mydir = basename(dirname(dirname(__FILE__)));
    return array('list'=>$list, 'dirname'=>$mydir);
}

function b_ccenter_receipt_edit($options) {
    global $xoopsConfig, $msg_status;
    $max = array_shift($options);
    $order = array_shift($options);
    $ln = "<div><b>"._BL_CCENTER_OPT_LINES."</b> <input name='options[0]' value='$max' size='4'/></div>\n";
    $ln .= "<div><b>"._BL_CCENTER_OPT_SORT."</b> <select name='options[1]'>\n";
    foreach (array('asc'=>_BL_CCENTER_SORT_ASC, 'desc'=>_BL_CCENTER_SORT_DESC) as $k=>$v) {
	$ck = ($k==$order)?" selected='selected'":"";
	$ln .= "<option value='$k'$ck>$v</option>";
    }
    $ln .= "</select></div>\n";
    $ln .= "<div><b>"._BL_CCENTER_OPT_STATS."</b>";
    foreach ($msg_status as $k=>$v) {
	$ck = in_array($k, $options)?" checked='checked'":"";
	$ln .= " <span class='cc_bopt'><input type='checkbox' name='options[]' value='$k'$ck/> $v<span>\n";
    }
    $ln .= "</div>\n";
    return $ln;
}
?>