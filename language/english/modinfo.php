<?php
// $Id: modinfo.php,v 1.6 2009/06/06 03:28:04 nobu Exp $
// Module Info

// The name of this module
define("_MI_CCENTER_NAME","Contact Center");

// A brief description of this module
define("_MI_CCENTER_DESC","Contact form with message store and management");

// Sub Menu
define("_MI_CCENTER_MYCONTACT", "My Messages");
define("_MI_CCENTER_MYCHARGE", "Contact for me");
define("_MI_CCENTER_STAFFDESK", "Staff Desk");

// Admin Menu
define("_MI_CCENTER_FORMADMIN", "Forms");
define("_MI_CCENTER_MSGADMIN", "Messages");
define("_MI_CCENTER_HELP", "About ccenter");

// A brief template of this module
define("_MI_CCENTER_INDEX_TPL", "List of forms");
define("_MI_CCENTER_FORM_TPL", "Contact form");
define("_MI_CCENTER_CUST_TPL", "Contact form (custom)");
define("_MI_CCENTER_CONF_TPL", "Confirm form inputs");
define("_MI_CCENTER_LIST_TPL", "List of my queries");
define("_MI_CCENTER_CHARGE_TPL", "List of contact for me");
define("_MI_CCENTER_MSGS_TPL", "Display contact message");
define("_MI_CCENTER_RECEPT_TPL", "Display staff desk");
define("_MI_CCENTER_WIDGET_TPL", "Form widgets");

// A brief blocks of this module
define("_MI_CCENTER_BLOCK_RECEIPT","Contact for me");
define("_MI_CCENTER_BLOCK_FORM","Contact form");

// Configs
define("_MI_CCENTER_LISTS","Number of list items");
define("_MI_CCENTER_LISTS_DESC","Set number of list show a display");
define("_MI_CCENTER_DEF_ATTRS","Default options");
define("_MI_CCENTER_DEF_ATTRS_DESC","Setting form definition and other attribute <a href='help.php#attr'>default options</a>. Example: <tt>size=60,rows=5,cols=50</tt>");
define("_MI_CCENTER_STATUS_COMBO", "Status selections");
define("_MI_CCENTER_STATUS_COMBO_DESC","the Format as: <tt>Display-label: [status1[,status2...]]</tt>, include multipule lines. the status is a character from (-,a,b,c). Example: <tt>Open: - a</tt>");
define("_MI_CCENTER_STATUS_COMBO_DEF","All: - a b c\nOpen: - a\nClosed: b c\n--------:\nWaiting: -\nWorking: a\nReplyed: b\nDone: c\n");

// Notifications
define("_MI_CCENTER_GLOBAL_NOTIFY","All forms");
define("_MI_CCENTER_FORM_NOTIFY","This form");
define("_MI_CCENTER_MESSAGE_NOTIFY","This Message");

define("_MI_CCENTER_NEWPOST_NOTIFY","Contact Message");
define("_MI_CCENTER_NEWPOST_NOTIFY_CAP","Notify contact message");
define("_MI_CCENTER_NEWPOST_SUBJECT","Post contact message");

define("_MI_CCENTER_STATUS_NOTIFY","Update status");
define("_MI_CCENTER_STATUS_NOTIFY_CAP","Notify status changes");
define("_MI_CCENTER_STATUS_SUBJECT","Status:[{X_MODULE}]{FORM_NAME}");

define("_MI_SAMPLE_FORM","Create sample form");
define("_MI_SAMPLE_TITLE","Contact us");
define("_MI_SAMPLE_DESC","Please send following form when you want contact us.");
define("_MI_SAMPLE_DEFS","Your name*,size=40\nEmail*,mail,size=60\nAbout*,radio,Site contents,Query about us,Others\nMessage,textarea,cols=50,rows=5");

// for altsys 
if (!defined('_MD_A_MYMENU_MYTPLSADMIN')) {
    define('_MD_A_MYMENU_MYTPLSADMIN','Templates');
    define('_MD_A_MYMENU_MYBLOCKSADMIN','Block/Access');
    define('_MD_A_MYMENU_MYPREFERENCES','Prefercenes');
}
?>
