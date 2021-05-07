<?php
// $Id: xoops_version.php,v 1.28 2012/01/21 16:55:15 nobu Exp $
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

$modversion = array(
	'name'        => _MI_CCENTER_NAME,
	'version'     => "0.98",
	'description' => _MI_CCENTER_DESC,
	'credits'     => "Nobuhiro Yasutomi",
	'author'      => "Nobuhiro Yasutomi",
	'help'        => "help.html",
	'license'     => "GPL see LICENSE",
	'official'    => 0,
	'image'       => "ccenter_slogo.png",
	'dirname'     => basename( __DIR__ )
);

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
//$modversion['sqlfile']['postgresql'] = "sql/pgsql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][] = "ccenter_form";
$modversion['tables'][] = "ccenter_message";
$modversion['tables'][] = "ccenter_log";

// OnUpdate - upgrade DATABASE 
$modversion['onUpdate'] = "onupdate.php";

// OnInstall - Insert Sample Form
$modversion['onInstall'] = "oninstall.php";

// Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/help.php";
$modversion['adminmenu']  = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;
global $xoopsUser;
if ( ! empty( $xoopsUser ) ) {
	$modversion['sub'][] = array(
		'name' => _MI_CCENTER_MYCONTACT,
		'url'  => "list.php"
	);
	$modversion['sub'][] = array(
		'name' => _MI_CCENTER_MYCHARGE,
		'url'  => "charge.php"
	);
	$modversion['sub'][] = array(
		'name' => _MI_CCENTER_STAFFDESK,
		'url'  => "reception.php"
	);
}

// Templates
$modversion['templates'][1] =
	array(
		'file'        => 'ccenter_index.html',
		'description' => _MI_CCENTER_INDEX_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_form.html',
		'description' => _MI_CCENTER_FORM_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_custom.html',
		'description' => _MI_CCENTER_CUST_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_confirm.html',
		'description' => _MI_CCENTER_CONF_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_list.html',
		'description' => _MI_CCENTER_LIST_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_charge.html',
		'description' => _MI_CCENTER_CHARGE_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_message.html',
		'description' => _MI_CCENTER_MSGS_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_reception.html',
		'description' => _MI_CCENTER_RECEPT_TPL
	);
$modversion['templates'][]  =
	array(
		'file'        => 'ccenter_form_widgets.html',
		'description' => _MI_CCENTER_WIDGET_TPL
	);

// Blocks
$modversion['blocks'][1] =
	array(
		'file'        => 'ccenter_receipt.php',
		'name'        => _MI_CCENTER_BLOCK_RECEIPT,
		'description' => '',
		'clone'       => true,
		'show_func'   => "b_ccenter_receipt_show",
		'edit_func'   => "b_ccenter_receipt_edit",
		'template'    => 'ccenter_block_receipt.html',
		'options'     => '5|asc|-|a|b'
	);
$modversion['blocks'][]  =
	array(
		'file'        => 'ccenter_block_form.php',
		'name'        => _MI_CCENTER_BLOCK_FORM,
		'description' => '',
		'clone'       => true,
		'show_func'   => "b_ccenter_form_show",
		'edit_func'   => "b_ccenter_form_edit",
		'template'    => '',
		'options'     => '0'
	);

// Comments
$modversion['hasComments']          = 1;
$modversion['comments']['pageName'] = 'message.php';
$modversion['comments']['itemName'] = 'id';

// Comment callback functions
$modversion['comments']['callbackFile']        = 'comment_functions.php';
$modversion['comments']['callback']['approve'] = 'ccenter_com_approve';
$modversion['comments']['callback']['update']  = 'ccenter_com_update';

// Config

$modversion['hasconfig'] = 1;
$modversion['config'][]  =
	array(
		'name'        => 'max_lists',
		'title'       => '_MI_CCENTER_LISTS',
		'description' => '_MI_CCENTER_LISTS_DESC',
		'formtype'    => 'select',
		'valuetype'   => 'int',
		'default'     => 25,
		'options'     => array( 5 => 5, 10 => 10, 25 => 25, 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000 )
	);
$modversion['config'][]  =
	array(
		'name'        => 'def_attrs',
		'title'       => '_MI_CCENTER_DEF_ATTRS',
		'description' => '_MI_CCENTER_DEF_ATTRS_DESC',
		'formtype'    => 'textarea',
		'valuetype'   => 'string',
		'default'     => "size=60\nrows=5\ncols=50\nnotify_with_email=0"
	);
$modversion['config'][]  =
	array(
		'name'        => 'status_combo',
		'title'       => '_MI_CCENTER_STATUS_COMBO',
		'description' => '_MI_CCENTER_STATUS_COMBO_DESC',
		'formtype'    => 'textarea',
		'valuetype'   => 'string',
		'default'     => _MI_CCENTER_STATUS_COMBO_DEF
	);

// Notification

$modversion['hasNotification']             = 1;
$modversion['notification']['lookup_file'] = 'notification.inc.php';
$modversion['notification']['lookup_func'] = 'ccenter_notify_iteminfo';

$modversion['notification']['category'][1] =
	array(
		'name'           => 'global',
		'title'          => _MI_CCENTER_GLOBAL_NOTIFY,
		'description'    => '',
		'subscribe_from' => array( 'reception.php' )
	);
$modversion['notification']['category'][]  =
	array(
		'name'           => 'form',
		'title'          => _MI_CCENTER_FORM_NOTIFY,
		'item_name'      => 'form',
		'description'    => '',
		'subscribe_from' => array( 'reception.php' )
	);
$modversion['notification']['category'][]  =
	array(
		'name'           => 'message',
		'title'          => _MI_CCENTER_MESSAGE_NOTIFY,
		'description'    => '',
		'item_name'      => 'id',
		'subscribe_from' => array( 'message.php' )
	);
$modversion['notification']['event'][1]    =
	array(
		'name'          => 'new',
		'category'      => 'global',
		'admin_only'    => 1,
		'title'         => _MI_CCENTER_NEWPOST_NOTIFY,
		'caption'       => _MI_CCENTER_NEWPOST_NOTIFY_CAP,
		'description'   => '',
		'mail_template' => 'notify',
		'mail_subject'  => _MI_CCENTER_NEWPOST_SUBJECT
	);
$modversion['notification']['event'][]     =
	array(
		'name'          => 'new',
		'category'      => 'form',
		'title'         => _MI_CCENTER_NEWPOST_NOTIFY,
		'caption'       => _MI_CCENTER_NEWPOST_NOTIFY_CAP,
		'description'   => '',
		'mail_template' => 'notify',
		'mail_subject'  => _MI_CCENTER_NEWPOST_SUBJECT
	);
$modversion['notification']['event'][]     =
	array(
		'name'          => 'status',
		'category'      => 'message',
		'title'         => _MI_CCENTER_STATUS_NOTIFY,
		'caption'       => _MI_CCENTER_STATUS_NOTIFY_CAP,
		'description'   => '',
		'mail_template' => 'status_notify',
		'mail_subject'  => _MI_CCENTER_STATUS_SUBJECT
	);
