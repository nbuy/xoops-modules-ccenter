<?php
// Changing message status
// $Id: status.php,v 1.4 2007/08/02 16:27:37 nobu Exp $

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
    if (is_evaluate($msgid, $uid, $pass)) {
	$xoopsDB->query("UPDATE ".MESSAGE." SET comment=$com,value=$eval,comtime=$now,status='c' WHERE msgid=$msgid");
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
	$res = $xoopsDB->query("UPDATE ".MESSAGE." SET touid=$uid WHERE msgid=$msgid AND touid=0");
	break;
    }
    redirect_header($redirect, 1, _MD_UPDATE_STATUS);
    exit;
}
?>
