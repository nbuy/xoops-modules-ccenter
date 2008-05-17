<?php
# ccenter module onInstall proceeding.
# $Id: oninstall.php,v 1.1 2008/05/17 05:55:47 nobu Exp $

global $xoopsDB, $xoopsUser;

define('FORM', $xoopsDB->prefix('ccenter_form'));

$data = array('mtime'=>time(),
	      'title'=>$xoopsDB->quoteString(_MI_SAMPLE_TITLE),
	      'description'=>$xoopsDB->quoteString(_MI_SAMPLE_DESC),
	      'grpperm'=>"'|".XOOPS_GROUP_ANONYMOUS."|".XOOPS_GROUP_USERS."|'",
	      'defs'=>$xoopsDB->quoteString(_MI_SAMPLE_DEFS),
	      'priuid'=>$xoopsUser->getVar('uid'));

$xoopsDB->query('INSERT INTO '.FORM."(".join(',', array_keys($data)).")VALUES(".join(',', $data).")");
$msgs[] = '&nbsp;&nbsp;<b>'._MI_SAMPLE_FORM."</b>";
?>
