<?php
// $Id: admin.php,v 1.7 2009/11/15 09:51:08 nobu Exp $

define('_AM_FORM_EDIT', 'Edit contact form');
define('_AM_FORM_NEW', 'Create new contact form');
define('_AM_FORM_TITLE', 'Form name');
define('_AM_FORM_MTIME', 'Updated');
define('_AM_FORM_DESCRIPTION', 'Description');
define('_AM_INS_TEMPLATE', 'Adding template');
define('_AM_FORM_ACCEPT_GROUPS', 'Accept Groups');
define('_AM_FORM_ACCEPT_GROUPS_DESC', 'This contact form accept from this setting groups');
define('_AM_FORM_DEFS', 'Form defunitions');
define('_AM_FORM_DEFS_DESC', '<a href="help.php#form" target="_blank">Defunitions</a> <small>Types: text checkbox radio textarea select const hidden mail file</small>');
define('_AM_FORM_PRIM_CONTACT', 'Contact person');
define('_AM_FORM_PRIM_NONE', 'None');
define('_AM_FORM_PRIM_DESC', 'Select Member of group, The contact person need select by uid argument from the group');
define('_AM_FORM_CONTACT_GROUP', 'Contact group');
define('_AM_FORM_CGROUP_NONE', 'None');
define('_AM_FORM_STORE', 'Store in Database');
define('_AM_FORM_CUSTOM', 'Description type');
define('_AM_FORM_WEIGHT', 'Weight');
define('_AM_FORM_REDIRECT', 'Display page after sending');
define('_AM_FORM_OPTIONS', 'Option variables');
define("_AM_FORM_OPTIONS_DESC","Setting form definition and other attribute <a href='help.php#attr'>default options</a>. Example: <tt>size=60,rows=5,cols=50</tt>");
define('_AM_FORM_ACTIVE', 'Form active');
define('_AM_DELETE_FORM', 'Delete From');
define('_AM_FORM_LAB', 'Item name');
define('_AM_FORM_LABREQ', 'Please input item name');
define('_AM_FORM_REQ','Required');
define('_AM_FORM_ADD', 'Add');
define('_AM_FORM_OPTREQ', 'Need option argument');
define('_AM_CUSTOM_DESCRIPTION', '0=Normal[bb],4=HTML description[bb],1=Part template,2=Overall template');
define('_AM_CHECK_NOEXIST', 'Variables not exist');
define('_AM_CHECK_DUPLICATE', 'Variable duplicates');
define('_AM_DETAIL', 'Detail');
define('_AM_OPERATION', 'Operation');
define('_AM_CHANGE','Change');
define('_AM_SEARCH_USER', 'Search User');

define('_AM_MSG_ADMIN', 'Contact Admin');
define('_AM_MSG_CHANGESTATUS', 'Status Change');
define('_AM_SUBMIT', 'Update');

define('_AM_MSG_COUNT', 'Count');
define('_AM_MSG_STATUS', 'Status');
define('_AM_MSG_CHARGE', 'Charge');
define('_AM_MSG_FROM', 'From');
define('_AM_MSG_COMMS', 'Comments');

define('_AM_MSG_WAIT', 'Wait');
define('_AM_MSG_WORK', 'Work');
define('_AM_MSG_REPLY', 'Reply');
define('_AM_MSG_CLOSE', 'Close');
define('_AM_MSG_DEL', 'Delete');

define('_AM_MSG_CTIME', 'Registerd');
define('_AM_MSG_MTIME', 'Updated');

define('_AM_MSG_UPDATED', 'Status changed');
define('_AM_MSG_UPDATE_FAIL', 'Update Failer');

define('_AM_LOGGING','History');

define('_AM_FORM_UPDATED', 'The form store in database');
define('_AM_FORM_DELETED', 'The form deleted');
define('_AM_FORM_UPDATE_FAIL', 'The form update failer');
define('_AM_TIME_UNIT', '%dmin,%dhour,%ddays,past %s');
define('_AM_NODATA', 'NoData');
define('_AM_SUBMIT_VIEW','Refresh');
define('_AM_OPTVARS_SHOW','Show more settings');
define('_AM_OPTVARS_LABEL','notify_with_email=Notify dispaly email address
redirect=Redirect page after submit
reply_comment=Add message in auto reply mail
reply_use_comtpl=Add message to be email template
others=Other variables ("Name=Value" style)
');

include_once dirname(__FILE__)."/common.php";
?>
