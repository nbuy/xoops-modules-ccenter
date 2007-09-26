<?php
// Changing message status
// $Id: status.php,v 1.6 2007/09/26 07:08:58 nobu Exp $

include "../../mainfile.php";
include "functions.php";

$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
$myts =& MyTextSanitizer::getInstance();
$msgid = intval($_POST['id']);
$redirect = "message.php?id=".$msgid;
if (!empty($_POST['eval'])) {	// evaluate at last
    $eval = intval($_POST['eval']);
    $pass = $myts->stripSlashesGPC($_POST['pass']);
    $com = $xoopsDB->quoteString($myts->stripSlashesGPC($_POST['comment']));
    $now = time();
    if (is_cc_evaluate($msgid, $uid, $pass)) {
	$xoopsDB->query("UPDATE ".CCMES." SET comment=$com,value=$eval,comtime=$now,status='c' WHERE msgid=$msgid");
	redirect_header($redirect, 1, _MD_EVAL_THANKYOU);
    } else {
	redirect_header($redirect, 3, _NOPERM);
    }
} elseif (!empty($_POST['status'])) {
    if (change_message_status($msgid, $uid, $myts->stripSlashesGPC($_POST['status']))) {
	redirect_header($redirect, 1, _MD_UPDATE_STATUS);
	exit;
    }
    redirect_header($redirect, 3, _MD_UPDATE_FAILED);
} else {
    switch ($_POST['op']) {
    case 'myself':
	$res = $xoopsDB->query("SELECT fidref,status,title FROM ".CCMES." LEFT JOIN ".FORMS." ON formid=fidref WHERE msgid=$msgid AND touid=0");
	if ($res && $xoopsDB->getRowsNum($res)) {
	    list($fid, $s, $title) = $xoopsDB->fetchRow($res);
	    $now = time();
	    $set = "SET mtime=$now, touid=$uid, status=".$xoopsDB->quoteString('a');
	    $res = $xoopsDB->query("UPDATE ".CCMES." $set WHERE msgid=$msgid");
	    $log = sprintf(_CC_LOG_TOUSER, _CC_USER_NONE, $xoopsUser->getVar('uname'));
	    $log .= "\n".sprintf(_CC_LOG_STATUS, $msg_status[$s], $msg_status['a']);
	    $notification_handler =& xoops_gethandler('notification');
	    $notification_handler->subscribe('message', $msgid, 'comment');
	    //$notification_handler->subscribe('message', $msgid, 'status');

	    cc_log_message($fid, $log, $msgid);
	}
	
	break;
    }
    redirect_header($redirect, 1, _MD_UPDATE_STATUS);
    exit;
}
?>
