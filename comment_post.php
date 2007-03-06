<?php
// $Id: comment_post.php,v 1.2 2007/03/06 17:46:55 nobu Exp $
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
include '../../mainfile.php';
include "functions.php";

$id = intval($_POST['com_itemid']);
$comid = intval($_POST['com_id']);
$res = $xoopsDB->query("SELECT uid, touid, email, onepass, fidref, title FROM ".MESSAGE.", ".FORMS." WHERE msgid=$id AND formid=fidref");
if ($comid==0 && $res && $xoopsDB->getRowsNum($res)) {
    $data = $xoopsDB->fetchArray($res);
    $email = $data['email'];

    $uid = is_object($xoopsUser)?$xoopsUser->getVar('uid'):0;
    if ($uid && $uid == $data['touid']) { // comment by charge
	// status to replyed
	$xoopsDB->query("UPDATE ".MESSAGE." SET status='b' WHERE msgid=$id AND status='a'");
    }
    if ($uid==0 || $uid==$data['uid']) { // comment by order person
	// status back to contacting
	$xoopsDB->query("UPDATE ".MESSAGE." SET status='a' WHERE msgid=$id AND status IN ('b', 'c')");
    }
    // notification for guest contact
    if (is_object($xoopsUser) && $data['uid']==0 && $email) {
	$subj = $data['title'];
	$url = XOOPS_URL."/modules/".basename(dirname(__FILE__))."/message.php?oid=$id&p=".urlencode($data['onepass']);
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

include XOOPS_ROOT_PATH.'/include/comment_post.php';
?>