<?php
// $Id: menu.php,v 1.5 2009/07/04 05:24:38 nobu Exp $

$adminmenu[]=array('title' => _MI_CCENTER_HELP,
		   'link'  => "admin/help.php");
$adminmenu[]=array('title' => _MI_CCENTER_FORMADMIN,
		    'link' => "admin/index.php");
$adminmenu[]=array('title' => _MI_CCENTER_MSGADMIN,
		    'link' => "admin/msgadm.php");

/* XXX: not yet work well...
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYLANGADMIN,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin');
*/
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYTPLSADMIN,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin');
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYBLOCKSADMIN,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin');
$adminmenu4altsys[]=
    array('title' => _MD_A_MYMENU_MYPREFERENCES,
	  'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences');
?>
