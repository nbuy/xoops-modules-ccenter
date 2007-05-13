<?php
// Changing message status
// $Id: status.php,v 1.3 2007/05/13 05:44:01 nobu Exp $

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

function change_message_status($msgid, $touid, $stat) {
    global $xoopsDB, $msg_status, $xoopsUser, $xoopsModule;

    $isadmin = is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid'));
    $own_status = array_slice($msg_status, 1, $isadmin?4:3);
    if (empty($own_status[$stat])) return false; // Invalid status
    $s = $xoopsDB->quoteString($stat);
    $res = $xoopsDB->query("SELECT onepass,status,email,title FROM ".MESSAGE.",
".FORMS." WHERE msgid=$msgid AND touid=$touid AND status<>$s AND formid=fidref");
    if (!$res || $xoopsDB->getRowsNum($res)==0) return false;
    $data = $xoopsDB->fetchArray($res);
    $res = $xoopsDB->query("UPDATE ".MESSAGE." SET status=$s WHERE msgid=$msgid");
    if (!$res) die('DATABASE error');	// unknown error?
    $msgurl = XOOPS_URL."/modules/".basename(dirname(__FILE__))."/message.php?id=$msgid";
    if ($data['onepass']) $msgurl.="&p=".urlencode($data['onepass']);
    $tags = array('PREV_STATUS'=>$msg_status[$data['status']],
		  'NEW_STATUS'=>$msg_status[$stat],
		  'SUBJECT'=>$data['title'],
		  'CHANGE_BY'=>XoopsUser::getUnameFromId($touid),
		  'MSG_URL'=>$msgurl);

    $res = $xoopsDB->query("SELECT not_uid FROM ".$xoopsDB->prefix('xoopsnotifications')." WHERE not_modid=".$xoopsModule->getVar('mid')." AND not_event='comment' AND not_itemid=".$msgid);

    $member_handler =& xoops_gethandler('member');
    $users = array();
    while (list($not_uid) = $xoopsDB->fetchRow($res)) {
	if ($not_uid != $touid) {
	    $users[] =& $member_handler->getUser($not_uid);
	}
    }

    notify_mail('status_notify.tpl', $tags, $users, $data['email']);
    
    return true;
}