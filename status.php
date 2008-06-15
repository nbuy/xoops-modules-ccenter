<?php
// Changing message status
// $Id: status.php,v 1.12 2008/06/15 13:57:15 nobu Exp $

include "../../mainfile.php";
include "functions.php";

$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
$myts =& MyTextSanitizer::getInstance();
$msgid = intval($_POST['id']);
$redirect = "message.php?id=".$msgid;
if (!empty($_POST['eval'])) {	// evaluate at last
    $eval = intval($_POST['eval']);
    $pass = $myts->stripSlashesGPC($_POST['pass']);
    $com = $myts->stripSlashesGPC($_POST['comment']);
    $now = time();
    if (is_cc_evaluate($msgid, $uid, $pass)) {
	$res = $xoopsDB->query("SELECT fidref,status FROM ".CCMES." WHERE msgid=$msgid");
	list($formid, $s) = $xoopsDB->fetchRow($res);
	$values = array("value=$eval",
			"comment=".$xoopsDB->quoteString($com),
			"comtime=$now", "atime=$now", "mtime=$now",
			"status=".$xoopsDB->quoteString(_STATUS_CLOSE));
	$xoopsDB->query("UPDATE ".CCMES." SET ".join(',',$values)." WHERE msgid=$msgid");
	$log = _MD_EVALS." ($eval)";
	$log .= "\n".sprintf(_CC_LOG_STATUS, $msg_status[$s], $msg_status[_STATUS_CLOSE]);
	$evalmsg = _MD_EVALS." ($eval)\n$com";
	$tags = array('X_COMMENT_URL'=>XOOPS_URL."/modules/".basename(dirname(__FILE__))."/message.php?id=$msgid\n\n".$evalmsg);
	$notification_handler =& xoops_gethandler('notification');
	$notification_handler->triggerEvent('message', $msgid, 'comment', $tags);
	cc_log_message($formid, $log, $msgid);
	redirect_header($redirect, 1, _MD_EVAL_THANKYOU);
    } else {
	redirect_header($redirect, 3, _NOPERM);
    }
} elseif (!empty($_POST['status'])) {
    $stat = $myts->stripSlashesGPC($_POST['status']);
    $res = $xoopsDB->query("SELECT fidref FROM ".CCMES." WHERE msgid=$msgid");
    list($fid) = $xoopsDB->fetchRow($res);
    if (change_message_status($msgid, $uid, $stat)) {
	if ($stat=='x') $redirect = "reception.php?form=$fid"; // delete the message
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
