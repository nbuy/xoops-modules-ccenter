<?php
// $Id: comment_functions.php,v 1.8 2008/06/01 13:54:23 nobu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

// comment callback functions
include_once "functions.php";

function ccenter_com_update($msgid, $total_num){
    return true;
}

function ccenter_com_approve(&$comment){
    global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsConfig;

    $msgid = $comment->getVar('com_itemid');
    $res = $xoopsDB->query("SELECT uid, touid, email, onepass, fidref, title, status FROM ".CCMES.", ".FORMS." WHERE msgid=$msgid AND formid=fidref");

    $comid = $comment->getVar('com_id');
    if ($res && $xoopsDB->getRowsNum($res)) {
	$data = $xoopsDB->fetchArray($res);
	$email = $data['email'];
	$s = $data['status'];

	$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
	$msg = _CC_LOG_COMMENT;
	$status = ''; // new status
	$now = time();
	$values = array('mtime='.$now);
	if ($uid && $uid == $data['touid']) { // comment by charge
	    // status to replyed
	    if ($s==_STATUS_ACCEPT) $status = _STATUS_REPLY;
	    $msg .= _CC_LOG_BYCHARGE;
	} elseif ($uid==0 || $uid==$data['uid']) { // comment by order person
	    // status back to contacting
	    if ($s==_STATUS_REPLY || $s==_STATUS_CLOSE) $status = _STATUS_ACCEPT;
	    $values[] = 'atime='.$now;
	}
	if ($status && $status != $s) {
	    global $msg_status;
	    $msg .= "\n".sprintf(_CC_LOG_STATUS, $msg_status[$s], $msg_status[$status]);
	    $values[] = 'status='.$xoopsDB->quoteString($status);
	}
	$xoopsDB->query("UPDATE ".CCMES." SET ".join(',', $values)." WHERE msgid=$msgid");
	cc_log_message($data['fidref'], $msg." (comid=$comid)", $msgid);
	// notification for guest contact
	if (is_object($xoopsUser) && $data['uid']==0 && $email) {
	    $subj = $data['title'];
	    $url = XOOPS_URL."/modules/".basename(dirname(__FILE__))."/message.php?id=$msgid&p=".urlencode($data['onepass'])."#comment$comid";
	    $tags = array('X_MODULE'=>$xoopsModule->getVar('name'),
			  'X_ITEM_TYPE'=>'', 'X_ITEM_NAME'=>$subj,
			  'X_COMMENT_URL'=>$url, 'FROM_EMAIL'=>$email,
			  'SUBJECT'=>$subj);
	    $xoopsMailer =& getMailer();
	    $xoopsMailer->useMail();
	    $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
	    $xoopsMailer->setFromName($xoopsModule->getVar('name'));
	    $xoopsMailer->setSubject(_MD_NOTIFY_SUBJ);
	    $xoopsMailer->assign($tags);
	    $tpl = 'guest_notify.tpl';
	    $xoopsMailer->setTemplateDir(template_dir($tpl));
	    $xoopsMailer->setTemplate($tpl);
	    $xoopsMailer->setToEmails($email);
	    $xoopsMailer->send();
	}
    }
}
?>