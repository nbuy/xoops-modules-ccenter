<?php
// $Id: comment_functions.php,v 1.3 2007/06/14 05:58:00 nobu Exp $
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
    global $xoopsDB, $xoopsUser, $xoopsModule, $xoopsConfig;

    $res = $xoopsDB->query("SELECT uid, touid, email, onepass, fidref, title FROM ".MESSAGE.", ".FORMS." WHERE msgid=$msgid AND formid=fidref");

    $comid = intval($_POST['com_id']); // new comment?
    if ($comid==0 && $res && $xoopsDB->getRowsNum($res)) {
	$data = $xoopsDB->fetchArray($res);
	$email = $data['email'];

	$uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
	if ($uid && $uid == $data['touid']) { // comment by charge
	    // status to replyed
	    $xoopsDB->query("UPDATE ".MESSAGE." SET status='b' WHERE msgid=$msgid AND status='a'");
	}
	if ($uid==0 || $uid==$data['uid']) { // comment by order person
	    // status back to contacting
	    $xoopsDB->query("UPDATE ".MESSAGE." SET status='a' WHERE msgid=$msgid AND status IN ('b', 'c')");
	}
	// notification for guest contact
	if (is_object($xoopsUser) && $data['uid']==0 && $email) {
	    $subj = $data['title'];
	    $url = XOOPS_URL."/modules/".basename(dirname(__FILE__))."/message.php?id=$msgid&p=".urlencode($data['onepass']);
	    $tags = array('X_MODULE'=>$xoopsModule->getVar('name'),
			  'X_ITEM_TYPE'=>'', 'X_ITEM_NAME'=>$subj,
			  'X_COMMENT_URL'=>$url, 'EMAIL'=>$email,
			  'SUBJECT'=>$subj);
	    $xoopsMailer =& getMailer();
	    $xoopsMailer->useMail();
	    $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
	    $xoopsMailer->setFromName($xoopsModule->getVar('name'));
	    $xoopsMailer->setSubject(_MD_NOTIFY_SUBJ);
	    $xoopsMailer->assign($tags);
	    $tpl = 'guest_notify.tpl';
	    $xoopsMailer->setTemplateDir($x=template_dir($tpl));
	    $xoopsMailer->setTemplate($tpl);
	    $xoopsMailer->setToEmails($email);
	    $xoopsMailer->send();
	}
    }
    return true;
}

function ccenter_com_approve(&$comment){
	// notification mail here
}
?>