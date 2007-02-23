<?php
// Person receipt blocks
// $Id: ccenter_receipt.php,v 1.1 2007/02/23 05:27:28 nobu Exp $

function b_ccenter_receipt_show($options) {
    global $xoopsDB, $xoopsUser;
    if (!is_object($xoopsUser)) return null;
    $uid = $xoopsUser->getVar('uid');
    $s = array();
    $stats = empty($options[0])?'-,a':$options[0];
    foreach (explode(',', $stats) as $v) {
	$s[] = "'$v'";
    }
    $cond =  " AND status IN (".join(',', $s).")";
    $res = $xoopsDB->query("SELECT msgid, m.mtime, uid, status, title
  FROM ".$xoopsDB->prefix('ccenter_message')." m,
    ".$xoopsDB->prefix('ccenter_form')." WHERE uid=$uid $cond
   AND fidref=formid ORDER BY status,m.mtime", $options[1]);
    echo $xoopsDB->error();
    if (!$res || $xoopsDB->getRowsNum($res)==0) return null;
    $list = array();
    while ($data = $xoopsDB->fetchArray($res)) {
	$data['mdate'] = formatTimestamp($data['mtime'], _BL_CCENTER_DATE_FMT);
	$data['uname'] = $xoopsUser->getUnameFromId($data['uid']);
	$list[] = $data;
    }
    $mydir = basename(dirname(dirname(__FILE__)));
    return array('list'=>$list, 'dirname'=>$mydir);
}

function b_ccenter_receipt_edit($options) {
    return "";
}
?>