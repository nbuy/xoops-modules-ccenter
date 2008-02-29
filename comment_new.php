<?php
// $Id: comment_new.php,v 1.3 2008/02/29 06:22:10 nobu Exp $
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
include 'functions.php';

$myts =& MyTextSanitizer::getInstance();
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
$res = $xoopsDB->query("SELECT m.*, title FROM ".CCMES." m,".FORMS." WHERE msgid=$com_itemid AND status<>".$xoopsDB->quoteString(_STATUS_DEL)." AND fidref=formid");

$data = $xoopsDB->fetchArray($res);

$com_replytext = _POSTEDBY.'&nbsp;<b>'.
    xoops_getLinkedUnameFromId($data['uid']).'</b>&nbsp;'.
    _DATE.'&nbsp;<b>'.formatTimestamp($data['mtime']).'</b>
<br /><br />'.$myts->displayTarea($data['body'])."<br/><br/>".

$com_replytitle = $data['title'];

include XOOPS_ROOT_PATH.'/include/comment_new.php';
?>